<?php

session_start();
include('../../../connection.php');
include('../../../includes/student-auth.php');

$module = 'medical';
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
$campus = $_SESSION['campus'];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Medical Documents</title>
    <?php include('../../../includes/header.php') ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL DOCUMENTS</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user WHERE 
                        ((au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'disapproved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'cancelled a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'completed a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'dismissed a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added a walk-in schedule%' AND au.activity LIKE '%$campus') 
                        OR (au.activity LIKE 'cancelled a walk-in schedule%' AND au.activity LIKE '%$campus')) 
                        AND au.status = 'unread' AND au.user != '$userid'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_num_rows($result)) {
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifes">
                                <?= $row ?>
                            </span>
                        <?php
                        }
                        ?>
                    </button>
                </div>
                <div class="profile-details">
                    <?php
                    $image = "SELECT * FROM patient_image WHERE patient_id = '$userid'";
                    $result = mysqli_query($conn, $image);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="profile">
                        <img src="../../../images/<?php echo $row['image']; ?>">
                    </div>
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
                <div class="content info">
                    <?php
                    $sql = "SELECT * FROM patient_info p INNER JOIN account a ON a.accountid=p.patientid WHERE p.patientid='$userid'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $data) {
                    ?>
                                <div class="row p-2">
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['patientid'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['program'] . ' ' . $data['yearlevel'] . '-' . $data['section']  . $data['block'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['college'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
                <?php
                include('medical-doc.php');
                ?>
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