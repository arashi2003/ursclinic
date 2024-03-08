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
            <li class="<?php if ($module == 'patient_add') {
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
                    <li><a href="transaction_add">Add Transaction</a></li>
                    <li><a href="#">Transaction History</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'medical') {
                            echo 'active';
                        } ?>">
                <a href="med_doc">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Medical Documents</span>
                </a>
            </li>
            <li class="<?php if ($module == 'med_entry' or  $module == 'sup_entry' or $module == 'te_entry' or $module == 'med_stocks_total' or $module == 'sup_stocks_total' or $module == 'te_stocks') {
                            echo 'active showMenu';
                        } ?>">
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-box'></i>
                        <span class="link_name">Inventory</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Inventory</a></li>
                    <li><a class="<?php if ($module == 'med_entry') {
                                        echo 'active';
                                    } ?>" href="med_entry">Medicine Entry</a></li>
                    <li><a class="<?php if ($module == 'sup_entry') {
                                        echo 'active';
                                    } ?>" href="sup_entry">Supply Entry</a></li>
                    <li><a class="<?php if ($module == 'te_entry') {
                                        echo 'active';
                                    } ?>" href="te_entry">Tools and Equipment Entry</a></li>
                    <li><a class="<?php if ($module == 'med_stocks_total') {
                                        echo 'active';
                                    } ?>" href="med_stocks_total">Medicine Stocks</a></li>
                    <li><a class="<?php if ($module == 'sup_stocks_total') {
                                        echo 'active';
                                    } ?>" href="sup_stocks_total">Supply Stocks</a></li>
                    <li><a class="<?php if ($module == 'te_stocks') {
                                        echo 'active';
                                    } ?>" href="te_stocks">Tools and Equipment Stocks</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'reports') {
                            echo 'active';
                        } ?>">
                <a href="reports.php">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Reports</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Reports</a></li>
                </ul>
            </li>

            <li class="<?php if ($module == 'apptype_set' or $module == 'apppurpose_set' or $module == 'appcc_set' or $module == 'chiefcomplaint' or $module == 'findings' or $module == 'medcase' or $module == 'designation' or $module == 'medadmin_set' or $module == 'dform_set' or $module == 'umeasure_set') {
                            echo 'active showMenu';
                        } ?>">
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-cog'></i>
                        <span class="link_name">Settings</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="<?php if ($module == 'apptype_set') {
                                        echo 'active';
                                    } ?>" href="apptype_set">Appointment Type</a></li>
                    <li><a class="<?php if ($module == 'apppurpose_set') {
                                        echo 'active';
                                    } ?>" href="apppurpose_set">Appointment Purpose</a></li>
                    <li><a class="<?php if ($module == 'appcc_set') {
                                        echo 'active';
                                    } ?>" href="appcc_set">Appointment Chief Complaint</a></li>
                    <li><a class="<?php if ($module == 'chiefcomplaint') {
                                        echo 'active';
                                    } ?>" href="chiefcomplaint">Chief Complaint</a></li>
                    <li><a class="<?php if ($module == 'findings') {
                                        echo 'active';
                                    } ?>" href="findings">Findings/Diagnosis</a></li>
                    <li><a class="<?php if ($module == 'medcase') {
                                        echo 'active';
                                    } ?>" href="medcase_set">Medical Cases</a></li>
                    <li><a class="<?php if ($module == 'designation') {
                                        echo 'active';
                                    } ?>" href="designation">Designation</a></li>
                    <li><a class="<?php if ($module == 'medadmin_set') {
                                        echo 'active';
                                    } ?>" href="medadmin_set">Medical Administration</a></li>
                    <li><a class="<?php if ($module == 'dform_set') {
                                        echo 'active';
                                    } ?>" href="dform_set">Dosage Form</a></li>
                    <li><a class="<?php if ($module == 'umeasure_set') {
                                        echo 'active';
                                    } ?>" href="umeasure_set">Unit Measure</a></li>
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
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bxs-user-account'></i>
                        <span class="link_name">User Accounts</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li <?php if ($module == 'account_add') {
                            echo 'active';
                        } ?>>
                        <a href="account_add">Add Account</a>
                    </li>
                    <li <?php if ($module == 'account_users') {
                            echo 'active';
                        } ?>>
                        <a href="account_users">Accounts</a>
                    </li>
                </ul>
            </li>
            <li>
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-file'></i>
                        <span class="link_name">Patient Information</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li <?php if ($module == 'patient_add') {
                            echo 'active';
                        } ?>>
                        <a href="patient_add">Add Patient</a>
                    </li>
                    <li <?php if ($module == 'patients') {
                            echo 'active';
                        } ?>>
                        <a href="patients">Patients</a>
                    </li>
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
                        <a href="transaction_add">Add Transaction</a>
                    </li>
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
                        <a href="transaction_add">Add Transaction</a>
                    </li>
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
<?php endif ?>

<script>

</script>