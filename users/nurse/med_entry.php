<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'med_entry';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$campus = $_SESSION['campus'];

// Check if the medicine, med_admin, or dosage form filter is set
if (isset($_GET['medicine']) || isset($_GET['med_admin']) || isset($_GET['dform'])) {
    // Validate and sanitize input
    $medicine = isset($_GET['medicine']) ? $_GET['medicine'] : '';
    $med_admin = isset($_GET['med_admin']) ? $_GET['med_admin'] : '';
    $dform = isset($_GET['dform']) ? $_GET['dform'] : '';

    // Initialize the WHERE clause
    $whereClause = "1=1"; // Start with a default condition that is always true

    // Add conditions based on filters
    if ($medicine !== '') {
        $whereClause .= " AND CONCAT(medicine, ' ', dosage, unit_measure) LIKE '%$medicine%'";
    }
    if ($med_admin !== '') {
        $whereClause .= " AND med_admin = '$med_admin'";
    }
    if ($dform !== '') {
        $whereClause .= " AND dosage_form = '$dform'";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM medicine WHERE $whereClause";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM medicine";
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
                <span class="dashboard">MEDICINE ENTRY</span>
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
                <div class="inv-tabs">
                    <div class="tabs">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Medicine</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="sup_entry">Medical Supply</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="te_entry">Tools and Equipment</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmedentry">Add Medicine</button>
                        <?php include('modals/nurseaddmedentrymodal.php'); ?>
                    </div>
                </div>
                <?php
                include('../../includes/alert.php');
                ?>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="medicine" value="<?= isset($_GET['medicine']) == true ? $_GET['medicine'] : '' ?>" class="form-control" placeholder="Search medicine entry">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="med_admin" class="form-select">
                                                <option value="" disabled selected>-Select Administration-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT med_admin FROM medicine ORDER BY med_admin ASC";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $admin = $row["med_admin"]; ?>
                                                        <option value="<?php echo $row["med_admin"]; ?>" <?= isset($_GET['med_admin']) == true ? ($_GET['med_admin'] == $row["med_admin"] ? 'selected' : '') : '' ?>><?php echo $row["med_admin"]; ?></option><?php }
                                                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="dform" class="form-select">
                                                <option value="" disabled selected>-Select Dosage Form-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT dosage_form FROM medicine ORDER BY dosage_form ASC";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $dform = $row["dosage_form"]; ?>
                                                        <option value="<?php echo $dform; ?>" <?= isset($_GET['dform']) == true ? ($_GET['dform'] == $dform ? 'selected' : '') : '' ?>><?php echo $dform; ?></option><?php }
                                                                                                                                                                                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="med_entry" class="btn btn-danger">Reset</a>
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
                                            <th>Medicine ID</th>
                                            <th>Administration</th>
                                            <th>Dosage Form</th>
                                            <th>Medicine</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['medicine']) && $_GET['medicine'] != '') {
                                            $medicine = $_GET['medicine'];
                                            $count = 1;
                                            $sql = "SELECT * FROM medicine WHERE CONCAT(medicine, ' ', dosage, unit_measure) LIKE '%$medicine%' ORDER BY med_admin, medicine LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['med_admin']) && $_GET['med_admin'] != '' || isset($_GET['dform']) && $_GET['dform'] != '') {
                                            $med_admin = isset($_GET['med_admin']) ? $_GET['med_admin'] : '';
                                            $dform = isset($_GET['dform']) ? $_GET['dform'] : '';
                                            if ($med_admin == "") {
                                                $medadmin = "";
                                            } else {
                                                $medadmin = "WHERE med_admin = '$med_admin'";
                                            }
                                            if ($dform != "" and $med_admin != "") {
                                                $dosage = " AND dosage_form = '$dform'";
                                            } elseif ($dform != "" and $med_admin == "") {
                                                $dosage = "WHERE dosage_form = '$dform'";
                                            } else {
                                                $dosage = "";
                                            }

                                            $count = 1;
                                            $sql = "SELECT * FROM medicine $medadmin $dosage ORDER BY med_admin, medicine LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM medicine ORDER BY med_admin, medicine LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                        ?>
                                                    <tr>
                                                        <td><?php echo $data['medid']; ?></td>
                                                        <td><?php echo $data['med_admin'] ?></td>
                                                        <td><?php echo $data['dosage_form'] ?></td>
                                                        <td><?php echo $data['medicine'] . " " . $data['dosage'] . $data['unit_measure']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatemed<?php echo $data['medid']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removemed<?php echo $data['medid']; ?>">Remove</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    include('modals/rem_medicine_modal.php');
                                                    include('modals/update_medicine_modal.php');
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <?php
                                                        include('../../includes/no-data.php');
                                                        ?>
                                                    </td>
                                                </tr>
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
                                            <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['med_admin']) ? 'med_admin=' . $_GET['med_admin'] . '&' : '', isset($_GET['dform']) ? 'dform=' . $_GET['dform'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['med_admin']) ? 'med_admin=' . $_GET['med_admin'] . '&' : '', isset($_GET['dform']) ? 'dform=' . $_GET['dform'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['med_admin']) ? 'med_admin=' . $_GET['med_admin'] . '&' : '', isset($_GET['dform']) ? 'dform=' . $_GET['dform'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['med_admin']) ? 'med_admin=' . $_GET['med_admin'] . '&' : '', isset($_GET['dform']) ? 'dform=' . $_GET['dform'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['med_admin']) ? 'med_admin=' . $_GET['med_admin'] . '&' : '', isset($_GET['dform']) ? 'dform=' . $_GET['dform'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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