<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/dentist-auth.php');
$campus = $_SESSION['campus'];
$name = $_SESSION['username'];
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$today = date('Y-m-d');

// get the total nr of rows.
$records = $conn->query("SELECT * FROM schedule WHERE physician = '$userid' AND date >= '$today'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Dentist's Visit</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">DENTIST'S VISIT</span>
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
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addsched">Add Walk-In Schedule</button>
                    <?php include('modals/add_sched_modal.php'); ?>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Campus</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Max. No. of Patients</th>
                                            <th>Action</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        $date = date("Y-m-d");
                                        $sql = "SELECT s.id, s.status, s.reason, s.date, s.time_from, s.time_to, s.physician, s.maxp, s.campus, a.firstname, a.middlename, a.lastname FROM schedule s INNER JOIN account a on a.accountid=s.physician WHERE date >= '$today' AND physician = '$userid' ORDER BY date, time_from LIMIT $start, $rows_per_page";
                                        $result = mysqli_query($conn, $sql);
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
                                                        <td><?php $id = $count;
                                                            $date = date("F d, Y", strtotime($data['date']));
                                                            $time = date("g:i A", strtotime($data['time_from'])) . " - " . date("g:i A", strtotime($data['time_to']));
                                                            $physician = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'];
                                                            echo $id; ?></td>
                                                        <td><?php echo $data['campus'] ?></td>
                                                        <td><?php echo $date ?></td>
                                                        <td><?php echo $time ?></td>
                                                        <td><?php echo $data['maxp'] ?></td>
                                                        <td>
                                                            <?php
                                                            if($data['status'] == 'CANCELLED')
                                                            {?>
                                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reason<?php echo $data['id']; ?>">Cancelled</button>
                                                            <?php }
                                                            else
                                                            {?>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatesched<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelsched<?php echo $data['id']; ?>">Cancel</button>
                                                            <?php }
                                                            ?></td>
                                                        <?php $count++; ?></td>
                                                    </tr>
                                                <?php include('modals/cancel_sched_modal.php');
                                                    include('modals/update_sched_modal.php');
                                                    include('modals/reason_sched_modal.php');
                                                }
                                                
                                                ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php'); ?>
                            <?php
                                            } else { ?>
                                <tr>
                                    <td colspan="7">No record Found</td>
                                </tr>
                            <?php
                                            }
                                        } else {
                            ?>
                            <tr>
                                <td colspan="7">No record Found</td>
                            </tr>
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