<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'appointment';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$today = date("Y-m-d");
$now = date("H:i:s", strtotime("+ 8 hours"));

//auto cancel appointment
$query = "SELECT * FROM appointment WHERE appointment.status='APPROVED' AND date < '$today' AND time_from < '$now'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    foreach ($result as $data) {
        $today = date("Y-m-d");
        $now = date("H:i:s", strtotime("+ 8 hours"));

        $query = "SELECT * FROM appointment WHERE appointment.status='APPROVED' AND date < '$today' AND time_from < '$now'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            foreach ($result as $data) {
                $sql = "UPDATE appointment SET status='CANCELLED', reason='The appointment had to be cancelled as it was not fulfilled within the allocated timeframe.', created_at='$today' WHERE status='APPROVED' AND date < '$today' AND time_from < '$now'";
                if (mysqli_query($conn, $sql)) {
                    $query = "SELECT * FROM appointment WHERE appointment.status='DISMISSED' AND created_at = '$today'";
                    $result = mysqli_query($conn, $query);
                    while ($data = mysqli_fetch_array($result)) {
                        $user = $_SESSION['userid'];
                        $campus = $_SESSION['campus'];
                        $fullname = strtoupper($_SESSION['name']);
                        $au_status = "unread";
                        $patient = $data['patient'];
                        $activity = 'cancelled an appointment of ' . $patient;
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                        mysqli_query($conn, $sql);
                    }
                }
            }
        }
    }
}

