<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'med_stocks_total';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

$lastd = date("Y-m-t");

// get the total nr of rows.
$records = $conn->query("SELECT * from report_medsupinv WHERE campus = '$campus' AND type = 'medicine' AND date = '$lastd' ORDER BY medicine");
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
                <span class="dashboard">MEDICINE STOCKS</span>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmedstocks">Add Entry</button>
                    <?php include('modals/nurseaddmedstocks_total_modal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <form action="stocks_filter.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <select name="stocks" class="form-select">
                                                    <option value="medicine" selected>Medicine Stocks</option>
                                                    <option value="supply">Medical Supply Stocks</option>
                                                    <option value="te">Tools and Equipment Stocks</option>
                                                </select>
                                            </div>
                                            <div class="col mb-2">
                                                <button type="submit" class="btn btn-primary">View</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="medinv_viewfilter.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <select name="medinv_view" class="form-select">
                                                    <option value="batch">By Batch</option>
                                                    <option value="expiration">By Expiration</option>
                                                    <option value="total" selected>By Total</option>
                                                </select>
                                            </div>
                                            <div class="col mb-2">
                                                <button type="submit" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group mb-2">
                                                    <input type="text" name="medicine" value="<?= isset($_GET['medicine']) == true ? $_GET['medicine'] : '' ?>" class="form-control" placeholder="Search medicine">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['medicine']) && $_GET['medicine'] != '') {
                                    $medicine = $_GET['medicine'];
                                    $count = 1;
                                    $sql = "SELECT id, campus, type, stockid, stock_name, open, closed, qty, unit_cost, state FROM inv_total i INNER JOIN medicine m ON m.medid=i.stockid WHERE campus = '$campus' AND type = 'medicine' AND stock_name LIKE '%$medicine%' ORDER BY stock_name LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT id, campus, type, stockid, stock_name, open, closed, qty, unit_cost, state FROM inv_total i INNER JOIN medicine m ON m.medid=i.stockid WHERE campus = '$campus' AND type = 'medicine' ORDER BY stock_name LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Medicine</th>
                                                    <th>Qty.</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Amt.</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                while ($data = mysqli_fetch_array($result)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $data['id']; ?></td>
                                                        <td><?php echo $data['stock_name'] ?></td>
                                                        <td><?php echo $data['qty'] ?></td>
                                                        <td><?php echo number_format($data['unit_cost'], 2, '.'); ?></td>
                                                        <td><?php echo number_format(($data['unit_cost'] * $data['qty']), 2, '.'); ?></td>
                                                        <?php
                                                        if ($data['state'] == 'open-close') {
                                                        ?>
                                                            <td><button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatemed<?php echo $data['stockid']; ?>">Update</button></td>
                                                        <?php } else { ?>
                                                            <td><button type="button" class="btn btn-primary btn-sm" disabled>Update</button></td>
                                                        <?php } ?>
                                                    </tr>
                                            <?php
                                                    include('modals/update_medstocks_modal.php');
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