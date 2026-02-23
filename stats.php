<?php

/**
 * This file contains all leave activities by staff - accepted leaves, rejected 
 * leaves and pending leaves
 */

$stmt = $db_con->prepare("SELECT * FROM leave_applications WHERE staff_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

echo '<div class="card mb-md-5">
        <h1 class="text-center mb-4 text-md">Requested Leaves</h1>
        <table class="table table-bordered table-responsive-sm w-100">

            <thead class="thead-dark">
                <th>Leave ID</th>
                <th>Leave Type</th>
                <th>Status</th>
                <th>Date Requested</th>
            </thead>';

if($result->num_rows > 0){

    while ($row = $result->fetch_object()){
    
        if($row->action == 'accept'){

        $status = "<button class='btn success-btn'>"
                . "<i class='fa fa-check pr-2'></i> Accepted</button>";
        }elseif($row->action == "reject"){

            $status = "<button class='btn danger-btn'>"
                    . "<i class='fa fa-remove pr-2'></i> Rejected</button>";
        }else{
            $status = "<button class='btn pending-btn'>"
                    . "<i class='fa fa-refresh pr-2'></i> Pending</button>";
        }

        if($row->leave_type == "short_embark_disembark"){

            $type = "Short Embarkation/Disembarkation Leave";

        }elseif ($row->leave_type == "long_embark_disembark") {

            $type = "Long Embarkation/Disembarkation Leave";

        }  else {

            $type = ucfirst($row->leave_type)." Leave";

        }

        $student = <<<STAFF
                <tr>

                    <td>$row->leave_id</td>

                    <td>$type</td>

                    <td>
                        $status
                     </td>
                    <td>
                        $row->date_requested
                    </td>
                </tr>
STAFF;

    echo $student; 
    }
     
  
 }else {
        echo '<tr><td class="text-center mb-m-2">No leave data available</td></tr>';
    }

echo '</table></div>';

$stmt = $db_con->prepare("SELECT * FROM leaves WHERE for_staff_level = ?");
$stmt->bind_param("s", $level);
$stmt->execute();
$res = $stmt->get_result();


$rows = $res->num_rows;

if($rows > 0){
    
    // Get accepted leaves grouped by type for this staff member
    $accepted_counts = array();
    $counts_query = $db_con->query("SELECT leave_type, SUM(num_days) as total FROM accepted_leaves WHERE staff_id = $staff_id GROUP BY leave_type");
    while($c_row = $counts_query->fetch_assoc()){
        $accepted_counts[$c_row['leave_type']] = $c_row['total'];
    }

    echo '<div class="card mb-md-5 mt-5">
        <h1 class="text-center text-md">My Leave Balances</h1>
        <table class="table table-bordered table-responsive-sm w-100">
        <thead class="thead-dark">
            <th>Leave Type</th>
            <th>Total Allowed Annually</th>
            <th>Monthly Limit</th>
            <th>Days Used</th>
            <th>Days Remaining</th>
        </thead>';

    while($row = $res->fetch_object()){
        
        $type_key = $row->leave_type;
        $used = isset($accepted_counts[$type_key]) ? $accepted_counts[$type_key] : 0;
        $remaining = $row->current_days - $used;
        
        $allowed = ($row->allowed_days == 0) ? "Indefinite" : $row->allowed_days;
        
        if($row->leave_type == "long_embark_disembark"){
            $type_display = "Long Embarkation/Disembarkation";
        }elseif($row->leave_type == "short_embark_disembark"){
            $type_display = "Short Embarkation/Disembarkation";
        }else{
            $type_display = ucfirst(str_replace('_', ' ', $row->leave_type));
        }
        
        echo "<tr>
                <td>$type_display</td>
                <td>$allowed</td>
                <td>$row->allowed_monthly_days</td>
                <td>$used</td>
                <td><span class='badge " . ($remaining > 0 ? "badge-success" : "badge-danger") . "'>$remaining</span></td>
              </tr>";
    }
    
    echo '</table></div>';
}