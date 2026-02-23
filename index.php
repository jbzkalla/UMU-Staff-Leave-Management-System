if(session_id() == ""){
    session_start();
}

include_once("functions.php");
 
// Check if user is already logged in
if(isset($_SESSION['staff-user']) && $_SESSION['staff-user'] !== ""){
    redirect_user("dashboard.php");
}elseif(isset($_SESSION['supervisor-user']) && $_SESSION['supervisor-user'] !== ""){
    redirect_user("dashboard.php?type=supervisor");
}elseif(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ""){
    redirect_user("admin.php");
}

// Redirect to splash page if no action is specified
if(!isset($_GET['action']) && !isset($_GET['error'])){
    include_once("splash.php");
    exit();
}

?>  
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>Login | Leon SmartLeave – UMU</title>
<meta name="author" content="Leon SmartLeave">

<?php require_once('styles.php');?>

</head>

<body>
        <?php
         
        include_once("login.php");

        include_once("scripts.php");

        ?>
   
</body>
</html>