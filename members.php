<?php
include("header.php");

if(session_id() == ""){
    session_start();
}

if(!isset($_SESSION['staff-user']) && !isset($_SESSION['admin-user']) && !isset($_SESSION['supervisor-user'])){
    redirect_user("login.php");
}

?>
<div class="container my-5">
    <div class="card p-4">
        <h2 class="mb-4 text-center">UMU Staff Members</h2>
        <table class="table table-striped table-bordered table-responsive-xl">
            <thead class="thead-dark">
                <tr>
                    <th>Staff Name</th>
                    <th>Staff ID</th>
                    <th>Department</th>
                    <th>Position / Rank</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $query = "SELECT e.fname, e.lname, e.staff_id, e.position_or_rank, d.name as dept_name 
                      FROM employee e 
                      LEFT JOIN departments d ON e.department_id = d.id 
                      ORDER BY e.fname ASC";
            $res = $db_con->query($query);
            
            if($res->num_rows > 0){
                while($row = $res->fetch_object()){
                    echo "<tr>
                            <td>{$row->fname} {$row->lname}</td>
                            <td>{$row->staff_id}</td>
                            <td>" . ($row->dept_name ?? 'N/A') . "</td>
                            <td>{$row->position_or_rank}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No members found.</td></tr>";
            }
            ?>
            </tbody>
        </table>      
    </div>
</div>
<?php include('footer.php'); ?>
