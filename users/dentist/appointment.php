<?php

session_start();
include('../../connection.php');
include('../../includes/dentist-auth.php');

$module = 'appointment';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$fullname = $_SESSION['name'];
$usertype = $_SESSION['usertype'];
$today = date("Y-m-d");

// Check if the patient or date filter is set
if (isset($_GET['patient']) || isset($_GET['date'])) {
    // Validate and sanitize input
    $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';

    // Initialize the WHERE clause
    $whereClause = ""; // Start with common conditions

    // Add conditions based on filters
    if ($patient !== '') {
        $whereClause .= " AND (CONCAT(ac.firstname, ' ', ac.middlename, ' ', ac.lastname) LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.lastname) LIKE '%$patient%') "; // Add patient filter
    }
    if ($date !== '') {
        $whereClause .= " AND ap.date = '$date'"; // Add date filter
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE date > '$today'  AND physician = '$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') $whereClause ORDER BY ap.date, ap.time_from, ap.time_to";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE date > '$today'  AND physician = '$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') ORDER BY ap.date, ap.time_from, ap.time_to";
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
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT</span>
            </div>
            <div class="right-nav">
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
            <?php
            include('../../includes/alert.php')
            ?>
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="appointment" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
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
                                            <th>Patient</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $today = date("Y-m-d");
                                        // Construct and execute SQL query based on filters
                                        if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                            $patient = $_GET['patient'];
                                            $count = 1;
                                            $sql = "SELECT ap.id, ap.patient, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE (CONCAT(ac.firstname, ' ', ac.middlename, ' ' ,ac.lastname)  LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.lastname) LIKE '%$patient%') AND date > '$today'  AND physician = '$fullname'  AND (ap.status='APPROVED' OR ap.status='COMPLETED') ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['date']) && $_GET['date'] != '') {
                                            $date = $_GET['date'];
                                            $count = 1;
                                            $sql = "SELECT ap.id, ap.patient, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.date = '$date' AND physician = '$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED')  ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT ap.id, ap.patient, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE date = '$today'  AND physician = '$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') ORDER BY ap.date, ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                                    if (count(explode(" ", $data['middlename'])) > 1) {
                                                        $middle = explode(" ", $data['middlename']);
                                                        $letter = $middle[0][0] . $middle[1][0];
                                                        $middleinitial = $letter . ".";
                                                    } else {
                                                        $middle = $data['middlename'];
                                                        if ($middle == "" or $middle == " ") {
                                                            $middleinitial = "";
                                                        } else {
                                                            $middleinitial = substr($middle, 0, 1) . ".";
                                                        }
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $id = $data['id']; ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_from'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_to'])) ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($data['status'] == 'APPROVED' AND $data['date'] == $today) {
                                                            ?>
                                                                <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href = 'appointment_view?id=<?php echo $data['id'] ?>'">Record</button>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id; ?>">Cancel</button>
                                                            <?php
                                                            } elseif ($data['status'] == 'APPROVED' AND $data['date'] != $today) {
                                                                ?>
                                                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href = 'appointment_view?id=<?php echo $data['id'] ?>'" disabled>Record</button>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id; ?>">Cancel</button>
                                                                <?php
                                                                }
                                                                elseif ($data['status'] == 'COMPLETED') {
                                                            ?>
                                                                <button type="button" class="btn btn-primary btn-sm" onclick="window.open('reports/reports_treatment_record.php?patientid=<?= $data['patient'] ?>')" target="_blank">COMPLETED</button>
                                                            <?php
                                                            } elseif ($data['status'] == 'CANCELLED') {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancelled<?php echo $data['id'] ?>">CANCELLED</button>
                                                            <?php

                                                            } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    include('modals/app_cancel_modal.php');
                                                    include('modals/app_cancelled_modal.php');
                                                    include('modals/app_completed_modal.php');
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="20">
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
                            </div>
                            <ul class="pagination justify-content-end">
                                <?php
                                if (mysqli_num_rows($result) > 0) : ?>
                                    <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                    </li>
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                    </li>
                                    <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                    </li>
                                    <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?<?= isset($_GET['medicine']) ? 'medicine=' . $_GET['medicine'] . '&' : '', isset($_GET['batch']) ? 'batch=' . $_GET['batch'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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

    document.addEventListener('DOMContentLoaded', function() {
        let tabParam = '<?php echo isset($_GET['tab']) ? $_GET['tab'] : ''; ?>';
        if (tabParam) {
            document.querySelector('.nav-tabs a[href="#' + tabParam + '"]').classList.add('active');
            document.querySelector('.tab-pane#' + tabParam).classList.add('show', 'active');
        }
    });
</script>

</html>