<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'transaction_add';
$userid=$_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Transaction</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">ADD TRANSACTION</span>
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
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_add.php'">Default</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_medhist.php'">Medical History</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_dental_checkup.php'">Dental Checkup</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_dental_consultation.php'">Dental Consultation</button>
                </div>
                <div class="content">
                    <form method="POST" action="add/transaction_vitals.php" id="form">
                    <h3><b>Patient</b></h3>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Patient ID:</span>
                                <input type="text" class="form-control" name="patientid" id="patientid">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">First Name:</span>
                                <input type="text" maxlength="45" class="form-control" name="firstname" id="firstname" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Middle Name:</span>
                                <input type="text" maxlength="45" class="form-control" name="middlename" id="middlename">
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Last Name:</span>
                                <input type="text" maxlength="45" class="form-control" name="lastname" id="lastname" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="designation" id="designation" required>
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM designation ORDER BY designation";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {?>
                                        <option value="<?= $row['designation']; ?>"><?= $row['designation']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Age:</span>
                                <input type="text" maxlength="3" class="form-control" name="age" id="age" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="sex" id="sex" required>
                                    <option value="" disabled selected></option>
                                    <option value="MALE">Male</option>
                                    <option value="FEMALE">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- responsive-->
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="department" id="department" required>
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM department ORDER BY department";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {?>
                                        <option value="<?= $row['department']; ?>"><?= $row['department']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">College:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="college" id="college">
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM college ORDER BY college";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {?>
                                        <option value="<?= $row['college']; ?>"><?= $row['college']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Program:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="program" id="program">
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM program ORDER BY program";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {?>
                                        <option value="<?= $row['abbrev']; ?>"><?= $row['program']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Year Level:</span>
                                <select class="form-control" aria-label=".form-select-md example" name="yearlevel" id="yearlevel">
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM yearlevel ORDER BY yearlevel";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {?>
                                        <option value="<?= $row['yearlevel']; ?>"><?= $row['yearlevel']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Section:</span>
                                <input type="text" class="form-control" name="section" id="section" >
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Block:</span>
                                <input type="text" class="form-control" name="block" id="block" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <!-- responsive pag others pinili lalabas additional na textbox-->
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Chief Complaints:</span>
                        <select class="form-control" aria-label=".form-select-md example" name="chief_complaint" id="chief_complaint">
                            <option value="" selected></option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM chief_complaint ORDER BY chief_complaint";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {?>
                                <option value="<?= $row['chief_complaint']; ?>"><?= $row['chief_complaint']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Others:</span>
                        <input type="text" class="form-control" name="chief_complaint_others" id="chief_complaint_others" >
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Blood Pressure:</span>
                                <input type="text" maxlength="7" class="form-control" name="bp" id="bp" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Pulse Rate:</span>
                                <input type="number" maxlength="3" class="form-control" name="pr" id="pr" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Temperature:</span>
                                <input type="text" maxlength="3" class="form-control" name="temp" id="temp" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Respiratory Rate:</span>
                                <input type="number" maxlength="3" class="form-control" name="respiratory" id="respiratory" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Oxygen Saturation:</span>
                                <input type="text" maxlength="4" class="form-control" name="oxygen" id="oxygen" required>
                            </div>
                        </div>
                    </div>

                    <!-- responsive pag others pinili lalabas additional na textbox-->
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Findings/Diagnosis:</span>
                        <select class="form-control" aria-label=".form-select-md example" name="findiag" id="findiag">
                            <option value="" selected></option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM findiag ORDER BY findiag";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {?>
                                <option value="<?= $row['findiag']; ?>"><?= $row['findiag']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Others:</span>
                        <input type="text" class="form-control" name="findiag_others" id="findiag_others" >
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Remarks:</span>
                        <input type="text" class="form-control" name="remarks" id="remarks">
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Referral:</span>
                        <input type="text" class="form-control" name="referral" id="referral">
                    </div>

                    <!-- responsive pag others pinili lalabas additional na textbox-->
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Medical Case:</span>
                        <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase" required>
                            <option value="" disabled selected></option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM med_case ORDER BY type, medcase";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {?>
                                <option value="<?= $row['id']; ?>"><?= "(" . ucfirst(strtolower( $row['type'])) . ") " . $row['medcase']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Others:</span>
                        <input type="text" class="form-control" name="medcase_others" id="medcase_others" >
                    </div>
                    
                    <div class="modal-footer">
                        <input type="text" class="form-control" name="service" value="Vitals" hidden>
                        <input type="text" class="form-control" name="type" value="Checkup" hidden>
                        <input type="text" class="form-control" name="transaction" value="Walk-In" hidden>
                        <input type="submit" class="btn btn-primary" value="Add Record"></input> 
                        &ThickSpace;
                        <input type="reset" class="btn btn-danger" value="Cancel"></input>
                    </div>
                </div>
            </form>
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