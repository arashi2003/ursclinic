<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'sup_stocks_exp';

// get the total nr of rows.
$records = $conn->query("SELECT i.id, i.open, i.closed, i.campus, i.supid, i.qty, i.unit_cost, i.expiration, m.supply, m.volume, m.unit_measure, m.supid FROM inventory_supply i INNER JOIN supply m on m.supid=i.supid WHERE campus = '$campus' ORDER BY expiration ");
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
                <span class="dashboard">MEDICAL SUPPLY STOCKS</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addsupstocks">Add Entry</button>
                    <?php include('modals/nurseaddsupstocks_exp_modal.php');?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="supinv_viewfilter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="medinv_view" class="form-select">
                                                <option value="batch">By Batch</option>
                                                <option value="expiration" selected>By Expiration</option>
                                                <option value="total">By Total</option>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <input type="text" name="supply" value="<?= isset($_GET['supply']) == true ? $_GET['supply'] : '' ?>" class="form-control" placeholder="Search medical supply">
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
                                if (isset($_GET['supply']) && $_GET['supply'] != '') {
                                    $supply = $_GET['supply'];
                                    $count = 1;
                                    $sql = "SELECT i.id, i.open, i.closed, i.campus, i.supid, i.qty, i.unit_cost, i.expiration, m.supply, m.volume, m.unit_measure, m.supid FROM inventory_supply i INNER JOIN supply m on m.supid=i.supid WHERE m.supply LIKE '%$supply%' AND campus = '$campus' ORDER BY expiration LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT i.id, i.open, i.closed, i.campus, i.supid, i.qty, i.unit_cost, i.expiration, m.supply, m.volume, m.unit_measure, m.supid FROM inventory_supply i INNER JOIN supply m on m.supid=i.supid WHERE campus = '$campus' ORDER BY expiration LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Supply</th>
                                                    <th>Opened</th>
                                                    <th>Unopened</th>
                                                    <th>Total Qty.</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Amt.</th>
                                                    <th>Expiration</th>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach($result as $data){
                                                    $today = date("Y-m-d");
                                                    
                                                    $amount = $data['qty'] * $data['unit_cost'];
                                                            
                                                    if ($data['expiration'] == "0000-00-00")
                                                    {
                                                        $date = "N/A";
                                                    }
                                                    else
                                                    {
                                                        $date = date("F d, Y", strtotime($data['expiration']));
                                                    }

                                                    if($date="N/A")
                                                    {                           
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $data['id'];?></td>
                                                        <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo $data['open']?></td>
                                                        <td><?php echo $data['closed']?></td>
                                                        <td><?php echo $data['qty']?></td>
                                                        <td><?php echo $data['unit_cost']?></td>
                                                        <td><?php echo $amount ?></td>
                                                        <td><?php echo $date;?></td>
                                                    </tr>
                                                    <?php
                                                    }elseif($data['expiration'] <= $today) {?>
                                                    <tr style="color: red;">
                                                        <td><?php echo $data['id'];?></td>
                                                        <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo $data['open']?></td>
                                                        <td><?php echo $data['closed']?></td>
                                                        <td><?php echo $data['qty']?></td>
                                                        <td><?php echo $data['unit_cost']?></td>
                                                        <td><?php echo $amount ?></td>
                                                        <td><?php echo $date;?></td>
                                                    </tr>
                                                    <?php
                                                    }else{?>
                                                    <tr>
                                                        <td><?php echo $data['id'];?></td>
                                                        <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo $data['open']?></td>
                                                        <td><?php echo $data['closed']?></td>
                                                        <td><?php echo $data['qty']?></td>
                                                        <td><?php echo $data['unit_cost']?></td>
                                                        <td><?php echo $amount ?></td>
                                                        <td><?php echo $date;?></td>
                                                    </tr>
                                                    <?php }}?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php');?>
                                    <?php
                                    }} else {
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