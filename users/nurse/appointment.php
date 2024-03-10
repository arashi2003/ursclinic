<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'appointment';
$campus = $_SESSION['campus'];
$userid=$_SESSION['userid'];

// get the total nr of rows.
$records = $conn->query("select * from appointment WHERE status='Pending'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Appointment</title>
    <?php include('../../includes/header.php');?>
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
                                echo $_SESSION['usertype'] . ' ' . $_SESSION['username'] ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
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
                    <h3>Pending Appointments</h3>
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
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
                                        <div class="col-md-2 mb-2">
                                            <select name="physician" class="form-select">
                                                <option value="">Select Physician</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM account WHERE usertype='DOCTOR' OR usertype='DENTIST' ORDER BY firstname";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {   
                                                        if (count(explode(" ", $row['middlename'])) > 1)
                                                        {
                                                            $middle = explode(" ", $row['middlename']);
                                                            $letter = $middle[0][0].$middle[1][0];
                                                            $middleinitial = $letter . ".";
                                                        }
                                                        else
                                                        {
                                                            $middle = $row['middlename'];
                                                            if ($middle == "" OR $middle == " ")
                                                            {
                                                                $middleinitial = "";
                                                            }
                                                            else
                                                            {
                                                                $middleinitial = substr($middle, 0, 1) . ".";
                                                            }    
                                                        }
                                                        $physician = strtoupper($row['firstname'] . " " . $middleinitial . " " .$row['lastname']);?>
                                                <option value="<?php echo $physician;?> <?= isset($_GET['']) == true ? ($_GET[''] == $physician ? 'selected' : '') : '' ?>"><?php echo $physician;?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="appointment" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['patient']) && $_GET['patient'] != '') {
                                    $patient = $_GET['patient'];
                                    $count = 1;
                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE  CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND ap.status='PENDING' AND ac.campus='$campus' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['date']) && $_GET['date'] != '' || isset($_GET['physician']) && $_GET['physician'] != '') {
                                    $date = $_GET['date'];
                                    $physician = $_GET['physician'];
                                    $count = 1;
                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.date = '$date' or ap.physician = '$physician' AND ac.campus='$campus' AND ap.status='PENDING' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname, ac.campus FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.status='PENDING' AND ac.campus='$campus' ORDER BY ap.date, ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Appointment ID</th>
                                                    <th>Date</th>
                                                    <th>Time from</th>
                                                    <th>Time to</th>
                                                    <th>Patient name</th>
                                                    <th>Physician</th>
                                                    <th>Status</th>
                                            </thead>
                                            <tbody>

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
                                                    if ($data['physician'] == NULL || $data['physician'] == "") {
                                                        $physician = "NONE";
                                                    } else {
                                                        $physician = $data['physician'];
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo $data['id']; ?></td>
                                                        <td><?php echo date("F d, Y", strtotime($data['date'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_from'])) ?></td>
                                                        <td><?php echo date("g:i A", strtotime($data['time_to'])) ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " .ucwords(strtolower($data['lastname'])) ?></td>
                                                        <td><?php echo $physician; ?></td>
                                                        <td><?php echo $data['status'];?>
                                                    </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php');?>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7">No record Found</td>
                                        </tr>
                                <?php
                                    }
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