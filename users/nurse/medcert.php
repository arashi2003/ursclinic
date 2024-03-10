<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'medcert';
$userid=$_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Medical Certificate</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL CERTIFICATE</span>
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
                    <div class="row">
                        <form method="POST" action="reports/reports_medcert_new.php" id="form">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">First Name:</span>
                                <input type="text" class="form-control" name="firstname" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Middle Name:</span>
                                <input type="text" class="form-control" name="middlename">
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Last Name:</span>
                                <input type="text" class="form-control" name="lastname" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Age:</span>
                                <input type="number" class="form-control" name="age" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                <input type="text" class="form-control" name="sex" required>
                            </div>
                            
                            <!-- Responsive ror ror-->

                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="department" id="department">
                                    <option value="" selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM department ORDER BY department";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['department']; ?>"><?= $row['department']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">College:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="college" id="college">
                                    <option value="" selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM college ORDER BY college";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['college']; ?>"><?= $row['college']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Program:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="course" id="course">
                                    <option value="" selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM program ORDER BY program";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['abbrev']; ?>"><?= $row['abbrev']?></option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Year Level:</span>
                                <input type="number" class="form-control" name="yearlevel">
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Section:</span>
                                <input type="text" class="form-control" name="section">
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Birthday:</span>
                                <input type="date" class="form-control" name="bday" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Height:</span>
                                <input type="text" class="form-control" name="height" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Weight:</span>
                                <input type="text" class="form-control" name="weight" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Blood Pressure:</span>
                                <input type="text" class="form-control" name="bp" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Pulse Rate:</span>
                                <input type="text" class="form-control" name="pr" required>
                            </div>
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Temperature:</span>
                                <input type="text" class="form-control" name="temp" required>
                            </div>

                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="View"></input>
                            </div>
                        </form>
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