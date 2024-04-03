<?php

session_start();
include('../../connection.php');
include('../../includes/doctor-auth.php');

$module = 'transaction_history';
$userid = $_SESSION['userid'];
$fullname = $_SESSION['name'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Check if the month filter is set
if (isset($_GET['account']) || isset($_GET['date_from']) || isset($_GET['date_to']) || isset($_GET['physician'])) {
    // Validate and sanitize input
    $account = isset($_GET['account']) ? $_GET['account'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $dt_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $dt_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

    $whereClause = ""; // Initialize the WHERE clause

    if ($account !== '') {
        $whereClause .= " (patient LIKE '%$account%' OR CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE '%$account%' OR CONCAT(firstname, ' ', lastname) LIKE '%$account%')";
    }
    if ($type !== '') {
        $whereClause .= " type = '$type'";
    }

    // Initialize the date filter
    $date = "";

    if ($dt_from == "" and $dt_to == "" and $type!="" and $account != "") {
        // No date range provided
        $date = "";
    } elseif ($dt_to == $dt_from and $type!="" and $account != "") {
        // Same start and end date
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND datetime LIKE '$fdate%'";
    } elseif ($dt_to == "" and $dt_from != "" and $type!="" and $account != "") {
        // Only start date provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND datetime >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "" and $type!="" and $account != "") {
        // Only end date provided
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " AND datetime <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to and $type!="" and $account != "") {
        // Start and end date range provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
    } 

    if ($dt_from == "" and $dt_to == "" and $type!="" and $account == "") {
        // No date range provided
        $date = "";
    } elseif ($dt_to == $dt_from and $type!="" and $account == "") {
        // Same start and end date
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND datetime LIKE '$fdate%'";
    } elseif ($dt_to == "" and $dt_from != "" and $type!="" and $account == "") {
        // Only start date provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND datetime >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "" and $type!="" and $account == "") {
        // Only end date provided
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " AND datetime <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to and $type!="" and $account == "") {
        // Start and end date range provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
    } 
    
    elseif ($dt_to == $dt_from && $type == "" && $account == "") {
        // Same start and end date
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " datetime LIKE '$fdate%'";
    } elseif ($dt_to == "" and $dt_from != "" && $type == "" && $account == "") {
        // Only start date provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " datetime >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "" && $type == "" && $account == "") {
        // Only end date provided
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " datetime <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to && $type == "" && $account == "") {
        // Start and end date range provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " datetime >= '$fdate' AND datetime <= '$ldate'";
    }

    elseif ($dt_to == $dt_from && $type == "" && $account != "") {
        // Same start and end date
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " datetime LIKE '$fdate%'";
    } elseif ($dt_to == "" and $dt_from != "" && $type == "" && $account != "") {
        // Only start date provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " datetime >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "" && $type == "" && $account != "") {
        // Only end date provided
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " datetime <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to && $type == "" && $account != "") {
        // Start and end date range provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " datetime >= '$fdate' AND datetime <= '$ldate'";
    }

    // Construct and execute SQL query for pending appointments count
    $sql_count = "SELECT COUNT(*) AS total_rows FROM transaction_history WHERE $whereClause $date ORDER BY datetime DESC";
} else {
    // If no filters are applied, count all rows in the database
    $sql_count = "SELECT COUNT(*) AS total_rows FROM transaction_history ORDER BY datetime DESC";
}

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
    <title>Medical Records</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL RECORDS</span>
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
            <?php include('../../includes/alert.php'); ?>
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addpatient">Add Record</button>
                    <?php include('modals/transaction_modal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="account" value="<?= isset($_GET['account']) == true ? $_GET['account'] : '' ?>" class="form-control" placeholder="Search patient">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="type" class="form-select">
                                                <option value="" disabled selected>-Select Transaction Type-</option>
                                                <option value="" <?= isset($_GET['type']) == true ? ($_GET['type'] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT type FROM transaction_history ORDER BY type";
                                                $result = mysqli_query($conn, $sql);
                                                foreach ($result as $row) {   ?>
                                                    <option value="<?php echo $row['type']; ?>" <?= isset($_GET['type']) == true ? ($_GET['type'] == $row['type'] ? 'selected' : '') : '' ?>><?php echo $row['type'] ?></option><?php } ?>
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
                                            <a href="transaction_history" class="btn btn-danger">Reset</a>
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
                                            <th>Type of Transaction</th>
                                            <th>Service</th>
                                            <th>Date and Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['account']) && $_GET['account'] != '') {
                                            $account = $_GET['account'];
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_history WHERE (patient LIKE '%$account%' OR CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE '%$account%' OR CONCAT(firstname, ' ', lastname) LIKE '%$account%') ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['type']) && $_GET['type'] != '' || isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                            $type = $_GET['type'];
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $count = 1;

                                            //date filter
                                            if ($dt_from == "" and $dt_to == "") {
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = "  datetime LIKE '$fdate%'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = "  datetime >= '$fdate'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = "  datetime <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = "  datetime >= '$fdate' AND datetime <= '$ldate'";
                                            }

                                            //type filter
                                            if ($type == "") {
                                                $tp = "";
                                            } elseif ($type != "" and $date == "") {
                                                $tp = " type = '$type'";
                                            } elseif ($date != "" and $type != "") {
                                                $tp = " AND type = '$type'";
                                            }

                                            $sql = "SELECT * FROM transaction_history WHERE $date $tp ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_history ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if ($row = mysqli_num_rows($result) > 0) {
                                        ?>
                                                <?php
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
                                                    $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));
                                                ?>
                                                    <tr>
                                                        <td><?= $data['id'] ?></td>
                                                        <td><?= $fullname ?></td>
                                                        <td><?= $data['transaction'] ?></td>
                                                        <td><?= $data['purpose'] ?></td>
                                                        <td><?= date("M. d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime'])) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($data['purpose'] == 'Dental' && $data['transaction'] == 'Consultation') { ?>
                                                                <button type="button" class="btn btn-primary btn-sm" onclick="window.open('reports/reports_treatment_record.php?patientid=<?= $data['patient'] ?>')" target="_blank">Expand</button>
                                                            <?php } elseif ($data['purpose'] == 'Medical History' || $data['transaction'] == 'Medical History') { ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewtrans<?php echo $data['id']; ?>">Expand</button>
                                                            <?php } else { ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewtrans<?php echo $data['id']; ?>">Expand</button>
                                                            <?php }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    if ($data['purpose'] == 'Medical History') {
                                                        include('modals/view_trans_medhist_modal.php');
                                                    } else {
                                                        include('modals/view_trans_modal.php');
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
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) : ?>
                                        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '' ?>
                                                <?= isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '' ?>
                                                <?= isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '' ?>
                                                <?= isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>
                                                page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '' ?>
                                                <?= isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '' ?>
                                                <?= isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '' ?>
                                                <?= isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>
                                                page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '' ?>
                                                <?= isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '' ?>
                                                <?= isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '' ?>
                                                <?= isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>
                                                page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '' ?>
                                                <?= isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '' ?>
                                                <?= isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '' ?>
                                                <?= isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>
                                                page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '' ?>
                                                <?= isset($_GET['type']) ? 'type=' . $_GET['type'] . '&' : '' ?>
                                                <?= isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '' ?>
                                                <?= isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>
                                                page=<?= $pages; ?>">&raquo;</a>
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