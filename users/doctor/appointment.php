<?php

session_start();
include('../../connection.php');
include('../../includes/doctor-auth.php');

$module = 'appointment';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$fullname = $_SESSION['name'];
$usertype = $_SESSION['usertype'];
$today = date("Y-m-d");

// Check if the month filter is set
if (isset($_GET['patient']) || isset($_GET['date'])) {
    // Validate and sanitize input
    $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
    $date = isset($_GET['date']) ? $_GET['date'] : '';

    // Construct WHERE clause based on filters
    $whereClause = "";
    if ($patient !== '') {
        $whereClause .= " AND (CONCAT(ac.firstname, ' ', ac.middlename, ' ', ac.lastname) LIKE '%$patient%' or CONCAT(ac.firstname, ' ', ac.lastname) LIKE '%$patient%')";
    }
    if ($date !== '') {
        $whereClause .= " AND ap.date = '$date'";
    }
    // Construct and execute SQL query for approved appointments count
    $approved_sql_count = "SELECT COUNT(*) AS total_rows 
                       FROM appointment ap 
                       INNER JOIN account ac ON ac.accountid = ap.patient
                       WHERE physician='$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') $whereClause";
} else {
    // Count all approved appointments
    $approved_sql_count = "SELECT COUNT(*) AS total_rows 
                           FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient 
                           INNER JOIN appointment_purpose p ON p.id=ap.purpose 
                           INNER JOIN appointment_type t ON t.id=p.type 
                           WHERE (ap.status='APPROVED' OR ap.status='COMPLETED') 
                           AND physician='$fullname' AND date >= '$today' ORDER BY ap.status 
                           DESC, ap.date, ap.time_from, ap.time_to";
}

// Execute the count queries for pending and approved appointments
$approved_count_result = $conn->query($approved_sql_count);

// Check if count queries were successful
if ($approved_count_result) {
    // Fetch the total number of rows for approved appointments
    $approved_count_row = $approved_count_result->fetch_assoc();
    $approved_nr_of_rows = $approved_count_row['total_rows'];
} else {
    // Handle count query error
    echo "Error: " . $conn->error;
}

// Setting the number of rows to display in a page.
$rows_per_page = 12;

// Determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from value.
$start = ($page - 1) * $rows_per_page;

$approved_pages = ceil($approved_nr_of_rows / $rows_per_page);

// Calculate the range of page numbers to be displayed for approved appointments
$approved_start_loop = max(1, $page - 2);
$approved_end_loop = min($approved_pages, $page + 2);

// Adjust the range if the current page is near the beginning or end for approved appointments
if ($approved_start_loop > 1) {
    $approved_start_loop--;
    $approved_end_loop++;
}

// Ensure that the range is never smaller than 4 for approved appointments
if ($approved_end_loop - $approved_start_loop < 4) {
    $approved_start_loop = max(1, $approved_end_loop - 4);
}

$approved_previous = $page - 1;
$approved_next = $page + 1;

// Calculate the start and end loop variables for approved appointments
$approved_start_loop = $page > 2 ? $page - 2 : 1;
$approved_end_loop = $page < $approved_pages - 2 ? $page + 2 : $approved_pages;

// Limit the number of pages displayed to a maximum of 4 for approved appointments
if ($approved_pages > 4) {
    if ($page > 2 && $page < $approved_pages - 1) {
        $approved_end_loop = $page + 1;
    } elseif ($page == 1) {
        $approved_start_loop = 1;
        $approved_end_loop = 4;
    } elseif ($page == $approved_pages) {
        $approved_start_loop = $approved_pages - 3;
        $approved_end_loop = $approved_pages;
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
                                    <input type="hidden" name="tab" value="approved">
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
                                            <a href="appointment?tab=approved" class="btn btn-danger">Reset</a>
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
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Type</th>
                                            <th>Request</th>
                                            <th>Patient</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                            $patient = $_GET['patient'];
                                            $count = 1;
                                            $sql = "SELECT ap.id, ap.date, ap.reason ap.patient, t.type, p.purpose, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND (ap.status='APPROVED' OR ap.status='COMPLETED') AND physician='$fullname' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['date']) && $_GET['date'] != '') {
                                            $date = $_GET['date'];
                                            $count = 1;
                                            $sql = "SELECT ap.id, ap.date, ap.reason, ap.patient, t.type, p.purpose, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE ap.date = '$date' AND physician='$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $today = date("Y-m-d");
                                            $sql = "SELECT ap.id, ap.date, ap.reason, ap.patient, t.type, p.purpose, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient INNER JOIN appointment_purpose p ON p.id=ap.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE (ap.status='APPROVED' OR ap.status='COMPLETED') AND physician='$fullname' AND date = '$today' ORDER BY ap.status DESC, ap.date, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
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
                                                        <td><?php echo date("g:i A", strtotime($data['time_from'])) . " - " .  date("g:i A", strtotime($data['time_to'])) ?></td>
                                                        <td><?php echo $data['type']; ?></td>
                                                        <td><?php echo $data['purpose']; ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($data['status'] == 'CANCELLED') {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancelled<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                                <?php
                                                            } elseif ($data['status'] == 'APPROVED') {
                                                                if ($data['date'] == $today) { ?>
                                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#recordppointment<?php echo $data['id'] ?>">Record</button>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id ?>">Cancel</button>
                                                                <?php } else { ?>
                                                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#recordppointment<?php echo $data['id'] ?>" disabled>Record</button>
                                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_cancel<?= $id ?>">Cancel</button>
                                                                <?php }
                                                            } elseif ($data['status'] == 'COMPLETED') {
                                                                ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#app_completed<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php } elseif ($data['status'] == 'DISMISSED') {
                                                            ?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#app_dismissed<?php echo $data['id'] ?>">
                                                                    <?php echo $data['status']; ?>
                                                                </button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    if ($data['status'] == 'CANCELLED') {
                                                        include('modals/app_cancelled_modal.php');
                                                    } elseif ($data['status'] == 'APPROVED') {
                                                        if ($data['type'] == "Request for Medicine" || $data['purpose'] == "Request for Medicine" || $data['type'] == "Request for Medical Supply" || $data['purpose'] == "Request for Medical Supply") {
                                                            include('modals/app_record_medsup_modal.php');
                                                            include('modals/app_cancel_modal.php');
                                                        } else {
                                                            include('modals/app_record_trans_modal.php');
                                                            include('modals/app_cancel_modal.php');
                                                        }
                                                    } elseif ($data['status'] == 'COMPLETED') {
                                                        include('modals/app_completed_modal.php');
                                                    } elseif ($data['status'] == 'DISMISSED') {
                                                        include('modals/app_dismissed_modal.php');
                                                    }
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
                                            ?>

                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                            ?>
                                <ul class="pagination justify-content-end">
                                    <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                    </li>
                                    <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $approved_previous; ?>">&lt;</a>
                                    </li>
                                    <?php for ($i = $approved_start_loop; $i <= $approved_end_loop; $i++) : ?>
                                        <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                            <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $page == $approved_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $approved_next; ?>">&gt;</a>
                                    </li>
                                    <li class="page-item <?php echo $page == $approved_pages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="appointment?tab=approved&<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '', isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '' ?>page=<?= $approved_pages; ?>">&raquo;</a>
                                    </li>
                                </ul>
                            <?php
                            }
                            ?>
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