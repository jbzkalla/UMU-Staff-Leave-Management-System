<?php
require_once("connection.php");

/*
 * Initializing @var $results to array. We want to create many tables so
 * this @var will be used to query the @db
 */
$results = array();

/*
 * These are the tables that are needed. Although automatically generated and
 * filled, some tables need to be ACTIVATED either by admin or the user.
 * ACTIVATED here means by pressing one or more buttons or entering text into
 * various input/text boxes
 */

/******************** TO BE ACTIVATED BY ADMINISTRATOR *************************/

$query = "CREATE TABLE IF NOT EXISTS leaves(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL UNIQUE, leave_type ENUM('annual',
    'sick','maternity','paternity','study','emergency','casual','special',
    'examinations','sports','absense','short_embark_disembark',
    'long_embark_disembark') NOT NULL, allowed_days BIGINT NOT NULL,
    current_days INT NOT NULL, allowed_monthly_days BIGINT NOT NULL,
    for_staff_level VARCHAR(200) NOT NULL,auto_update BIGINT NOT NULL)";

$results[] = $db_con->query($query);

$stmt = "CREATE TABLE IF NOT EXISTS leave_applications(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,leave_start_date VARCHAR(25) NOT NULL,
    leave_end_date VARCHAR(25) NOT NULL, action ENUM('accept','reject'),
    date_requested VARCHAR(25) NOT NULL)";

$results[] = $db_con->query($stmt);


/*********************** AUTO-GENERATED TABLES *******************************/
/**
 * These tables are automatically created and filled based on the actions of the
 * admin or staff/supervisor
 */

$res = "CREATE TABLE IF NOT EXISTS user_leave_metadata(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL UNIQUE, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,total_yr_leave_count BIGINT NOT NULL,
    total_month_leave_count BIGINT NOT NULL, yr_leave_left BIGINT NOT NULL,
    month_leave_left BIGINT NOT NULL, total_leave_left_staff BIGINT NOT NULL)";

$results[] = $db_con->query($res);


$querry = "CREATE TABLE IF NOT EXISTS accepted_leaves(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL, num_days INT NOT NULL,
    date_accepted VARCHAR(25) NOT NULL)";

$results[] = $db_con->query($querry);

$q = "CREATE TABLE IF NOT EXISTS password_recovery_meta(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, token VARCHAR(2000) NOT NULL, expiry BIGINT, email VARCHAR(1000) NOT NULL)";

$results[] = $db_con->query($q);

$qry = "CREATE TABLE IF NOT EXISTS rejected_leaves(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, leave_id BIGINT NOT NULL, staff_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,
    reason_reject VARCHAR(1000), date_rejected VARCHAR(25) NOT NULL)";

$results[] = $db_con->query($qry);

$sqlquery = "CREATE TABLE IF NOT EXISTS recommended_leaves(id INT NOT
    NULL AUTO_INCREMENT PRIMARY KEY, leave_id BIGINT NOT NULL,
    leave_type VARCHAR(250) NOT NULL,staff_id BIGINT NOT NULL,num_days INT NOT NULL,
    recommended_by VARCHAR(250) NOT NULL,why_recommend VARCHAR(1000),
    date_recommended VARCHAR(25) NOT NULL,status ENUM('accepted','rejected'))";

$results[] = $db_con->query($sqlquery);

$sql_query = "CREATE TABLE IF NOT EXISTS job_description(id INT NOT NULL
    AUTO_INCREMENT PRIMARY KEY, staff_id BIGINT NOT NULL,
    staff_level ENUM('supervisor','non-supervisor') NOT NULL, salary_level
    DECIMAL(45,2) NOT NULL, date_joined VARCHAR(25) NOT NULL,
    annual_leave_days_allowed INT NOT NULL, total_leave_days INT NOT NULL,
    total_taken_leaves INT NOT NULL)";

$results[] = $db_con->query($sql_query);

$sql = "CREATE TABLE IF NOT EXISTS departments(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200) NOT NULL)";
$results[] = $db_con->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS faculties(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200) NOT NULL)";
$results[] = $db_con->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS employee(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, staff_id BIGINT NOT NULL UNIQUE, payroll_number VARCHAR(100) NOT NULL,
    department_id INT NOT NULL, position_or_rank VARCHAR(200) NOT NULL,
    title VARCHAR(20) NOT NULL, fname VARCHAR(150) NOT NULL, lname VARCHAR(150) NOT NULL,
    username VARCHAR(70) NOT NULL UNIQUE,password VARCHAR(250) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE, country_code VARCHAR(4) NOT NULL,
    phone INT(10) UNSIGNED NOT NULL UNIQUE, supervisor VARCHAR(200),
    staff_level ENUM('supervisor','non-supervisor'),
    date_registered DATE NOT NULL)";

$results[] = $db_con->query($sql);

$stmt = "CREATE TABLE IF NOT EXISTS admin(id INT NOT NULL AUTO_INCREMENT
    PRIMARY KEY, admin_id BIGINT NOT NULL UNIQUE, title VARCHAR(20) NOT NULL,
    fname VARCHAR(150) NOT NULL, lname VARCHAR(150) NOT NULL,
    username VARCHAR(70) NOT NULL UNIQUE,password VARCHAR(250) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,phone INT(10) UNSIGNED NOT NULL UNIQUE,
    date_registered DATE NOT NULL)";

