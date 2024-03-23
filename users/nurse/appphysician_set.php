<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'appphysician_set';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM appointment_physician");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Settings</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT PHYSICIAN</span>
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
                                echo $name ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="usertype"><?= $usertype ?></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#physician_set">Add Entry</button>
                    <?php include('modals/appphysician_set_modal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md">
                                <form action="app_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="app" class="form-select">
                                                <option value="type">Type</option>
                                                <option value="purpose">Purpose</option>
                                                <option value="cc">Chief Complaint</option>
                                                <option value="physician" selected>Physician</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="physician" value="<?= isset($_GET['physician']) == true ? $_GET['physician'] : '' ?>" class="form-control" placeholder="Search appointment physician   ">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="head">
                                        <tr>
                                            <th>ID</th>
                                            <th>Appointment Type</th>
                                            <th>Appointment Purpose</th>
                                            <th>Physician</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['physician']) && $_GET['physician'] != '') {
                                            $physician = $_GET['physician'];
                                            $count = 1;
                                            $sql = "SELECT * FROM appointment_physician ap INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE physician LIKE '%$physician%' ORDER BY ap.purpose, ap.physician LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM appointment_physician ap INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type ORDER BY ap.purpose, ap.physician LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                        ?>
                                                    <tr>
                                                        <td><?php echo $data['id']; ?></td>
                                                        <td><?php echo $data['type']; ?></td>
                                                        <td><?php echo $data['purpose']; ?></td>
                                                        <td><?php echo $data['physician']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removephysician_set<?php echo $data['id'] ?>">Remove</button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    include('modals/rem_physician_set_modal.php');
                                                }
                                            }
                                            ?>
                                        <?php
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="12">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php'); ?>
                            </div>
                        </div>
                    </div>
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