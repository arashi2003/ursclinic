<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'sup_stocks_batch';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

$ldate = date("Y-m-t");

// get the total nr of rows.
$records = $conn->query("SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND campus = '$campus' ORDER BY batchid, stockid");
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
                <span class="dashboard">MEDICAL SUPPLY STOCKS</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addsupstocks">Add Entry</button>
                    <?php include('modals/nurseaddsupstocks_total_modal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="stocks_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="stocks" class="form-select">
                                                <option value="medicine">Medicine Stocks</option>
                                                <option value="supply" selected>Medical Supply Stocks</option>
                                                <option value="te">Tools and Equipment Stocks</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="supinv_viewfilter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="supinv_view" class="form-select">
                                                <option value="batch" selected>By Batch</option>
                                                <option value="expiration">By Expiration</option>
                                                <option value="total">By Total</option>
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
                                                <input type="text" name="supply" value="<?= isset($_GET['supply']) == true ? $_GET['supply'] : '' ?>" class="form-control" placeholder="Search medical supply">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="batch" class="form-select">
                                                <option value="">Select Batch ID</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT batchid FROM inventory WHERE stock_type = 'supply' AND campus = '$campus' ORDER BY batchid ASC";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $batch = $row["batchid"]; ?>
                                                        <option value="<?php echo $row["batchid"]; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["batchid"] ? 'selected' : '') : '' ?>"><?php echo $row["batchid"]; ?></option><?php }
                                                                                                                                                                                                                            } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['supply']) && $_GET['supply'] != '') {
                                    $supply = $_GET['supply'];
                                    $count = 1;
                                    $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND CONCAT(s.supply, ' ', s.volume, s.unit_measure) LIKE '%$supply%' AND campus = '$campus' ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['batch']) && $_GET['batch'] != '') {
                                    $batch = $_GET['batch'];
                                    $count = 1;
                                    $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND batchid='$batch' AND campus = '$campus' ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND campus = '$campus' ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Batch ID</th>
                                                    <th>Supply</th>
                                                    <th>Qty.</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Amt.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($data = mysqli_fetch_array($result)) {
                                                ?>
                                                    <tr>
                                                        <?php
                                                        $amount = $data['qty'] * $data['unit_cost'];
                                                        if ($data['expiration'] == "0000-00-00") {
                                                            $date = "N/A";
                                                        } else {
                                                            $date = date("F d, Y", strtotime($data['expiration']));
                                                        } ?>
                                                        <td><?php echo $data['batchid'] ?></td>
                                                        <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo $data['qty']?></td>
                                                        <td><?php echo $data['unit_cost']?></td>
                                                        <td><?php echo $amount;}?></td>
                                                    </tr>
                                                <?php
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