$results[] = $db_con->query($stmt);

// Manually ensure columns exist for existing installations
$db_con->query("ALTER TABLE employee ADD COLUMN IF NOT EXISTS payroll_number VARCHAR(100) NOT NULL AFTER staff_id");
$db_con->query("ALTER TABLE employee ADD COLUMN IF NOT EXISTS department_id INT NOT NULL AFTER payroll_number");
$db_con->query("ALTER TABLE employee ADD COLUMN IF NOT EXISTS position_or_rank VARCHAR(200) NOT NULL AFTER department_id");

// Fix job_description table for existing installations
$db_con->query("ALTER TABLE job_description ADD COLUMN IF NOT EXISTS annual_leave_days_allowed INT NOT NULL AFTER date_joined");
$db_con->query("ALTER TABLE job_description ADD COLUMN IF NOT EXISTS total_leave_days INT NOT NULL AFTER annual_leave_days_allowed");
$db_con->query("ALTER TABLE job_description ADD COLUMN IF NOT EXISTS total_taken_leaves INT NOT NULL AFTER total_leave_days");

// Populate departments with comprehensive UMU list
$check_dept = $db_con->query("SELECT id FROM departments LIMIT 1");
$depts = [
    // Academic Faculties & Schools
    "Faculty of Agriculture", 
    "Faculty of Business Administration and Management", 
    "Faculty of Education",
    "Faculty of Health Sciences", 
    "Faculty of Science", 
    "Faculty of the Built Environment",
    "Faculty of Engineering and Applied Sciences", 
    "Institute of Ethics and Development Studies",
    "Institute of Languages and Communication Studies", 
    "School of Arts and Social Sciences",
    "School of Postgraduate Studies and Research", 
    "Mother Kevin Postgraduate Medical School",
    "East African School of Diplomacy, Governance and International Studies",
    "Center for African Studies",
    
    // Administrative Departments
    "Human Resource Department", 
    "Finance Department", 
    "ICT Department",
    "Registry Department", 
    "Library Department", 
    "Estates and Works Department",
    "Public Relations and Communications Office", 
    "Quality Assurance Directorate",
    "Office of the Vice-Chancellor", 
    "Office of the Registrar", 
    "Student Affairs Office",
    "Security Department",
    "Procurement and Disposal Unit",
    "Institutional Advancement Office"
];

foreach($depts as $dept){
    // Check if department exists to avoid duplicates
    $name_safe = $db_con->real_escape_string($dept);
    $exists = $db_con->query("SELECT id FROM departments WHERE name = '$name_safe'");
    if($exists->num_rows == 0){
        $db_con->query("INSERT INTO departments(name) VALUES('$name_safe')");
    }
}

// Seed Default Admin User if missing
$check_admin = $db_con->query("SELECT id FROM admin WHERE username = 'admin'");
if($check_admin->num_rows == 0){
    $admin_id = date('mYdHis');
    $admin_pass = password_hash('admin123', PASSWORD_DEFAULT);
    $db_con->query("INSERT INTO admin(admin_id, title, fname, lname, username, password, email, phone, date_registered) 
                    VALUES('$admin_id', 'Mr', 'System', 'Admin', 'admin', '$admin_pass', 'hrm@umu.ac.ug', '0700000000', CURDATE())");
}

// Seed Default Staff User if missing
$check_staff = $db_con->query("SELECT id FROM employee WHERE username = 'staff'");
if($check_staff->num_rows == 0){
    $staff_id = date('mYdHis') . "1";
    $staff_pass = password_hash('staff123', PASSWORD_DEFAULT);
    // Note: department_id 1 corresponds to "Faculty of Agriculture" after seeding
    $db_con->query("INSERT INTO employee(staff_id, payroll_number, department_id, position_or_rank, title, fname, lname, username, password, email, country_code, phone, staff_level, date_registered) 
                    VALUES('$staff_id', 'UMU-ST-001', 1, 'Lecturer', 'Mr', 'Test', 'Staff', 'staff', '$staff_pass', 'staff@umu.ac.ug', '+256', '711111111', 'non-supervisor', CURDATE())");
}

// Seed Default Supervisor User if missing
$check_super = $db_con->query("SELECT id FROM employee WHERE username = 'supervisor'");
if($check_super->num_rows == 0){
    $super_id = date('mYdHis') . "2";
    $super_pass = password_hash('super123', PASSWORD_DEFAULT);
    $db_con->query("INSERT INTO employee(staff_id, payroll_number, department_id, position_or_rank, title, fname, lname, username, password, email, country_code, phone, staff_level, supervisor, date_registered) 
                    VALUES('$super_id', 'UMU-SU-201', 6, 'HOD ICT', 'Dr', 'Leo', 'Supervisor', 'supervisor', '$super_pass', 'hod-ict@umu.ac.ug', '+256', '722222222', 'supervisor', 'N/A', CURDATE())");
}
?>
