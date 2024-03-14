<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'reports_transaction';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

$now = date("Y-m-t");

// get the total nr of rows.
$records = $conn->query(
    "SELECT * FROM transaction_history WHERE campus = '$campus'"
);
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Reports</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?= $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">
                    <H1>TRANSACTION REPORT</H1>
                </span>
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
                    <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_trans.php');">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="reports_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="reports" class="form-select">
                                                <option value="" disabled>Select Report</option>
                                                <option value="appointment">Appointment Report</option>
                                                <option value="docvisit">Doctor's Visit Schedule Report</option>
                                                <option value="transaction" selected>Transaction Report</option>
                                                <option value="medcase">Medical Cases</option>
                                                <option value="medinv">Medicine Consumption Report</option>
                                                <option value="supinv">Medical Supply Consumption Report</option>
                                                <option value="teinv">Tools and Equipment Inventory Report</option>
                                                <option value="tecalimain">Tools and Equipment Calibration and Maintenance Report</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 mb-2">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="date" name="date_from" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_to" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_teinv" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                    $dt_from = $_GET['date_from'];
                                    $dt_to = $_GET['date_to'];
                                    $count = 1;

                                    //campus filter
                                    if ($campus == "") {
                                        $ca = "";
                                    } else {
                                        $ca = " WHERE t.campus = '$campus'";
                                    }

                                    //date filter
                                    if ($dt_from == "" and $dt_to == "") {
                                        $date = "";
                                    } elseif ($ca == "" and $dt_to == $dt_from) {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
                                    } elseif ($ca != "" and $dt_to == $dt_from) {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                    } elseif ($ca == "" and $dt_to == "" and $dt_from != "") {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $date = " AND date >= '$fdate'";
                                    } elseif ($ca != "" and $dt_to == "" and $dt_from != "") {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $date = " AND date >= '$fdate'";
                                    } elseif ($ca == "" and $dt_from == "" and $dt_to != "") {
                                        $d = date("Y-m-d", strtotime($dt_to));
                                        $date = " WHERE date <= '$d'";
                                    } elseif ($ca != "" and $dt_from == "" and $dt_to != "") {
                                        $d = date("Y-m-d", strtotime($dt_to));
                                        $date = " AND date <= '$d'";
                                    } elseif ($ca == "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
                                    } elseif ($ca != "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                    }

                                    $sql = "SELECT id, patient, firstname, middlename, lastname, designation, age, sex, department, college, program, 
                                    birthday, yearlevel, section,
                                    type, transaction, purpose, height,
                                    weight, bp, pr, temp, heent, chest_lungs,
                                    heart, abdomen, extremities, bronchial_asthma, surgery, 
                                    lmp, heart_disease, allergies, epilepsy, hernia,
                                    respiratory, oxygen_saturation, chief_complaint, findiag,
                                    remarks, medsup, pod_nod, medcase, medcase_others, 
                                    datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial
                                    FROM transaction_history 
                                    WHERE $ca $date ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $now = date("Y-m-t");
                                    $sql = "SELECT id, patient, firstname, middlename, lastname, 
                                    designation, age, sex, department, college, program, 
                                    birthday, yearlevel, section,
                                    type, transaction, purpose, height,
                                    weight, bp, pr, temp, heent, chest_lungs,
                                    heart, abdomen, extremities, bronchial_asthma, surgery, 
                                    lmp, heart_disease, allergies, epilepsy, hernia,
                                    respiratory, oxygen_saturation, chief_complaint, findiag,
                                    remarks, medsup, pod_nod, medcase, medcase_others, 
                                    datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial
                                    FROM transaction_history 
                                    WHERE campus = '$campus' ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Patient</th>
                                                    <th>Physician/Nurse On Duty</th>
                                                    <th>Transaction</th>
                                                    <th>Date and Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $row) {
                                                    if (count(explode(" ", $row['middlename'])) > 1) {
                                                        $middle = explode(" ", $row['middlename']);
                                                        $letter = $middle[0][0] . $middle[1][0];
                                                        $middleinitial = $letter . ".";
                                                    } else {
                                                        $middle = $row['middlename'];
                                                        if ($middle == "" or $middle == " ") {
                                                            $middleinitial = "";
                                                        } else {
                                                            $middleinitial = substr($middle, 0, 1) . ".";
                                                        }
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?= $row['id'] ?></td>
                                                        <td><?= ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($row['lastname'])) ?></td>
                                                        <td><?= $row['pod_nod'] ?></td>
                                                        <td><?= $row['type'] . " - " . $row['transaction'] ?></td>
                                                        <td><?= date("M d, Y", strtotime($row['datetime'])) . " " . date("g:i A", strtotime($row['datetime'])) ?></td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php') ?>
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