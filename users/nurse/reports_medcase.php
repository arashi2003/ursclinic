<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'reports_medcase';
$campus = $_SESSION['campus'];
$now = date("Y-m-t");

if (!isset($_SESSION['username'])) {
    header('location:../../index');
}

// Check if the month filter is set
if (isset($_GET['month']) && !empty($_GET['month'])) {
    $month = date("Y-m-t", strtotime($_GET['month']));
    $sql_count = "SELECT COUNT(*) AS total_rows FROM reports_medcase WHERE campus = '$campus' AND date='$month'";
} else {
    // If month filter is not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM reports_medcase WHERE campus = '$campus'";
}

// Execute the count query
$count_result = $conn->query($sql_count);

// Check if count query was successful
if ($count_result) {
    // Fetch the total number of rows
    $count_row = $count_result->fetch_assoc();
    $nr_of_rows = $count_row['total_rows'];
} else {
    // Handle count query error
    echo "Error: " . $conn->error;
}


// Setting the number of rows to display in a page.
$rows_per_page = 10;

// determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from, value.
$start = ($page - 1) * $rows_per_page;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);

// calculate the range of page numbers to be displayed
$start_loop = max(1, $page - 2);
$end_loop = min($pages, $page + 2);

// adjust the range if the current page is near the beginning or end
if ($start_loop > 1) {
    $start_loop--;
    $end_loop++;
}

// ensure that the range is never smaller than 4
if ($end_loop - $start_loop < 4) {
    $start_loop = max(1, $end_loop - 4);
}

$previous = $page - 1;
$next = $page + 1;

// calculate the start and end loop variables
$start_loop = $page > 2 ? $page - 2 : 1;
$end_loop = $page < $pages - 2 ? $page + 2 : $pages;

// limit the number of pages displayed to a maximum of 4
if ($pages > 4) {
    if ($page > 2 && $page < $pages - 1) {
        $end_loop = $page + 1;
    } elseif ($page == 1) {
        $start_loop = 1;
        $end_loop = 4;
    } elseif ($page == $pages) {
        $start_loop = $pages - 3;
        $end_loop = $pages;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Reports</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">
                    <H1>MEDICAL CASES REPORT</H1>
                </span>
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
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.open('reports/reports_medcase.php');">Export to PDF</button>
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
                                                <option value="medcase" selected>Medical Cases</option>
                                                <option value="medinv">Medicine Consumption Report</option>
                                                <option value="supinv">Medical Supply Consumption Report</option>
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
                            <div class="col-md-12 mb-3">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <input type="month" name="month" class="form-control" value="<?= isset($_GET['month']) == true ? $_GET['month'] : '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="hidden" name="page" value="<?= $page ?>">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_teinv" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['month']) && $_GET['month'] != '') {
                                    $month = date("Y-m-t", strtotime($_GET['month']));
                                    $sql = "SELECT * FROM reports_medcase WHERE campus = '$campus' AND date='$month' LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $now = date("Y-m-t");
                                    $sql = "SELECT * FROM reports_medcase WHERE campus = '$campus' AND date='$now' LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Medical Case</th>
                                                    <th>Students</th>
                                                    <th>Personnel</th>
                                                    <th>Grand Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['medcase'] ?></td>
                                                        <td><?php echo $row['st'] ?></td>
                                                        <td><?php echo $row['pt'] ?></td>
                                                        <td><?php echo $row['gt'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <h3>No records found for the selected date.</h3>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            // Handle query error
                                            echo "Error: " . $conn->error;
                                        }
                                        mysqli_close($conn);
                                        ?>
                                            </tbody>
                                        </table>
                            </div>
                            <ul class="pagination justify-content-end">
                                <?php 
                                if (!empty($_GET['month'])) : ?>
                                    <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['month']) ? 'month=' . $_GET['month'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                    </li>
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['month']) ? 'month=' . $_GET['month'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                    </li>
                                    <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['month']) ? 'month=' . $_GET['month'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['month']) ? 'month=' . $_GET['month'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                    </li>
                                    <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['month']) ? 'month=' . $_GET['month'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
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