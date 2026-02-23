<?php
session_start();
include_once("functions.php");

// Redirect if already logged in
if(isset($_SESSION['staff-user']) && $_SESSION['staff-user'] !== ""){
    redirect_user("dashboard.php");
}elseif(isset($_SESSION['supervisor-user']) && $_SESSION['supervisor-user'] !== ""){
    redirect_user("dashboard.php?type=supervisor");
}elseif(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ""){
    redirect_user("admin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Leon SmartLeave – Uganda Martyrs University</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/font-awesome.css" rel="stylesheet">
    <link href="./css/splash.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="splash-container">
        <div class="splash-overlay"></div>
        
        <div class="splash-card">
            <img src="images/logo(2).jpeg" alt="UMU Logo" class="splash-logo">
            <h1 class="splash-title">Leon SmartLeave</h1>
            <p class="splash-subtitle">Uganda Martyrs University Staff Leave Management System. Manage your leave requests efficiently and professionally.</p>
            
            <div class="btn-group-splash">
                <a href="index.php?action=login" class="btn-splash btn-splash-primary">Login Portal</a>
                <a href="register.php" class="btn-splash btn-splash-outline">Staff Signup</a>
            </div>
        </div>

        <div class="splash-footer">
            &copy; <?php echo date('Y'); ?> Uganda Martyrs University | Human Resource Department | v2.4
        </div>
    </div>

    <script src="./js/jquery.min.js"></script>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
