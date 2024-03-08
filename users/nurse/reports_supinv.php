<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'reports_supinv';
$campus = $_SESSION['campus'];
$now = date("Y-m-t");

if (!isset($_SESSION['username'])) {
    header('location:../../index');
}

// get the total nr of rows.
$records = $conn->query("SELECT * FROM report_medsupinv WHERE type='supply' AND campus = '$campus' AND date='$now'  ORDER BY medicine ");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Reports</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL SUPPLY CONSUMPTION REPORT</span>
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
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.open('reports/reports_supinv.php');">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="reports_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="reports" class="form-select">
                                                <option value="" disabled>Select Report</option>
                                                <option value="appointment">Appointment Report</option>
                                                <option value="docvisit">Doctor's Visit Schedule Report</option>
                                                <option value="transaction">Transaction Report</option>
                                                <option value="medcase">Medical Cases</option>
                                                <option value="medinv">Medicine Consumption Report</option>
                                                <option value="supinv" selected>Medical Supply Consumption Report</option>
                                                <option value="teinv">Tools and Equipment Inventory Report</option>
                                                <option value="tecalimain">Tools and Equipment Calibration and Maintenance Report</option>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="month" name="month" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_supinv" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <p>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['month']) && $_GET['month'] != '') {
                                    $month = date("Y-m-t", strtotime($_GET['month']));
                                    $count = 1;

                                    $sql = "SELECT * FROM report_medsupinv WHERE type='supply' AND campus = '$campus' AND date='$month'  ORDER BY medicine LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $now = date("Y-m-t");
                                    $sql = "SELECT * FROM report_medsupinv WHERE type='supply' AND campus = '$campus' AND date='$now' ORDER BY medicine LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Medical Supply</th>
                                            <th>Unit Cost</th>
                                            <th>Beginning Qty.</th>
                                            <th>Received Qty.</th>
                                            <th>Issued Qty.</th>
                                            <th>Ending Qty.</th>
                                            <th>Ending Amt.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($result as $row) {
                                                if($row['buc'] = 0)
                                                {
                                                    $buc = $row['eamt']/$row['eqty'];
                                                }
                                                elseif($row['eamt'] != 0)
                                                {
                                                    $buc = $row['eamt']/$row['eqty'];
                                                }
                                                elseif($row['buc'] != 0)
                                                {
                                                    $buc = $row['buc'];
                                                }
                                            ?>
                                            <tr>
                                                <td><?php echo $row['medicine'] ?></td>
                                                <td><?php echo number_format($buc, 2, '.') ?></td>
                                                <td><?php echo $row['bqty'] ?></td>
                                                <td><?php echo $row['rqty'] ?></td>
                                                <td><?php echo $row['iqty'] ?></td>
                                                <td><?php echo $row['eqty'] ?></td>
                                                <td><?php echo number_format($row['eamt'], 2, '.') ?></td>
                                            </tr>  
                                        <?php
                                        }}}
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php') ?>
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