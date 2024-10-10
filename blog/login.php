<?php
    require "auth.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email_input = $_POST["email"];
        $pwd_input = $_POST["password"];

        $response = verify_login($email_input, $pwd_input);
        $response_data = json_decode($response, true);
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
        .error, .success {
            margin-top: 20px;
            text-align: center;
        }
        .error {
            color: #e74c3c;
        }
        .success {
            color: #27ae60;
        }
        .regis-text {
            margin-top: 15px;
            font-size: 12px
        }
        .regis-text .cre {
            cursor: pointer;
            margin-left: 3px;
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <!-- Display login feedback -->
            <?php if (isset($response_data)): ?>
                <?php if ($response_data['status'] == 200): ?>
                    <p class="success"><?php echo "Login successful. Welcome " . $response_data['data']['email']; ?></p>
                <?php else: ?>
                    <p class="error"><?php echo "Error: " . $response_data['message']; ?></p>
                <?php endif; ?>
            <?php endif; ?>
        <form id="loginForm" method="POST">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
        <div class="regis-text mt-3">
          <span>You don't have account?</span>
          <span>
            <a id="registerBtn" class="cre">Create</a>
          </span>
        
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email === '' || password === '') {
                event.preventDefault();
                alert('Both fields are required');
            }
        });
    </script>
    <script>
        document.getElementById("registerBtn").addEventListener("click", function() {
            console.log("Register btn");  
            window.location.href = "register.php";
        });
    </script>
</body>
</html>
