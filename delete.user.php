<?php
session_start();
include_once('db.php');
include_once('functions.php');

if(isset($_POST['delete-account'])){
    
    $id = intval($_POST['id']);
    $password = $_POST['password'];
    $tbl = strip_tags($_POST['table']);
    $page = strip_tags($_POST['page']);

    // Verification: Staff can only delete their own account
    if(isset($_SESSION['staff-user']) && $tbl == 'employee'){
        $username = $_SESSION['staff-user'];
    } else {
        redirect_user("index.php");
    }

    // Verify password before deletion
    $stmt = $db_con->prepare("SELECT password FROM $tbl WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $id, $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows == 1){
        $user = $res->fetch_object();
        if(password_verify($password, $user->password)){
            // Password correct, proceed with deletion
            $db_con->query("DELETE FROM $tbl WHERE id = $id");
            if($db_con->affected_rows == 1){
                // Logout and redirect to landing
                session_destroy();
                header("Location:index.php?msg=".urlencode("Your account has been successfully deleted."));
                exit();
            } else {
                redirect_user("$page&error=".urlencode("Could not delete account. Try again."));
            }
        } else {
            redirect_user("$page&error=".urlencode("Incorrect password. Verification failed."));
        }
    } else {
        redirect_user("$page&error=".urlencode("Account not found or mismatch."));
    }

} else {
    redirect_user("index.php");
}
?>
