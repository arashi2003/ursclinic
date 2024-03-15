<?php

session_start();
include('../../../connection.php');
include('../../../includes/student-auth.php');

$module = 'history';
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
$campus = $_SESSION['campus'];

// get the total nr of rows.
$records = $conn->query("select * from appointment WHERE status='Pending'");
$nr_of_rows = $records->num_rows;

include('../../../includes/pagination-limit.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>History</title>
    <?php include('../../../includes/header.php') ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">HISTORY</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user WHERE 
                        ((au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'disapproved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'cancelled a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'completed a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'dismissed a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added a walk-in schedule%' AND au.activity LIKE '%$campus') 
                        OR (au.activity LIKE 'cancelled a walk-in schedule%' AND au.activity LIKE '%$campus')) 
                        AND au.status = 'unread' AND au.user != '$userid'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_num_rows($result)) {
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifes">
                                <?= $row ?>
                            </span>
                        <?php
                        }
                        ?>
                    </button>
                </div>
                <div class="profile-details">
                    <?php
                    $image = "SELECT * FROM patient_image WHERE patient_id = '$userid'";
                    $result = mysqli_query($conn, $image);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="profile">
                        <img src="../../../images/<?php echo $row['image']; ?>">
                    </div>
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
                <div class="content">
                    <h3>History Appointments</h3>
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="physician" class="form-select">
                                                <option value="">Select Physician</option>
                                                <option value="NONE" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <option value="GODWIN A. OLIVAS" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'GODWIN A. OLIVAS' ? 'selected' : '') : '' ?>>GODWIN A. OLIVAS</option>
                                                <option value="EDNA C. MAYCACAYAN" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'EDNA C. MAYCACAYAN' ? 'selected' : '') : '' ?>>EDNA C. MAYCACAYAN</option>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="history" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['date']) && $_GET['date'] != '') {
                                    $date = $_GET['date'];
                                    $count = 1;
                                    $sql = "SELECT a.id, a.patient, a.date, a.time_from, a.time_to, a.physician, a.type, a.purpose, a.chiefcomplaint, a.others, a.status, t.type, p.purpose
                                    FROM appointment a 
                                    INNER JOIN appointment_type t on t.id=a.type 
                                    INNER JOIN appointment_purpose p on p.id=a.purpose
                                    WHERE a.date='$date' AND a.patient='$userid' AND a.status IN ('COMPLETED', 'DISAPPROVED')
                                    ORDER BY a.date, a.time_from, a.time_to LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['physician']) && $_GET['physician'] != '') {
                                    $physician = $_GET['physician'];
                                    $count = 1;
                                    $sql = "SELECT a.id, a.patient, a.date, a.time_from, a.time_to, a.physician, a.type, a.purpose, a.chiefcomplaint, a.others, a.status, t.type, p.purpose
                                    FROM appointment a 
                                    INNER JOIN appointment_type t on t.id=a.type 
                                    INNER JOIN appointment_purpose p on p.id=a.purpose
                                    WHERE a.physician='$physician' AND a.patient='$userid' AND a.status IN ('COMPLETED', 'DISAPPROVED')
                                    ORDER BY a.date, a.time_from, a.time_to LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT * FROM med_history WHERE userid='$userid' LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Appointment No.</th>
                                                    <th>Date</th>
                                                    <th>Time from</th>
                                                    <th>Time to</th>
                                                    <th>Physician</th>
                                                    <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $data) {
                                                ?>
                                                    <tr>
                                                        <?php $data['id']; ?>
                                                        <td><?php $id = $count;
                                                            echo $id; ?></td>
                                                        <td><?php echo $data['date'] ?></td>
                                                        <td><?php echo date("h:i a", strtotime($data['time_from'])) ?></td>
                                                        <td><?php echo date("h:i a", strtotime($data['time_to'])) ?></td>
                                                        <td><?php echo $data['pod_nod'];
                                                            $count++; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewrecord<?php echo $data['id'] ?>">Expand</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    include('modals/view-record-modal.php');
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php include('../../../includes/pagination.php') ?>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7">
                                                <h3>No record Found</h3>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                mysqli_close($conn);
                                ?>
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