// Check if the month filter is set
if (isset($_GET['request']) || isset($_GET['type']) || isset($_GET['patient']) || isset($_GET['date']) || isset($_GET['physician'])) {
    // Validate and sanitize input
    $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';
    $physician = isset($_GET['physician']) ? $_GET['physician'] : '';
    $request = isset($_GET['request']) ? $_GET['request'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    // Construct WHERE clause based on filters
    $whereClause = "";
    if ($patient !== '') {
        $whereClause .= " AND CONCAT(ac.firstname, ac.middlename, ac.lastname) LIKE '%$patient%'";
    }
    if ($date !== '') {
        $whereClause .= " AND ap.date = '$date'";
    }
    if ($physician !== '') {
        $whereClause .= " AND ap.physician = '$physician'";
    }
    if ($type !== '') {
        $whereClause .= " AND t.type = '$type'";
    }
    if ($request !== '') {
        $whereClause .= " AND p.purpose = '$request'";
    }

    // Construct and execute SQL query for pending appointments count
    $pending_sql_count = "SELECT COUNT(*) AS total_rows 
                      FROM appointment ap 
                      INNER JOIN account ac ON ac.accountid = ap.patient
                      INNER JOIN appointment_type t ON t.id=ap.type
                      INNER JOIN appointment_purpose p ON p.id=ap.purpose
                      WHERE campus ='$campus' AND ap.status = 'PENDING' $whereClause";

    // Construct and execute SQL query for approved appointments count
    $approved_sql_count = "SELECT COUNT(*) AS total_rows 
                       FROM appointment ap 
                       INNER JOIN account ac ON ac.accountid = ap.patient
                      INNER JOIN appointment_type t ON t.id=ap.type
                      INNER JOIN appointment_purpose p ON p.id=ap.purpose
                       WHERE campus ='$campus' AND (ap.status='APPROVED' OR ap.status='COMPLETED') $whereClause";
} else {
    // If no filter is set, count all rows
    $pending_sql_count = "SELECT COUNT(*) AS total_rows 
                          FROM appointment ap 
                          INNER JOIN account ac ON ac.accountid = ap.patient
                          WHERE ap.status = 'PENDING' AND campus = '$campus'";

    // Count all approved appointments
    $approved_sql_count = "SELECT COUNT(*) AS total_rows 
                           FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient 
                           INNER JOIN appointment_purpose p ON p.id=ap.purpose 
                           INNER JOIN appointment_type t ON t.id=p.type 
                           WHERE (ap.status='APPROVED' OR ap.status='COMPLETED') 
                           AND ac.campus='$campus' AND date = '$today' 
                           ORDER BY ap.status DESC, ap.date, ap.time_from, ap.time_to";
}

// Execute the count queries for pending and approved appointments
$pending_count_result = $conn->query($pending_sql_count);
$approved_count_result = $conn->query($approved_sql_count);

// Check if count queries were successful
if ($pending_count_result && $approved_count_result) {
    // Fetch the total number of rows for pending appointments
    $pending_count_row = $pending_count_result->fetch_assoc();
    $pending_nr_of_rows = $pending_count_row['total_rows'];

    // Fetch the total number of rows for approved appointments
    $approved_count_row = $approved_count_result->fetch_assoc();
    $approved_nr_of_rows = $approved_count_row['total_rows'];
} else {
    // Handle count query error
    echo "Error: " . $conn->error;
}

// Setting the number of rows to display in a page.
$rows_per_page = 12;

// Determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from value.
$start = ($page - 1) * $rows_per_page;

// Calculating the number of pages.
$pending_pages = ceil($pending_nr_of_rows / $rows_per_page);
$approved_pages = ceil($approved_nr_of_rows / $rows_per_page);

// Calculate the range of page numbers to be displayed for pending appointments
$pending_start_loop = max(1, $page - 2);
$pending_end_loop = min($pending_pages, $page + 2);

// Adjust the range if the current page is near the beginning or end for pending appointments
if ($pending_start_loop > 1) {
    $pending_start_loop--;
    $pending_end_loop++;
}

// Ensure that the range is never smaller than 4 for pending appointments
if ($pending_end_loop - $pending_start_loop < 4) {
    $pending_start_loop = max(1, $pending_end_loop - 4);
}

$pending_previous = $page - 1;
$pending_next = $page + 1;

// Calculate the start and end loop variables for pending appointments
$pending_start_loop = $page > 2 ? $page - 2 : 1;
$pending_end_loop = $page < $pending_pages - 2 ? $page + 2 : $pending_pages;

// Limit the number of pages displayed to a maximum of 4 for pending appointments
if ($pending_pages > 4) {
    if ($page > 2 && $page < $pending_pages - 1) {
        $pending_end_loop = $page + 1;
    } elseif ($page == 1) {
        $pending_start_loop = 1;
        $pending_end_loop = 4;
    } elseif ($page == $pending_pages) {
        $pending_start_loop = $pending_pages - 3;
        $pending_end_loop = $pending_pages;
    }
}

// Calculate the range of page numbers to be displayed for approved appointments
$approved_start_loop = max(1, $page - 2);
$approved_end_loop = min($approved_pages, $page + 2);

// Adjust the range if the current page is near the beginning or end for approved appointments
if ($approved_start_loop > 1) {
    $approved_start_loop--;
    $approved_end_loop++;
}

// Ensure that the range is never smaller than 4 for approved appointments
if ($approved_end_loop - $approved_start_loop < 4) {
    $approved_start_loop = max(1, $approved_end_loop - 4);
}

$approved_previous = $page - 1;
$approved_next = $page + 1;

// Calculate the start and end loop variables for approved appointments
$approved_start_loop = $page > 2 ? $page - 2 : 1;
$approved_end_loop = $page < $approved_pages - 2 ? $page + 2 : $approved_pages;

// Limit the number of pages displayed to a maximum of 4 for approved appointments
if ($approved_pages > 4) {
    if ($page > 2 && $page < $approved_pages - 1) {
        $approved_end_loop = $page + 1;
    } elseif ($page == 1) {
        $approved_start_loop = 1;
        $approved_end_loop = 4;
    } elseif ($page == $approved_pages) {
        $approved_start_loop = $approved_pages - 3;
        $approved_end_loop = $approved_pages;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Appointment</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.usertype, ac.lastname, ac.campus, i.image FROM audit_trail au INNER JOIN account ac ON ac.accountid = au.user INNER JOIN patient_image i ON i.patient_id = au.user WHERE ((au.activity LIKE '%added a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE '%uploaded%'  AND au.campus ='$campus') OR (au.activity LIKE '%cancelled a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE 'sent%' AND au.campus ='$campus') OR (au.activity LIKE 'cancelled%' AND au.campus ='$campus') OR (au.activity LIKE 'uploaded medical document%' AND au.campus ='$campus') OR (au.activity LIKE '%expired%' AND au.campus ='$campus')) AND au.status='unread' AND au.user != '$userid' ORDER BY au.datetime DESC";
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
            <?php
            include('../../includes/alert.php')
            ?>
            <div class="overview-boxes">
                <div class="tab-content" id="myTabContent">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['tab']) && $_GET['tab'] == 'pending' ? 'active' : '' ?>" href="appointment?tab=pending" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['tab']) && $_GET['tab'] == 'approved' ? 'active' : '' ?>" href="appointment?tab=approved" role="tab" aria-controls="approve" aria-selected="false">Approved</a>
                        </li>
                    </ul>
                    <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == 'pending' ? 'show active' : '' ?>" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="content appointment">
                            <h3>Pending Appointments</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="appointment" method="get">
                                            <input type="hidden" name="tab" value="pending">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                                                        <button type="submit" class="btn btn-primary">Search</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2 mb-2">
                                                            <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                                        </div>
                                                        <div class="col-md-2 mb-2">
                                                            <select name="physician" class="form-select">
                                                                <option value="" disabled selected>-Select Physician-</option>
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
                                                                        $physician = strtoupper($row['firstname'] . " " . $middleinitial . " " . $row['lastname']); ?>
                                                                        <option value="<?php echo $physician; ?>" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == '$physician' ? 'selected' : '') : '' ?>><?php echo $physician; ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <select name="type" class="form-select">
                                                                <option value="" disabled selected>-Select Type-</option>
                                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                                <?php
                                                                $sql = "SELECT DISTINCT type FROM appointment_type ORDER BY type";
                                                                if ($result = mysqli_query($conn, $sql)) {
                                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                                        <option value="<?php echo $row['type']; ?>" <?= isset($_GET['type']) == true ? ($_GET['type'] == $row['type'] ? 'selected' : '') : '' ?>><?php echo $row['type']; ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <select name="request" class="form-select">
                                                                <option value="" disabled selected>-Select Request For-</option>
                                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                                <?php
                                                                $sql = "SELECT DISTINCT purpose FROM appointment_purpose ORDER BY purpose";
                                                                if ($result = mysqli_query($conn, $sql)) {
                                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                                        <option value="<?php echo $row['purpose']; ?>" <?= isset($_GET['request']) == true ? ($_GET['request'] == $row['purpose'] ? 'selected' : '') : '' ?>><?php echo $row['purpose']; ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 mb-2">
                                                            <button type="submit" class="btn btn-primary">Filter</button>
                                                            <a href="appointment?tab=approved" class="btn btn-danger">Reset</a>
                                                        </div>
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
                                                    <th>
                                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Type</th>
                                                    <th>Request for</th>
                                                    <th>Patient</th>
                                                    <th>Physician</th>
                                                    <th>Action</th>
                                                    <th>
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" id="disapproveBtnHeader" style="display: none;" data-bs-target="#disapproveselectedappointment">Disapprove All</button>
                                                    </th>
                                                </tr>
                                                <?php include('modals/disapprove-selected-appointment-modal.php'); ?>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT ap.id, ap.date, ap.patient, ap.med_1, ap.mqty_1, ap.med_2, ap.mqty_2, ap.med_3, ap.mqty_3, ap.med_4, ap.mqty_4, ap.med_5, ap.mqty_5, ap.sup_1, ap.sqty_1, ap.sup_2, ap.sqty_2, ap.sup_3, ap.sqty_3, ap.sup_4, ap.sqty_4, ap.sup_5, ap.sqty_5, p.purpose, t.type, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus, ac.email 
                                                FROM appointment ap 
                                                INNER JOIN account ac ON ac.accountid = ap.patient 
                                                INNER JOIN appointment_purpose p ON p.id = ap.purpose 
                                                INNER JOIN appointment_type t ON t.id = p.type";

                                                if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                                    // Filter by patient name
                                                    $patient = $_GET['patient'];
                                                    $sql .= " WHERE CONCAT(ac.firstname, ac.middlename, ac.lastname) LIKE '%$patient%' AND ap.status = 'PENDING' AND ac.campus = '$campus'";
                                                } elseif (isset($_GET['physician']) && $_GET['physician'] != '' || isset($_GET['request']) && $_GET['request'] != '' || isset($_GET['type']) && $_GET['type'] != '' || isset($_GET['date']) && $_GET['date'] != '') {
                                                    // Filter by date
                                                    $date = isset($_GET['date']) ? $_GET['date'] : '';
                                                    $type = isset($_GET['type']) ? $_GET['type'] : '';
                                                    $request = isset($_GET['request']) ? $_GET['request'] : '';
                                                    $physician = isset($_GET['physician']) ? $_GET['physician'] : '';

                                                    $whereClause = "";

                                                    if ($date !== '') {
                                                        $whereClause .= " AND ap.date = '$date'";
                                                    }
                                                    if ($physician !== '') {
                                                        $whereClause .= " AND ap.physician = '$physician'";
                                                    }
                                                    if ($type !== '') {
                                                        $whereClause .= " AND t.type = '$type'";
                                                    }
                                                    if ($request !== '') {
                                                        $whereClause .= " AND p.purpose = '$request'";
                                                    }

                                                    $sql .= " WHERE ap.status = 'PENDING' $whereClause  AND ac.campus = '$campus'";
                                                } else {
                                                    // No filter, retrieve all pending appointments
                                                    $sql .= " WHERE ap.status = 'PENDING' AND ac.campus = '$campus'";
                                                }

                                                $sql .= " ORDER BY ap.date, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";

                                                $result = mysqli_query($conn, $sql);
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
                                                            if ($data['physician'] == NULL || $data['physician'] == "") {
                                                                $physician = "N/A";
                                                            } else {
                                                                $physician = $data['physician'];
                                                            }
                                                            $id = $data['id'];

                                                            $sql = "SELECT * FROM appointment a  
                                                                    INNER JOIN appointment_purpose p ON p.id=a.purpose 
                                                                    INNER JOIN appointment_type t ON t.id=p.type 
                                                                    INNER JOIN account ac ON ac.accountid=a.patient 
                                                                    WHERE a.id = ?";

                                                            $stmt = mysqli_prepare($conn, $sql);
                                                            mysqli_stmt_bind_param($stmt, "i", $id);
                                                            mysqli_stmt_execute($stmt);
                                                            $result = mysqli_stmt_get_result($stmt);

                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                if ($row['chiefcomplaint'] == 'Others' || $row['chiefcomplaint'] == 'Others:') {
                                                                    $chief_complaint = $row['others'];
                                                                } else {
                                                                    $chief_complaint = $row['chiefcomplaint'];
                                                                }
                                                                $date = $row['date'];
                                                                $time_from = $row['time_from'];
                                                                $time_to = $row['time_to'];
                                                                $type = $row['type'];
                                                                $purpose = $row['purpose'];
                                                                $pname = ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname']));

                                                                // Fetching medicine and supply data
                                                                $medicines = array();
                                                                $supplies = array();

                                                                // Fetching medicine data
                                                                for ($i = 1; $i <= 5; $i++) {
                                                                    $med_id = $row["med_$i"];
                                                                    $med_qty = $row["mqty_$i"];
                                                                    if (!empty($med_id)) {
                                                                        $md_query = "SELECT * FROM inv_total WHERE stockid = ? AND type = 'medicine'";
                                                                        $stmt = mysqli_prepare($conn, $md_query);
                                                                        mysqli_stmt_bind_param($stmt, "i", $med_id);
                                                                        mysqli_stmt_execute($stmt);
                                                                        $med_result = mysqli_stmt_get_result($stmt);

                                                                        if ($med_data = mysqli_fetch_assoc($med_result)) {
                                                                            $medicine_name = $med_data['stock_name'];
                                                                            $medicines[] = $med_qty . ' ' . $medicine_name;
                                                                        }
                                                                    }
                                                                }

                                                                // Fetching supply data
                                                                for ($i = 1; $i <= 5; $i++) {
                                                                    $sup_id = $row["sup_$i"];
                                                                    $sup_qty = $row["sqty_$i"];
                                                                    if (!empty($sup_id)) {
                                                                        $sp_query = "SELECT * FROM inv_total WHERE stockid = ? AND type = 'supply'";
                                                                        $stmt = mysqli_prepare($conn, $sp_query);
                                                                        mysqli_stmt_bind_param($stmt, "i", $sup_id);
                                                                        mysqli_stmt_execute($stmt);
                                                                        $sup_result = mysqli_stmt_get_result($stmt);

                                                                        if ($sup_data = mysqli_fetch_assoc($sup_result)) {
                                                                            $supply_name = $sup_data['stock_name'];
                                                                            $supplies[] = $sup_qty . ' ' . $supply_name;
                                                                        }
                                                                    }
                                                                }

                                                                $medsup = implode(', ', array_merge($medicines, $supplies));
                                                            }

                                                ?>
                                                            <tr>
                                                                <td>
                                                                    <input class="form-check-input checkbox" type="checkbox" name="app_disapprove_id[]" value="<?php echo $id; ?>">
                                                                </td>
                                                                <td><?php echo $id ?></td>
                                                                <td><?php echo date("F d, Y", strtotime($date)) ?></td>
                                                                <td><?php echo date("g:i A", strtotime($time_from)) . " - " . date("g:i A", strtotime($time_to)) ?></td>
                                                                <td><?php echo  $type; ?></td>
                                                                <td><?php echo  $purpose; ?></td>
                                                                <td><?php echo $pname ?></td>
                                                                <td><?php echo $physician; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#approveappointment<?php echo $id ?>">Approve</button>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#disapproveappointment<?= $id ?>">Disapprove</button>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            include('modals/approve-appointment-modal.php');
                                                            //$_GET['apid'] = $id;
                                                            include('modals/disapprove-appointment-modal.php');
                                                        }
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
                                                    ?>

                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $pending_previous; ?>">&lt;</a>
                                            </li>
                                            <?php for ($i = $pending_start_loop; $i <= $pending_end_loop; $i++) : ?>
                                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                    <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?php echo $page == $pending_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $pending_next; ?>">&gt;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == $pending_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $pending_pages; ?>">&raquo;</a>
                                            </li>
                                        </ul>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade <?= isset($_GET['tab']) && $_GET['tab'] == 'approved' ? 'show active' : '' ?>" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                        <div class="content appointment">
                            <h3>Approved Appointments</h3>
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="appointment" method="get">
                                            <input type="hidden" name="tab" value="approved">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                                                        <button type="submit" class="btn btn-primary">Search</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-2 mb-2">
                                                            <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                                        </div>
                                                        <div class="col-md-2 mb-2">
                                                            <select name="physician" class="form-select">
                                                                <option value="" disabled selected>-Select Physician-</option>
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
                                                                        $physician = strtoupper($row['firstname'] . " " . $middleinitial . " " . $row['lastname']); ?>
                                                                        <option value="<?php echo $physician; ?>" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == '$physician' ? 'selected' : '') : '' ?>><?php echo $physician; ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <select name="type" class="form-select">
                                                                <option value="" disabled selected>-Select Type-</option>
                                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                                <?php
                                                                $sql = "SELECT DISTINCT type FROM appointment_type ORDER BY type";
                                                                if ($result = mysqli_query($conn, $sql)) {
                                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                                        <option value="<?php echo $row['type']; ?>" <?= isset($_GET['type']) == true ? ($_GET['type'] == $row['type'] ? 'selected' : '') : '' ?>><?php echo $row['type']; ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-2">
                                                            <select name="request" class="form-select">
                                                                <option value="" disabled selected>-Select Request For-</option>
                                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                                <?php
                                                                $sql = "SELECT DISTINCT purpose FROM appointment_purpose ORDER BY purpose";
                                                                if ($result = mysqli_query($conn, $sql)) {
                                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                                        <option value="<?php echo $row['purpose']; ?>" <?= isset($_GET['request']) == true ? ($_GET['request'] == $row['purpose'] ? 'selected' : '') : '' ?>><?php echo $row['purpose']; ?></option>
                                                                <?php }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2 mb-2">
                                                            <button type="submit" class="btn btn-primary">Filter</button>
                                                            <a href="appointment?tab=approved" class="btn btn-danger">Reset</a>
                                                        </div>
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
                                                    <th>
                                                        <input class="form-check-input" type="checkbox" id="checkCancelAll">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Type</th>
                                                    <th>Request for</th>
                                                    <th>Patient</th>
                                                    <th>Physician</th>
                                                    <th>Action</th>
                                                    <th>
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" id="cancelBtnHeader" style="display: none;" data-bs-target="#cancelselectedappointment">Cancel All</button>
                                                    </th>
                                                </tr>
                                                <?php include('modals/app_cancel_selected_modal.php'); ?>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                                    $patient = $_GET['patient'];
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.reason, ap.patient, ap.med_1, ap.mqty_1, ap.med_2, ap.mqty_2, ap.med_3, ap.mqty_3, ap.med_4, ap.mqty_4, ap.med_5, ap.mqty_5, ap.sup_1, ap.sqty_1, ap.sup_2, ap.sqty_2, ap.sup_3, ap.sqty_3, ap.sup_4, ap.sqty_4, ap.sup_5, ap.sqty_5, t.type, p.purpose, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND ap.status='APPROVED' AND ac.campus='$campus' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                                    $result = mysqli_query($conn, $sql);
                                                } elseif (isset($_GET['physician']) && $_GET['physician'] != '' || isset($_GET['request']) && $_GET['request'] != '' || isset($_GET['type']) && $_GET['type'] != '' || isset($_GET['date']) && $_GET['date'] != '') {
                                                    // Filter by date
                                                    $date = isset($_GET['date']) ? $_GET['date'] : '';
                                                    $type = isset($_GET['type']) ? $_GET['type'] : '';
                                                    $request = isset($_GET['request']) ? $_GET['request'] : '';
                                                    $physician = isset($_GET['physician']) ? $_GET['physician'] : '';

                                                    $whereClause = "";

                                                    if ($date !== '') {
                                                        $whereClause .= " AND ap.date = '$date'";
                                                    }
                                                    if ($physician !== '') {
                                                        $whereClause .= " AND ap.physician = '$physician'";
                                                    }
                                                    if ($type !== '') {
                                                        $whereClause .= " AND t.type = '$type'";
                                                    }
                                                    if ($request !== '') {
                                                        $whereClause .= " AND p.purpose = '$request'";
                                                    }
                                                    $count = 1;
                                                    $today = date("Y-m-d");
                                                    $sql = "SELECT ap.id, ap.date, ap.reason, ap.patient, t.type, p.purpose, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE (ap.status='APPROVED' OR ap.status='COMPLETED') AND ac.campus='$campus' AND date = '$today' $whereClause ORDER BY ap.status DESC, ap.date, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
                                                    $result = mysqli_query($conn, $sql);
                                                } else {
                                                    $count = 1;
                                                    $today = date("Y-m-d");
                                                    $sql = "SELECT ap.id, ap.date, ap.reason, ap.patient, t.type, p.purpose, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE (ap.status='APPROVED' OR ap.status='COMPLETED') AND ac.campus='$campus' AND date = '$today' ORDER BY ap.status DESC, ap.date, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
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
                                                            if ($data['physician'] == NULL || $data['physician'] == "") {
                                                                $physician = "N/A";
                                                            } else {
                                                                $physician = $data['physician'];
                                                            }
                                                ?>
                                                            <tr>
                                                                <td>
                                                                    <input class="form-check-input cancelcheckbox" type="checkbox" name="app_cancel_id[]" value="<?php echo $data['id']; ?>">
                                                                </td>
                                                                <td><?php echo $id = $data['id']; ?></td>
                                                                <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                                <td><?php echo date("g:i A", strtotime($data['time_from'])) . " - " .  date("g:i A", strtotime($data['time_to'])) ?></td>
                                                                <td><?php echo $data['type']; ?></td>
                                                                <td><?php echo $data['purpose']; ?></td>
                                                                <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?></td>
                                                                <td><?php echo $physician; ?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($data['status'] == 'CANCELLED') {
                                                                    ?>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancelled<?php echo $data['id'] ?>">
                                                                            <?php echo $data['status']; ?>
                                                                        </button>
                                                                        <?php
                                                                    } elseif ($data['status'] == 'APPROVED') {
                                                                        if ($data['physician'] == 'N/A') {
                                                                            if ($data['date'] == $today) { ?>
                                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#recordppointment<?php echo $data['id'] ?>">Record</button>
                                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id ?>">Cancel</button>
                                                                            <?php } else { ?>
                                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#recordppointment<?php echo $data['id'] ?>" disabled>Record</button>
                                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id ?>">Cancel</button>
                                                                            <?php }
                                                                        } else { ?>
                                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#recordppointment<?php echo $data['id'] ?>" disabled>Record</button>
                                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id ?>">Cancel</button>
                                                                        <?php }
                                                                    } elseif ($data['status'] == 'COMPLETED') {
                                                                        ?>
                                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#app_completed<?php echo $data['id'] ?>">
                                                                            <?php echo $data['status']; ?>
                                                                        </button>
                                                                    <?php } elseif ($data['status'] == 'DISMISSED') {
                                                                    ?>
                                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_dismissed<?php echo $data['id'] ?>">
                                                                            <?php echo $data['status']; ?>
                                                                        </button>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            if ($data['status'] == 'CANCELLED') {
                                                                include('modals/app_cancelled_modal.php');
                                                            } elseif ($data['status'] == 'APPROVED') {
                                                                if ($data['type'] == "Request for Medicine" || $data['purpose'] == "Request for Medicine" || $data['type'] == "Request for Medical Supply" || $data['purpose'] == "Request for Medical Supply") {
                                                                    include('modals/app_record_medsup_modal.php');
                                                                    include('modals/app_cancel_modal.php');
                                                                } else {
                                                                    include('modals/app_record_trans_modal.php');
                                                                    include('modals/app_cancel_modal.php');
                                                                }
                                                            } elseif ($data['status'] == 'COMPLETED') {
                                                                include('modals/app_completed_modal.php');
                                                            } elseif ($data['status'] == 'DISMISSED') {
                                                                include('modals/app_dismissed_modal.php');
                                                            }
                                                        }
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
                                                    ?>

                                                <?php
                                                }
                                                mysqli_close($conn);
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $approved_previous; ?>">&lt;</a>
                                            </li>
                                            <?php for ($i = $approved_start_loop; $i <= $approved_end_loop; $i++) : ?>
                                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                    <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?php echo $page == $approved_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $approved_next; ?>">&gt;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == $approved_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['request']) ? 'request=' . $_GET['request'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $approved_pages; ?>">&raquo;</a>
                                            </li>
                                        </ul>
                                    <?php
                                    }
                                    ?>
                                </div>
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

    document.addEventListener('DOMContentLoaded', function() {
        let tabParam = '<?php echo isset($_GET['tab']) ? $_GET['tab'] : ''; ?>';
        if (tabParam) {
            document.querySelector('.nav-tabs a[href="#' + tabParam + '"]').classList.add('active');
            document.querySelector('.tab-pane#' + tabParam).classList.add('show', 'active');
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Function to check if all checkboxes in the table rows are checked
        function areAllChecked() {
            return $(".checkbox:checked").length === $(".checkbox").length;
        }

        // Function to synchronize the "Select All" checkbox state with checkboxes in the table rows
        function syncSelectAllCheckbox() {
            $("#checkAll").prop('checked', areAllChecked());
        }

        // Function to toggle the visibility of the "Disapprove" button in the header
        function toggleDisapproveButton() {
            if ($(".checkbox:checked").length > 1) {
                $("#disapproveBtnHeader").show();
            } else {
                $("#disapproveBtnHeader").hide();
            }
        }

        // Function to handle disapprove action
        $("#disapproveBtnHeader").click(function() {
            var disapprovedIDs = [];
            $(".checkbox:checked").each(function() {
                disapprovedIDs.push($(this).val());
            });

            // Pass disapprovedIDs to the modal
            openDisapproveModal(disapprovedIDs);
        });

        // Open modal function
        function openDisapproveModal(disapprovedIDs) {
            // Set the value of a hidden input field inside the modal to pass disapprovedIDs
            $("#disapprovedIDsInput").val(disapprovedIDs.join(','));

            // Open the disapprove modal
            $('#disapproveselectedappointment').modal('show');
            console.log(disapprovedIDs);
        }

        // When any checkbox in the table rows is clicked
        $(".checkbox").click(function() {
            syncSelectAllCheckbox();
            toggleDisapproveButton();
        });

        // When the "Select All" checkbox in the header is clicked
        $("#checkAll").click(function() {
            // Check/uncheck all checkboxes in the table rows based on the "Select All" checkbox status
            $(".checkbox").prop('checked', $(this).prop('checked'));
            toggleDisapproveButton();
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Function to check if all checkboxes in the table rows are checked
        function areAllCancelChecked() {
            return $(".cancelcheckbox:checked").length === $(".cancelcheckbox").length;
        }

        // Function to synchronize the "Select All" checkbox state with checkboxes in the table rows
        function syncSelectCancelAllCheckbox() {
            $("#checkCancelAll").prop('checked', areAllCancelChecked());
        }

        // Function to toggle the visibility of the "Disapprove" button in the header
        function toggleCancelButton() {
            if ($(".cancelcheckbox:checked").length > 1) {
                $("#cancelBtnHeader").show();
            } else {
                $("#cancelBtnHeader").hide();
            }
        }

        // Function to handle disapprove action
        $("#cancelBtnHeader").click(function() {
            var cancelIDs = [];
            $(".cancelcheckbox:checked").each(function() {
                cancelIDs.push($(this).val());
            });

            // Pass disapprovedIDs to the modal
            openCancelModal(cancelIDs);
        });

        // Open modal function
        function openCancelModal(cancelIDs) {
            // Set the value of a hidden input field inside the modal to pass disapprovedIDs
            $("#cancelIDsInput").val(cancelIDs.join(','));

            // Open the disapprove modal
            $('#cancelselectedappointment').modal('show');
            console.log(cancelIDs);
        }

        // When any checkbox in the table rows is clicked
        $(".cancelcheckbox").click(function() {
            syncSelectCancelAllCheckbox();
            toggleCancelButton();
        });

        // When the "Select All" checkbox in the header is clicked
        $("#checkCancelAll").click(function() {
            // Check/uncheck all checkboxes in the table rows based on the "Select All" checkbox status
            $(".cancelcheckbox").prop('checked', $(this).prop('checked'));
            toggleCancelButton();
        });
    });
</script>


</html>