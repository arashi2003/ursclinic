<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');

// get the total nr of rows.
$records = $conn->query("SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, m.medicine, m.dosage, m.unit_measure FROM inventory b INNER JOIN medicine m on m.medid=b.stockid WHERE stock_type = 'medicine' AND campus = '$campus' ORDER BY batchid, stockid ");
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
                <span class="dashboard">MEDICINE STOCKS</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addmedstocks">Add Entry</button>
                    <?php include('modals/nurseaddmedstocks_batch_modal.php');?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <form action="medinv_viewfilter.php" method="POST">
                                        <div class="row">
                                            <div class="col-md-2 mb-3">
                                                <select name="medinv_view" class="form-select">
                                                    <option value="batch" selected>By Batch</option>
                                                    <option value="expiration">By Expiration</option>
                                                    <option value="total">By Total</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <button type="submit" class="btn btn-primary">View</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="" method="get">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <input type="text" name="medicine" value="<?= isset($_GET['medicine']) == true ? $_GET['medicine'] : '' ?>" class="form-control" placeholder="Search medicine">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <select name="batch" class="form-select">
                                                    <option value="">Select Batch ID</option>
                                                    <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                    <?php
                                                    $sql = "SELECT DISTINCT batchid FROM inventory WHERE stock_type = 'medicine' AND campus = '$campus' ORDER BY batchid ASC";
                                                    if($result = mysqli_query($conn, $sql))
                                                    {   while($row = mysqli_fetch_array($result) )
                                                        {   $batch = $row["batchid"];?>
                                                    <option value="<?php echo $row["batchid"];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["batchid"] ? 'selected' : '') : '' ?>"><?php echo $row["batchid"];?></option><?php }}?>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
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
                                    $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, m.medicine, m.dosage, m.unit_measure FROM inventory b INNER JOIN medicine m on m.medid=b.stockid WHERE stock_type = 'medicine' AND CONCAT(m.medicine, ' ', m.dosage, m.unit_measure) LIKE '%$medicine%' AND campus = '$campus' ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                elseif (isset($_GET['batch']) && $_GET['batch'] != '') {
                                    $batch = $_GET['batch'];
                                    $count = 1;
                                    $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, m.medicine, m.dosage, m.unit_measure FROM inventory b INNER JOIN medicine m on m.medid=b.stockid WHERE stock_type = 'medicine' AND batchid='$batch' AND campus = '$campus' ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, m.medicine, m.dosage, m.unit_measure FROM inventory b INNER JOIN medicine m on m.medid=b.stockid WHERE stock_type = 'medicine' AND campus = '$campus' ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Batch ID</th>
                                                    <th>Medicine</th>
                                                    <th>Qty.</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Amt.</th>
                                                    <th>Expiration.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while($data = mysqli_fetch_array($result)){
                                                    ?>
                                                    <tr>
                                                        <?php
                                                        $amount = $data['qty'] * $data['unit_cost'];
                                                        if ($data['expiration'] == "0000-00-00")
                                                        {
                                                            $date = "N/A";
                                                        }
                                                        else
                                                        {
                                                            $date = date("F d, Y", strtotime($data['expiration']));
                                                        }?>
                                                        <td><?php echo $data['batchid'] ?></td>
                                                        <td><?php echo $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo $data['qty']?></td>
                                                        <td><?php echo $data['unit_cost']?></td>
                                                        <td><?php echo $amount;?></td>
                                                        <td><?php echo $date;}?></td>
                                                    </tr>
                                                    <?php
                                                    }?>
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