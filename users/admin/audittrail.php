<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'audittrail';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

if (!isset($_SESSION['username'])) {
    header('location:../../index');
}

// Check if the medicine, med_admin, or dosage form filter is set
if (isset($_GET['date_from']) || isset($_GET['date_to']) || isset($_GET['account']) || isset($_GET['campus']) || isset($_GET['usertype'])) {
    // Validate and sanitize input
    $account = isset($_GET['account']) ? $_GET['account'] : '';
    $campus = isset($_GET['campus']) ? $_GET['campus'] : '';
    $usertype = isset($_GET['usertype']) ? $_GET['usertype'] : '';
    $dt_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
    $dt_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

    // Initialize the WHERE clause
    $whereClause = "WHERE"; // Start with a default condition that is always true

    if ($dt_from == "" and $dt_to == "") {
        // No date range provided
        $whereClause .= "";
    } elseif ($dt_to == $dt_from) {
        // Same start and end date
        $fdate = date("Y-m-d", strtotime($dt_from));
        $whereClause .= " datetime LIKE '$fdate%'";
    } elseif ($dt_to == "" and $dt_from != "") {
        // Only start date provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $whereClause .= " datetime >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "") {
        // Only end date provided
        $d = date("Y-m-d", strtotime($dt_to));
        $whereClause .= " datetime <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
        // Start and end date range provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $whereClause .= " datetime >= '$fdate' AND datetime <= '$ldate'";
    }
    
    if ($account !== '' AND ($dt_from != "" OR $dt_to != "")) {
        $account = strtoupper($account);
        $whereClause .= " AND (CONCAT(ac.firstname, ' ', ac.middlename, ' ' , ac.lastname) LIKE '%$account%' OR CONCAT(ac.firstname, ' ' , ac.lastname) LIKE '%$account%' OR ac.accountid LIKE '%$account%')";
    }elseif ($account !== '' AND $dt_from == "" AND $dt_to == "") {
        $account = strtoupper($account);
        $whereClause .= " (CONCAT(ac.firstname, ' ', ac.middlename, ' ' , ac.lastname) LIKE '%$account%' OR CONCAT(ac.firstname, ' ' , ac.lastname) LIKE '%$account%' OR ac.accountid LIKE '%$account%')";
    }

    if ($campus !== '' AND ($account !== '' OR $dt_from != "" OR $dt_to != "")) {
        $whereClause .= " AND ac.campus = '$campus'";
    } elseif ($campus !== '' AND $account == '' AND $dt_from == "" AND $dt_to == "") {
        $whereClause .= " ac.campus = '$campus'";
    } 
    if ($usertype !== '' AND ($campus !== '' OR $account !== '' OR $dt_from != "" OR $dt_to != "")) {
        $whereClause .= " AND ac.usertype = '$usertype'";
    } elseif ($usertype !== '' AND $campus == '' AND $account == '' AND $dt_from == "" AND $dt_to == "") {
        $whereClause .= " ac.usertype = '$usertype'";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user $whereClause";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user ORDER BY id DESC";
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
    <title>Audit Trail</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">AUDIT TRAIL</span>
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
                <div class="schedule-button">
                    <form action="reports/reports_audit_trail" method="post" id="exportPdfForm" target="_blank">
                        <!-- Hidden input fields to store filter values -->
                        <input type="text" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>" name="date_from" id="date_from" hidden>
                        <input type="text" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>" name="date_to" id="date_to" hidden>
                        <input type="hidden" value="<?= isset($_GET['usertype']) == true ? $_GET['usertype'] : '' ?>" name="usertype" id="usertype">
                        <input type="hidden" value="<?= isset($_GET['campus']) == true ? $_GET['campus'] : '' ?>" name="campus" id="campus">
                        <input type="hidden" value="<?= isset($_GET['status']) == true ? $_GET['status'] : '' ?>" name="status" id="status">
                        <input type="hidden" value="<?= isset($_GET['account']) == true ? $_GET['account'] : '' ?>" name="account" id="account">

                        <!-- Export PDF button -->
                        <button type="submit" class="btn btn-primary" name="export_pdf">Export PDF</button>
                    </form>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="GET"  id="filterForm">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="input-group mb-2">
                                                <input type="text" name="account" value="<?= isset($_GET['account']) == true ? $_GET['account'] : '' ?>" class="form-control" placeholder="Search user account">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="campus" class="form-select">
                                                <option value="" disabled selected>-Select Campus-</option>
                                                <option value="<?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>">NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM campus ORDER BY campus";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $campus = $row["campus"]; ?>
                                                        <option value="<?php echo $row["campus"]; ?>" <?= isset($_GET['campus']) == true ? ($_GET['campus'] == $row["campus"] ? 'selected' : '') : '' ?>><?php echo $row["campus"]; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-1 mb-2">
                                            <select name="usertype" class="form-select">
                                                <option value="" disabled selected>-Usertype-</option>
                                                <option value="<?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>">NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT usertype FROM account ORDER BY usertype";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $usertype = $row["usertype"]; ?>
                                                        <option value="<?php echo $row["usertype"]; ?>" <?= isset($_GET['usertype']) == true ? ($_GET['usertype'] == $row["usertype"] ? 'selected' : '') : '' ?>><?php echo $row["usertype"]; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="date_from" id="from" placeholder="Date From" class="form-control" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="date_to" id="to" placeholder="Date To" class="form-control" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>">
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="audittrail" class="btn btn-danger">Reset</a>
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
                                            <th>Campus</th>
                                            <th>Usertype</th>
                                            <th>Activity</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['account']) && $_GET['account'] != '') {
                                            $account = strtoupper($_GET['account']);
                                            $sql = "SELECT au.id, au.user, au.fullname, au.activity, au.datetime, ac.usertype, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user WHERE (CONCAT(ac.firstname, ' ', ac.middlename, ' ' , ac.lastname) LIKE '%$account%' OR CONCAT(ac.firstname, ' ' , ac.lastname) LIKE '%$account%' OR ac.accountid LIKE '%$account%') ORDER BY id DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['campus']) && $_GET['campus'] != '' || isset($_GET['status']) && $_GET['status'] != '' || isset($_GET['usertype']) && $_GET['usertype'] != '' || isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $campus = isset($_GET['campus']) ? $_GET['campus'] : '';
                                            $usertype = isset($_GET['usertype']) ? $_GET['usertype'] : '';
                                            $count = 1;

                                            // Initialize the date filter
                                            $date = "";

                                            if ($dt_from == "" and $dt_to == "") {
                                                // No date range provided
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                // Same start and end date
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " datetime LIKE '$fdate%'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                // Only start date provided
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " datetime >= '$fdate'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                // Only end date provided
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = " datetime <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                // Start and end date range provided
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to . "+1 day"));
                                                $date = " datetime >= '$fdate' AND datetime <= '$ldate'";
                                            }
                                            //campus filter
                                            if ($campus != "" AND ($dt_to != "" OR $dt_from != "")) {
                                                $date .= " AND ac.campus = '$campus'";
                                            } elseif ($campus != "" AND $dt_to == "" AND $dt_from == "") {
                                                $date .= " ac.campus = '$campus'";
                                            }

                                            //usertype filter
                                            if ($usertype != "" AND ($campus !="" OR $dt_to != "" OR $dt_from != "")){
                                                $date .= " AND ac.usertype = '$usertype'";
                                            }elseif ($usertype != "" AND $campus =="" AND $dt_to == "" AND $dt_from == ""){
                                                $date .= " ac.usertype = '$usertype'";
                                            }

                                            $sql = "SELECT au.id, au.user, au.fullname, au.activity, au.datetime, ac.usertype, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user WHERE $date ORDER BY id DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT au.id, au.user, au.fullname, au.activity, au.datetime, ac.usertype, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user ORDER BY id DESC LIMIT $start, $rows_per_page";
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
                                                    if($row['fullname'] != 'SYSTEM ALERT'){
                                                        $act = ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname'])) . " " . lcfirst($row['activity']);
                                                    }
                                                    else{
                                                        $act = "SYSTEM ALERT : " . $row['activity'];
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $row['id'] ?></td>
                                                        <td><?php echo $row['campus'] ?></td>
                                                        <td><?php echo $row['usertype'] ?></td>
                                                        <td><?php echo $act ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($row['datetime'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($row['datetime'] . "+ 8 hours")); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <td colspan="5">
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
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['usertype']) ? 'usertype=' . $_GET['usertype'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['usertype']) ? 'usertype=' . $_GET['usertype'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['usertype']) ? 'usertype=' . $_GET['usertype'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['usertype']) ? 'usertype=' . $_GET['usertype'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['account']) ? 'account=' . $_GET['account'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['usertype']) ? 'usertype=' . $_GET['usertype'] . '&' : '', isset($_GET['date_from']) ? 'date_from=' . $_GET['date_from'] . '&' : '', isset($_GET['date_to']) ? 'date_to=' . $_GET['date_to'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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

<script>
    function updateExportPdfForm() {
        var dateFromInput = document.querySelector("input[name='date_from']");
        var dateToInput = document.querySelector("input[name='date_to']");
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
</script>

</html>