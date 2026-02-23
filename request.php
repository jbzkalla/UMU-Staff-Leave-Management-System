<?php
include_once("connection.php");

include_once("functions.php");

if(isset($_POST['request'])){
    
    $errors = array();
    
    if(var_set($_POST['leave_start_date'])){
        
        $leave_start_date = strip_tags($_POST['leave_start_date']);
    }else{
        
        $errors[] = urlencode("Please select the start date of your leave");
    }
    
    
    if(var_set($_POST['leave_end_date'])){
        $leave_end_date = strip_tags($_POST['leave_end_date']);
    }else{
        
        $errors[] = urlencode("Please select end date of your leave");
    }
    
    $start_dt = new DateTime($leave_start_date);
    $end_dt = new DateTime($leave_end_date);
    
    if($start_dt > $end_dt){
        $errors[] = urlencode("Start date must be less than or equal to end date");
    }
    
    if(var_set($_POST['staff_id'])){
    
        $staff_id = strip_tags($_POST['staff_id']);
    
    }else{
        
        $errors[] = urlencode("An error occured. Try again".$db_con->error);
    }
    
    $date_requested = date("d-m-Y");
    
    if(var_set($_POST['leave_id'])){
        $leave_id = intval($_POST['leave_id']);
        $stmt = $db_con->prepare("SELECT id,leave_id,leave_type FROM leaves WHERE leave_id = ?");
        $stmt->bind_param("i", $leave_id);
        $stmt->execute();
        $res_obj = $stmt->get_result();
        if($res_obj->num_rows > 0){
            $res = $res_obj->fetch_object();
            $leave_type = $res->leave_type;
        }else{
            $errors[] = urlencode("Invalid leave type selected");
        }
    }else{
        $errors[] = urlencode("You must select leave type");
    }

    // New UMU Fields
    $semester = isset($_POST['semester']) ? strip_tags($_POST['semester']) : '';
    $handover = isset($_POST['handover']) ? strip_tags($_POST['handover']) : '';
    $reason = isset($_POST['reason']) ? strip_tags($_POST['reason']) : '';
    $contact = isset($_POST['contact']) ? strip_tags($_POST['contact']) : '';
    
    // File Upload Handling
    $supporting_doc = "";
    if(isset($_FILES['document']) && $_FILES['document']['error'] == 0){
        $target_dir = "uploads/documents/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . "_" . basename($_FILES["document"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Security: Check file size (e.g., 5MB limit)
        if($_FILES["document"]["size"] > 5000000){
             $errors[] = urlencode("File is too large. Max size is 5MB.");
        }
        
        // Security: Verify MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $actual_mime = finfo_file($finfo, $_FILES["document"]["tmp_name"]);
        finfo_close($finfo);
        
        $allowed_mimes = array(
            "application/pdf",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "image/jpeg",
            "image/png"
        );
        
        if(in_array($actual_mime, $allowed_mimes)){
            if(move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)){
                $supporting_doc = $file_name;
            } else {
                $errors[] = urlencode("Sorry, there was an error uploading your file.");
            }
        } else {
            $errors[] = urlencode("Invalid file content. Only PDF, DOC, DOCX, JPG, and PNG are allowed.");
        }
    }
    
    
    
    $stmt = $db_con->prepare("SELECT id FROM leave_applications WHERE leave_id = ? AND staff_id = ? AND (action IS NULL OR action = '')");
    $stmt->bind_param("ii", $leave_id, $staff_id);
    $stmt->execute();
    $r = $stmt->get_result();
    
    if($r->num_rows == 1){
        
        $errors[] = urlencode("You have already applied for this leave");
    }
    
    if(!$errors){
        
        $stmt = $db_con->prepare("INSERT INTO leave_applications(leave_id,staff_id,
                leave_type,semester_or_academic_term,handover_staff_name,detailed_reason,
                contact_while_away,supporting_document,leave_start_date,leave_end_date,
                date_requested,approval_stage) 
                VALUES(?,?,?,?,?,?,?,?,?,?,?,'Pending Supervisor')");
        
        $stmt->bind_param("iisssssssss", $leave_id,$staff_id,$leave_type,
                $semester,$handover,$reason,$contact,$supporting_doc,
                $leave_start_date,$leave_end_date,$date_requested);
        
        $stmt->execute();
        
        echo "<h3>Error: $db_con->error</h3>";
        
        if($db_con->affected_rows == 1){
            
            $msg = urlencode("Leave request successful");
            
            redirect_user("dashboard.php?tab=6&msg=$msg");
        }   
    }  else {
        redirect_user("dashboard.php?tab=6&error=".implode(urlencode("<br>"), $errors));
    }
}