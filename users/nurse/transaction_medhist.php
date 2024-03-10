<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'transaction_add';
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
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_vitals.php'">Vitals</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_dental_checkup.php'">Dental Checkup</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_dental_consultation.php'">Dental Consultation</button>
                </div>
                <div class="content">
                    <form method="POST" action="add/transaction_medhist.php" id="form">
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
                                <input type="text" class="form-control" name="sex" id="sex" required>
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
                    <h3><b>Medical</b></h3>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Birthday:</span>
                                <input type="date" class="form-control" name="birthday" id="birthday" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Height (cm):</span>
                                <input type="number" maxlength="7" class="form-control" name="height" id="height" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Weight:</span>
                                <input type="text" maxlength="7" class="form-control" name="weight" id="weight" required>
                            </div>
                        </div>
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
                                <input type="number"  maxlength="3" class="form-control" name="pr" id="pr" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Temperature:</span>
                                <input type="text" maxlength="4" class="form-control" name="temp" id="temp" required>
                            </div>
                        </div>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">H.E.E.N.T.:</span>
                        <input type="text" maxlength="65" class="form-control" name="heent" id="heent" required>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Chest/Lungs:</span>
                        <input type="text" maxlength="65" class="form-control" name="chest_lungs" id="chest_lungs" required>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Heart:</span>
                        <input type="text" maxlength="65" class="form-control" name="heart" id="heart" required>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Abdomen:</span>
                        <input type="text" maxlength="65" class="form-control" name="abdomen" id="abdomen" required>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Extremities:</span>
                        <input type="text" maxlength="65" class="form-control" name="extremities" id="extremities" required>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Last Menstrual Period:</span>
                                <input type="date" class="form-control" name="lmp" id="lmp">
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Bronchial Asthma:</span>
                                <input type="date" class="form-control" name="bronchial_asthma" id="bronchial_asthma" >
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Surgery:</span>
                                <input type="date" class="form-control" name="surgery" id=""surgery >
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Heart Disease:</span>
                                <input type="date" class="form-control" name="heart_disease" id="heart_disease" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Allergies:</span>
                                <input type="date" class="form-control" name="allergies" id="allergies">
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Epilepsy:</span>
                                <input type="date" class="form-control" name="epilepsy" id="epilepsy" >
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Hernia:</span>
                                <input type="date" class="form-control" name="hernia" id="hernia" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <h3><b>Dental</b></h3>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <input type="text" id="ddefects" name="ddefects" value="" hidden>
                            <input type="checkbox" id="ddefects" name="ddefects" value="x">
                            <label for="ddefects"> No Dental Defects</label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" id="dcs" name="dcs" value="" hidden>
                            <input type="checkbox" id="dcs" name="dcs" value="x">
                            <label for="dcs"> Presence of Oral Debris, Calculi (tartar) deposits, Stains/discoloration</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <input type="text" id="gp" name="gp" value="" hidden>
                            <input type="checkbox" id="gp" name="gp" value="x">
                            <label for="gp"> Presence of GINGIVITIS and/or PERIODONTITIS</label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" id="scaling_polish" name="scaling_polish" value="" hidden>
                            <input type="checkbox" id="scaling_polish" name="scaling_polish" value="x">
                            <label for="scaling_polish"> For Tooth Scaling and Polishing</label>
                        </div>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Other Dento-Facial Findings:</span>
                        <input type="text" maxlength="45" class="form-control" name="dento_facial" id="dento_facial">
                    </div>
                </div>

                <div class="content">
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Remarks:</span>
                        <input type="text" class="form-control" name="remarks" id="remarks" >
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Recommendation:</span>
                        <input type="text" class="form-control" name="referral" id="referral" >
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
                        <input type="text" maxlength="45" class="form-control" name="medcase_others" id="medcase_others">
                    </div>
                    
                    <div class="modal-footer">
                        <input type="text" class="form-control" value="Walk-In" name="type" hidden>
                        <input type="text" class="form-control" value="Checkup" name="transaction" hidden>
                        <input type="text" class="form-control" value="Medical History" name="service" hidden>
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