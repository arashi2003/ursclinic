<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'te_stocks';
$userid = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Check if the te or te_status filter is set
if (isset($_GET['te']) || isset($_GET['te_status'])) {
    // Validate and sanitize input
    $te = isset($_GET['te']) ? $_GET['te'] : '';
    $te_status = isset($_GET['te_status']) ? $_GET['te_status'] : '';

    // Initialize the WHERE clause
    $whereClause = " campus = '$campus' AND i.qty > 0"; // Start with common conditions

    // Add conditions based on filters
    if ($te !== '') {
        $whereClause .= " AND t.tools_equip LIKE '%$te%'"; // Add te filter
    }
    if ($te_status !== '') {
        $whereClause .= " AND i.status = '$te_status'"; // Add te_status filter
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM inventory_te i 
                  INNER JOIN tools_equip t ON t.teid = i.teid 
                  WHERE $whereClause";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM inventory_te i 
                  INNER JOIN tools_equip t ON t.teid = i.teid 
                  WHERE campus = '$campus' AND i.qty > 0";
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
    <title>Inventory</title>
    <?php include('../../includes/header.php'); ?>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtestocks">Add Entry</button>
                    <?php include('modals/nurseaddtestocksmodal.php'); ?>
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
                                            <div class="input-group mb-2">
                                                <input type="text" name="te" value="<?= isset($_GET['te']) == true ? $_GET['te'] : '' ?>" class="form-control" placeholder="Search tool/equipment">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="te_status" class="form-select">
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM te_status ORDER BY te_status";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $te_status = $row["te_status"];
                                                        $id = $row["id"]; ?>
                                                        <option value="<?php echo $id; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $te_status ? 'selected' : '') : '' ?>"><?php echo $te_status; ?></option><?php }
                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="te_stocks" class="btn btn-danger">Reset</a>
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
                                            <th>ID</th>
                                            <th>Tools and Equipment</th>
                                            <th>Unit Cost</th>
                                            <th>Total Amt.</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                    </thead>
                                    <tbody>
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
                                                foreach ($result as $data) {
                                        ?>
                                                    <tr>
                                                        <td><?php
                                                            $amount = $data['qty'] * $data['unit_cost'];
                                                            echo $data['id']; ?></td>
                                                        <td><?php echo $data['tools_equip'] . $data['unit_measure'] ?></td>
                                                        <td><?php echo number_format($data['unit_cost'], '2', '.') ?></td>
                                                        <td><?php echo number_format($amount, '2', '.') ?></td>
                                                        <td><?php echo $data['te_status']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#calimain<?php echo $data['teid'] ?>">Maintenance/Calibration</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    include('modals/calimain_modal.php');
                                                }
                                            } else {
                                                ?>
                                                <td colspan="7">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                        <?php
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) : ?>
                                        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['te']) ? 'te=' . $_GET['te'] . '&' : '', isset($_GET['te_status']) ? 'te_status=' . $_GET['te_status'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['te']) ? 'te=' . $_GET['te'] . '&' : '', isset($_GET['te_status']) ? 'te_status=' . $_GET['te_status'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['te']) ? 'te=' . $_GET['te'] . '&' : '', isset($_GET['te_status']) ? 'te_status=' . $_GET['te_status'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['te']) ? 'te=' . $_GET['te'] . '&' : '', isset($_GET['te_status']) ? 'te_status=' . $_GET['te_status'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['te']) ? 'te=' . $_GET['te'] . '&' : '', isset($_GET['te_status']) ? 'te_status=' . $_GET['te_status'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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

</html>