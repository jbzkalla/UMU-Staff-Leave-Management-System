<?php
require_once('connection.php');

$password = password_hash('admin123', PASSWORD_DEFAULT);
$db_con->query("UPDATE admin SET password = '$password' WHERE username = 'admin'");

if($db_con->affected_rows > 0){
    echo "Admin password reset successfully to: admin123\n";
} else {
    // If admin doesn't exist, create it
    $admin_id = date('mYdHis');
    $db_con->query("INSERT INTO admin(admin_id, title, fname, lname, username, password, email, phone, date_registered) 
                    VALUES('$admin_id', 'Mr', 'System', 'Admin', 'admin', '$password', 'hrm@umu.ac.ug', '0700000000', CURDATE())");
    echo "Admin user created with username: admin and password: admin123\n";
}

// Check for staff
$res = $db_con->query("SELECT username FROM employee LIMIT 1");
if($res->num_rows == 0){
    $staff_id = date('mYdHis') . "1";
    $staff_pass = password_hash('staff123', PASSWORD_DEFAULT);
    $db_con->query("INSERT INTO employee(staff_id, payroll_number, department_id, position_or_rank, title, fname, lname, username, password, email, country_code, phone, staff_level, date_registered) 
                    VALUES('$staff_id', 'UMU-ST-001', 1, 'Lecturer', 'Mr', 'Test', 'Staff', 'staff', '$staff_pass', 'staff@umu.ac.ug', '+256', '711111111', 'non-supervisor', CURDATE())");
    echo "Test Staff user created with username: staff and password: staff123\n";
}
?>
