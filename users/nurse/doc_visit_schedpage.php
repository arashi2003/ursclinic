<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'doc_visit';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$date = date("Y-m-d");

// get the total nr of rows.
$records = $conn->query("SELECT s.id, s.date, s.time_from, s.time_to, s.physician, s.campus, a.firstname, a.middlename, a.lastname FROM schedule s INNER JOIN account a on a.accountid=s.physician WHERE s.campus = '$campus' AND date >= '$date' ORDER BY date, time_from");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Doctor's Visit</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">DOCTOR'S VISIT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user INNER JOIN patient_image i ON i.patient_id=au.user WHERE (au.activity LIKE '%added a walk-in schedule%' OR au.activity 
                        LIKE 'sent a request for%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%already expired') AND au.status='unread' AND au.user != '$userid'";
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
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Physician</th>
                                            <th>Max. No. of Patients</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        $date = date("Y-m-d");
                                        $sql = "SELECT s.id, s.maxp, s.date, s.time_from, s.time_to, s.physician, s.campus, a.firstname, a.middlename, a.lastname FROM schedule s INNER JOIN account a on a.accountid=s.physician WHERE s.campus = '$campus' AND date >= '$date' ORDER BY date, time_from LIMIT $start, $rows_per_page";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($data = mysqli_fetch_array($result)) {
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
                                                        <td><?php $id = $count;
                                                            $date = date("F d, Y", strtotime($data['date']));
                                                            $time = date("g:i A", strtotime($data['time_from'])) . " - " . date("g:i A", strtotime($data['time_to']));
                                                            $physician = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));
                                                            echo $id; ?></td>
                                                        <td><?php echo $date ?></td>
                                                        <td><?php echo $time ?></td>
                                                        <td><?php echo $physician ?></td>
                                                        <td><?php echo $data['maxp'];
                                                            $count++;
                                                        } ?></td>
                                                    </tr>
                                                    <?php
                                                    ?>
                                    </tbody>
                                </table>
                            <?php include('../../includes/pagination.php');
                                            } else { ?><td colspan="7">
                                    <?php
                                                include('../../includes/no-data.php');
                                    ?>
                                </td>
                            <?php
                                            }
                                        } else {
                            ?><td colspan="7">
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