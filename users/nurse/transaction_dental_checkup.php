<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'dental_checkup';
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
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_dental_consultation.php'">Dental Consultation</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_medhist.php'">Medical History</button>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href = 'transaction_vitals.php'">Vitals</button>
                </div>
                <div class="content">
                    <form method="POST" action="add/transaction_dental_checkup.php" id="form">
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

                <!-- Start : Operation and Condition -->
                <div class="content">  
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">55</span>
                                <input type="text" maxlength="4" class="form-control" name="t_55" id="t_55" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">54</span>
                                <input type="text" maxlength="4" class="form-control" name="t_54" id="t_54" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">53</span>
                                <input type="text" maxlength="4" class="form-control" name="t_53" id="t_53" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">52</span>
                                <input type="text" maxlength="4" class="form-control" name="t_52" id="t_52" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">51</span>
                                <input type="text" maxlength="4" class="form-control" name="t_51" id="t_51" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">55</span>
                                <input type="text" maxlength="4" class="form-control" name="b_55" id="b_55">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">54</span>
                                <input type="text" maxlength="4" class="form-control" name="b_54" id="b_54">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">53</span>
                                <input type="text" maxlength="4" class="form-control" name="b_53" id="b_53">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">52</span>
                                <input type="text" maxlength="4" class="form-control" name="b_52" id="b_52">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">51</span>
                                <input type="text" maxlength="4" class="form-control" name="b_51" id="b_51">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">  
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">61</span>
                                <input type="text" maxlength="4" class="form-control" name="t_61" id="t_61" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">62</span>
                                <input type="text" maxlength="4" class="form-control" name="t_62" id="t_62" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">63</span>
                                <input type="text" maxlength="4" class="form-control" name="t_63" id="t_63" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">64</span>
                                <input type="text" maxlength="4" class="form-control" name="t_64" id="t_64" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">65</span>
                                <input type="text" maxlength="4" class="form-control" name="t_65" id="t_65" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">61</span>
                                <input type="text" maxlength="4" class="form-control" name="b_61" id="b_61">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">62</span>
                                <input type="text" maxlength="4" class="form-control" name="b_62" id="b_62">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">63</span>
                                <input type="text" maxlength="4" class="form-control" name="b_63" id="b_63">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">64</span>
                                <input type="text" maxlength="4" class="form-control" name="b_64" id="b_64">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">65</span>
                                <input type="text" maxlength="4" class="form-control" name="b_65" id="b_65">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content"> 
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">18</span>
                                <input type="text" maxlength="4" class="form-control" name="t_18" id="t_18" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">17</span>
                                <input type="text" maxlength="4" class="form-control" name="t_17" id="t_17" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">16</span>
                                <input type="text" maxlength="4" class="form-control" name="t_16" id="t_16" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">15</span>
                                <input type="text" maxlength="4" class="form-control" name="t_15" id="t_15" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">14</span>
                                <input type="text" maxlength="4" class="form-control" name="t_14" id="t_14" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">13</span>
                                <input type="text" maxlength="4" class="form-control" name="t_13" id="t_13" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">12</span>
                                <input type="text" maxlength="4" class="form-control" name="t_12" id="t_12" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">11</span>
                                <input type="text" maxlength="4" class="form-control" name="t_11" id="t_11" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">18</span>
                                <input type="text" maxlength="4" class="form-control" name="b_18" id="b_18" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">17</span>
                                <input type="text" maxlength="4" class="form-control" name="b_17" id="b_17" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">16</span>
                                <input type="text" maxlength="4" class="form-control" name="b_16" id="b_16" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">15</span>
                                <input type="text" maxlength="4" class="form-control" name="b_15" id="b_15" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">14</span>
                                <input type="text" maxlength="4" class="form-control" name="b_14" id="b_14" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">13</span>
                                <input type="text" maxlength="4" class="form-control" name="b_13" id="b_13" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">12</span>
                                <input type="text" maxlength="4" class="form-control" name="b_12" id="b_12" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">11</span>
                                <input type="text" maxlength="4" class="form-control" name="b_11" id="b_11" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content"> 
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">21</span>
                                <input type="text" maxlength="4" class="form-control" name="t_21" id="t_21" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">22</span>
                                <input type="text" maxlength="4" class="form-control" name="t_22" id="t_22" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">23</span>
                                <input type="text" maxlength="4" class="form-control" name="t_23" id="t_23" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">24</span>
                                <input type="text" maxlength="4" class="form-control" name="t_24" id="t_24" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">25</span>
                                <input type="text" maxlength="4" class="form-control" name="t_25" id="t_25" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">26</span>
                                <input type="text" maxlength="4" class="form-control" name="t_26" id="t_26" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">27</span>
                                <input type="text" maxlength="4" class="form-control" name="t_27" id="t_27" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">28</span>
                                <input type="text" maxlength="4" class="form-control" name="t_28" id="t_28" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">21</span>
                                <input type="text" maxlength="4" class="form-control" name="b_21" id="b_21" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">22</span>
                                <input type="text" maxlength="4" class="form-control" name="b_22" id="b_22" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">23</span>
                                <input type="text" maxlength="4" class="form-control" name="b_23" id="b_23" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">24</span>
                                <input type="text" maxlength="4" class="form-control" name="b_24" id="b_24" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">25</span>
                                <input type="text" maxlength="4" class="form-control" name="b_25" id="b_25" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">26</span>
                                <input type="text" maxlength="4" class="form-control" name="b_26" id="b_26" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">27</span>
                                <input type="text" maxlength="4" class="form-control" name="b_27" id="b_27" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">28</span>
                                <input type="text" maxlength="4" class="form-control" name="b_28" id="b_28" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content"> 
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">48</span>
                                <input type="text" maxlength="4" class="form-control" name="t_48" id="t_48" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">47</span>
                                <input type="text" maxlength="4" class="form-control" name="t_47" id="t_47" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">46</span>
                                <input type="text" maxlength="4" class="form-control" name="t_46" id="t_46" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">45</span>
                                <input type="text" maxlength="4" class="form-control" name="t_45" id="t_45" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">44</span>
                                <input type="text" maxlength="4" class="form-control" name="t_44" id="t_44" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">43</span>
                                <input type="text" maxlength="4" class="form-control" name="t_43" id="t_43" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">42</span>
                                <input type="text" maxlength="4" class="form-control" name="t_42" id="t_42" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">41</span>
                                <input type="text" maxlength="4" class="form-control" name="t_41" id="t_41" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">48</span>
                                <input type="text" maxlength="4" class="form-control" name="b_48" id="b_48" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">47</span>
                                <input type="text" maxlength="4" class="form-control" name="b_47" id="b_47" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">46</span>
                                <input type="text" maxlength="4" class="form-control" name="b_46" id="b_46" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">45</span>
                                <input type="text" maxlength="4" class="form-control" name="b_45" id="b_45" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">44</span>
                                <input type="text" maxlength="4" class="form-control" name="b_44" id="b_44" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">43</span>
                                <input type="text" maxlength="4" class="form-control" name="b_43" id="b_43" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">42</span>
                                <input type="text" maxlength="4" class="form-control" name="b_42" id="b_42" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">41</span>
                                <input type="text" maxlength="4" class="form-control" name="b_41" id="b_41" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content"> 
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">31</span>
                                <input type="text" maxlength="4" class="form-control" name="t_31" id="t_31" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">32</span>
                                <input type="text" maxlength="4" class="form-control" name="t_32" id="t_32" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">33</span>
                                <input type="text" maxlength="4" class="form-control" name="t_33" id="t_33" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">34</span>
                                <input type="text" maxlength="4" class="form-control" name="t_34" id="t_34" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">35</span>
                                <input type="text" maxlength="4" class="form-control" name="t_35" id="t_35" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">36</span>
                                <input type="text" maxlength="4" class="form-control" name="t_36" id="t_36" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">37</span>
                                <input type="text" maxlength="4" class="form-control" name="t_37" id="t_37" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">38</span>
                                <input type="text" maxlength="4" class="form-control" name="t_38" id="t_38" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">31</span>
                                <input type="text" maxlength="4" class="form-control" name="b_31" id="b_31" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">32</span>
                                <input type="text" maxlength="4" class="form-control" name="b_32" id="b_32" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">33</span>
                                <input type="text" maxlength="4" class="form-control" name="b_33" id="b_33" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">34</span>
                                <input type="text" maxlength="4" class="form-control" name="b_34" id="b_34" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">35</span>
                                <input type="text" maxlength="4" class="form-control" name="b_35" id="b_35" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">36</span>
                                <input type="text" maxlength="4" class="form-control" name="b_36" id="b_36" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">37</span>
                                <input type="text" maxlength="4" class="form-control" name="b_37" id="b_37" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">38</span>
                                <input type="text" maxlength="4" class="form-control" name="b_38" id="b_38" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">  
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">85</span>
                                <input type="text" maxlength="4" class="form-control" name="t_85" id="t_85" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">84</span>
                                <input type="text" maxlength="4" class="form-control" name="t_84" id="t_84" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">83</span>
                                <input type="text" maxlength="4" class="form-control" name="t_83" id="t_83" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">82</span>
                                <input type="text" maxlength="4" class="form-control" name="t_82" id="t_82" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">81</span>
                                <input type="text" maxlength="4" class="form-control" name="t_81" id="t_81" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">85</span>
                                <input type="text" maxlength="4" class="form-control" name="b_85" id="b_85">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">84</span>
                                <input type="text" maxlength="4" class="form-control" name="b_84" id="b_84">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">83</span>
                                <input type="text" maxlength="4" class="form-control" name="b_83" id="b_83">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">82</span>
                                <input type="text" maxlength="4" class="form-control" name="b_82" id="b_82">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">81</span>
                                <input type="text" maxlength="4" class="form-control" name="b_81" id="b_81">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">  
                    <div class="row">
                        <h3>Operation</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">71</span>
                                <input type="text" maxlength="4" class="form-control" name="t_71" id="t_71" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">72</span>
                                <input type="text" maxlength="4" class="form-control" name="t_72" id="t_72" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">73</span>
                                <input type="text" maxlength="4" class="form-control" name="t_73" id="t_73" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">74</span>
                                <input type="text" maxlength="4" class="form-control" name="t_74" id="t_74" required>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">75</span>
                                <input type="text" maxlength="4" class="form-control" name="t_75" id="t_75" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Condition</h3>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">71</span>
                                <input type="text" maxlength="4" class="form-control" name="b_71" id="b_71">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">72</span>
                                <input type="text" maxlength="4" class="form-control" name="b_72" id="b_72">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">73</span>
                                <input type="text" maxlength="4" class="form-control" name="b_73" id="b_73">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">74</span>
                                <input type="text" maxlength="4" class="form-control" name="b_74" id="b_74">
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">75</span>
                                <input type="text" maxlength="4" class="form-control" name="b_75" id="b_75">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End : Operation and Condition -->

                <div class="content">  
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Presence of Oral Debris/Stains/Calculus:</span>
                                <input type="text" maxlength="4" class="form-control" name="posc" id="posc">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Presence of Gingivitis and/or Periodontitis:</span>
                                <input type="text" maxlength="4" class="form-control" name="pgp" id="pgp">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Presence of Periodontal Pockets:</span>
                                <input type="text" maxlength="4" class="form-control" name="ppp" id="ppp">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Presence of Dento-Facial Anomaly:</span>
                                <input type="text" maxlength="4" class="form-control" name="pdfa" id="pdfa">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="input-group input-group-md mb-2">
                            <span class="input-group-text" id="inputGroup-sizing-md">Use Toothbrush:</span>
                            <input type="text" maxlength="4" class="form-control" name="toothbrush" id="toothbrush">
                        </div>
                    </div>
                </div>
                
                
                <div class="content">  
                    <div class="row">
                        <h3>Tooth Count</h3>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Caries Indicated for Filling (T):</span>
                                <input type="number" maxlength="2" class="form-control" name="ciff_t" id="ciff_t">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Caries Indicated for Filling (P):</span>
                                <input type="number" maxlength="2" class="form-control" name="ciff_p" id="ciff_p">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Caries Indicated for Extraction (T):</span>
                                <input type="number" maxlength="2" class="form-control" name="cife_t" id="cife_t">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Caries Indicated for Extraction (P):</span>
                                <input type="number" maxlength="2" class="form-control" name="cife_p" id="cife_p">
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Root Fragment (T):</span>
                                <input type="number" maxlength="2" class="form-control" name="rf_t" id="rf_t">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Root Fragment (P):</span>
                                <input type="number" maxlength="2" class="form-control" name="rf_p" id="rf_p">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Filled or Restored (T):</span>
                                <input type="number" maxlength="2" class="form-control" name="for_t" id="for_t">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Filled or Restored (P):</span>
                                <input type="number" maxlength="2" class="form-control" name="for_p" id="for_p">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Total DMF & df (T):</span>
                                <input type="number" maxlength="2" class="form-control" name="tdmfdf_t" id="tdmfdf_t">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Total DMF & df (P):</span>
                                <input type="number" maxlength="2" class="form-control" name="tdmfdf_p" id="tdmfdf_p">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Missing Due to Caries (P):</span>
                                <input type="number" maxlength="2" class="form-control" name="mdtc_p" id="mdtc_p">
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="input-group input-group-md mb-2">
                                <span class="input-group-text" id="inputGroup-sizing-md">Fluoride Application:</span>
                                <input type="text" maxlength="4" class="form-control" name="fa" id="fa">
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
                                <option value="<?= $row['medcase']; ?>"><?= "(" . ucfirst(strtolower( $row['type'])) . ") " . $row['medcase']; ?></option>
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
                        <input type="text"  class="form-control"  name="service" value="Dental Checkup" hidden>
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