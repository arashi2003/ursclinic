<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'apptype_set';

// get the total nr of rows.
$records = $conn->query("SELECT * FROM appointment_type");
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
                <span class="dashboard">APPOINTMENT TYPE</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#apptype_set">Add Entry</button>
                    <?php include('modals/apptype_set_modal.php');?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="app_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="app" class="form-select">
                                                <option value="type" selected>Type</option>
                                                <option value="purpose">Purpose</option>
                                                <option value="cc">Chief Complaint</option>
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
                                                <input type="text" name="apptype" value="<?= isset($_GET['apptype']) == true ? $_GET['apptype'] : '' ?>" class="form-control" placeholder="Search appointment type">
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
                                if (isset($_GET['apptype']) && $_GET['apptype'] != '') {
                                    $apptype = $_GET['apptype'];
                                    $count = 1;
                                    $sql = "SELECT * FROM appointment_type WHERE type LIKE '%$apptype%' ORDER BY type LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT * FROM appointment_type ORDER BY type LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Appointment Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach($result as $data){?>
                                                    <tr>
                                                        <td><?php echo $type=$data['id']; ?></td>
                                                        <td><?php echo $data['type'];?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateapptype_set<?php echo $data['id']; ?>">Update</button>
                                                            <?php
                                                            $sql = "SELECT type FROM appointment WHERE type LIKE '%$type%'";
                                                            $result = mysqli_query($conn, $sql);
                                                                if (mysqli_num_rows($result) > 0) 
                                                            {?>
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeapptype_set<?php echo $data['id']; ?>" disabled>Remove</button>
                                                            <?php }
                                                            else
                                                            {?>
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeapptype_set<?php echo $data['id'] ?>">Remove</button>
                                                            <?php }?> 
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    include('modals/update_apptype_set_modal.php');
                                                    include('modals/rem_apptype_set_modal.php');
                                                    }}?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php');?>
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