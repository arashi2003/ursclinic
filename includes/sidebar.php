<!-- NURSE SIDEBAR -->
<?php if ($_SESSION['usertype'] == "NURSE") : ?>

    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bx-clinic'></i>
            <span class="logo_name"><strong>URS</strong> Health Service Unit</span>
        </div>
        <ul class="nav-links">
            <li class="<?php if ($module == 'dashboard') {
                            echo 'active showMenu';
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
                            echo 'active showMenu';
                        } ?>">
                <a href="appointment?tab=pending">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'patient_add' or $module == 'view_patient') {
                            echo 'active showMenu';
                        } ?>">
                <a href="patients">
                    <i class='bx bx-id-card'></i>
                    <span class="link_name">Patient Information</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Patient Information</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'transaction_history') {
                            echo 'active showMenu';
                        } ?>">
                <a href="transaction_history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Transaction</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Transaction</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'medical') {
                            echo 'active showMenu';
                        } ?>">
                <a href="med_doc">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Medical Documents</span>
                </a>
            </li>
            <li class="<?php if ($module == 'entry' or $module == 'stocks' or $module == 'med_entry' or  $module == 'sup_entry' or $module == 'te_entry' or $module == 'med_stocks_total' or $module == 'med_stocks' or $module == 'sup_stocks_total' or $module == 'sup_stocks_batch' or $module == 'med_stocks_batch' or $module == 'sup_stocks_exp' or $module == 'te_stocks') {
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

                    <li>
                        <a class="<?php if ($module == 'entry' or $module == 'med_entry' or  $module == 'sup_entry' or $module == 'te_entry') {
                                        echo 'active showMenu';
                                    } ?>" href="entry">Entry</a>
                    </li>

                    <li>
                        <a class="<?php if ($module == 'stocks' or $module == 'med_stocks_total' or $module == 'med_stocks_batch' or $module == 'med_stocks' or $module == 'sup_stocks_total' or $module == 'sup_stocks_exp' or $module == 'sup_stocks_batch' or $module == 'te_stocks') {
                                        echo 'active showMenu';
                                    } ?>" href="stocks">Stocks</a>
                    </li>
                </ul>
            </li>
            <li class="<?php if ($module == 'reports' or $module == 'reports_appointment' or $module == 'report_doc_visit' or $module == 'reports_transaction' or $module == 'reports_medcase' or $module == 'reports_medinv' or $module == 'reports_supinv' or $module == 'reports_teinv' or $module == 'reports_tecalimain') {
                            echo 'active showMenu';
                        } ?>">
                <a href="reports.php">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Reports</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Reports</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'app' or $module == 'apptype_set' or $module == 'apppurpose_set' or $module == 'appcc_set' or $module == 'medrec' or $module == 'chiefcomplaint' or $module == 'findings' or $module == 'medcase' or $module == 'designation' or $module == 'inv' or $module == 'medadmin_set' or $module == 'dform_set' or $module == 'umeasure_set') {
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
                    <li>
                        <a class="<?php if ($module == 'app' or $module == 'apptype_set' or $module == 'apppurpose_set' or $module == 'appcc_set' or $module == 'appphysician_set') {
                                        echo 'active showMenu';
                                    } ?>" href="app">Appointment</a>
                    </li>
                    <li>
                        <a class="<?php if ($module == 'medrec' or $module == 'chiefcomplaint' or $module == 'findings' or $module == 'medcase' or $module == 'designation') {
                                        echo 'active showMenu';
                                    } ?>" href="medrec">Medical Record</a>
                    </li>
                    <li>
                        <a class="<?php if ($module == 'inv' or $module == 'medadmin_set' or $module == 'dform_set' or $module == 'umeasure_set') {
                                        echo 'active showMenu';
                                    } ?>" href="inv">Inventory</a>
                    </li>
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
                        } ?>">
                <a href="medical">
                    <i class='bx bx-folder'></i>
                    <span class="link_name">Medical Document</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="medical">Medical Document</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'history') {
                            echo 'active showMenu';
                        } ?>">
                <a href="history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Transaction</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="history">Transaction</a></li>
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
                        } ?>">
                <a href="appointment">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'patients' || $module == 'view_patient') {
                            echo 'active showMenu';
                        } ?>">
                <a href="patients">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Patient Information</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="patients">Patient Information</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'transaction_history' || $module == 'transaction_dental_consultation') {
                            echo 'active showMenu';
                        } ?>">
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Dental Record</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Dental Record</a></li>

                    <li>
                        <a class="<?php if ($module == 'transaction_dental_consultation') {
                                        echo 'active showMenu';
                                    } ?>" href="transaction_dental_consultation">Record</a>
                    </li>

                    <li>
                        <a class="<?php if ($module == 'transaction_history') {
                                        echo 'active showMenu';
                                    } ?>" href="transaction_history">History</a>
                    </li>
                </ul>
            </li>
            <li class="<?php if ($module == 'patientinfo') {
                            echo 'active showMenu';
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
                            echo 'active showMenu';
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
                            echo 'active showMenu';
                        } ?>">
                <a href="appointment">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'patients' or $module == 'view_patient') {
                            echo 'active showMenu';
                        } ?>">
                <a href="patients">
                    <i class='bx bx-id-card'></i>
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
                    <li <?php if ($module == 'transaction_add') {
                            echo 'active showMenu';
                        } ?>>
                        <a href="transaction_add">Add Transaction</a>
                    </li>
                    <li <?php if ($module == 'transaction_history') {
                            echo 'active showMenu';
                        } ?>>
                        <a href="transaction_history">Transaction History</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
<?php endif ?>