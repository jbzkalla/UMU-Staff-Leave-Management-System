</div>
<footer class="footer py-4">
    <div class="container">
        <div class="row">
            <!-- Quick Links -->
            <div class="col-md-4 mb-3">
                <h5 class="border-bottom pb-2" style="font-size: 1rem; color: #F6F09F;">Quick Links</h5>
                <ul class="footer-list" style="list-style: none; padding-left: 0;">
                    <li><a href="about.php" class="text-white-50"><i class="fa fa-info-circle mr-2"></i>About System</a></li>
                    <li><a href="https://umu.ac.ug" target="_blank" class="text-white-50"><i class="fa fa-external-link mr-2"></i>Official UMU Website</a></li>
                    <li><a href="https://umu.ac.ug/staff-portal/" target="_blank" class="text-white-50"><i class="fa fa-university mr-2"></i>Staff Portal</a></li>
                </ul>
            </div>

            <!-- Institutional Contact -->
            <div class="col-md-4 mb-3">
                <h5 class="border-bottom pb-2" style="font-size: 1rem; color: #F6F09F;">HR Office Contact</h5>
                <ul class="footer-list" style="list-style: none; padding-left: 0;">
                    <li class="text-white-50"><i class="fa fa-envelope mr-2"></i>hrm@umu.ac.ug</li>
                    <li class="text-white-50"><i class="fa fa-phone mr-2"></i>+256 382 410611</li>
                    <li class="text-white-50"><i class="fa fa-map-marker mr-2"></i>Nkozi, Uganda</li>
                </ul>
            </div>

            <!-- System Statistics -->
            <div class="col-md-4 mb-3">
                <h5 class="border-bottom pb-2" style="font-size: 1rem; color: #F6F09F;">System Overview</h5>
                <?php
                // Fetch stats if db_con exists
                if(isset($db_con)){
                    $staff_count = $db_con->query("SELECT COUNT(*) as total FROM employee")->fetch_object()->total;
                    $pending_count = $db_con->query("SELECT COUNT(*) as total FROM leave_applications WHERE action IS NULL OR action = ''")->fetch_object()->total;
                } else {
                    $staff_count = "N/A";
                    $pending_count = "N/A";
                }
                ?>
                <ul class="footer-list" style="list-style: none; padding-left: 0;">
                    <li class="text-white-50">Total Registered Staff: <span class="badge badge-info" style="color: white;"><?php echo $staff_count; ?></span></li>
                    <li class="text-white-50">Pending Leave Requests: <span class="badge badge-warning" style="color: white;"><?php echo $pending_count; ?></span></li>
                    <li class="text-white-50">System Version: <span class="text-white">v2.4 - UMU Edition</span></li>
                </ul>
            </div>
        </div>

        <div class="row pt-3 border-top mt-3">
            <div class="col-12 text-center">
                <h6 style="color: #F6F09F; font-size: 0.85rem; margin-bottom: 5px;">
                    &copy; <?php echo date("Y"); ?> Mudiima Leon &ndash; Reg:20223-B291-11709. All rights reserved.
                </h6>
                <p class="text-white-50" style="font-size: 0.85rem; max-width: 800px; margin: 0 auto; line-height: 1.4;">
                    Uganda Martyrs University. Leon SmartLeave.
                </p>
            </div>
        </div>
    </div>
</footer>
<?php
include 'scripts.php';
?>
</body>
</html>
