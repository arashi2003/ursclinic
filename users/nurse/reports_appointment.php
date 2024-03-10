<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'reports_appointment';
$campus = $_SESSION['campus'];
$userid=$_SESSION['userid'];

if (!isset($_SESSION['username'])) {
    header('location:../../index');
}

// get the total nr of rows.
$records = $conn->query("SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.patient, ap.type, ap.status, ap.purpose, ac.campus, ac.firstname, ac.middlename, ac.lastname, t.type, p.purpose FROM appointment ap INNER JOIN account ac ON ac.accountid=ap.patient INNER JOIN appointment_type t ON t.id=ap.type INNER JOIN appointment_purpose p ON p.id=ap.purpose ORDER BY ap.date, ap.time_from, ap.time_to");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Reports</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT REPORT</span>
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
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.open('reports/reports_appointment.php');">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="reports_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="reports" class="form-select">
                                                <option value="" disabled>Select Report</option>
                                                <option value="appointment" selected>Appointment Report</option>
                                                <option value="docvisit">Doctor's Visit Schedule Report</option>
                                                <option value="transaction">Transaction Report</option>
                                                <option value="medcase">Medical Cases</option>
                                                <option value="medinv">Medicine Consumption Report</option>
                                                <option value="supinv">Medical Supply Consumption Report</option>
                                                <option value="teinv">Tools and Equipment Inventory Report</option>
                                                <option value="tecalimain">Tools and Equipment Calibration and Maintenance Report</option>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="physician" class="form-select">
                                                <option value="">Select Physician</option>
                                                <?php
                                                $sql = "SELECT DISTINCT physician FROM appointment ORDER BY physician";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {?>
                                                <option value="<?php echo $row['physician'];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row['physician'] ? 'selected' : '') : '' ?>"><?php echo $row['physician'];?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="status" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT status FROM appointment ORDER BY status";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {  ?>
                                                <option value="<?php echo $row['status'];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row['status'] ? 'selected' : '') : '' ?>"><?php echo strtoupper($row['status']);?></option><?php }}?>
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
                                            <a href="reports_appointment" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '' || isset($_GET['physician']) && $_GET['physician'] != '' || isset($_GET['status']) && $_GET['status'] != '') {
                                    $dt_from = $_GET['date_from'];
                                    $dt_to = $_GET['date_to'];
                                    $pod =  $_GET['physician'];
                                    $status = $_GET['status'];


                                    //campus filter
                                    if ($campus == "")
                                    {
                                        $ca = "";
                                    }
                                    else
                                    {
                                        $ca = " WHERE ac.campus = '$campus'";
                                    }

                                    //date filter
                                    if ($dt_from =="" AND $dt_to =="")
                                    {
                                        $date = "";
                                    }
                                    elseif ($ca == "" AND $dt_to == $dt_from)
                                    {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
                                    }
                                    elseif ($ca != "" AND $dt_to == $dt_from)
                                    {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                    }

                                    elseif ($ca == "" AND $dt_to == "" AND $dt_from != "" )
                                    {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $date = " AND date >= '$fdate'";
                                    }
                                    elseif ($ca != "" AND $dt_to == "" AND $dt_from != "" )
                                    {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $date = " AND date >= '$fdate'";
                                    }
                                    elseif ($ca == "" AND $dt_from == "" AND $dt_to != "" )
                                    {
                                        $d = date("Y-m-d", strtotime($dt_to));
                                        $date = " WHERE date <= '$d'";
                                    }
                                    elseif ($ca != "" AND $dt_from == "" AND $dt_to != "" )
                                    {
                                        $d = date("Y-m-d", strtotime($dt_to));
                                        $date = " AND date <= '$d'";
                                    }
                                    elseif ($ca == "" AND $dt_from != "" AND $dt_to != "" AND $dt_from != $dt_to)
                                    {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
                                    }
                                    elseif ($ca != "" AND $dt_from != "" AND $dt_to != "" AND $dt_from != $dt_to)
                                    {
                                        $fdate = date("Y-m-d", strtotime($dt_from));
                                        $ldate = date("Y-m-d", strtotime($dt_to));
                                        $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                    }

                                    //physician filter
                                    if ($pod =="")
                                    {
                                        $doc = "";
                                    }
                                    elseif ($ca == "" AND $date== "" AND $pod != "")
                                    {
                                        $doc = " WHERE ap.physician = '$pod'";
                                    }
                                    elseif ($ca != "" OR $date!= "" AND $pod != "")
                                    {
                                        $doc = " AND ap.physician = '$pod'";
                                    }

                                    //status filter
                                    if ($status =="")
                                    {
                                        $st = "";
                                    }
                                    elseif ($ca == "" AND $date == "" AND $doc == "" AND $status != "")
                                    {
                                        $st = " WHERE ap.status = '$status'";
                                    }
                                    elseif ($ca != "" OR $date != "" OR $doc != "" AND $status != "")
                                    {
                                        $st = " AND ap.status = '$status'";
                                    }

                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.patient, ap.type, ap.status, ap.purpose, ac.campus, ac.firstname, ac.middlename, ac.lastname, t.type, p.purpose FROM appointment ap INNER JOIN account ac ON ac.accountid=ap.patient INNER JOIN appointment_type t ON t.id=ap.type INNER JOIN appointment_purpose p ON p.id=ap.purpose $ca $date $doc $st ORDER BY ap.date, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.patient, ap.type, ap.status, ap.purpose, ac.campus, ac.firstname, ac.middlename, ac.lastname, t.type, p.purpose FROM appointment ap INNER JOIN account ac ON ac.accountid=ap.patient INNER JOIN appointment_type t ON t.id=ap.type INNER JOIN appointment_purpose p ON p.id=ap.purpose WHERE campus = '$campus' ORDER BY ap.date, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Physician</th>
                                            <th>Patient</th>
                                            <th>Type and Purpose</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($result as $row) {
                                                if (count(explode(" ", $row['middlename'])) > 1)
                                                {
                                                    $middle = explode(" ", $row['middlename']);
                                                    $letter = $middle[0][0].$middle[1][0];
                                                    $middleinitial = $letter . ".";
                                                }
                                                else
                                                {
                                                    $middle = $row['middlename'];
                                                    if ($middle == "" OR $middle == " ")
                                                    {
                                                        $middleinitial = "";
                                                    }
                                                    else
                                                    {
                                                        $middleinitial = substr($middle, 0, 1) . ".";
                                                    }    
                                                }
                                                if($row['physician'] == NULL)
                                                {
                                                    $physician = "NONE";
                                                }
                                                else
                                                {
                                                    $physician = $row['physician'];
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id'] ?></td>
                                                <td><?php echo date("F d, Y", strtotime($row['date'])) ?></td>
                                                <td><?php echo date("g:i A", strtotime($row['time_from'])) . " - " . date("g:i A", strtotime($row['time_to'])) ?></td>
                                                <td><?php echo $physician ?></td>
                                                <td><?php echo ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname']))?></td>
                                                <td><?php echo $row['type'] . " - " . $row['purpose'] ?></td>
                                                <td><?php echo strtoupper($row['status']) ?></td>
                                            </tr>  
                                        <?php
                                        }}}
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