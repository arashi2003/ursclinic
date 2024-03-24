<?php

session_start();
include('../../../connection.php');
include('../../../includes/student-auth.php');

$module = 'history';
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
$campus = $_SESSION['campus'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM transaction_history WHERE patient='$userid'");
$nr_of_rows = $records->num_rows;

include('../../../includes/pagination-limit.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Medical Records</title>
    <?php include('../../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL RECORD</span>
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
                            <li><a class="dropdown-item" href="../../../logout">Logout</a></li>
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
                                        <div class="col-md-2 mb-2">
                                            <select name="type" class="form-select">
                                                <option value="">Select Transaction Type</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT type FROM transaction_history WHERE campus='$campus' ORDER BY type";
                                                $result = mysqli_query($conn, $sql);
                                                foreach ($result as $row) {   ?>
                                                    <option value="<?php echo $row['type']; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row['type'] ? 'selected' : '') : '' ?>"><?php echo $row['type'] ?></option><?php } ?>
                                            </select>
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
                                            <th>ID</th>
                                            <th>Type of Transaction</th>
                                            <th>Service</th>
                                            <th>Physician/Nurse on Duty</th>
                                            <th>Date and Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['type']) && $_GET['type'] != '' || isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                            $type = $_GET['type'];
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $count = 1;

                                            //date filter
                                            if ($dt_from == "" and $dt_to == "") {
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND datetime >= '$fdate'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $date = " AND datetime >= '$fdate'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND datetime <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
                                                $fdate = date("Y-m-d", strtotime($dt_from));
                                                $ldate = date("Y-m-d", strtotime($dt_to));
                                                $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
                                            }

                                            //type filter
                                            if ($type == "") {
                                                $tp = "";
                                            } elseif ($type != "" and $date == "") {
                                                $tp = " AND type = '$type'";
                                            } elseif ($date != "" and $type != "") {
                                                $tp = " AND type = '$type'";
                                            }

                                            $sql = "SELECT * FROM transaction_history WHERE campus='$campus' $date $tp AND transaction NOT LIKE '%Medical History%' AND transaction NOT LIKE '%Vitals%' AND purpose NOT LIKE '%Medical History%' AND purpose NOT LIKE '%Vitals%' AND patient='$userid' ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_history WHERE campus='$campus' AND transaction NOT LIKE '%Medical History%' AND transaction NOT LIKE '%Vitals%' AND purpose NOT LIKE '%Medical History%' AND purpose NOT LIKE '%Vitals%' AND patient='$userid' ORDER BY datetime DESC LIMIT $start, $rows_per_page";
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
                                                    $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));
                                        ?>
                                                    <tr>
                                                        <td><?= $data['id'] ?></td>
                                                        <td><?= $data['transaction'] ?></td>
                                                        <td><?= $data['purpose'] ?></td>
                                                        <td><?= $data['pod_nod'] ?></td>
                                                        <td><?= date("M. d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime'])) ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewtrans<?php echo $data['id']; ?>">Expand</button>
                                                        </td>

                                                    </tr>
                                                <?php
                                                    include('modals/view_trans_modal.php');
                                                }
                                                ?>

                                            <?php include('../../../includes/pagination.php');
                                            } else { ?>
                                                <tr>
                                                    <td colspan="7">
                                                        <?php
                                                        include('../../../includes/no-data.php');
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="7">
                                                    <?php
                                                    include('../../../includes/no-data.php');
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
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