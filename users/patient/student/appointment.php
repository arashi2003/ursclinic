<?php

session_start();
include('../../../connection.php');
include('../../../includes/student-auth.php');

$module = 'appointment';
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
$campus = $_SESSION['campus'];

// Check if the patient or designation filter is set
if (isset($_GET['physician']) || isset($_GET['date'])) {

    // Validate and sanitize input
    $physician = isset($_GET['physician']) ? $_GET['physician'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';

    // Initialize the WHERE clause
    $whereClause = "";

    // Add conditions based on filters
    if ($physician !== '') {
        $whereClause .= " physician='$physician' AND";
    }
    if ($date !== '') {
        $whereClause .= " date='$date' AND";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM appointment WHERE $whereClause patient='$userid'  ORDER BY date, time_from, time_to";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM appointment WHERE patient='$userid' ORDER BY date, time_from, time_to";
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
    <title>Appointment</title>
    <?php include('../../../includes/header.php') ?>
    <link rel="stylesheet" href="../../../css/bootstrap-datepicker3.min.css" />
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user WHERE 
                        ((au.activity LIKE 'approved a request%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'disapproved a request%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'cancelled a request%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'approved a request%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'completed a request%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'dismissed a request%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added a walk-in schedule%' AND au.activity LIKE '%$campus') 
                        OR (au.activity LIKE 'cancelled a walk-in schedule%' AND au.activity LIKE '%$campus')) 
                        AND au.status = 'unread' AND au.user != '$userid'";
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
                    <?php
                    $image = "SELECT * FROM patient_image WHERE patient_id = '$userid'";
                    $result = mysqli_query($conn, $image);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="profile">
                        <img src="../../../images/<?php echo $row['image']; ?>">
                    </div>
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
                            <li><a class="dropdown-item" href="../../../logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addappointment">Request Appointment</button>
                    <?php include('modals/add-appointment-modal.php');
                    ?>
                </div>
                <?php
                include('../../../includes/alert.php')
                ?>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="physician" class="form-select">
                                                <option value="" selected disabled>-Select Physician-</option>
                                                <option value="NONE" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <option value="GODWIN A. OLIVAS" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'GODWIN A. OLIVAS' ? 'selected' : '') : '' ?>>GODWIN A. OLIVAS</option>
                                                <option value="EDNA C. MAYCACAYAN" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'EDNA C. MAYCACAYAN' ? 'selected' : '') : '' ?>>EDNA C. MAYCACAYAN</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="appointment" class="btn btn-danger">Reset</a>
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
                                            <th>Appointment ID</th>
                                            <th>Date</th>
                                            <th>Time from</th>
                                            <th>Time to</th>
                                            <th>Physician</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['date']) && $_GET['date'] != '') {
                                            $date = $_GET['date'];
                                            $count = 1;
                                            $sql = "SELECT * FROM appointment WHERE date='$date' AND patient='$userid' ORDER BY date DESC, time_from, time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['physician']) && $_GET['physician'] != '') {
                                            $physician = $_GET['physician'];
                                            $count = 1;
                                            $sql = "SELECT * FROM appointment WHERE physician='$physician' AND patient='$userid' ORDER BY date DESC, time_from, time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM appointment WHERE patient='$userid' ORDER BY date DESC, time_from, time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                        ?>
                                                <?php
                                                foreach ($result as $data) {

                                                    if ($data['physician'] == NULL || $data['physician'] == "") {
                                                        $physician = "NONE";
                                                    } else {
                                                        $physician = $data['physician'];
                                                    }

                                                ?>
                                                    <tr>
                                                        <td><?= $data['id']; ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_from'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_to'])) ?></td>
                                                        <td><?php echo $physician; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($data['status'] == 'PENDING') {
                                                            ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php
                                                            } elseif ($data['status'] == 'CANCELLED') {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancelled<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php
                                                            } elseif ($data['status'] == 'APPROVED') {
                                                            ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#app_approved">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php
                                                            } elseif ($data['status'] == 'DISAPPROVED') {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_disapproved<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php
                                                            } elseif ($data['status'] == 'COMPLETED') {
                                                            ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#app_completed<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php
                                                            } elseif ($data['status'] == 'DISMISSED') {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_dismissed<?php echo $data['id'] ?>">
                                                                <?php echo $data['status'];
                                                            } ?>
                                                                </button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    if ($data['status'] == 'PENDING') {
                                                        include('modals/app_cancel_modal.php');
                                                    } elseif ($data['status'] == 'CANCELLED') {
                                                        include('modals/app_cancelled_modal.php');
                                                    } elseif ($data['status'] == 'APPROVED') {
                                                        include('modals/app_approved_modal.php');
                                                    } elseif ($data['status'] == 'DISAPPROVED') {
                                                        include('modals/app_disapproved_modal.php');
                                                    } elseif ($data['status'] == 'COMPLETED') {
                                                        include('modals/app_completed_modal.php');
                                                    } elseif ($data['status'] == 'DISMISSED') {
                                                        include('modals/app_dismissed_modal.php');
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="6">
                                                        <?php
                                                        include('../../../includes/no-data.php');
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
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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