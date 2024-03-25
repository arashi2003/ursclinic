<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'sup_stocks_exp';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$campus = $_SESSION['campus'];

// Check if the supply filter is set
if (isset($_GET['supply'])) {
    // Validate and sanitize input
    $supply = isset($_GET['supply']) ? $_GET['supply'] : '';

    // Initialize the WHERE clause
    $whereClause = " campus = '$campus' AND i.qty > 0"; // Start with common conditions

    // Add conditions based on filters
    if ($supply !== '') {
        $whereClause .= " AND m.supply LIKE '%$supply%'"; // Use $supply instead of $medicine for supply filter
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM inventory_supply i 
                  INNER JOIN supply m ON m.supid=i.supid
                  WHERE $whereClause ORDER BY expiration";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM inventory_supply i 
                  INNER JOIN supply m ON m.supid=i.supid
                  WHERE campus = '$campus' AND i.qty > 0 ORDER BY expiration";
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
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image FROM audit_trail au INNER JOIN account ac ON ac.accountid = au.user INNER JOIN patient_image i ON i.patient_id = au.user WHERE ((au.activity LIKE '%added a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE '%cancelled a walk-in schedule%' AND au.activity LIKE '%$campus%') OR au.activity LIKE 'sent%' OR au.activity LIKE 'cancelled%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%expired%') AND au.status='unread' AND au.user != '$userid' ORDER BY au.datetime DESC";
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addsupstocks">Add Entry</button>
                    <?php include('modals/nurseaddsupstocks_exp_modal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4">
                                <form action="stocks_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-10 mb-2">
                                            <select name="stocks" class="form-select">
                                                <option value="medicine">Medicine Stocks</option>
                                                <option value="supply" selected>Medical Supply Stocks</option>
                                                <option value="te">Tools and Equipment Stocks</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form action="supinv_viewfilter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-10 mb-2">
                                            <select name="medinv_view" class="form-select">
                                                <option value="batch">By Batch</option>
                                                <option value="expiration" selected>By Expiration</option>
                                                <option value="total">By Total</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group mb-2">
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
                                <table class="table">
                                    <thead class="head">
                                        <tr>
                                            <th>ID</th>
                                            <th>Supply</th>
                                            <th>Qty.</th>
                                            <th>Unit Cost</th>
                                            <th>Total Amt.</th>
                                            <th>Expiration</th>
                                            <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['supply']) && $_GET['supply'] != '') {
                                            $supply = $_GET['supply'];
                                            $count = 1;
                                            $sql = "SELECT i.id, i.open, i.closed, i.campus, i.supid, i.qty, i.unit_cost, i.expiration, m.supply, m.volume, m.unit_measure, m.supid FROM inventory_supply i INNER JOIN supply m on m.supid=i.supid WHERE m.supply LIKE '%$supply%' AND campus = '$campus' AND qty > 0  ORDER BY expiration DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT i.id, i.open, i.closed, i.campus, i.supid, i.qty, i.unit_cost, i.expiration, m.supply, m.volume, m.unit_measure, m.supid FROM inventory_supply i INNER JOIN supply m on m.supid=i.supid WHERE campus = '$campus' AND qty > 0  ORDER BY expiration DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                                    $today = date("Y-m-d");

                                                    $amount = $data['qty'] * $data['unit_cost'];

                                                    if ($data['expiration'] == "") {
                                                        $date = "N/A";
                                                    } else {
                                                        $date = date("F d, Y", strtotime($data['expiration']));
                                                    }

                                                    if ($date == "N/A") {
                                        ?>
                                                        <tr>
                                                            <td><?php echo $data['id']; ?></td>
                                                            <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                            <td><?php echo $data['qty'] ?></td>
                                                            <td><?php echo $data['unit_cost'] ?></td>
                                                            <td><?php echo $amount ?></td>
                                                            <td><?php echo $date; ?></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm" disabled>Remove</button></td>
                                                        </tr>
                                                    <?php
                                                    } elseif ($data['expiration'] <= $today) { ?>
                                                        <tr style="color: red;">
                                                            <td><?php echo $data['id']; ?></td>
                                                            <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                            <td><?php echo $data['qty'] ?></td>
                                                            <td><?php echo $data['unit_cost'] ?></td>
                                                            <td><?php echo $amount ?></td>
                                                            <td><?php echo $date; ?></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rem_exp<?php echo $data['id']; ?>">Remove</button></td>
                                                        </tr>
                                                    <?php
                                                        include('modals/rem_exp_medstocks_modal.php');
                                                    } else {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $data['id']; ?></td>
                                                            <td><?php echo $data['supply'] . " " . $data['volume'] . $data['unit_measure'] ?></td>
                                                            <td><?php echo $data['qty'] ?></td>
                                                            <td><?php echo $data['unit_cost'] ?></td>
                                                            <td><?php echo $amount ?></td>
                                                            <td><?php echo $date; ?></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm" disabled>Remove</button></td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                            } else { ?>
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
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['supply']) ? 'supply=' . $_GET['supply'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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