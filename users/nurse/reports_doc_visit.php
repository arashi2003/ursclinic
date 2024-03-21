<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'report_doc_visit';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM schedule WHERE campus = '$campus'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Inventory</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">DOCTOR'S VISIT SCHEDULE REPORT</span>
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
                    <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_doc_visit.php');">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="reports_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="reports" class="form-select">
                                                <option value="" disabled selected>Select Report</option>
                                                <option value="appointment">Appointment Report</option>
                                                <option value="docvisit" selected>Doctor's Visit Schedule Report</option>
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
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="physician" class="form-select">
                                                <option value="">Select Physician</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM account WHERE usertype='DOCTOR' OR usertype='DENTIST' ORDER BY firstname";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
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
                                                        $physician = ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($row['lastname'])); ?>
                                                        <option value="<?php echo $row['accountid']; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $physician ? 'selected' : '') : '' ?>"><?php echo $physician; ?></option><?php }
                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_from" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_to" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_doc_visit" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Physician</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Max. No. of Patients</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['physician']) && $_GET['physician'] != '' || isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                            $physician = $_GET['physician'];
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];

                                            //date filter
                                            if ($dt_from == "" and $dt_to == "") {
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-t", strtotime($dt_to));
                                                $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND date >= '$fdate'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND date >= '$fdate'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-t", strtotime($dt_to));
                                                $date = " AND date <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-t", strtotime($dt_to));
                                                $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                            }

                                            //physician filter
                                            if ($physician == "") {
                                                $doc = "";
                                            } elseif ($physician != "" and $date == "") {
                                                $doc = " AND physician = '$physician'";
                                            } elseif ($date != "" and $physician != "") {
                                                $doc = " AND physician = '$physician'";
                                            }

                                            $count = 1;
                                            $sql = "SELECT physician, date, time_from, time_to, s.campus, maxp, firstname, middlename, lastname FROM schedule s INNER JOIN account a ON a.accountid=s.physician WHERE s.campus = '$campus' $date $doc ORDER BY date DESC, time_from ASC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT physician, date, time_from, time_to, s.campus, maxp, firstname, middlename, lastname FROM schedule s INNER JOIN account a ON a.accountid=s.physician WHERE s.campus = '$campus' ORDER BY date DESC, time_from ASC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                                    if (count(explode(" ", $data['middlename'])) > 1) {
                                                        $middle = explode(" ", $data['middlename']);
                                                        $letter = $middle[0][0] . $middle[1][0];
                                                        $middleinitial = $letter . ".";
                                                    } else {
                                                        $middle = $data['middlename'];
                                                        if ($middle == "" or $middle == " ") {
                                                            $middleinitial = "";
                                                        } else {
                                                            $middleinitial = substr($middle, 0, 1) . ".";
                                                        }
                                                    }

                                                    $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));
                                        ?>
                                                    <tr>
                                                        <td><?php echo $fullname; ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_from'])) . " - " . date("g:i A", strtotime($data['time_to'])) ?></td>
                                                        <td><?php echo $data['maxp'];
                                                        }
                                                    } ?></td>
                                                    </tr>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php'); ?>
                            <?php
                                        } else {
                            ?><td colspan="7">
                                    <?php
                                            include('../../includes/no-data.php');
                                    ?>
                                </td>
                            <?php
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