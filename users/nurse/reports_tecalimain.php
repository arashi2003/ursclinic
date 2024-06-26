<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'reports_tecalimain';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

$dt1 = date("Y-m-d");
$dt2 = date("Y-m-t");

// Check if the supply or batch filter is set
if (isset($_GET['month'])) {
    // Validate and sanitize input
    $month = isset($_GET['month']) ? $_GET['month'] : '';

    $whereClause = " campus = '$campus'"; // Start with common conditions

    if ($month !== '') {
        $month = date("Y-m-t", strtotime($month)); // Convert month to last day of the month
        $whereClause .= " AND date = '$month'"; // Add month filter
    }

    // Construct and execute SQL query for counting total rows for transaction_history
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM report_teinv 
                  WHERE $whereClause";
} else {
    // If filters are not set, count all rows for transaction_history
    $now = date("Y-m-t");
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM report_teinv WHERE campus = '$campus' AND date='$now'";
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
                    CALIBRATION AND MAINTENANCE REPORT
                </span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.usertype, ac.lastname, ac.campus, i.image FROM audit_trail au INNER JOIN account ac ON ac.accountid = au.user INNER JOIN patient_image i ON i.patient_id = au.user WHERE ((au.activity LIKE '%added a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE '%uploaded%'  AND au.campus ='$campus') OR (au.activity LIKE '%cancelled a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE 'sent%' AND au.campus ='$campus') OR (au.activity LIKE 'cancelled%' AND au.campus ='$campus') OR (au.activity LIKE 'uploaded medical document%' AND au.campus ='$campus') OR (au.activity LIKE '%expired%' AND au.campus ='$campus')) AND au.status='unread' AND au.user != '$userid' ORDER BY au.datetime DESC";
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
                    <form action="reports/reports_teCaliMain" method="post" id="exportPdfForm" target="_blank">
                        <!-- Hidden input fields to store filter values -->
                        <input type="hidden" value="<?= isset($_GET['month']) == true ? $_GET['month'] : '' ?>" name="month" id="month">

                        <!-- Export PDF button -->
                        <button type="submit" class="btn btn-primary" name="export_pdf">Export PDF</button>
                    </form>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="reports_filter.php" method="POST" id="reportForm">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="reports" class="form-select" id="reportSelect">
                                                <option value="" disabled>Select Report</option>
                                                <option value="appointment">Appointment Report</option>
                                                <option value="docvisit">Doctor's Visit Schedule Report</option>
                                                <option value="medcase">Medical Cases</option>
                                                <option value="meddoc">Medical Documents Accomplishment Report</option>
                                                <option value="medinv">Medicine Consumption Report</option>
                                                <option value="supinv">Medical Supply Consumption Report</option>
                                                <option value="patinfo">Patient Information Report</option>
                                                <option value="transaction">Transaction Report</option>
                                                <option value="teinv">Tools and Equipment Inventory Report</option>
                                                <option value="tecalimain" selected>Tools and Equipment Calibration and Maintenance Report</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <form action="" method="GET" id="filterForm">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <input type="month" name="month" class="form-control" value="<?= isset($_GET['month']) == true ? $_GET['month'] : '' ?>">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_tecalimain" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="head">
                                        <tr>
                                            <th>Tool/Equipment</th>
                                            <th>Date From</th>
                                            <th>Date To</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['month']) && $_GET['month'] != '') {
                                            $mon = date("Y-m", strtotime($_GET['month']));
                                            $count = 1;
                                            $sql = "SELECT campus, c.tools_equip, c.date_from, c.date_to, c.status, t.tools_equip, t.unit_measure FROM te_calimain c INNER JOIN tools_equip t on t.teid=c.tools_equip WHERE campus = '$campus' AND (date_from LIKE '%$mon%' AND date_to LIKE '%$mon%') ORDER BY date_from DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT campus, c.tools_equip, c.date_from, c.date_to, c.status, t.tools_equip, t.unit_measure FROM te_calimain c INNER JOIN tools_equip t on t.teid=c.tools_equip WHERE campus = '$campus' ORDER BY date_from DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $row) {
                                        ?>
                                                    <tr>
                                                        <td><?php echo $row['tools_equip'] . $row['unit_measure'] ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($row['date_from'])) ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($row['date_to'])) ?></td>
                                                        <td><?php echo $row['status'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <td colspan="4">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                        <?php }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) : ?>
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

<script>
    // Function to update hidden input fields with filter values
    function updateExportPdfForm() {
        var monthInput = document.querySelector("input[name='month']");

        document.getElementById("month").value = monthInput.value;
    }

    // Event listener for Export PDF form submission
    document.getElementById("exportPdfForm").addEventListener("submit", function(event) {
        // Update hidden input fields with filter values
        updateExportPdfForm();
    });

    // Event listener for Filter form submission
    document.getElementById("filterForm").addEventListener("submit", function(event) {
        // Update hidden input fields with filter values
        updateExportPdfForm();
    });
</script>

<script>
    document.getElementById('reportSelect').addEventListener('change', function() {
        document.getElementById('reportForm').submit();
    });
</script>

</html>