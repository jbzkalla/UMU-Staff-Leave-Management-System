<?php

include_once('connection.php');
include_once('functions.php');

if(isset($_POST['remove']) || isset($_POST['delete'])){

      $page = strip_tags($_POST['page']);
      
      if(var_set($_POST['id']) && is_numeric($_POST['id']) && var_set($_POST['table'])){

            $id = intval(strip_tags($_POST['id']));
            $tbl = strip_tags($_POST['table']);
            
            // SECURITY: Only allow specific tables to be deleted via this generic script
            // and only if the user is an admin
            $allowed_tables = ['leaves', 'employee', 'admin', 'departments'];
            
            if(isset($_SESSION['admin-user']) && in_array($tbl, $allowed_tables)){
                
                // Prevent admin from deleting themselves accidentally
                if($tbl == 'admin' && $id == $_SESSION['admin-id']){
                    redirect_user("$page&error=".urlencode("You cannot delete your own admin account from here."));
                }

                $sql = $db_con->query("DELETE FROM $tbl WHERE id = $id");
                $rows = $db_con->affected_rows;

                if($rows == 1){
                      $msg = urlencode("Item deleted successfully");
                      header("Location:$page?&msg=$msg");
                } else{
                      $error = urlencode("Couldn't delete item, or item already removed");
                      redirect_user("$page&error=$error");
                }
            } else {
                // Unauthorized access or illegal table
                $error = urlencode("Unauthorized deletion request.");
                redirect_user("$page&error=$error");
            }

      }else{
          redirect_user($page);
      }

}else{
      echo "<script>history.go(-1)</script>";
}
?>
