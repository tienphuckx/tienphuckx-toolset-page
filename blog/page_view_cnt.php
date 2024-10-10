<?php
function _increase_page_view($conn, $pageCode) {
    $today = date('Y-m-d');
    $sql = "
        SELECT view_count 
        FROM tbl_page_views 
        WHERE page_code = ? 
        AND view_date = ?
    ";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("is", $pageCode, $today);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($view_count);
        $stmt->fetch();
        $stmt->close();
        $sql = "
            UPDATE tbl_page_views 
            SET view_count = view_count + 1, 
                last_viewed = CURRENT_TIMESTAMP
            WHERE page_code = ? 
            AND view_date = ?
        ";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("is", $pageCode, $today);
        $stmt->execute();
        $stmt->close();
    } else {
        $stmt->close();
        $sql = "
            INSERT INTO tbl_page_views (page_code, view_count, last_viewed, view_date)
            VALUES (?, 1, CURRENT_TIMESTAMP, ?)
        ";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("is", $pageCode, $today);
        if (!$stmt->execute()) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
    }
}

function _get_today_view_count($conn, $pageCode) {
    $today = date('Y-m-d');
    $sql = "
        SELECT view_count 
        FROM tbl_page_views 
        WHERE page_code = ? 
        AND view_date = ?
    ";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("is", $pageCode, $today);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($view_count);
        $stmt->fetch();
        $stmt->close();
        return $view_count;
    } else {
        $stmt->close();
        return 0;
    }
}
?>

