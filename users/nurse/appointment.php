<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'appointment';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Check if the month filter is set
if (isset($_GET['patient']) || isset($_GET['date']) || isset($_GET['physician'])) {
    // Validate and sanitize input
    $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';
    $physician = isset($_GET['physician']) ? $_GET['physician'] : '';

    // Construct WHERE clause based on filters
    if ($patient !== '') {
        $whereClause = " AND (CONCAT(ac.firstname, ac.middlename, ac.lastname) LIKE '%$patient%')";
    }
    if ($date !== '') {
        $whereClause = " AND ap.date = '$date'";
    }
    if ($physician !== '') {
        $whereClause = " AND ap.physician = '$physician'";
    } else {
        $whereClause = "";
    }

    // Construct and execute SQL query for pending appointments count
    $pending_sql_count = "SELECT COUNT(ap.id) AS total_rows 
                      FROM appointment ap 
                      INNER JOIN account ac ON ac.accountid = ap.patient
                      WHERE campus ='$campus' AND ap.status = 'PENDING' $whereClause";

    // Construct and execute SQL query for approved appointments count
    $approved_sql_count = "SELECT COUNT(ap.id) AS total_rows 
                       FROM appointment ap 
                       INNER JOIN account ac ON ac.accountid = ap.patient
                       WHERE campus ='$campus' AND ap.status = 'APPROVED' $whereClause";
} else {
    // If no filter is set, count all rows
    $pending_sql_count = "SELECT COUNT(ap.id) AS total_rows 
                          FROM appointment ap 
                          INNER JOIN account ac ON ac.accountid = ap.patient
                          WHERE ap.status = 'PENDING' AND campus = '$campus'";

    // Count all approved appointments
    $approved_sql_count = "SELECT COUNT(ap.id) AS total_rows 
                           FROM appointment ap 
                           INNER JOIN account ac ON ac.accountid = ap.patient
                           WHERE ap.status = 'APPROVED' AND campus = '$campus'";
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
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user INNER JOIN patient_image i ON i.patient_id=au.user WHERE (au.activity LIKE '%added a walk-in schedule%' OR au.activity 
                        LIKE 'sent a request for%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%already expired'
                        OR au.activity LIKE 'cancelled a request%' OR au.activity LIKE 'cancelled a walk-in%') AND au.status='unread' AND au.user != '$userid'";
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
                            <li><a class="dropdown-item" href="../../../logout">Logout</a></li>
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
                                                <div class="col-md-2 mb-2">
                                                    <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                                </div>
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
                                                                $physician = strtoupper($row['firstname'] . " " . $middleinitial . " " . $row['lastname']); ?>
                                                                <option value="<?php echo $physician; ?>" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == $physician ? 'selected' : '') : '' ?>><?php echo $physician; ?></option><?php }
                                                                                                                                                                                                                                            } ?>
                                                    </select>
                                                </div>
                                                <div class="col mb-2">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                    <a href="appointment?tab=pending" class="btn btn-danger">Reset</a>
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
                                                    <th>Appointment ID</th>
                                                    <th>Date</th>
                                                    <th>Time from</th>
                                                    <th>Time to</th>
                                                    <th>Patient name</th>
                                                    <th>Physician</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                                    $patient = $_GET['patient'];
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE  CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND ap.status='PENDING' AND ac.campus='$campus' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                                    $result = mysqli_query($conn, $sql);
                                                } elseif (isset($_GET['date']) && $_GET['date'] != '' || isset($_GET['physician']) && $_GET['physician'] != '') {
                                                    $date = $_GET['date'];
                                                    $physician = $_GET['physician'];
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.date = '$date' or ap.physician = '$physician' AND ac.campus='$campus' AND ap.status='PENDING' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                                    $result = mysqli_query($conn, $sql);
                                                } else {
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.status='PENDING' AND ac.campus='$campus' ORDER BY ap.date, ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
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
                                                                $physician = "NONE";
                                                            } else {
                                                                $physician = $data['physician'];
                                                            }
                                                ?>
                                                            <tr>
                                                                <td><?php echo $data['id']; ?></td>
                                                                <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                                <td><?php echo date("g:i A", strtotime($data['time_from'])) ?></td>
                                                                <td><?php echo date("g:i A", strtotime($data['time_to'])) ?></td>
                                                                <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?></td>
                                                                <td><?php echo $physician; ?></td>
                                                                <td><?php echo $data['status']; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#approveappointment<?php echo $data['id'] ?>">Approve</button>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelappointment<?php echo $data['id'] ?>">Cancel</button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                            include('modals/approve-appointment-modal.php');
                                                            include('modals/cancel-appointment-modal.php');
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='8'>No record Found</td></tr>";
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>
                                    <?php
                                                }

                                    ?>
                                    </div>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $pending_previous; ?>">&lt;</a>
                                            </li>
                                            <?php for ($i = $pending_start_loop; $i <= $pending_end_loop; $i++) : ?>
                                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                    <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?php echo $page == $pending_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $pending_next; ?>">&gt;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == $pending_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=pending&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $pending_pages; ?>">&raquo;</a>
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
                                                <div class="col-md-2 mb-2">
                                                    <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                                </div>
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
                                                                $physician = strtoupper($row['firstname'] . " " . $middleinitial . " " . $row['lastname']); ?>
                                                                <option value="<?php echo $physician; ?>" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == '$physician' ? 'selected' : '') : '' ?>><?php echo $physician; ?></option><?php }
                                                                                                                                                                                                                                            } ?>
                                                    </select>
                                                </div>
                                                <div class="col mb-2">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                    <a href="appointment?tab=approved" class="btn btn-danger">Reset</a>
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
                                                    <th>Appointment ID</th>
                                                    <th>Date</th>
                                                    <th>Time from</th>
                                                    <th>Time to</th>
                                                    <th>Patient name</th>
                                                    <th>Physician</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                                    $patient = $_GET['patient'];
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE  CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND ap.status='APPROVED' AND ac.campus='$campus' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                                    $result = mysqli_query($conn, $sql);
                                                } elseif (isset($_GET['date']) && $_GET['date'] != '' || isset($_GET['physician']) && $_GET['physician'] != '') {
                                                    $date = $_GET['date'];
                                                    $physician = $_GET['physician'];
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.date = '$date' or ap.physician = '$physician' AND ac.campus='$campus' AND ap.status='APPROVED' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                                    $result = mysqli_query($conn, $sql);
                                                } else {
                                                    $count = 1;
                                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.status='APPROVED' AND ac.campus='$campus' ORDER BY ap.date, ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
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
                                                                $physician = "NONE";
                                                            } else {
                                                                $physician = $data['physician'];
                                                            }
                                                ?>
                                                            <tr>
                                                                <td><?php echo $data['id']; ?></td>
                                                                <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                                <td><?php echo date("g:i A", strtotime($data['time_from'])) ?></td>
                                                                <td><?php echo date("g:i A", strtotime($data['time_to'])) ?></td>
                                                                <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?></td>
                                                                <td><?php echo $physician; ?></td>
                                                                <td><?php echo $data['status']; ?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#completeappointment">Complete</button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                            include('modals/complete-appointment-modal.php');
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan='8'>No record Found</td></tr>";
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>
                                    <?php
                                                }
                                                mysqli_close($conn);
                                    ?>
                                    </div>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                        <ul class="pagination justify-content-end">
                                            <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&page=<?= 1; ?>">&laquo;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&page=<?= $approved_previous; ?>">&lt;</a>
                                            </li>
                                            <?php for ($i = $approved_start_loop; $i <= $approved_end_loop; $i++) : ?>
                                                <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                    <a class="page-link" href="appointment?tab=approved&page=<?= $i; ?>"><?= $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                            <li class="page-item <?php echo $page == $approved_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&page=<?= $approved_next; ?>">&gt;</a>
                                            </li>
                                            <li class="page-item <?php echo $page == $approved_pages ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="appointment?tab=approved&page=<?= $approved_pages; ?>">&raquo;</a>
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

</html>