<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'patient_add';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM patient_info");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php')
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
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="designation" class="form-select">
                                                <option value="">Select Designation</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT designation FROM patient_info ORDER BY designation";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row["designation"]; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["designation"] ? 'selected' : '') : '' ?>"><?php echo $row["designation"]; ?></option><?php }
                                                                                                                                                                                                                                            } ?>
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
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>College</th>
                                            <th>Patient Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                            $patient = $_GET['patient'];
                                            $count = 1;
                                            $sql = "SELECT p.patientid, p.address, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid WHERE (CONCAT(ac.firstname,' ', ac.lastname) LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.middlename,' ', ac.lastname) LIKE '%$patient%' OR patientid LIKE '%$patient%')ORDER BY department, designation, ac.firstname LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['designation']) && $_GET['designation'] != '' || isset($_GET['campus']) && $_GET['campus'] != '') {
                                            $designation = $_GET['designation'];
                                            $count = 1;
                                            $sql = "SELECT p.patientid, p.address, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid WHERE designation = '$designation' ORDER BY department, designation, ac.firstname LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT p.patientid, p.address, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid ORDER BY department, designation, ac.firstname LIMIT $start, $rows_per_page";
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
                                                    if ($data['college'] == NULL) {
                                                        $college = "N/A";
                                                    }  elseif ($data['designation'] == 'STUDENT') {
                                                        $college = $data['college'];
                                                    } else {
                                                        $college = "N/A";
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $patientid = $data['patientid']; ?></td>
                                                        <td><?php echo $data['designation']; ?></td>
                                                        <td><?php echo $dep; ?></td>
                                                        <td><?php echo $college; ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($data['lastname'])); ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatepatient<?php echo $data['patientid']; ?>">Expand</button>
                                                            <?php $count++; ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    include('modals/update_patient_modal.php');
                                                } ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php') ?>
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
                                        } else {
                            ?>
                            <tr>
                                <td colspan="6">
                                    <?php
                                            include('../../includes/no-data.php');
                                    ?>
                                </td>
                            </tr>
                        <?php }
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