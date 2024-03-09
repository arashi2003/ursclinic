<!-- NURSE SIDEBAR -->
<?php if ($_SESSION['usertype'] == "NURSE") : ?>

    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bx-clinic'></i>
            <span class="logo_name"><strong>URS</strong> Health Service Unit</span>
        </div>
        <ul class="nav-links">
            <li class="<?php if ($module == 'dashboard') {
                            echo 'active';
                        } ?>">
                <a href="dashboard">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="dashboard">Dashboard</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'appointment') {
                            echo 'active';
                        } ?>">
                <a href="appointment">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'patients') {
                            echo 'active';
                        } ?>">
                <a href="patients">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Patient Information</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Patient Information</a></li>
                </ul>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Transaction</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Transaction</a></li>
                    <li>
                    <a href="transaction_add">Add Transaction</a></li>
                    <li <?php if ($module == 'transaction_history') {
                        echo 'active';
                    } ?>>
                    <a href="transaction_history">Transaction History</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Medical Documents</span>
                </a>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-box'></i>
                        <span class="link_name">Inventory</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Inventory</a></li>

                    <li class="<?php if ($module == 'entry') {
                            echo 'active';
                        } ?>">
                    <a href="entry">Entry</a></li>

                    <li class="<?php if ($module == 'stocks') {
                            echo 'active';
                        } ?>">
                    <a href="stocks">Stocks</a></li>
                </ul>
            </li>
            <li>
                <a href="reports.php">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Reports</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Reports</a></li>
                </ul>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li <?php if ($module == 'app') {
                            echo 'active';
                        } ?>>
                    <a href="app">Appointment</a></li>
                    <li <?php if ($module == 'medrec') {
                            echo 'active';
                        } ?>>
                    <a href="medrec">Medical Record</a></li>
                    <li <?php if ($module == 'inv') {
                            echo 'active';
                        } ?>>
                    <a href="inv">Inventory</a></li>
                </ul>
            </li>
        </ul>
    </div>


    <!-- STUDENT SIDEBAR -->
<?php elseif ($_SESSION['usertype'] == "STUDENT") : ?>

    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bx-clinic'></i>
            <span class="logo_name"><strong>URS</strong> Health Service</span>
        </div>
        <ul class="nav-links">
            <li class="<?php if ($module == 'appointment') {
                            echo 'active';
                        } ?>">
                <a href="appointment">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="appointment">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'profile') {
                            echo 'active';
                        } ?>">
                <a href="profile">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Profile Information</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="profile">Profile Information</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'medical') {
                            echo 'active';
                        } ?>">
                <a href="medical">
                    <i class='bx bx-folder'></i>
                    <span class="link_name">Medical Document</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="medical">Medical Document</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'transaction') {
                            echo 'active';
                        } ?>">
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Transaction</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Transaction</a></li>
                    <li><a href="request">Request</a></li>
                    <li><a href="history">History</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- FACULTY SIDEBAR -->
<?php elseif ($_SESSION['usertype'] == "FACULTY") : ?>

    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bx-clinic'></i>
            <span class="logo_name"><strong>URS</strong> Health Service</span>
        </div>
        <ul class="nav-links">
            <li class="<?php if ($module == 'appointment') {
                            echo 'active';
                        } ?>">
                <a href="appointment">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="appointment">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'profile') {
                            echo 'active';
                        } ?>">
                <a href="profile">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Profile Information</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="profile">Profile Information</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'transaction') {
                            echo 'active';
                        } ?>">
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Transaction</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Transaction</a></li>
                    <li><a href="request">Request</a></li>
                    <li><a href="history">History</a></li>
                </ul>
            </li>
        </ul>
    </div>

<!-- ADMIN SIDEBAR -->
<?php elseif ($_SESSION['usertype'] == "ADMIN") : ?>

