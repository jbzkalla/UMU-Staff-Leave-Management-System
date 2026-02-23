<?php

 include_once("header.php");
    
if(isset($_SESSION['admin-user']) && $_SESSION['admin-user'] !== ""){

    $username = $_SESSION['admin-user'];
    $id = $_SESSION['admin-id'];

    $stmt = $db_con->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $row = $result->fetch_object();
        $fullname = $row->fname." ".$row->lname;
    }

    include_once("dash-header.php");
   
     echo "<div class='col-md-8 ml-md-3'>"
    . "<div class='main-content'>";
      show_alert();
    
   
    $date_posted = date('Y-m-d');

    $time_posted = date('h:m:sa',time());

    if(isset($_GET['tab']) && $_GET['tab'] == 1){

        $leave_types = ['annual'=>"Annual Leave",'sick'=>"Sick Leave",'maternity'=>'Maternity Leave',
        'paternity'=>'Paternity Leave','study'=>'Study Leave','emergency'=>'Emergency Leave',
        'casual'=>'Casual Leave','special'=>'Special Leave','examinations'=>'Exams Leave',
        'sports'=>'Sports Leave','absense'=>'Absence Leave',
        'short_embark_disembark'=>'Short Embarkation/Disembarkation Leave',
        'long_embark_disembark'=>'Long Embarkation/Disembarkation Leave'];
    
        echo "<h1 class='text-center hide'>New Leave Type</h1>

                <form action='leaves.php' method='post' class='mb-5'>
                
                    <label for='leave-type'>Leave Type</label><br>
                    <select name='leave_type' id='leave-type' class='selectable' required>
                        <option value=''>---Select---</option>";
        
                    foreach($leave_types as $key=>$value){
                        echo "<option value='$key'>$value</option>";
                    }
                    unset($leave_types);

                    $leave_id = rand(10, 20).date("U");
                    
                    $date_now = date("U")+2591590;
                    
                    $auto_date = date("U") + 2591590;

                    $dif = intval($date_now) - intval($auto_date);
                    
                    echo "</select><hr>
                
                    <label for='title'>Allowed Days</label><br>
                            
                    <input type='number' min='0' name='allowed_days' id='days' required><br>
                    <div id='hint' class='hide text-red'>
                    
                        <ul style='list-style-type:none;font-size:13px;'><br>
                            <b>Note:</b>
                            <li> 0 means Indefinite</li>
                            <li> 1 or more convey actual days</li>
                        </ul>
                    </div><hr>
                    <label for='title'>Allowed Monthly Days</label><br>
                            
                    <input type='number' min='1' name='allowed_monthly_days' required>
                    
                    <input type='hidden' name='leave_id' value='$leave_id'>
                    <input type='hidden' name='auto_update' value='$auto_date'>
                    <hr>
                    <label>Staff Level</label><br>
                    <select name='staff_level' class='selectable'>
                        <option value='supervisor'>Supervisor</option>
                        <option value='non-supervisor'>Non-supervisor</option>
                    </select>

                    <hr><button class='btn btn-primary ml-md-5' name='new_leave'>Publish Leave</button>

                </form><hr><br>";

    }elseif(isset($_GET['tab']) && $_GET['tab'] == 2){

        include_once("approve.php");
        
    }elseif(isset($_GET['tab']) && $_GET['tab'] == 3){

        include_once("pending-leaves.php");
        
    } elseif(isset($_GET['tab']) && $_GET['tab'] == 4){

        include_once("account.php");
        
    } elseif(isset($_GET['tab']) && $_GET['tab'] == 5){

        include_once("assign.php");
        
    }elseif(isset ($_GET['tab']) && $_GET['tab'] == 6){
        include("desc.php");
    }elseif(isset ($_GET['tab']) && $_GET['tab'] == 7){
        include("new.php");
     }elseif(isset ($_GET['tab']) && $_GET['tab'] == 8){
        include("leave-meta.php");
    }else{
        ?>
        <div class="container mb-5 p-4">
            <h4 class="text-center">Institutional Control Panel – HR Admin Portal</h4>
            <p>Welcome, $fullname (HR Administrator). You are logged into the Uganda Martyrs University Staff Leave Management System.</p>
            <p>This administrative dashboard allows you to manage staff records, configure institutional leave types, assign departmental supervisors, and perform final approval/rejection of leave applications.</p>
            <p>Use the advanced reporting module to analyze departmental leave utilization and generate academic-year statistics.</p>
            <h5>Uganda Martyrs University – HR Department</h5>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <canvas id="leaveChart" style="max-height: 300px;"></canvas>
                </div>
            </div>

            <?php
            // Fetch stats for chart
            $stats_sql = "SELECT approval_stage, COUNT(*) as count FROM leave_applications GROUP BY approval_stage";
            $stats_res = $db_con->query($stats_sql);
            $labels = [];
            $data = [];
            if($stats_res && $stats_res->num_rows > 0){
                while($s = $stats_res->fetch_object()){
                    $labels[] = $s->approval_stage ? $s->approval_stage : 'Pending';
                    $data[] = $s->count;
                }
            }
            $labels_json = json_encode($labels);
            $data_json = json_encode($data);
            ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('leaveChart');
                    if(ctx){
                        new Chart(ctx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: <?php echo $labels_json; ?>,
                                datasets: [{
                                    label: 'Leave Applications by Stage',
                                    data: <?php echo $data_json; ?>,
                                    backgroundColor: 'rgba(40, 167, 69, 0.5)',
                                    borderColor: 'rgba(40, 167, 69, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: { y: { beginAtZero: true } }
                            }
                        });
                    }
                });
            </script>

            <br><br><br>
        </div>
<?php
    }
?>

<?php
    echo "</div></div>";
    ?>
    <script src="js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>
    <script>
        $('#days').on('change input', function(){
            
            var val = $(this).val();
            
            if(val !== ''){
                $("#hint").removeClass("hide");
            }else{
                
                $('#hint').addClass("hide");
            }
        });
        
    </script>
        
    </body>
    </html>
    <?php
}else{
    header("Location:index.php?action=login&type=admin");
}

include("footer.php");
?>