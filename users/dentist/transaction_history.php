<?php

session_start();
include('../../connection.php');
include('../../includes/dentist-auth.php');

$module = 'transaction_history';
$userid = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM transaction_history WHERE transaction = 'Consultation' OR purpose = 'Dental'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Transaction</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">TRANSACTION HISTORY</span>
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
            <div class="overview-boxes">
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
                                        <div class="col-md-2">
                                            <input type="date" name="date_from" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="date" name="date_to" class="form-control">
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
                                            <th>Campus</th>
                                            <th>Patient</th>
                                            <th>Designation</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['account']) && $_GET['account'] != '') {
                                            $account = $_GET['account'];
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_history INNER JOIN account ON account.accountid=transaction_history.patient WHERE (patientid LIKE '%$account%' OR CONCAT(firstname, ' ', middlename, ' ', lastname) LIKE '%$account%' OR CONCAT(firstname, ' ', lastname) LIKE '%$account%') AND (transaction = 'Consultation' OR purpose = 'Dental') GROUP BY patient ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $count = 1;

                                            //date filter
                                            if ($dt_from == "" and $dt_to == "") {
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = "WHERE date >= '$fdate' AND date <= '$ldate'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = "WHERE date >= '$fdate'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = "WHERE date >= '$fdate'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = "WHERE date <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = "WHERE date >= '$fdate' AND date <= '$ldate'";
                                            }

                                            $sql = "SELECT * FROM transaction_history INNER JOIN account ON account.accountid=transaction_history.patient $date AND (transaction = 'Consultation' OR purpose = 'Dental') GROUP BY patient ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_history INNER JOIN account ON account.accountid=transaction_history.patient WHERE transaction = 'Consultation' OR purpose = 'Dental' GROUP BY patient ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if ($row = mysqli_num_rows($result) > 0) {
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
                                                    $patientid = $data['patient'];
                                                    $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));

                                                    $sql = "SELECT date FROM treatment_record WHERE patientid='$patientid'";
                                                    $result = mysqli_query($conn, $sql);
                                                    foreach ($result as $row) {
                                                        $datelatest = $row['date'];
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?= $data['campus'] ?></td>
                                                        <td><?= $fullname ?></td>
                                                        <td><?= $data['designation'] ?></td>
                                                        <td><?= date("F d, Y", strtotime($datelatest)) ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" onclick="window.open('reports/reports_treatment_record.php?patientid=<?= $patientid ?>')" target="_blank">View</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="5">No record Found</td>
                                                </tr>
                                            <?php } ?>
                                    </tbody>
                                </table>
                            <?php
                                        } else {
                            ?>
                                <tr>
                                    <td colspan="5">No record Found</td>
                                </tr>
                            <?php
                                        }
                                        mysqli_close($conn);
                            ?>
                            </div>
                        </div>
                        <?php include('../../includes/pagination.php'); ?>
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