<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'program';

// get the total nr of rows.
$records = $conn->query("SELECT * FROM program");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php')
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
                <span class="dashboard">PROGRAM</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addprogram">Add Entry</button>
                    <?php include('modals/addprogram_modal.php');?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <input type="text" name="program" value="<?= isset($_GET['program']) == true ? $_GET['program'] : '' ?>" class="form-control" placeholder="Search program">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="department" class="form-select">
                                                <option value="">Select Department</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM department ORDER BY department";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {?>
                                                <option value="<?php echo $row["department"];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["department"] ? 'selected' : '') : '' ?>"><?php echo $row["department"];?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="college" class="form-select">
                                                <option value="">Select College</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM college ORDER BY college";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {?>
                                                <option value="<?php echo $row["college"];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["college"] ? 'selected' : '') : '' ?>"><?php echo $row["college"];?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="program" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['program']) && $_GET['program'] != '') {
                                    $program = $_GET['program'];
                                    $count = 1;
                                    $sql = "SELECT * FROM program WHERE program LIKE '%$program%' ORDER BY department, college, program LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['department']) && $_GET['department'] != '' || isset($_GET['college']) && $_GET['college'] != '') {
                                    $department = $_GET['department'];
                                    $college = $_GET['college'];
                                    $count = 1;
                                    if ($department == "")
                                    {
                                        $dep = "";
                                    }
                                    else
                                    {
                                        $dep = " WHERE department = '$department'";
                                    }

                                    if ($college =="")
                                    {
                                        $col = "";
                                    }
                                    elseif ($dep == "" AND $college != "")
                                    {
                                        $col = " WHERE college = '$college'";
                                    }
                                    elseif ($dep != "" AND $college != "")
                                    {
                                        $col = " AND college = '$college'";
                                    }
                                    $sql = "SELECT * FROM program $dep $col ORDER BY department, college, program LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                else {
                                    $count = 1;
                                    $sql = "SELECT * FROM program ORDER BY department, college, program LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Department</th>
                                                    <th>College</th>
                                                    <th>Program</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach($result as $data){
                                                    
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $data['department'];?></td>
                                                        <td><?php echo $data['college'];?></td>
                                                        <td><?php echo $data['abbrev']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateprogram<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeprogram<?php echo $data['id']; ?>">Remove</button>
                                                        <?php $count++; ?></td>
                                                        
                                                    </tr>
                                                    <?php
                                                    include('modals/update_program_modal.php');
                                                    include('modals/rem_program_modal.php');
                                                    }}?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php')?>
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