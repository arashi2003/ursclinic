<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'medical';

$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];


// Check if the supply or batch filter is set
if (isset($_GET['patient']) || isset($_GET['program']) || isset($_GET['docu']) || isset($_GET['yearlevel']) || isset($_GET['status']) || isset($_GET['date_from']) || isset($_GET['date_to']) || isset($_GET['college'])) {
    // Validate and sanitize input
    $docu = isset($_GET['docu']) ? $_GET['docu'] : '';
    $yearlevel = isset($_GET['yearlevel']) ? $_GET['yearlevel'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $student = isset($_GET['patient']) ? $_GET['patient'] : '';
    $college = isset($_GET['college']) ? $_GET['college'] : '';
    $program = isset($_GET['program']) ? $_GET['program'] : '';
    $dt_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $dt_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

    // Initialize the WHERE clause
    $whereClause = " a.campus = '$campus'"; // Start with common conditions

    //student filter
    if ($student != "") {
        $whereClause .= "AND (CONCAT(a.firstname,' ', a.lastname) LIKE '%$student%' OR CONCAT(a.firstname, ' ', a.middlename,' ', a.lastname) LIKE '%$student%' OR m.applicant LIKE '%$student%')";
    }

    //date filter
    if ($dt_to == "" and $dt_from == "") {
        $whereClause .= "";
    } elseif ($dt_to == $dt_from) {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $whereClause .= " AND dt_updated >= '$fdate' AND dt_updated <= '$ldate'";
    } elseif ($dt_to == "" and $dt_from != "") {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $whereClause .= " AND dt_updated >= '$fdate'";
    } elseif ($dt_to == "" and $dt_from != "") {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $whereClause .= " AND dt_updated >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "") {
        $d = date("Y-m-d", strtotime($dt_to));
        $whereClause .= " AND dt_updated <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $whereClause .= " AND dt_updated >= '$fdate' AND dt_updated <= '$ldate'";
    }

    //docu filter
    if ($docu != "") {
        $whereClause .= " AND m.type = '$docu'";
    }

    //yearlevel filter
    if ($yearlevel != "") {
        $whereClause .= " AND p.yearlevel = '$yearlevel'";
    }

    //status filter
    if ($status != "") {
        $whereClause .= " AND m.status = '$status'";
    }

    //college filter
    if ($college != "") {
        $whereClause .= " AND p.college = '$college'";
    }

    //program filter
    if ($program != "") {
        $whereClause .= " AND p.program = '$program'";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM meddoc m 
                  INNER JOIN patient_info p ON p.patientid=m.applicant 
                  INNER JOIN account a ON a.accountid=m.applicant
                  WHERE $whereClause AND m.dt_updated != m.dt_uploaded
                  GROUP BY m.applicant, m.type";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM meddoc m 
                  INNER JOIN patient_info p ON p.patientid=m.applicant 
                  INNER JOIN account a ON a.accountid=m.applicant
                  WHERE a.campus = '$campus' AND m.dt_updated != m.dt_uploaded
                  GROUP BY m.applicant, m.type";
}

// Execute the count query
$count_result = $conn->query($sql_count);

// Check if count query was successful
if ($count_result) {
    // Fetch the total number of rows
    $count_row = $count_result->fetch_assoc();
    if (!empty($count_row['total_rows']) > 0) {
        $nr_of_rows = $count_row['total_rows'];
    } else {
        $nr_of_rows = 1;
    }
} else {
    // Handle count query error
    echo "Error: " . $conn->error;
}

// Setting the number of rows to display in a page.
$rows_per_page = 10;

// determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from, value.
$start = ($page - 1) * $rows_per_page;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);

// calculate the range of page numbers to be displayed
$start_loop = max(1, $page - 2);
$end_loop = min($pages, $page + 2);

// adjust the range if the current page is near the beginning or end
if ($start_loop > 1) {
    $start_loop--;
    $end_loop++;
}

// ensure that the range is never smaller than 4
if ($end_loop - $start_loop < 4) {
    $start_loop = max(1, $end_loop - 4);
}

$previous = $page - 1;
$next = $page + 1;

// calculate the start and end loop variables
$start_loop = $page > 2 ? $page - 2 : 1;
$end_loop = $page < $pages - 2 ? $page + 2 : $pages;

// limit the number of pages displayed to a maximum of 4
if ($pages > 4) {
    if ($page > 2 && $page < $pages - 1) {
        $end_loop = $page + 1;
    } elseif ($page == 1) {
        $start_loop = 1;
        $end_loop = 4;
    } elseif ($page == $pages) {
        $start_loop = $pages - 3;
        $end_loop = $pages;
    }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Medical Documents</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">
                    <h1>MEDICAL DOCUMENTS</h1>
                </span>
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
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <form action="" method="GET" id="filterForm">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search student">
                                                        <button type="submit" class="btn btn-primary">Search</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" id="collegeDiv">
                                                    <select class="form-select" name="college" id="collegeSelect">
                                                        <option value="" disabled selected>-Select College-</option>
                                                        <option value="" <?= isset($_GET['college']) == true ? ($_GET['college'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                        <?php
                                                        include('connection.php');
                                                        $sql = "SELECT * FROM college ORDER BY college";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?= $row['college']; ?>" <?= isset($_GET['college']) == true ? ($_GET['college'] == $row['college'] ? 'selected' : '') : '' ?>><?= $row['college']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" id="programDiv">
                                                    <select class="form-select" name="program" id="programSelect">
                                                        <option value="" disabled selected>-Select Program-</option>
                                                        <option value="" <?= isset($_GET['program']) == true ? ($_GET['program'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                        <?php
                                                        include('connection.php');
                                                        $sql = "SELECT * FROM program";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                        ?>
                                                            <option value="<?= $row['abbrev']; ?>" <?= isset($_GET['program']) == true ? ($_GET['program'] == $row['abbrev'] ? 'selected' : '') : '' ?>><?= $row['program']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <select name="yearlevel" class="form-select">
                                                        <option value="" disabled selected>-Select Year Level-</option>
                                                        <option value="" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                        <option value="1" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == 1 ? 'selected' : '') : '' ?>>1st Year</option>
                                                        <option value="2" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == 2 ? 'selected' : '') : '' ?>>2nd Year</option>
                                                        <option value="3" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == 3 ? 'selected' : '') : '' ?>>3rd Year</option>
                                                        <option value="4" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == 4 ? 'selected' : '') : '' ?>>4th Year</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <select name="docu" class="form-select">
                                                        <option value="" disabled selected>-Select Document Type-</option>
                                                        <option value="" <?= isset($_GET['docu']) == true ? ($_GET['docu'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                        <option value="FRESHMEN" <?= isset($_GET['docu']) == true ? ($_GET['docu'] == "FRESHMEN" ? 'selected' : '') : '' ?>>FRESHMEN</option>
                                                        <option value="ATHLETE" <?= isset($_GET['docu']) == true ? ($_GET['docu'] == "ATHLETE" ? 'selected' : '') : '' ?>>ATHLETE</option>
                                                        <option value="OJT" <?= isset($_GET['docu']) == true ? ($_GET['docu'] == "OJT" ? 'selected' : '') : '' ?>>OJT</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mb-2">
                                                    <select name="status" class="form-select">
                                                        <option value="" disabled selected>-Select Status-</option>
                                                        <option value="" <?= isset($_GET['status']) == true ? ($_GET['status'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                        <option value="PENDING" <?= isset($_GET['status']) == true ? ($_GET['status'] == "PENDING" ? 'selected' : '') : '' ?>>PENDING</option>
                                                        <option value="APPROVED" <?= isset($_GET['status']) == true ? ($_GET['status'] == "APPROVED" ? 'selected' : '') : '' ?>>APPROVED</option>
                                                        <option value="DISAPPROVED" <?= isset($_GET['status']) == true ? ($_GET['status'] == "DISAPPROVED" ? 'selected' : '') : '' ?>>DISAPPROVED</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="date_from" id="from" placeholder="Date From" class="form-control" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="date_to" id="to" placeholder="Date To" class="form-control" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                    <a href="med_doc" class="btn btn-danger">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="head">
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Full Name</th>
                                            <th>College</th>
                                            <th>Program, Year & Section</th>
                                            <th>Document Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                            $patient = $_GET['patient'];

                                            $sql = "SELECT 
                                            m.type, m.applicant, m.status, m.dt_updated, m.dt_uploaded,
                                            p.patientid, p.designation, p.department, p.college,
                                            p.program, p.yearlevel, p.section, p.block, 
                                            a.accountid, a.firstname, a.middlename, a.lastname, a.campus
                                            FROM meddoc m 
                                            INNER JOIN patient_info p ON p.patientid=m.applicant 
                                            INNER JOIN account a ON a.accountid=m.applicant
                                            WHERE a.campus = '$campus' AND m.dt_updated != m.dt_uploaded AND
                                            (CONCAT(a.firstname,' ', a.lastname) LIKE '%$patient%' OR CONCAT(a.firstname, ' ', a.middlename,' ', a.lastname) LIKE '%$patient%' OR m.applicant LIKE '%$patient%')
                                            GROUP BY m.applicant, m.type
                                            ORDER BY m.dt_updated DESC
                                            LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['program']) && $_GET['program'] != '' || isset($_GET['college']) && $_GET['college'] != '' || isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '' || isset($_GET['docu']) && $_GET['docu'] != '' || isset($_GET['yearlevel']) && $_GET['yearlevel'] != '' || isset($_GET['status']) && $_GET['status'] != '') {
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $docu = isset($_GET['docu']) ? $_GET['docu'] : "";
                                            $college = isset($_GET['college']) ? $_GET['college'] : "";
                                            $program = isset($_GET['program']) ? $_GET['program'] : "";
                                            $yearlevel = isset($_GET['yearlevel']) ? $_GET['yearlevel'] : "";
                                            $status = isset($_GET['status']) ? $_GET['status'] : "";

                                            //campus filter
                                            if ($campus == "") {
                                                $ca = "";
                                            } else {
                                                $ca = " WHERE a.campus = '$campus'";
                                            }

                                            //date filter
                                            if ($dt_to == "" and $dt_from == "") {
                                                $ca .= "";
                                            } elseif ($ca != "" and $dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $ca .= " AND dt_updated >= '$fdate' AND dt_updated <= '$ldate'";
                                            } elseif ($ca == "" and $dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ca .= " AND dt_updated >= '$fdate'";
                                            } elseif ($ca != "" and $dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ca .= " AND dt_updated >= '$fdate'";
                                            } elseif ($ca != "" and $dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $ca .= " AND dt_updated <= '$d'";
                                            } elseif ($ca != "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $ca .= " AND dt_updated >= '$fdate' AND dt_updated <= '$ldate'";
                                            }

                                            //docu filter
                                            if ($docu != "") {
                                                $ca .= " AND m.type = '$docu'";
                                            }

                                            //yearlevel filter
                                            if ($yearlevel != "") {
                                                $ca .= " AND p.yearlevel = '$yearlevel'";
                                            }

                                            //status filter
                                            if ($status != "") {
                                                $ca .= " AND m.status = '$status'";
                                            }

                                            //college filter
                                            if ($college != "") {
                                                $ca .= " AND p.college = '$college'";
                                            }

                                            //college filter
                                            if ($program != "") {
                                                $ca .= " AND p.program = '$program'";
                                            }

                                            $sql = "SELECT 
                                            m.type, m.applicant, m.status, m.dt_updated, m.dt_uploaded,
                                            p.patientid, p.designation, p.department, p.college,
                                            p.program, p.yearlevel, p.section, p.block, 
                                            a.accountid, a.firstname, a.middlename, a.lastname, a.campus
                                            FROM meddoc m 
                                            INNER JOIN patient_info p ON p.patientid=m.applicant 
                                            INNER JOIN account a ON a.accountid=m.applicant
                                            $ca AND m.dt_updated != m.dt_uploaded
                                            GROUP BY m.applicant, m.type
                                            ORDER BY m.dt_updated DESC
                                            LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $sql = "SELECT 
                                            m.type, m.applicant, m.status, m.dt_updated, m.dt_uploaded,
                                            p.patientid, p.designation, p.department, p.college,
                                            p.program, p.yearlevel, p.section, p.block,
                                            a.accountid, a.firstname, a.middlename, a.lastname, a.campus
                                            FROM meddoc m 
                                            INNER JOIN patient_info p ON p.patientid=m.applicant 
                                            INNER JOIN account a ON a.accountid=m.applicant
                                            WHERE a.campus = '$campus' AND m.dt_updated != m.dt_uploaded
                                            GROUP BY m.applicant, m.type
                                            ORDER BY m.dt_updated DESC
                                            LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
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
                                                    $applicant = $row['applicant'];
                                                    $type = $row['type'];
                                                    $chu = "SELECT dt_updated FROM meddoc WHERE applicant = '$applicant' AND type='$type' ORDER BY dt_updated DESC LIMIT 1";
                                                    $grr = mysqli_query($conn, $chu);
                                                    $boop = mysqli_fetch_array($grr);
                                                    $updated = $boop['dt_updated'];


                                                    // Check if all medical documents are approved
                                                    $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$applicant' AND type='$type' AND status='APPROVED'";
                                                    $result_check_approved = mysqli_query($conn, $sql_check_approved);
                                                    $row_check_approved = mysqli_fetch_assoc($result_check_approved);
                                                    $total_approved = $row_check_approved['total_approved'];

                                                    // Check if all medical documents are approved
                                                    $sql_check_disapproved = "SELECT COUNT(*) AS total_disapproved FROM meddoc WHERE applicant='$applicant' AND type='$type' AND status='DISAPPROVED'";
                                                    $result_check_disapproved = mysqli_query($conn, $sql_check_disapproved);
                                                    $row_check_disapproved = mysqli_fetch_assoc($result_check_disapproved);
                                                    $total_disapproved = $row_check_disapproved['total_disapproved'];

                                                    // Fetch total number of medical documents for OJT of the user
                                                    $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$applicant' AND type='$type'";
                                                    $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
                                                    $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
                                                    $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

                                                    if ($total_approved === $total_medical_docs && $total_medical_docs > 0 && $total_disapproved == 0) {
                                                        $status = 'APPROVED';
                                                    } elseif ($total_disapproved > 0) {
                                                        $status = 'DISAPPROVED';
                                                    } else {
                                                        $status = 'PENDING';
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $row['applicant'] ?></td>
                                                        <td><?php echo ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname'])) ?></td>
                                                        <td><?php echo $row['college'] ?></td>
                                                        <td><?php echo $row['program'] . " " . $row['yearlevel'] . "-" .  $row['section'] . $row['block'] ?></td>
                                                        <td><?php echo $row['type'] ?></td>
                                                        <td><?php echo $status ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($updated)) ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href = 'view_patient_doc?patientid=<?php echo $row['applicant'] ?>'">View</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <td colspan="7">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                        <?php }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) : ?>
                                        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['docu']) ? 'docu=' . $_GET['docu'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['docu']) ? 'docu=' . $_GET['docu'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['docu']) ? 'docu=' . $_GET['docu'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['docu']) ? 'docu=' . $_GET['docu'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['docu']) ? 'docu=' . $_GET['docu'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
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

<script>
    // Function to update hidden input fields with filter values
    function updateExportPdfForm() {
        var physicianSelect = document.querySelector("input[name='physician']");
        var statusSelect = document.querySelector("input[name='status']");
        var dateFromInput = document.querySelector("input[name='date_from']");
        var dateToInput = document.querySelector("input[name='date_to']");

        document.getElementById("physician").value = physicianSelect.options[physicianSelect.selectedIndex].value;
        document.getElementById("status").value = statusSelect.options[statusSelect.selectedIndex].value;
        document.getElementById("date_from").value = dateFromInput.value;
        document.getElementById("date_to").value = dateToInput.value;
    }

    // Event listener for Export PDF form submission
    document.getElementById("exportPdfForm").addEventListener("submit", function(event) {
        // Update hidden input fields with filter values
        updateExportPdfForm();
    });

    // Event listener for Filter form submission
    document.getElementById("filterForm").addEventListener("submit", function(event) {
        // Update hidden input fields with filter values
        updateExportPdfForm();
    });

    $(function() {
        var dateFormat = "mm/dd/yy",
            from = $("#from")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
            })
            .on("change", function() {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = $("#to").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
            })
            .on("change", function() {
                from.datepicker("option", "maxDate", getDate(this));
            });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }
    });
</script>

<script>
    document.getElementById('reportSelect').addEventListener('change', function() {
        document.getElementById('reportForm').submit();
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#collegeSelect").change(function() {
            var college_id = $(this).val();
            if (college_id == '') {
                $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
            } else {
                $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
                $.ajax({
                    url: "action_college.php",
                    method: "POST",
                    data: {
                        cid: college_id
                    },
                    success: function(data) {
                        console.log(data); // Log received data
                        $("#programSelect").html(data);
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $("#departmentSelect").change(function() {
            $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
        });
    });
</script>

</html>