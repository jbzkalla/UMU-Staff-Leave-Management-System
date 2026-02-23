<?php
require_once('db.php');
session_start();

if(!isset($_SESSION['admin-user'])){
    die("Access Denied");
}

$dept_id = isset($_GET['dept']) ? intval($_GET['dept']) : 0;
$start_date = isset($_GET['from']) ? $_GET['from'] : '';
$end_date = isset($_GET['to']) ? $_GET['to'] : '';

$filename = "UMU_Leave_Report_" . date('Ymd') . ".csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
fputcsv($output, array('Staff Name', 'Department', 'Leave Type', 'Start Date', 'End Date', 'Stage', 'Date Requested'));

$where = "WHERE 1=1";
$params = "";
$values = array();

if($dept_id > 0) {
    $where .= " AND e.department_id = ?";
    $params .= "i";
    $values[] = $dept_id;
}
if($start_date) {
    $where .= " AND la.leave_start_date >= ?";
    $params .= "s";
    $values[] = $start_date;
}
if($end_date) {
    $where .= " AND la.leave_end_date <= ?";
    $params .= "s";
    $values[] = $end_date;
}

$sql = "SELECT la.*, e.fname, e.lname, d.department_name 
        FROM leave_applications la 
        JOIN employee e ON la.staff_id = e.staff_id 
        LEFT JOIN departments d ON e.department_id = d.id 
        $where 
        ORDER BY la.id DESC";

$stmt = $db_con->prepare($sql);
if($params != "") {
    $stmt->bind_param($params, ...$values);
}
$stmt->execute();
$reports = $stmt->get_result();
while($r = $reports->fetch_assoc()){
    fputcsv($output, array(
        $r['fname'] . ' ' . $r['lname'],
        $r['department_name'],
        $r['leave_type'],
        $r['leave_start_date'],
        $r['leave_end_date'],
        $r['approval_stage'],
        $r['date_requested']
    ));
}
fclose($output);
exit();
?>
