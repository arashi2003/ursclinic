<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'reports_transaction';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

$now = date("Y-m-t");

// Check if the supply or batch filter is set
if (isset($_GET['patient']) || isset($_GET['designation']) || isset($_GET['transaction']) || isset($_GET['type']) || isset($_GET['purpose']) || isset($_GET['date_from']) || isset($_GET['date_to'])) {
    // Validate and sanitize input
    $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
    $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $purpose = isset($_GET['purpose']) ? $_GET['purpose'] : '';
    $transaction = isset($_GET['transaction']) ? $_GET['transaction'] : '';
    $designation = isset($_GET['designation']) ? $_GET['designation'] : '';

    $whereClause = " campus = '$campus'"; // Start with common conditions

    if ($patient != "") {
        $whereClause .= " AND (CONCAT(firstname,' ', lastname) LIKE '%$patient%' OR CONCAT(firstname, ' ', middlename,' ', lastname) LIKE '%$patient%' OR patient LIKE '%$patient%')";
    }
    if ($type !== '') {
        $whereClause .= " AND type = '$type'";
    }
    if ($purpose !== '') {
        $whereClause .= " AND purpose = '$purpose'";
    }
    if ($transaction !== '') {
        $whereClause .= " AND transaction = '$transaction'"; // Add physician filter
    }
    if ($designation !== '') {
        $whereClause .= " AND designation = '$designation'"; // Add physician filter
    }
    
    if ($date_from !== '') {
        $date_from = date("Y-m-d", strtotime($date_from));
        $whereClause .= " AND datetime >= '$date_from'"; // Add date from filter
    }
    if ($date_to !== '') {
        $date_to = date("Y-m-d", strtotime($date_to));
        $whereClause .= " AND datetime <= '$date_to'"; // Add date to filter
    }

    // Construct and execute SQL query for counting total rows for transaction_history
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM transaction_history 
                  WHERE $whereClause";
} else {
    // If filters are not set, count all rows for transaction_history
    $sql_count = "SELECT COUNT(*) AS total_rows 
                  FROM transaction_history 
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

<body id="<?= $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">
                    <H1>TRANSACTION REPORT</H1>
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
                    <form action="reports/reports_trans" method="post" id="exportPdfForm" target="_blank">
                        <!-- Hidden input fields to store filter values -->
                        <input type="hidden" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" name="patient" id="patient">
                        <input type="hidden" value="<?= isset($_GET['designation']) == true ? $_GET['designation'] : '' ?>" name="designation" id="designation">
                        <input type="hidden" value="<?= isset($_GET['type']) == true ? $_GET['type'] : '' ?>" name="type" id="type">
                        <input type="hidden" value="<?= isset($_GET['purpose']) == true ? $_GET['purpose'] : '' ?>" name="purpose" id="purpose">
                        <input type="hidden" value="<?= isset($_GET['transaction']) == true ? $_GET['transaction'] : '' ?>" name="transaction" id="transaction">
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
                                                <option value="transaction" selected>Transaction Report</option>
                                                <option value="teinv">Tools and Equipment Inventory Report</option>
                                                <option value="tecalimain">Tools and Equipment Calibration and Maintenance Report</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <form action="" method="GET" id="filterForm">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="designation" class="form-select">
                                                <option value="" selected disabled>-Select Designation-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT designation FROM patient_info ORDER BY designation";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {  ?>
                                                        <option value="<?php echo $row['designation']; ?>" <?= isset($_GET['designation']) == true ? ($_GET['designation'] == $row['designation'] ? 'selected' : '') : '' ?>><?php echo strtoupper($row['designation']); ?></option><?php }
                                                                                                                                                                                                                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="type" class="form-select">
                                                <option value="" disabled selected>-Select Type-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <option value="Appointment" <?= isset($_GET['type']) == true ? ($_GET['type'] == 'Appointment' ? 'selected' : '') : '' ?>>Appointment</option>
                                                <option value="Walk-In" <?= isset($_GET['type']) == true ? ($_GET['type'] == 'Walk-In' ? 'selected' : '') : '' ?>>Walk-In</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="transaction" class="form-select">
                                                <option value="" selected>-Select Transaction-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT transaction FROM transaction_history ORDER BY transaction";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row['transaction']; ?>" <?= isset($_GET['transaction']) == true ? ($_GET['transaction'] == $row['transaction'] ? 'selected' : '') : '' ?>><?php echo $row['transaction']; ?></option><?php }
                                                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="purpose" class="form-select">
                                                <option value="" selected>-Select Request For-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT purpose FROM transaction_history ORDER BY purpose";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row['purpose']; ?>" <?= isset($_GET['purpose']) == true ? ($_GET['purpose'] == $row['purpose'] ? 'selected' : '') : '' ?>><?php echo $row['purpose']; ?></option><?php }
                                                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="date_from" id="from" placeholder="Date From" class="form-control" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="date_to" id="to" placeholder="Date To" class="form-control" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>">
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="reports_trans" class="btn btn-danger">Reset</a>
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
                                            <th>Patient</th>
                                            <th>Physician/Nurse On Duty</th>
                                            <th>Transaction</th>
                                            <th>Date and Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                            $patient = $_GET['patient'];
                                            $sql = "SELECT id, patient, firstname, middlename, lastname, designation, age, sex, department, college, program, birthday, yearlevel, section,type, transaction, purpose, height,weight, bp, pr, temp, heent, chest_lungs,heart, abdomen, extremities, bronchial_asthma, surgery, lmp, heart_disease, allergies, epilepsy, hernia,respiratory, oxygen_saturation, chief_complaint, findiag,remarks, medsup, pod_nod, medcase, medcase_others, datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial FROM transaction_history WHERE (CONCAT(firstname,' ', lastname) LIKE '%$patient%' OR CONCAT(firstname, ' ', middlename,' ', lastname) LIKE '%$patient%' OR patient LIKE '%$patient%') AND  campus = '$campus' ORDER BY datetime DESC  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['designation']) && $_GET['designation'] != '' || isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '' || isset($_GET['type']) && $_GET['type'] != '' || isset($_GET['purpose']) && $_GET['purpose'] != '' || isset($_GET['transaction']) && $_GET['transaction'] != '') {
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $transaction = isset($_GET['transaction']) ? $_GET['transaction'] : "";
                                            $purpose = isset($_GET['purpose']) ? $_GET['purpose'] : "";
                                            $type = isset($_GET['type']) ? $_GET['type'] : "";
                                            $designation = isset($_GET['designation']) ? $_GET['designation'] : "";
                                            $count = 1;

                                            //campus filter
                                            if ($campus == "") {
                                                $ca = "";
                                            } else {
                                                $ca = " WHERE campus = '$campus'";
                                            }

                                            //date filter

                                            if ($dt_from == "" and $dt_to == "") {
                                                // No date range provided
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                // Same start and end date
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND datetime LIKE '$fdate%'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                // Only start date provided
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND datetime >= '$fdate'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                // Only end date provided
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND datetime <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                // Start and end date range provided
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
                                            }

                                            
                                            //type filter
                                            if ($type == "") {
                                                $ty = "";
                                            } else {
                                                $ty = " AND type = '$type'";
                                            }

                                            //purpose filter
                                            if ($purpose == "") {
                                                $purp = "";
                                            } else {
                                                $purp = " AND purpose = '$purpose'";
                                            }
                                            
                                            //transaction filter
                                            if ($transaction == "") {
                                                $tra = "";
                                            } else {
                                                $tra = " AND transaction = '$transaction'";
                                            }
                                            
                                            //designation filter
                                            if ($designation == "") {
                                                $des = "";
                                            } else {
                                                $des = " AND designation = '$designation'";
                                            }

                                            $sql = "SELECT id, patient, firstname, middlename, lastname, designation, age, sex, department, college, program, birthday, yearlevel, section,type, transaction, purpose, height,weight, bp, pr, temp, heent, chest_lungs,heart, abdomen, extremities, bronchial_asthma, surgery, lmp, heart_disease, allergies, epilepsy, hernia,respiratory, oxygen_saturation, chief_complaint, findiag,remarks, medsup, pod_nod, medcase, medcase_others, datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial FROM transaction_history $ca $date $ty $purp $tra $des ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $now = date("Y-m-t");
                                            $sql = "SELECT id, patient, firstname, middlename, lastname, designation, age, sex, department, college, program, birthday, yearlevel, section,type, transaction, purpose, height,weight, bp, pr, temp, heent, chest_lungs,heart, abdomen, extremities, bronchial_asthma, surgery, lmp, heart_disease, allergies, epilepsy, hernia,respiratory, oxygen_saturation, chief_complaint, findiag,remarks, medsup, pod_nod, medcase, medcase_others, datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial FROM transaction_history WHERE campus = '$campus' ORDER BY datetime DESC LIMIT $start, $rows_per_page";
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
                                        ?>
                                                    <tr>
                                                        <td><?= $row['id'] ?></td>
                                                        <td><?= ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($row['lastname'])) ?></td>
                                                        <td><?= $row['pod_nod'] ?></td>
                                                        <td><?= $row['transaction'] . " - " . $row['purpose'] ?></td>
                                                        <td><?= date("M d, Y", strtotime($row['datetime'])) . " " . date("g:i A", strtotime($row['datetime'] . "+ 8 hours")); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <td colspan="5">
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
                                            <a class="page-link" href="?<?= isset($_GET['designation']) ? 'designation=' . $_GET['designation'] . '&' : '',isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['transaction']) ? 'transaction=' . $_GET['transaction'] . '&' : '', isset($_GET['purpose']) ? 'purpose=' . $_GET['purpose'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['designation']) ? 'designation=' . $_GET['designation'] . '&' : '',isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['transaction']) ? 'transaction=' . $_GET['transaction'] . '&' : '', isset($_GET['purpose']) ? 'purpose=' . $_GET['purpose'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['designation']) ? 'designation=' . $_GET['designation'] . '&' : '',isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['transaction']) ? 'transaction=' . $_GET['transaction'] . '&' : '', isset($_GET['purpose']) ? 'purpose=' . $_GET['purpose'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['designation']) ? 'designation=' . $_GET['designation'] . '&' : '',isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['transaction']) ? 'transaction=' . $_GET['transaction'] . '&' : '', isset($_GET['purpose']) ? 'purpose=' . $_GET['purpose'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['designation']) ? 'designation=' . $_GET['designation'] . '&' : '',isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '', isset($_GET['transaction']) ? 'transaction=' . $_GET['transaction'] . '&' : '', isset($_GET['purpose']) ? 'purpose=' . $_GET['purpose'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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
        //var physicianSelect = document.querySelector("input[name='physician']");
        var dateFromInput = document.querySelector("input[name='date_from']");
        var dateToInput = document.querySelector("input[name='date_to']");

        //document.getElementById("physician").value = physicianSelect.options[physicianSelect.selectedIndex].value;
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

<script>
    document.getElementById('reportSelect').addEventListener('change', function() {
        document.getElementById('reportForm').submit();
    });
</script>

</html>