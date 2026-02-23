<?php
if($level == "non-supervisor"){
    
    $result = $db_con->query("SELECT * FROM leaves WHERE for_staff_level = 'non-supervisor'");
    
}else{
        
    $result = $db_con->query("SELECT * FROM leaves WHERE for_staff_level = 'supervisor'");

}

if($result->num_rows > 0){
    
    include("leave-types.php");

    echo "<h1 class='text-center hide'>New Leave Request</h1>

        <form action='request.php' method='post' class='mb-5' id='request-form'>
            <input type='hidden' name='staff_id' value='$id'>

            <label for='leave-type'>Select leave type</label>
            <select name='leave_id' class='form-control' required>";

    while($row = $result->fetch_object()){

        
        $num_days = $row->allowed_monthly_days;
        
        switch($row->leave_type){
            case "sick": $type = "Sick Leave";
            break;
            case "casual":$type = "Compassionate Leave";
            break;
            case "maternity": $type = "Maternity Leave";
            break;
            case "paternity": $type = "Paternity Leave";
            break;
            case "annual": $type = "Annual Leave";
            break;
            case "study": $type = "Study Leave";
            break;
            case "special": $type = "Sabbatical Leave";
            break;
            case "official_duty": $type = "Official Duty Leave";
            break;
            default : $type = $row->leave_type;
            break;
        }
            
            echo "<option class='leave_type' value='$row->leave_id'>$type</option>";
            
    }
       
        echo "</select><hr>";

        
}         

    $min = date("Y-m-d");
    
    echo "<div class='row mt-3'>
            <div class='col-md-6 mb-3'>
                <label for='start'>Start Date</label>
                <input type='date' name='leave_start_date' min='$min' id='start' class='form-control' required>
            </div>
            <div class='col-md-6 mb-3'>
                <label for='end'>End Date</label>
                <input type='date' name='leave_end_date' id='end' min='$min' class='form-control' required>
            </div>
        </div>
        
        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label for='semester'>Semester / Academic Term</label>
                <select name='semester' id='semester' class='form-control' required>
                    <option value=''>Select Semester</option>
                    <option value='Semester I 2024/2025'>Semester I 2024/2025</option>
                    <option value='Semester II 2024/2025'>Semester II 2024/2025</option>
                    <option value='Semester I 2025/2026'>Semester I 2025/2026</option>
                    <option value='Semester II 2025/2026'>Semester II 2025/2026</option>
                </select>
            </div>
            <div class='col-md-6 mb-3'>
                <label for='handover'>Handover Staff Name</label>
                <select name='handover' id='handover' class='form-control' required>
                    <option value=''>Select Staff</option>";
                    
                    $staff_res = $db_con->query("SELECT fname, lname FROM employee ORDER BY fname ASC");
                    if($staff_res && $staff_res->num_rows > 0){
                        while($s = $staff_res->fetch_assoc()){
                            $full = $s['fname'].' '.$s['lname'];
                            echo "<option value='$full'>$full</option>";
                        }
                    }

            echo "</select>
            </div>
        </div>

        <div class='mb-3'>
            <label for='reason'>Detailed Reason for Leave</label>
            <textarea name='reason' id='reason' class='form-control' rows='3' placeholder='Specifically explain why you need this leave' required></textarea>
        </div>

        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label for='contact'>Contact While Away</label>
                <input type='text' name='contact' id='contact' class='form-control' placeholder='Phone or Email' required>
            </div>
            <div class='col-md-6 mb-3'>
                <label for='document'>Supporting Document (Optional)</label>
                <input type='file' name='document' id='document' class='form-control-file'>
            </div>
        </div>

        <small class='error text-danger' id='error'></small>
        <hr>
        <button class='btn btn-success btn-lg btn-block' type='submit' name='request'>
        Submit Leave Application</button></form>";
