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

// get the total nr of rows.
$records = $conn->query("SELECT * FROM audit_trail ORDER BY id DESC");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php')
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
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_audit_trail?date_from=<?= !empty($_GET['date_from']) ?>&date_to=<?= !empty($_GET['date_to']) ?>');" target="_blank">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-2 mb-2">
                                            <input type="date" name="date_from" value="<?= isset($_GET['date_from']) == true ? $_GET['date_from'] : '' ?>" class="form-control">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <input type="date" name="date_to" value="<?= isset($_GET['date_to']) == true ? $_GET['date_to'] : '' ?>" class="form-control">
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
                                            <th>Usertype</th>
                                            <th>Activity</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['date_from']) && $_GET['date_from'] != '' || isset($_GET['date_to']) && $_GET['date_to'] != '') {
                                            $dt_from = $_GET['date_from'];
                                            $dt_to = $_GET['date_to'];
                                            $count = 1;

                                            if ($dt_from == "" and $dt_to == "") {
                                                $date = "";
                                            } elseif ($dt_to == $dt_from) {
                                                $d2 = date("Y-m-d", strtotime("$dt_to + 1 day"));
                                                $date = " AND datetime >= '$dt_from' AND datetime <= '$d2'";
                                            } elseif ($dt_to == "" and $dt_from != "") {
                                                $d1 = date("Y-m-d", strtotime("$dt_from"));
                                                $d2 = date("Y-m-d", strtotime("+ 1 day"));
                                                $date = " AND datetime >= '$d1' AND datetime <= '$d2'";
                                            } elseif ($dt_from == "" and $dt_to != "") {
                                                $d = date("Y-m-d", strtotime("$dt_to + 1 day"));
                                                $date = " AND datetime <= '$d'";
                                            } elseif ($dt_from != "" and $dt_to != "") {
                                                $d = date($dt_to, strtotime("+ 1 day"));
                                                $date = " AND datetime >= '$dt_from' AND datetime <= '$d'";
                                            }

                                            $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, ac.firstname, ac.middlename, ac.lastname, ac.usertype FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user WHERE au.campus = '$campus' $date ORDER BY id DESC LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, ac.firstname, ac.middlename, ac.lastname, ac.usertype FROM audit_trail au INNER JOIN account ac on ac.accountid=au.user WHERE au.campus = '$campus' ORDER BY id DESC LIMIT $start, $rows_per_page";
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
                                                        <td><?php echo $row['id'] ?></td>
                                                        <td><?php echo $row['usertype'] ?></td>
                                                        <td><?php echo ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname'])) . " " . lcfirst($row['activity']) ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($row['datetime'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($row['datetime'])) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else { ?>
                                                <td colspan="5">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                            <?php } ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php') ?>
                            <?php
                                        } else {
                            ?>
                                <td colspan="5">
                                    <?php
                                            include('../../includes/no-data.php');
                                    ?>
                                </td>
                            <?php
                                        }
                                        mysqli_close($conn);
                            ?>
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