<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'appcc_set';

// get the total nr of rows.
$records = $conn->query("SELECT c.id, c.chief_complaint, t.type, p.purpose FROM appointment_cc c INNER JOIN appointment_purpose p ON p.id=c.purpose INNER JOIN appointment_type t ON t.id=p.type");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Settings</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT CHIEF COMPLAINT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <i class='bx bx-bell'></i>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#appcc_set">Add Entry</button>
                    <?php include('modals/appcc_set_modal.php');?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="app_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="app" class="form-select">
                                                <option value="type">Type</option>
                                                <option value="purpose">Purpose</option>
                                                <option value="cc" selected>Chief Complaint</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <input type="text" name="addcc" value="<?= isset($_GET['addcc']) == true ? $_GET['addcc'] : '' ?>" class="form-control" placeholder="Search appointment chief complaint">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['addcc']) && $_GET['addcc'] != '') {
                                    $addcc = $_GET['addcc'];
                                    $count = 1;
                                    $sql = "SELECT c.id, c.chief_complaint, t.type, p.purpose FROM appointment_cc c INNER JOIN appointment_purpose p ON p.id=c.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE chief_complaint LIKE '%$addcc%' ORDER BY t.type LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT c.id, c.chief_complaint, t.type, p.purpose FROM appointment_cc c INNER JOIN appointment_purpose p ON p.id=c.purpose INNER JOIN appointment_type t ON t.id=p.type ORDER BY t.type LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Appointment Type</th>
                                                    <th>Appointment Purpose</th>
                                                    <th>Appointment Chief Complaint</th>
                                                    <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($result as $data){?>
                                                    <tr>
                                                        <td><?php echo$data['id']; ?></td>
                                                        <td><?php echo $data['type'];?></td>
                                                        <td><?php echo $data['purpose'];?></td>
                                                        <td><?php echo  $chief = $data['chief_complaint'];?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateappcc_set<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeappcc_set<?php echo $data['id']; ?>" >Remove</button>
                                                            <?php $count++;?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    include('modals/update_appcc_set_modal.php');
                                                    include('modals/rem_appcc_set_modal.php');
                                                    }}?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php') ?>
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