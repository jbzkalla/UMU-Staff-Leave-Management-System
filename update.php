<?php
require_once('db.php');

require_once('functions.php');

if(isset($_POST['update'])){

    $err = array();
    
    if(var_set($_POST['password'])){

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
    }else{
        $err[] = urlencode("Provide a password");
    }
    
    if(var_set($_POST['confpassword'])){

        $confpass = password_hash($_POST['confpassword'], PASSWORD_DEFAULT);
    }else{
        $err[] = urlencode("Confirm password");
    }
    
    if(var_set($_POST['phone'])){

        $phone = strip_tags($_POST['phone']);
    }else{
        $err[] = urlencode("Provide a phone number");
    }
    
    // Fix: Using the correct variable for ID
    $id = (isset($_POST['id']) && !empty($_POST['id'])) ? intval($_POST['id']) : 0;
      
    if(var_set($_POST['email'])){
        $email = strip_tags($_POST['email']);
    }else{
        $err[] = urlencode("Enter your email");
    }
    
    if(!$err){
        // Verification: If user is logged in, confirm they match the ID they are trying to update
        if(isset($_SESSION['staff-user'])){
            $tbl = "employee";
            $redirect = "dashboard.php?tab=4";
        } else if(isset($_SESSION['admin-user'])){
            $tbl = "admin";
            $redirect = "admin.php?tab=4";
        } else {
            redirect_user("index.php");
        }

        $query = $db_con->query("UPDATE $tbl SET email = '$email', phone = '$phone', password = '$password' WHERE id = $id");

        if($db_con->affected_rows == 1){
            $msg = urlencode("Your information has been updated successfully.");
            header("Location:$redirect&msg=$msg");
        }else{
            $error = urlencode("No changes made or update failed. ".$db_con->error);
            header("Location:$redirect&error=$error");
        }
        
    }else{
        $redirect = (isset($_SESSION['admin-user'])) ? "admin.php?tab=4" : "dashboard.php?tab=4";
        header("Location:$redirect&error=".join(urlencode("<br>"), $err));
    }
}else{
    header("Location:dashboard.php?tab=4");
}