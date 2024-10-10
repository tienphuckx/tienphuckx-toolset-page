<?php
require "connect_db.php";
require "response_msg.php";
session_start();

function do_register($fname, $lname, $email, $hashed_password, $gender, $avatar, $intro) {
    $conn = get_db_connection();
    if ($conn->connect_error) {
       return DB_CONNECTION_ERROR;
    }

    $sql = "INSERT INTO tbl_users (firstname, lastname, email, pwd, gender, avatar, intro) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $conn->close();
        return QUERY_PREPARE_ERROR;
    }

    $stmt->bind_param("sssssss", $fname, $lname, $email, $hashed_password, $gender, $avatar, $intro);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        
        header("Location: login.php");
        exit();
    } else {
        $errorMessage = "Error: " . $stmt->error;
        $stmt->close();
        $conn->close();
        return $errorMessage;
    }
}

function verify_login($email_input, $pwd_input) {
    if (empty($email_input) || empty($pwd_input)) {
        return EMPTY_CREDENTIALS;
    }

    $conn = get_db_connection();
    if ($conn->connect_error) {
        return DB_CONNECTION_ERROR;
    }
    
    $hash_pwd_input = password_hash($pwd_input, PASSWORD_DEFAULT);
    $query_for_verify_login = $conn->prepare("SELECT email,pwd,status FROM tbl_users WHERE email = ?");
    $query_for_verify_login->bind_param("s", $email_input);
    $query_for_verify_login->execute();
    $result = $query_for_verify_login->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] != 1) {
            $conn->close();
            return ACCOUNT_DISABLED;
        }
        
        if (password_verify($pwd_input, $row['pwd'])) {
            $conn->close();

            $_SESSION['user'] = array(
                "email" => $row["email"],
                "fname" => $row["firstname"],
                "lname" => $row["lastname"],
                "gender" => $row["gender"]
            );

            header("Location: index.php");
            exit();
        } else {
            $conn->close();
            return PASSWORD_INCORRECT;
        }
    } else {
        $conn->close();
        return EMAIL_NOT_EXIST;
    }
}
?>