<div class="sidebar">
    <div class="logo-details">
        <i class='bx bx-clinic'></i>
        <span class="logo_name"><strong>URS</strong> Health Service</span>
    </div>
    <ul class="nav-links">
        <li class="<?php if ($module == 'account_users') {
                        echo 'active';
                    } ?>">
            <a href="account_users">
                <i class='bx bx-file'></i>
                <span class="link_name">Accounts</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="account_users">Accounts</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'patients') {
                        echo 'active';
                    } ?>">
            <a href="patients">
                <i class='bx bx-file'></i>
                <span class="link_name">Patient Information</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="patients">Patient Information</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'audittrail') {
                        echo 'active';
                    } ?>">
            <a href="audittrail.php">
                <i class='bx bxs-report'></i>
                <span class="link_name">Audit Trail</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="reports">Audit Trail</a></li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-cog'></i>
                    <span class="link_name">Settings</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a href="campus">Campus</a></li>
                <li><a href="department">Department</a></li>
                <li><a href="college">College</a></li>
                <li><a href="program">Program</a></li>
                <li><a href="yearlevel">Year Level</a></li>
                <li><a href="organization">Organization</a></li>
                <li><a href="buar">Backup and Restore</a></li>
            </ul>
        </li>
    </ul>
</div>

<?php elseif ($_SESSION['usertype'] == "DENTIST") : ?>

<div class="sidebar">
    <div class="logo-details">
        <i class='bx bx-clinic'></i>
        <span class="logo_name"><strong>URS</strong> Health Service</span>
    </div>
    <ul class="nav-links">
        <li class="<?php if ($module == 'dashboard') {
                        echo 'active';
                    } ?>">
            <a href="dashboard">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="dashboard">Dashboard</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'appointment') {
                        echo 'active';
                    } ?>">
            <a href="appointment">
                <i class='bx bx-calendar'></i>
                <span class="link_name">Appointment</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Appointment</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'patientinfo') {
                        echo 'active';
                    } ?>">
            <a href="patientinfo">
                <i class='bx bx-file'></i>
                <span class="link_name">Patient Information</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="patientinfo">Patient Information</a></li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Transaction</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Transaction</a></li>
                <li <?php if ($module == 'transaction_add') {
                        echo 'active';
                    } ?>>
                <a href="transaction_add">Add Transaction</a></li>
                <li><a href="#">Transaction History</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'patientinfo') {
                        echo 'active';
                    } ?>">
            <a href="patientinfo">
                <i class='bx bx-file'></i>
                <span class="link_name">Patient Information</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="patientinfo">Patient Information</a></li>
            </ul>
        </li>
    </ul>
</div>

<?php elseif ($_SESSION['usertype'] == "DOCTOR") : ?>

<div class="sidebar">
    <div class="logo-details">
        <i class='bx bx-clinic'></i>
        <span class="logo_name"><strong>URS</strong> Health Service</span>
    </div>
    <ul class="nav-links">
        <li class="<?php if ($module == 'dashboard') {
                        echo 'active';
                    } ?>">
            <a href="dashboard">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Dashboard</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="dashboard">Dashboard</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'appointment') {
                        echo 'active';
                    } ?>">
            <a href="appointment">
                <i class='bx bx-calendar'></i>
                <span class="link_name">Appointment</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Appointment</a></li>
            </ul>
        </li>
        <li class="<?php if ($module == 'patientinfo') {
                        echo 'active';
                    } ?>">
            <a href="patientinfo">
                <i class='bx bx-file'></i>
                <span class="link_name">Patient Information</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="patientinfo">Patient Information</a></li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Transaction</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Transaction</a></li>
                <li <?php if ($module == 'transaction_add') {
                        echo 'active';
                    } ?>>
                <a href="transaction_add">Add Transaction</a></li>
                <li <?php if ($module == 'transaction_history') {
                        echo 'active';
                    } ?>>
                <a href="transaction_history">Transaction History</a></li>
            </ul>
        </li>
    </ul>
</div>
<?php endif ?>