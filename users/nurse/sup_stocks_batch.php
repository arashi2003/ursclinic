<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'sup_stocks_batch';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$campus = $_SESSION['campus'];

$ldate = date("Y-m-t");

// Check if the supply or batch filter is set
if (isset($_GET['supply']) || isset($_GET['batch'])) {
    // Validate and sanitize input
    $supply = isset($_GET['supply']) ? $_GET['supply'] : '';
    $batch = isset($_GET['batch']) ? $_GET['batch'] : '';

    // Initialize the WHERE clause
    $whereClause = " campus = '$campus' AND b.qty > 0"; // Start with common conditions

    // Add conditions based on filters
    if ($supply !== '') {
        $whereClause .= " AND CONCAT(s.supply, ' ', s.volume, s.unit_measure) LIKE '%$supply%'"; // Add supply filter
    }
    if ($batch !== '') {
        $whereClause .= " AND b.batchid = '$batch'"; // Add batch filter
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM inventory b 
                  INNER JOIN supply s ON s.supid = b.stockid 
                  WHERE $whereClause AND b.stock_type = 'supply'";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM inventory b 
                  INNER JOIN supply s ON s.supid = b.stockid 
                  WHERE campus = '$campus' AND b.qty > 0 AND b.stock_type = 'supply'";
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
                <span class="dashboard">MEDICAL SUPPLY STOCKS</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image FROM audit_trail au INNER JOIN account ac ON ac.accountid = au.user INNER JOIN patient_image i ON i.patient_id = au.user WHERE ((au.activity LIKE '%added a walk-in schedule%' AND au.activity LIKE '%$campus%') OR au.activity LIKE '%uploaded%' OR (au.activity LIKE '%cancelled a walk-in schedule%' AND au.activity LIKE '%$campus%') OR au.activity LIKE 'sent%' OR au.activity LIKE 'cancelled%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%expired%') AND au.status='unread' AND au.user != '$userid' ORDER BY au.datetime DESC";
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
                <div class="inv-tabs">
                    <div class="tabs">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link" href="med_stocks_total">Medicine</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Medical Supply</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="te_stocks">Tools and Equipment</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addsupstocks">Add Entry</button>
                        <?php include('modals/nurseaddsupstocks_total_modal.php'); ?>
                    </div>
                </div>
                <?php
                include('../../includes/alert.php');
                ?>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" name="supply" value="<?= isset($_GET['supply']) == true ? $_GET['supply'] : '' ?>" class="form-control" placeholder="Search medicine">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="supinv_viewfilter.php" method="POST">
                                    <div class="row">
                                        <div class="col mb-2">
                                            <select name="supinv_view" class="form-select">
                                                <option value="batch" selected>By Batch</option>
                                                <option value="expiration">By Expiration</option>
                                                <option value="total">By Total</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-9 mb-2">
                                            <select name="batch" class="form-select">
                                                <option value="" disabled selected>Select Batch ID</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT batchid FROM inventory WHERE stock_type = 'medicine' AND campus = '$campus' ORDER BY batchid ASC";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $batch = $row["batchid"]; ?>
                                                        <option value="<?php echo $row["batchid"]; ?>" <?= isset($_GET['batch']) == true ? ($_GET['batch'] == $row["batchid"] ? 'selected' : '') : '' ?>><?php echo $row["batchid"]; ?></option><?php }
                                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <div class="d-flex flex-row align-items-center">
                                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                                <a href="sup_stocks_batch" class="btn btn-danger">Reset</a>
                                            </div>
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
                                            <th>Batch ID</th>
                                            <th>Supply</th>
                                            <th>Qty.</th>
                                            <th>Unit Cost</th>
                                            <th>Total Amt.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['supply']) && $_GET['supply'] != '') {
                                            $supply = $_GET['supply'];
                                            $count = 1;
                                            $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND CONCAT(s.supply, ' ', s.volume, s.unit_measure) LIKE '%$supply%' AND campus = '$campus' AND qty > 0  ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['batch']) && $_GET['batch'] != '') {
                                            $batch = $_GET['batch'];
                                            $count = 1;
                                            $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND batchid='$batch' AND campus = '$campus' AND qty > 0  ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT b.id, b.campus, b.batchid, b.stock_type, b.stockid, b.qty, b.unit_cost, b.expiration, s.supply, s.volume, s.unit_measure FROM inventory b INNER JOIN supply s on s.supid=b.stockid WHERE stock_type = 'supply' AND campus = '$campus' AND qty > 0  ORDER BY batchid, stockid LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
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
                                                        <td><?php echo $data['qty'] ?></td>
                                                        <td><?php echo $data['unit_cost'] ?></td>
                                                        <td><?php echo $amount;
                                                        } ?></td>
                                                    </tr>
                                                <?php
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
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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