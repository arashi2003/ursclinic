<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'patient_add';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Check if the medicine, med_admin, or dosage form filter is set
if (isset($_GET['patient']) || isset($_GET['designation']) || isset($_GET['campus']) || isset($_GET['program']) || isset($_GET['department']) || isset($_GET['yearlevel']) || isset($_GET['college'])) {
    // Validate and sanitize input
    $campus = isset($_GET['campus']) ? $_GET['campus'] : '';
    $department = isset($_GET['department']) ? $_GET['department'] : '';
    $yearlevel = isset($_GET['yearlevel']) ? $_GET['yearlevel'] : '';
    $designation = isset($_GET['designation']) ? $_GET['designation'] : '';
    $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
    $college = isset($_GET['college']) ? $_GET['college'] : '';
    $program = isset($_GET['program']) ? $_GET['program'] : '';

    // Initialize the WHERE clause
    $whereClause = " WHERE"; // Start with a default condition that is always true

    // Add conditions based on filters
    if ($patient !== '') {
        $whereClause .= "  (CONCAT(ac.firstname,' ', ac.lastname) LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.middlename,' ', ac.lastname) LIKE '%$patient%' OR patientid LIKE '%$patient%')";
    }

    if ($designation !== '' and $patient == "") {
        $whereClause .= " p.designation = '$designation'";
    } elseif ($designation !== '' and $patient == "") {
        $whereClause .= "  p.designation = '$designation'";
    }

    if ($campus !== '' and $patient != "" and $designation != "") {
        $whereClause .= " AND p.campus = '$campus'";
    } elseif ($campus !== '' and $patient == "" and $designation != "") {
        $whereClause .= " AND p.campus = '$campus'";
    } elseif ($campus !== '' and $patient != "" and $designation == "") {
        $whereClause .= " AND p.campus = '$campus'";
    } elseif ($campus !== '' and $patient == "" and $designation == "") {
        $whereClause .= " p.campus = '$campus'";
    }


    //yearlevel filter
    if ($yearlevel != "" and $patient == "" and $designation == "" and $campus == "") {
        $whereClause .= " p.yearlevel = '$yearlevel'";
    } elseif ($yearlevel != "" and ($patient != "" or $designation != "" or $campus != "")) {
        $whereClause .= " AND p.yearlevel = '$yearlevel'";
    }

    //department filter
    if ($department != "" and $yearlevel == "" and $patient == "" and $designation == "" and $campus == "") {
        $whereClause .= " p.department = '$department'";
    } elseif ($department != "" and ($yearlevel != "" and $patient != "" and $designation != "" and $campus != "")) {
        $whereClause .= " AND p.department = '$department'";
    }

    //college filter
    if ($college != "" and $department == "" and $yearlevel == "" and $patient == "" and $designation == "" and $campus == "") {
        $whereClause .= " p.college = '$college'";
    } elseif ($college != "" and ($department != "" or $yearlevel != "" or $patient != "" or $designation != "" or $campus != "")) {
        $whereClause .= " AND p.college = '$college'";
    }

    //program filter
    if ($program != "" and $college != "" and $department == "" and $yearlevel == "" and $patient == "" and $designation == "" and $campus == "") {
        $whereClause .= " AND p.program = '$program'";
    } elseif ($program != "" and ($college != "" or $department != "" or $yearlevel != "" or $patient != "" or $designation != "" or $campus != "")) {
        $whereClause .= " AND p.program = '$program'";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid $whereClause";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid ORDER BY patientid";
}
// Execute the count query
$count_result = $conn->query($sql_count);

// Check if count query was successful
if ($count_result) {
    // Fetch the total number of rows
    $count_row = $count_result->fetch_assoc();
    $nr_of_rows = $count_row['total_rows'];
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
    <title>Patient Information</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">PATIENTS</span>
            </div>
            <div class="right-nav">
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#patient_bulk">CSV Upload</button>
                    <?php include('modals/patient_bulk.php'); ?>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpatient">Add Patient</button>
                    <?php include('modals/addpatient_modal.php'); ?>
                </div>
                <?php
                include('../../includes/alert.php')
                ?>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="GET" id="filterForm">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="campus" class="form-select">
                                                <option value="" disabled selected>-Select Campus-</option>
                                                <option value="<?= isset($_GET['campus']) == true ? ($_GET['campus'] == 'NONE' ? 'selected' : '') : '' ?>">NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM campus ORDER BY campus";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $campus = $row["campus"]; ?>
                                                        <option value="<?php echo $row["campus"]; ?>" <?= isset($_GET['campus']) == true ? ($_GET['campus'] == $row["campus"] ? 'selected' : '') : '' ?>><?php echo $row["campus"]; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select class="form-select" name="designation" id="designation">
                                                <option value="" disabled selected>-Select Designation-</option>
                                                <option value="" <?= isset($_GET['designation']) == true ? ($_GET['designation'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                include('connection.php');
                                                $sql = "SELECT * FROM designation ORDER BY designation";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value="<?= $row['designation']; ?>" <?= isset($_GET['designation']) == true ? ($_GET['designation'] == $row['designation'] ? 'selected' : '') : '' ?>><?= $row['designation']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2" id="departmentDiv">
                                            <select class="form-select" name="department" id="departmentSelect">
                                                <option value="" disabled selected>-Select Department-</option>
                                                <option value="" <?= isset($_GET['department']) == true ? ($_GET['department'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                include('connection.php');
                                                $sql = "SELECT * FROM department ORDER BY department";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value="<?= $row['department']; ?>" <?= isset($_GET['department']) == true ? ($_GET['department'] == $row['department'] ? 'selected' : '') : '' ?>><?= $row['department']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2" id="collegeDiv">
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
                                        <div class="col-md-4" id="programDiv">
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
                                        <div class="col-md-2 mb-2" id="yearlevelDiv">
                                            <select class="form-select" id="yearlevelSelect">
                                                <option value="" disabled selected>-Select Year Level-</option>
                                                <option value="" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == "" ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                include('connection.php');
                                                $sql = "SELECT * FROM yearlevel";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value="<?= $row['yearlevel']; ?>" <?= isset($_GET['yearlevel']) == true ? ($_GET['yearlevel'] == $row['yearlevel'] ? 'selected' : '') : '' ?>><?= $row['yearlevel']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="patients" class="btn btn-danger">Reset</a>
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
                                            <th>Patient ID</th>
                                            <th>Patient</th>
                                            <th>Campus</th>
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>College</th>
                                            <th>Program, Year & Section</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                            $patient = $_GET['patient'];
                                            $count = 1;
                                            $sql = "SELECT p.patientid, ac.usertype, p.address, p.campus, p.block, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid WHERE (CONCAT(ac.firstname,' ', ac.lastname) LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.middlename,' ', ac.lastname) LIKE '%$patient%' OR patientid LIKE '%$patient%')ORDER BY patientid LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['designation']) && $_GET['designation'] != '' || isset($_GET['campus']) && $_GET['campus'] != '' || isset($_GET['program']) && $_GET['program'] != '' || isset($_GET['college']) && $_GET['college'] != '' || isset($_GET['department']) && $_GET['department'] != '' || isset($_GET['yearlevel']) && $_GET['yearlevel'] != '') {
                                            $designation = isset($_GET['designation']) ? $_GET['designation'] : '';
                                            $campus = isset($_GET['campus']) ? $_GET['campus'] : '';
                                            $department = isset($_GET['department']) ? $_GET['department'] : "";
                                            $college = isset($_GET['college']) ? $_GET['college'] : "";
                                            $program = isset($_GET['program']) ? $_GET['program'] : "";
                                            $yearlevel = isset($_GET['yearlevel']) ? $_GET['yearlevel'] : "";

                                            // Initialize the WHERE clause
                                            $whereClause = " WHERE"; // Start with a default condition that is always true

                                            // Add conditions based on filters
                                            if ($patient !== '') {
                                                $whereClause .= "  (CONCAT(ac.firstname,' ', ac.lastname) LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.middlename,' ', ac.lastname) LIKE '%$patient%' OR patientid LIKE '%$patient%')";
                                            }

                                            if ($designation !== '' and $patient == "") {
                                                $whereClause .= " p.designation = '$designation'";
                                            } elseif ($designation !== '' and $patient == "") {
                                                $whereClause .= "  p.designation = '$designation'";
                                            }

                                            if ($campus !== '' and $patient != "" and $designation != "") {
                                                $whereClause .= " AND p.campus = '$campus'";
                                            } elseif ($campus !== '' and $patient == "" and $designation != "") {
                                                $whereClause .= " AND p.campus = '$campus'";
                                            } elseif ($campus !== '' and $patient != "" and $designation == "") {
                                                $whereClause .= " AND p.campus = '$campus'";
                                            } elseif ($campus !== '' and $patient == "" and $designation == "") {
                                                $whereClause .= " p.campus = '$campus'";
                                            }


                                            //yearlevel filter
                                            if ($yearlevel != "" and $patient == "" and $designation == "" and $campus == "") {
                                                $whereClause .= " p.yearlevel = '$yearlevel'";
                                            } elseif ($yearlevel != "" and ($patient != "" or $designation != "" or $campus != "")) {
                                                $whereClause .= " AND p.yearlevel = '$yearlevel'";
                                            }

                                            //department filter
                                            if ($department != "" and $yearlevel == "" and $patient == "" and $designation == "" and $campus == "") {
                                                $whereClause .= " p.department = '$department'";
                                            } elseif ($department != "" and ($yearlevel != "" and $patient != "" and $designation != "" and $campus != "")) {
                                                $whereClause .= " AND p.department = '$department'";
                                            }

                                            //college filter
                                            if ($college != "" and $department == "" and $yearlevel == "" and $patient == "" and $designation == "" and $campus == "") {
                                                $whereClause .= " p.college = '$college'";
                                            } elseif ($college != "" and ($department != "" or $yearlevel != "" or $patient != "" or $designation != "" or $campus != "")) {
                                                $whereClause .= " AND p.college = '$college'";
                                            }

                                            //program filter
                                            if ($program != "" and $college != "" and $department == "" and $yearlevel == "" and $patient == "" and $designation == "" and $campus == "") {
                                                $whereClause .= " AND p.program = '$program'";
                                            } elseif ($program != "" and ($college != "" or $department != "" or $yearlevel != "" or $patient != "" or $designation != "" or $campus != "")) {
                                                $whereClause .= " AND p.program = '$program'";
                                            }

                                            $count = 1;
                                            $sql = "SELECT p.patientid, ac.usertype, p.address, p.campus, p.block, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid $whereClause ORDER BY patientid LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT p.patientid, ac.usertype, p.address, p.campus, p.block, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid ORDER BY patientid LIMIT $start, $rows_per_page";
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
                                                    if ($data['department'] == NULL) {
                                                        $dep = "N/A";
                                                    } else {
                                                        $dep = $data['department'];
                                                    }
                                                    if ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' and $data['department'] == 'COLLEGE' and $data['college'] != 'GRADUATE STUDIES') {
                                                        $college = $data['college'];
                                                        $pys = $data['program'] . " " . $data['yearlevel'] . "-" .  $data['section'] . $data['block'];
                                                    } elseif ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' and $data['college'] == 'GRADUATE STUDIES') {
                                                        $college = $data['college'];
                                                        $pys =  $data['program'];
                                                    } elseif ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' and $data['department'] == 'JUNIOR HIGH SCHOOL') {
                                                        $college = "N/A";
                                                        $pys = $data['yearlevel'];
                                                    } elseif ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' and $data['department'] == 'SENIOR HIGH SCHOOL') {
                                                        $college = "N/A";
                                                        $pys =  $data['program'] . " - " . $data['yearlevel'];
                                                    } else {
                                                        $college = "N/A";
                                                        $pys = "N/A";
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $patientid = $data['patientid']; ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($data['lastname'])); ?></td>
                                                        <td><?php echo $data['campus']; ?></td>
                                                        <td><?php echo $data['designation']; ?></td>
                                                        <td><?php echo $dep ?></td>
                                                        <td><?php echo $college ?></td>
                                                        <td><?php echo $pys ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatepatient<?php echo $data['patientid']; ?>">Expand</button>
                                                            <?php $count++; ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    include('modals/update_patient_modal.php');
                                                } ?>

                                            <?php
                                            } else {
                                            ?>
                                                <td colspan="6">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                        <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) : ?>
                                        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['designation']) ? 'docu=' . $_GET['designation'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] .  '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['designation']) ? 'docu=' . $_GET['designation'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] .  '&' : '', isset($_GET['campus']) ? 'campus' . $_GET['campus'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['designation']) ? 'docu=' . $_GET['designation'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] .  '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['designation']) ? 'docu=' . $_GET['designation'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] .  '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['yearlevel']) ? 'yearlevel=' . $_GET['yearlevel'] . '&' : '', isset($_GET['designation']) ? 'docu=' . $_GET['designation'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] .  '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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
        $("#departmentSelect").change(function() {
            var department_id = $(this).val();
            $.ajax({
                url: "action_college.php",
                method: "POST",
                data: {
                    did: department_id,
                    type: 'department' // Add type parameter
                },
                success: function(data) {
                    $("#yearlevelSelect").html(data);
                }
            });
        });
    });

    $(document).ready(function() {
        $("#departmentSelect").change(function() {
            $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
        });
    });
</script>

</html>