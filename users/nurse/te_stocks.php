<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$campus = $_SESSION['campus'];
$module = 'te_stocks';

// get the total nr of rows.
$records = $conn->query("SELECT * FROM inventory_te WHERE campus='$campus'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Inventory</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">TOOLS AND EQUIPMENT STOCKS</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addtestocks">Add Entry</button>
                    <?php include('modals/nurseaddtestocksmodal.php');?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="stocks_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select name="stocks" class="form-select">
                                                <option value="medicine">Medicine Stocks</option>
                                                <option value="supply">Medical Supply Stocks</option>
                                                <option value="te" selected>Tools and Equipment Stocks</option>
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
                                                <input type="text" name="te" value="<?= isset($_GET['te']) == true ? $_GET['te'] : '' ?>" class="form-control" placeholder="Search tool/equipment">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="te_status" class="form-select">
                                                <option value="Select Status">Select Status</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM te_status ORDER BY te_status";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {   $te_status = $row["te_status"];
                                                        $id = $row["id"];?>
                                                <option value="<?php echo $id;?> <?= isset($_GET['']) == true ? ($_GET[''] == $te_status ? 'selected' : '') : '' ?>"><?php echo $te_status;?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="te_stocks" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['te']) && $_GET['te'] != '') {
                                    $te = $_GET['te'];
                                    $count = 1;
                                    $sql = "SELECT i.id, i.campus, i.teid, i.qty, i.unit_cost, i.status, i.date, i.time, t.tools_equip, t.unit_measure, t.teid, s.te_status FROM inventory_te i INNER JOIN tools_equip t on t.teid=i.teid INNER JOIN te_status s on s.id=i.status WHERE t.tools_equip LIKE '%$te%' AND campus = '$campus' ORDER BY t.tools_equip LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['te_status']) && $_GET['te_status'] != '') {
                                    $te_status = $_GET['te_status'];
                                    $count = 1;
                                    $sql = "SELECT i.id, i.campus, i.teid, i.qty, i.unit_cost, i.status, i.date, i.time, t.tools_equip, t.unit_measure, t.teid, s.te_status FROM inventory_te i INNER JOIN tools_equip t on t.teid=i.teid INNER JOIN te_status s on s.id=i.status WHERE status = '$te_status' AND campus = '$campus' ORDER BY t.tools_equip LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT i.id, i.campus, i.teid, i.qty, i.unit_cost, i.status, i.date, i.time, t.tools_equip, t.unit_measure, t.teid, s.te_status FROM inventory_te i INNER JOIN tools_equip t on t.teid=i.teid INNER JOIN te_status s on s.id=i.status WHERE campus = '$campus' ORDER BY t.tools_equip LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tools and Equipment</th>
                                                <th>Unit Cost</th>
                                                <th>Total Amt.</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($result as $data) {
                                                ?>
                                                    <tr>
                                                        <td><?php  
                                                            $amount = $data['qty'] * $data['unit_cost'];
                                                            echo $data['id']; ?></td> 
                                                        <td><?php echo $data['tools_equip'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo number_format($data['unit_cost'], '2', '.')?></td>
                                                        <td><?php echo number_format($amount, '2', '.') ?></td>
                                                        <td><?php echo $data['te_status'];?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calimain<?php echo $data['teid']?>">Maintenance/Calibration</button>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                include('modals/calimain_modal.php');}}
                                                ?>
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