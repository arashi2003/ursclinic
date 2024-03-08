<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'med_entry';
$userid = $_SESSION['userid'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM medicine");
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
                <span class="dashboard">MEDICINE ENTRY</span>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmedentry">Add Entry</button>
                    <?php include('modals/nurseaddmedentrymodal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <input type="text" name="medicine" value="<?= isset($_GET['medicine']) == true ? $_GET['medicine'] : '' ?>" class="form-control" placeholder="Search medicine entry">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="med_admin" class="form-select">
                                                <option value="">Select Administration</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT med_admin FROM medicine ORDER BY med_admin ASC";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $admin = $row["med_admin"]; ?>
                                                        <option value="<?php echo $row["med_admin"]; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["med_admin"] ? 'selected' : '') : '' ?>"><?php echo $row["med_admin"]; ?></option><?php }
                                                                                                                                                                                                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="dform" class="form-select">
                                                <option value="">Select Dosage Form</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT dosage_form FROM medicine ORDER BY dosage_form ASC";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $dform = $row["dosage_form"]; ?>
                                                        <option value="<?php echo $dform; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $dform ? 'selected' : '') : '' ?>"><?php echo $dform; ?></option><?php }
                                                                                                                                                                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="med_entry" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['medicine']) && $_GET['medicine'] != '') {
                                    $medicine = $_GET['medicine'];
                                    $count = 1;
                                    $sql = "SELECT * FROM medicine WHERE CONCAT(medicine, ' ', dosage, unit_measure) LIKE '%$medicine%' ORDER BY med_admin, medicine LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['med_admin']) && $_GET['med_admin'] != '' || isset($_GET['dform']) && $_GET['dform'] != '') {
                                    $med_admin = $_GET['med_admin'];
                                    $dform = $_GET['dform'];
                                    if ($med_admin == "") {
                                        $medadmin = "";
                                    } else {
                                        $medadmin = "WHERE med_admin = '$med_admin'";
                                    }
                                    if ($dform != "" and $med_admin != "") {
                                        $dosage = " AND dosage_form = '$dform'";
                                    } elseif ($dform != "" and $med_admin == "") {
                                        $dosage = "WHERE dosage_form = '$dform'";
                                    } else {
                                        $dosage = "";
                                    }

                                    $count = 1;
                                    $sql = "SELECT * FROM medicine $medadmin $dosage ORDER BY med_admin, medicine LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT * FROM medicine ORDER BY med_admin, medicine LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Medicine ID</th>
                                                    <th>Administration</th>
                                                    <th>Dosage Form</th>
                                                    <th>Medicine</th>
                                                    <th>Action</th>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach ($result as $data) { ?>
                                                    <tr>
                                                        <td><?php echo $data['medid']; ?></td>
                                                        <td><?php echo $data['med_admin'] ?></td>
                                                        <td><?php echo $data['dosage_form'] ?></td>
                                                        <td><?php echo $data['medicine'] . " " . $data['dosage'] . $data['unit_measure']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatemed<?php echo $data['medid']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removemed<?php echo $data['medid']; ?>">Remove</button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    include('modals/rem_medicine_modal.php');
                                                    include('modals/update_medicine_modal.php');
                                                }
                                            } ?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php'); ?>
                                    <?php
                                } else {
                                    ?>
                                        <tr>
                                            <td colspan="7">No record Found</td>
                                        </tr>
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