<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'patient_add';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Patient Information</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">ADD PATIENT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <i class='bx bx-bell'></i>
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
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutmodal">Log Out</button></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <?php include('modals/logout_modal.php'); ?>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="input-group input-group-md">
                            <input class="form-control" type="file" name="acccsv" accept=".jpg, .jpeg, .png, .csv">
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="row">
                        <form method="POST" action="add/patient_add.php" id="form">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Patient ID:</span>
                                        <input type="text" class="form-control" name="patientid" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-2">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Age:</span>
                                        <input type="number" maxlength="3" class="form-control" name="age" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                        <select class="form-control" aria-label=".form-select-md example" name="sex" id="sex" required>
                                            <option value="" disabled selected></option>
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Birthday:</span>
                                        <input type="date" class="form-control" name="birthday" required>
                                    </div>
                                </div>
                                <!-- Responsive: pag faculty, disabled ung program, year at section. pag staff disabled ung simula department gang section -->
                                <div class="col-md-6">
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

                                <!-- pag di college department ma disable or hide nalang ung college tas value is ""-->
                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">College:</span>
                                        <select class="form-control" aria-label=".form-select-md example" name="college" id="college" required>
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
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Program:</span>
                                    <select class="form-control" aria-label=".form-select-md example" name="program" id="program" required>
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
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Year Level:</span>
                                        <select class="form-control" aria-label=".form-select-md example" name="yearlevel" id="yearlevel" required>
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
                                <div class="col-md-2">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Section:</span>
                                        <input type="text" class="form-control" name="section" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row"><p>
                                <!-- if na recognize ung patient id, mag populate ung email at contact number nila from account table-->
                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Email Address:</span>
                                        <input type="text" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Contact Number:</span>
                                        <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Emergency Contact Name:</span>
                                        <input type="text" class="form-control" name="emcon_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Emergency Contact Number:</span>
                                        <input type="text" maxlength="13" class="form-control" name="emcon_number" id="emcon_number" required>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Add Account"></input> 
                                &ThickSpace;
                                <input type="reset" class="btn btn-danger" value="Cancel"></input>
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