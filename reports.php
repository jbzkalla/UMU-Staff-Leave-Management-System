<?php
if(!isset($_SESSION['admin-user'])){
    die("Access Denied");
}

$dept_id = isset($_GET['dept']) ? intval($_GET['dept']) : 0;
$start_date = isset($_GET['from']) ? $_GET['from'] : '';
$end_date = isset($_GET['to']) ? $_GET['to'] : '';

?>

<div class="card p-4">
    <h3 class="text-center mb-4">Advanced Institutional Reporting</h3>
    
    <form action="admin.php" method="GET" class="mb-4">
        <input type="hidden" name="tab" value="9">
        <div class="row">
            <div class="col-md-4 mb-2">
                <label>Department</label>
                <select name="dept" class="form-control">
                    <option value="0">All Departments</option>
                    <?php
                    $depts = $db_con->query("SELECT * FROM departments");
                    while($d = $depts->fetch_object()){
                        $sel = ($dept_id == $d->id) ? 'selected' : '';
                        echo "<option value='$d->id' $sel>$d->department_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label>From</label>
                <input type="date" name="from" class="form-control" value="<?php echo $start_date; ?>">
            </div>
            <div class="col-md-3 mb-2">
                <label>To</label>
                <input type="date" name="to" class="form-control" value="<?php echo $end_date; ?>">
            </div>
            <div class="col-md-2 mb-2">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>

    <div class="reporting-results">
        <h4>Leave Summary Report</h4>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Staff Name</th>
                    <th>Department</th>
                    <th>Leave Type</th>
                    <th>Duration</th>
                    <th>Stage</th>
                    <th>Requested</th>
                </tr>
            </thead>
            <tbody>
                <?php
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
                if($reports->num_rows > 0){
                    while($r = $reports->fetch_object()){
                        echo "<tr>
                                <td>$r->fname $r->lname</td>
                                <td>$r->department_name</td>
                                <td>$r->leave_type</td>
                                <td>$r->leave_start_date to $r->leave_end_date</td>
                                <td><span class='badge badge-info'>$r->approval_stage</span></td>
                                <td>$r->date_requested</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No records found for the selected criteria.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <div class="mt-3 text-right">
            <button onclick="window.print()" class="btn btn-secondary">Print Report</button>
            <a href="export_csv.php?dept=<?php echo $dept_id; ?>&from=<?php echo $start_date; ?>&to=<?php echo $end_date; ?>" class="btn btn-success">Export to CSV</a>
        </div>
    </div>
</div>
