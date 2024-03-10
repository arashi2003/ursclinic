<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'dental_consultation';
$campus = $_SESSION['campus'];
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
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_dental_checkup.php'">Dental Checkup</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_medhist.php'">Medical History</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_vitals.php'">Vitals</button>
                </div>
                <div class="content">
                    <form method="POST" action="add/transaction_dental_consultation.php" id="form">
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
                                <span class="input-group-text" id="inputGroup-sizing-md">Age Last Birthday:</span>
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
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_1" id="toothno_1">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_1" id="diagnosis_1">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_1" id="treatment_1">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_2" id="toothno_2">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_2" id="diagnosis_2">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_2" id="treatment_2">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_3" id="toothno_3">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_3" id="diagnosis_3">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_3" id="treatment_3">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_4" id="toothno_4">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_4" id="diagnosis_4">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_4" id="treatment_4">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_5" id="toothno_5">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_5" id="diagnosis_5">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_5" id="treatment_5">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_6" id="toothno_6">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_6" id="diagnosis_6">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_6" id="treatment_6">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_7" id="toothno_7">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_7" id="diagnosis_7">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_7" id="treatment_7">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_8" id="toothno_8">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_8" id="diagnosis_8">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_8" id="treatment_8">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_9" id="toothno_9">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_9" id="diagnosis_9">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_9" id="treatment_9">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_10" id="toothno_10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_10" id="diagnosis_10">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_10" id="treatment_10">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_11" id="toothno_11">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_11" id="diagnosis_11">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_11" id="treatment_11">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_12" id="toothno_12">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_12" id="diagnosis_12">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_12" id="treatment_12">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_13" id="toothno_13">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_13" id="diagnosis_13">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_13" id="treatment_13">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_14" id="toothno_14">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_14" id="diagnosis_14">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_14" id="treatment_14">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_15" id="toothno_15">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_15" id="diagnosis_15">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_15" id="treatment_15">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_16" id="toothno_16">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_16" id="diagnosis_16">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_16" id="treatment_16">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_17" id="toothno_17">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_17" id="diagnosis_17">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_17" id="treatment_17">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_18" id="toothno_18">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_18" id="diagnosis_18">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_18" id="treatment_18">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_19" id="toothno_19">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_19" id="diagnosis_19">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_19" id="treatment_19">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="content">  
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                <input type="number" maxlength="2" class="form-control" name="toothno_20" id="toothno_20">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                <input type="text" maxlength="20" class="form-control" name="diagnosis_20" id="diagnosis_20">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                <input type="text" maxlength="20" class="form-control" name="treatment_20" id="treatment_20">
                            </div>
                        </div>
                    </div>
                </div>                                                   

                <div class="content">
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
                        <input type="text" class="form-control" name="type" value="Walk-In" id="type" hidden>
                        <input type="text"  class="form-control"  name="transaction" value="Walk-In" hidden>
                        <input type="text"  class="form-control"  name="service" value="Dental Consultation" hidden>
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

<script type="text/javascript">
    function enableOther(answer) {
        console.log(answer.value);
        {
            if (answer.value == 1) {
                document.getElementById('medical').classList.add('hidden');
                document.getElementById('medicine').classList.remove('hidden');
                document.getElementById('quantity').classList.remove('hidden');
                document.getElementById('purpose').classList.remove('hidden');
            } else if (answer.value == 2) {
                document.getElementById('medicine').classList.add('hidden');
                document.getElementById('medical').classList.remove('hidden');
                document.getElementById('quantity').classList.remove('hidden');
                document.getElementById('purpose').classList.remove('hidden');
            } else {
                document.getElementById('medical').classList.add('hidden');
                document.getElementById('medicine').classList.add('hidden');
                document.getElementById('quantity').classList.add('hidden');
                document.getElementById('purpose').classList.add('hidden');
            }
        }
    };
</script>

<script>
    function duplicate() {
        var row = $('.duplicate').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove(this)');
        $('.duplicate').last().after(row);
    }

    function remove(btn) {
        $(btn).closest('.duplicate').remove();
    }

    $('select[name="request"]').change(function() {
        $('.duplicate:not(:first)').remove();
    });

    $(document).ready(function() {
        $('#add-request').submit(function(e) {
            e.preventDefault();
            $('#addbtn').val('Requesting...');
            $.ajax({
                url: 'action-add-request.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    window.location.href = "request";
                }
            });
        });
    });
</script>
</html>