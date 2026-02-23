<?php
include_once("styles.php");

if(isset($_SESSION['username'])){

    echo "<script>histroy.back();</script>";

}

?>

<div class="container">
<h1 class="text-hide">Signup for an account</h1>

<h4 class="text-center">Register for an account</h4>

    <div class="row">

        <div class="col-md-6 mb-3 mx-auto">

            <div class="card login">

<?php

            if(isset($_GET['error']) && !empty($_GET['error'])){

                $error = $_GET['error'];
                
                echo "<small class='alert alert-danger alert-dismissible'>$error
                <span class='close' data-dismiss='alert'>&times;</span></small>";
            }
 
?>


    <form action="process.php" method="post" id="signup">
        
        <div class="row mb-2">
            <div class="col-md-4 mb-md-2">
                <label for="title">Title</label><br>
                <select name="title" id="title" class="form-control">
                    <option value="Mr">Mr</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                    <option value="Prof">Prof</option>
                    <option value="Rev">Rev</option>
                </select>
            </div>
            <div class="col-md-8 mb-2">
                <label for="username">Username / Staff ID</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="e.g. leon.m">
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md-6 mb-3">
                <label for="payroll">Payroll Number</label>
                <input type="text" name="payroll" id="payroll" class="form-control" placeholder="UMU-PN-XXXX">
            </div>
            <div class="col-md-6 mb-3">
                <label for="department">Department</label>
                <select name="department" id="department" class="form-control">
                    <option value="">Select Department</option>
                    <?php
                    $dept_res = $db_con->query("SELECT * FROM departments ORDER BY name ASC");
                    while($dept = $dept_res->fetch_assoc()){
                        echo "<option value='".$dept['id']."'>".$dept['name']."</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
            
        <div class="row my-2">
            <div class="col-md-4 mb-3">
                <label for="firstname">Firstname</label>
                <input type="text" name="firstname" id="firstname" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label for="lastname">Lastname</label>
                <input type="text" name="lastname" id="lastname" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label for="rank">Rank / Position</label>
                <select name="rank" id="rank" class="form-control" required>
                    <option value="">Select Rank</option>
                    <option value="Professor">Professor</option>
                    <option value="Associate Professor">Associate Professor</option>
                    <option value="Senior Lecturer">Senior Lecturer</option>
                    <option value="Lecturer">Lecturer</option>
                    <option value="Assistant Lecturer">Assistant Lecturer</option>
                    <option value="Teaching Assistant">Teaching Assistant</option>
                    <option value="Administrator">Administrator</option>
                    <option value="Support Staff">Support Staff</option>
                </select>
            </div>
        </div>
        <div class="container el">
            <label class="padding-none">Phone Number</label>
            <hr class="divider">

            <div class="row">
                <div class="col-4 stacked-el">
                    <label for="code" class="text-sm padding-none">Country code</label><br>
                    <select name="country-code" id="code">
                        <?php

                        for($i = 1; $i < 301; $i++){
                            echo "<option value='+$i'>+$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-8 stacked-el">
                    <label for="phone" class="text-sm padding-none">Number</label><br>
                    <input type="text" name="phone" placeholder="543000391" id="phone">
                </div>
            </div>
        </div>
        
        <div class="row mb-2">
            
            <div class="col-md-6 mb-2">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-yellow" type="submit" name="register">
            Register
        </button>
        <p class="text-sm">
            Already registered?
            <a href="index.php" class="text-sm">Login here</a>
        </p>
    </form>
    </div>
   </div>
  </div>
 </div>

<?php include('footer.php');

