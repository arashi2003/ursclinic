<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'reports';
$userid = $_SESSION['userid'];
$campus = $_SESSION['campus'];

if (!isset($_SESSION['username'])) {
    header('location:../../index');
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Reports</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">REPORTS</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user INNER JOIN patient_image i ON i.patient_id=au.user WHERE (au.activity LIKE '%added a walk-in schedule%' OR au.activity 
                        LIKE 'sent a request for%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%already expired') AND au.status='unread' AND au.user != '$userid'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_num_rows($result)) {
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?= $row ?>
                            </span>
                        <?php
                        }
                        ?>
                    </button>
                </div>
                <div class="profile-details">
                    <i class='bx bx-user-circle'></i>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="admin_name">
                                <?php
                                echo $_SESSION['usertype'] . ' ' . $_SESSION['username'] ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile">Profile</a></li>
                            <li><a class="dropdown-item" href="../../logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary" disabled>Export to PDF</button>
                </div>
                <div class="content">
                    <form action="reports_filter.php" method="POST">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="reports" class="form-select">
                                    <option value="" disabled selected>Select Report</option>
                                    <option value="appointment">Appointment Report</option>
                                    <option value="docvisit">Doctor's Visit Schedule Report</option>
                                    <option value="transaction">Transaction Report</option>
                                    <option value="medcase">Medical Cases</option>
                                    <option value="medinv">Medicine Consumption Report</option>
                                    <option value="supinv">Medical Supply Consumption Report</option>
                                    <option value="teinv">Tools and Equipment Inventory Report</option>
                                    <option value="tecalimain">Tools and Equipment Calibration and Maintenance Report</option>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">View</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
</script>

</html>