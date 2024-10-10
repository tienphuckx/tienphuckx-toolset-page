<?php
  require "auth.php";
  $errorMessage = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $fname = trim($_POST["fname"]);
      $lname = trim($_POST["lname"]);
      $email = trim($_POST["email"]);
      $password = trim($_POST["password"]);
      $gender = 1;
      $avatar = "";
      $intro = "";
  
      if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
          $errorMessage = "All fields are required!";
      } else {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          do_register($fname, $lname, $email, $hashed_password, $gender, $avatar, $intro);
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="__register.php">
            <div class="mb-3">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
        </form>
    </div>
</body>
</html>
