<?php
require "blog/post_ctl.php";
include 'blog/analysis.php';
require "blog/page_view_cnt.php";

session_start();
if (isset($_SESSION['user'])) {
    $user_email = $_SESSION['user']['email'];
    $user_fname = $_SESSION['user']['fname'];
    $user_lname = $_SESSION['user']['lname'];
}

$num_post = 5;
$index = 0;
$posts = get_newest_post($num_post, $index);
$right_side_tags = fetch_tags();

try {
    $conn = get_db_connection();
} catch (PDOException $e) {
    die("Could not connect to the database " . $e->getMessage());
}


/* _collect_visitor_data($conn); */
_increase_page_view($conn, PAGE_CODES['INDEX']);
$today_views = _get_today_view_count($conn, 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tienphuckx</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="blog/css_index.css">

    <!-- Open Graph Meta Tags (For Zalo, Facebook, etc.) -->
    <meta property="og:title" content="tienphuckx - Phúc's Toolset Website">
    <!-- <meta name="description" content="Explore Phúc's toolset and utilities for various tasks."> -->
    <meta name="description" content="Explore Phúc's toolset and utilities for various tasks.">
    <meta property="og:url" content="https://tienphuckx.ueuo.com/">
    <meta property="og:image" content="https://yourwebsite.com/images/avatar.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
</head>



<body>
    <div id="wrap" class="container">
        <header class="main-header">
            <div class="head-logo">
                <span class="lg-name">tienphuckx</span>
                <div class="links">
                    <a href="https://github.com/tienphuckx/tienphuckx" target="_blank">GitHub</a>
                    <a href="https://www.linkedin.com/in/tienphuckx" target="_blank">LinkedIn</a>
                    <a href="#">tienphuckx@gmail.com</a>
                    <a href="https://www.facebook.com/tienphucptit" target="_blank">Facebook</a>
                    <a href="https://www.youtube.com/@tienphuckx" target="_blank">Youtube</a>
                </div>
            </div>


            <?php include 'blog/header.php'; ?>

            <?php
            // if (isset($user_email) && !empty($user_email)) {
            //     echo $user_fname . " " . $user_lname . " (" . htmlspecialchars($user_email) . ") ";
            // } else {
            //     echo "anonymous";
            // }
            ?>

        </header>

        <main class="main-block">
            <div class="row m-0">
                <div class="col-md-9 block-left">
                    <div class="wrap-left-content">
                    <?php include 'blog/content.php'; ?>
                    </div>
                </div>
                <div class="col-md-3 block-right">
                    <?php include 'blog/right_side.php'; ?>
                </div>
            </div>
        </main>

        <footer class="bg-dark py-3">
            <div class="text-center">
                <p class="cpy-right">&copy; 2024 tienphuckx. All rights reserved.</p>
            </div>
        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="blog/js_index.js"></script>
    <!-- <script>
    // JavaScript to collect screen resolution and send it to the server
    function sendScreenResolution() {
        var screenResolution = screen.width + 'x' + screen.height;

        // Create a new AJAX request to send data to the PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "blog/analysis.php", true); // Replace with the actual PHP script URL
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Send the screen resolution to the server
        xhr.send("screen_resolution=" + screenResolution);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Once the data is sent, process further actions like loading the rest of the page
                console.log('Screen resolution sent successfully');
                // You could also call your PHP logic here or redirect the page, etc.
                //window.location.href = "your_php_script.php"; // Reload to continue PHP processing
            }
        };
    }

    // Call the function to send screen resolution
    sendScreenResolution();
</script> -->

</body>

</html>