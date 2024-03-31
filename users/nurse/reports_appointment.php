<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'reports_appointment';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];


// Check if the supply or batch filter is set
if (isset($_GET['physician']) || isset($_GET['status']) || isset($_GET['date_from']) || isset($_GET['date_to'])) {
    // Validate and sanitize input
    $physician = isset($_GET['physician']) ? $_GET['physician'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

    // Initialize the WHERE clause
    $whereClause = " campus = '$campus'"; // Start with common conditions

    // Add conditions based on filters
    if ($physician !== '') {
        $whereClause .= " AND ap.physician = '$physician'"; // Add physician filter
    }
    if ($status !== '') {
        $whereClause .= " AND ap.status = '$status'"; // Add status filter
    }
    if ($date_from !== '') {
        $date_from = date("Y-m-d", strtotime($date_from));
        $whereClause .= " AND ap.date >= '$date_from'"; // Add date from filter
    }
    if ($date_to !== '') {
        $date_to = date("Y-m-d", strtotime($date_to));
        $whereClause .= " AND ap.date <= '$date_to'"; // Add date to filter
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM appointment ap 
                  INNER JOIN account ac ON ac.accountid = ap.patient 
                  INNER JOIN appointment_type t ON t.id = ap.type 
                  INNER JOIN appointment_purpose p ON p.id = ap.purpose 
                  WHERE $whereClause";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM appointment ap 
                  INNER JOIN account ac ON ac.accountid = ap.patient 
                  INNER JOIN appointment_type t ON t.id = ap.type 
                  INNER JOIN appointment_purpose p ON p.id = ap.purpose 
                  WHERE campus = '$campus'";
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
                <span class="dashboard">APPOINTMENT REPORT</span>
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
                    <form action="reports/reports_appointment" method="post" id="exportPdfForm" target="_blank">
                        <!-- Hidden input fields to store filter values -->
                        <input type="hidden" value="<?= isset($_GET['physician']) == true ? $_GET['physician'] : '' ?>" name="physician" id="physician">
                        <input type="hidden" value="<?= isset($_GET['status']) == true ? $_GET['status'] : '' ?>" name="status" id="status">
                        <input type="hidden" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>" name="date_from" id="date_from">
                        <input type="hidden" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>" name="date_to" id="date_to">

                        <!-- Export PDF button -->
                        <button type="submit" class="btn btn-primary" name="export_pdf">Export PDF</button>
                    </form>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="reports_filter.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="reports" class="form-select">
                                                <option value="" disabled>Select Report</option>
                                                <option value="appointment" selected>Appointment Report</option>
                                                <option value="docvisit">Doctor's Visit Schedule Report</option>
                                                <option value="transaction">Transaction Report</option>
                                                <option value="medcase">Medical Cases</option>
                                                <option value="medinv">Medicine Consumption Report</option>
                                                <option value="supinv">Medical Supply Consumption Report</option>
                                                <option value="teinv">Tools and Equipment Inventory Report</option>
                                                <option value="tecalimain">Tools and Equipment Calibration and Maintenance Report</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">View</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <form action="" method="GET" id="filterForm">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <select name="physician" class="form-select">
                                                <option value="" selected disabled>-Select Physician-</option>
                                                <?php
                                                $sql = "SELECT DISTINCT physician FROM appointment ORDER BY physician";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row['physician']; ?>" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == $row['physician'] ? 'selected' : '') : '' ?>><?php echo $row['physician']; ?></option><?php }
                                                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="status" class="form-select">
                                                <option value="" selected disabled>-Select Status-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT status FROM appointment ORDER BY status";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {  ?>
                                                        <option value="<?php echo $row['status']; ?>" <?= isset($_GET['status']) == true ? ($_GET['status'] == $row['status'] ? 'selected' : '') : '' ?>><?php echo strtoupper($row['status']); ?></option><?php }
                                                                                                                                                                                                                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="date_from" id="from" placeholder="Date From" class="form-control" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="date_to" id="to" placeholder="Date To" class="form-control" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_appointment" class="btn btn-danger">Reset</a>
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
                                            <th>Physician</th>
                                            <th>Patient</th>
                                            <th>Type and Purpose</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '' || isset($_GET['physician']) && $_GET['physician'] != '' || isset($_GET['status']) && $_GET['status'] != '') {
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $pod = isset($_GET['physician']) ? $_GET['physician'] : "";
                                            $status = isset($_GET['status']) ? $_GET['status'] : "";

                                            //campus filter
                                            if ($campus == "") {
                                                $ca = "";
                                            } else {
                                                $ca = " WHERE ac.campus = '$campus'";
                                            }

                                            //date filter
                                            if ($dt_from == "" and $dt_to == "") {
                                                $date = "";
                                            } elseif ($ca == "" and $dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
                                            } elseif ($ca != "" and $dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                            } elseif ($ca == "" and $dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND date >= '$fdate'";
                                            } elseif ($ca != "" and $dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND date >= '$fdate'";
                                            } elseif ($ca == "" and $dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = " WHERE date <= '$d'";
                                            } elseif ($ca != "" and $dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND date <= '$d'";
                                            } elseif ($ca == "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
                                            } elseif ($ca != "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND date >= '$fdate' AND date <= '$ldate'";
                                            }

                                            //physician filter
                                            if ($pod == "") {
                                                $doc = "";
                                            } else {
                                                $doc = " AND ap.physician = '$pod'";
                                            }

                                            //status filter
                                            if ($status == "") {
                                                $st = "";
                                            } else {
                                                $st = " AND ap.status = '$status'";
                                            }

                                            $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.patient, ap.type, ap.status, ap.purpose, ac.campus, ac.firstname, ac.middlename, ac.lastname, t.type, p.purpose FROM appointment ap INNER JOIN account ac ON ac.accountid=ap.patient INNER JOIN appointment_type t ON t.id=ap.type INNER JOIN appointment_purpose p ON p.id=ap.purpose $ca $date $doc $st ORDER BY ap.date DESC, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.patient, ap.type, ap.status, ap.purpose, ac.campus, ac.firstname, ac.middlename, ac.lastname, t.type, p.purpose FROM appointment ap INNER JOIN account ac ON ac.accountid=ap.patient INNER JOIN appointment_type t ON t.id=ap.type INNER JOIN appointment_purpose p ON p.id=ap.purpose WHERE campus = '$campus' ORDER BY ap.date DESC, ap.time_from, ap.time_to LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $row) {
                                                    if (count(explode(" ", $row['middlename'])) > 1) {
                                                        $middle = explode(" ", $row['middlename']);
                                                        $letter = $middle[0][0] . $middle[1][0];
                                                        $middleinitial = $letter . ".";
                                                    } else {
                                                        $middle = $row['middlename'];
                                                        if ($middle == "" or $middle == " ") {
                                                            $middleinitial = "";
                                                        } else {
                                                            $middleinitial = substr($middle, 0, 1) . ".";
                                                        }
                                                    }
                                                    if ($row['physician'] == NULL) {
                                                        $physician = "NONE";
                                                    } else {
                                                        $physician = $row['physician'];
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $row['id'] ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($row['date'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($row['time_from'])) . " - " . date("g:i A", strtotime($row['time_to'])) ?></td>
                                                        <td><?php echo $physician ?></td>
                                                        <td><?php echo ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname'])) ?></td>
                                                        <td><?php echo $row['type'] . " - " . $row['purpose'] ?></td>
                                                        <td><?php echo strtoupper($row['status']) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <td colspan="7">
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
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['physician']) ? 'physician=' . $_GET['physician'] . '&' : '', isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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
        var physicianSelect = document.querySelector("input[name='physician']");
        var statusSelect = document.querySelector("input[name='status']");
        var dateFromInput = document.querySelector("input[name='date_from']");
        var dateToInput = document.querySelector("input[name='date_to']");

        document.getElementById("physician").value = physicianSelect.options[physicianSelect.selectedIndex].value;
        document.getElementById("status").value = statusSelect.options[statusSelect.selectedIndex].value;
        document.getElementById("date_from").value = dateFromInput.value;
        document.getElementById("date_to").value = dateToInput.value;
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

    $(function() {
        var dateFormat = "mm/dd/yy",
            from = $("#from")
            .datepicker({
                defaultDate: "+1w",
                changeMonth: true,
            })
            .on("change", function() {
                to.datepicker("option", "minDate", getDate(this));
            }),
            to = $("#to").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
            })
            .on("change", function() {
                from.datepicker("option", "maxDate", getDate(this));
            });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }
    });
</script>

</html>