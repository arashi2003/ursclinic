<!-- NURSE SIDEBAR -->
<?php 
date_default_timezone_set("Asia/Manila");
if ($_SESSION['usertype'] == "NURSE") : ?>

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
                <a href="appointment?tab=pending">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Appointment</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Appointment</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'patient_add' or $module == 'view_patient') {
                            echo 'active';
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
                            echo 'active';
                        } ?>">
                <a href="transaction_history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Medical Records</a></li>
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
                        <a class="<?php if ($module == 'stocks' or $module == 'med_stocks_total' or $module == 'med_stocks_batch' or $module == 'med_stocks' or $module == 'sup_stocks_total' or $module == 'sup_stocks_exp' or $module == 'sup_stocks_batch' or $module == 'te_stocks') {
                                        echo 'active showMenu';
                                    } ?>" href="med_stocks_total">Stocks</a>
                    </li>
                    <li>
                        <a class="<?php if ($module == 'entry' or $module == 'med_entry' or  $module == 'sup_entry' or $module == 'te_entry') {
                                        echo 'active showMenu';
                                    } ?>" href="med_entry">Entry</a>
                    </li>
                </ul>
            </li>
            <li class="<?php if ($module == 'reports' or $module == 'reports_appointment' or $module == 'report_doc_visit' or $module == 'reports_transaction' or $module == 'reports_medcase' or $module == 'reports_medinv' or $module == 'reports_supinv' or $module == 'reports_teinv' or $module == 'reports_tecalimain') {
                            echo 'active';
                        } ?>">
                <a href="reports_appointment">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Reports</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Reports</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'app' or $module == 'apptype_set' or $module == 'apppurpose_set' or $module == 'transaction_set' or $module == 'appcc_set' or $module == 'appphysician_set' or $module == 'medrec' or $module == 'chiefcomplaint' or $module == 'findings' or $module == 'medcase' or $module == 'designation' or $module == 'inv' or $module == 'medadmin_set' or $module == 'dform_set' or $module == 'umeasure_set') {
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
                                        echo 'active';
                                    } ?>" href="apptype_set">Appointment</a>
                    </li>
                    <li>
                        <a class="<?php if ($module == 'medrec' or $module == 'chiefcomplaint' or $module == 'transaction_set' or $module == 'findings' or $module == 'medcase' or $module == 'designation') {
                                        echo 'active';
                                    } ?>" href="chiefcomplaint">Medical Records</a>
                    </li>
                    <li>
                        <a class="<?php if ($module == 'inv' or $module == 'medadmin_set' or $module == 'dform_set' or $module == 'umeasure_set') {
                                        echo 'active';
                                    } ?>" href="medadmin_set">Inventory</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>


    <!-- STUDENT SIDEBAR: COLLEGE -->
<?php elseif ($_SESSION['usertype'] == "STUDENT" && $_SESSION['department'] == 'COLLEGE' && $_SESSION['status'] != 'ALUMNUS') : ?>

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
            <li class="<?php if ($module == 'history') {
                            echo 'active';
                        } ?>">
                <a href="history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="history">Medical Records</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- STUDENT SIDEBAR: JHS, ELEM, SHS -->
<?php elseif ($_SESSION['usertype'] == "STUDENT" && $_SESSION['department'] != 'COLLEGE') : ?>

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
            <li class="<?php if ($module == 'history') {
                            echo 'active';
                        } ?>">
                <a href="history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="history">Medical Records</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- STUDENT SIDEBAR: ALUMNUS -->
<?php elseif ($_SESSION['status'] == 'ALUMNUS') : ?>

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
            <li class="<?php if ($module == 'history') {
                            echo 'active';
                        } ?>">
                <a href="history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="history">Medical Records</a></li>
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
            <li class="<?php if ($module == 'history') {
                            echo 'active';
                        } ?>">
                <a href="history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="history">Medical Records</a></li>
                </ul>
            </li>
        </ul>
    </div>


    <!-- STAFF SIDEBAR -->
<?php elseif ($_SESSION['usertype'] == "STAFF") : ?>

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
            <li class="<?php if ($module == 'history') {
                            echo 'active';
                        } ?>">
                <a href="history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="history">Medical Records</a></li>
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
                    <i class='bx bx-user'></i>
                    <span class="link_name">Accounts</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="account_users">Accounts</a></li>
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
                    <li><a class="link_name" href="patients">Patient Information</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'audittrail') {
                            echo 'active';
                        } ?>">
                <a href="audittrail">
                    <i class='bx bxs-report'></i>
                    <span class="link_name">Audit Trail</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="reports">Audit Trail</a></li>
                </ul>
            </li>
            <li class="<?php if ($module == 'campus' || $module == 'department' || $module == 'college' || $module == 'program' || $module == 'yearlevel' || $module == 'organization' || $module == 'buar') {
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
                    <li><a href="campus" class="<?php if ($module == 'campus') {
                                                    echo 'active';
                                                } ?>">Campus</a></li>
                    <li><a href="department" class="<?php if ($module == 'department') {
                                                        echo 'active';
                                                    } ?>">Department</a></li>
                    <li><a href="college" class="<?php if ($module == 'college') {
                                                        echo 'active';
                                                    } ?>">College</a></li>
                    <li><a href="program" class="<?php if ($module == 'program') {
                                                        echo 'active';
                                                    } ?>">Program</a></li>
                    <li><a href="yearlevel" class="<?php if ($module == 'yearlevel') {
                                                        echo 'active';
                                                    } ?>">Year Level</a></li>
                    <li><a href="organization" class="<?php if ($module == 'organization') {
                                                            echo 'active';
                                                        } ?>">Organization</a></li>
                    <li><a href="buar" class="<?php if ($module == 'buar') {
                                                    echo 'active';
                                                } ?>">Backup</a></li>
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
            <li class="<?php if ($module == 'patients' || $module == 'view_patient') {
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
            <li class="<?php if ($module == 'transaction_history' || $module == 'dental_consultation' || $module == 'dental_checkup') {
                            echo 'active showMenu';
                        } ?>">
                <div class="icon-link">
                    <a href="#">
                        <i class='bx bx-collection'></i>
                        <span class="link_name">Dental</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="#">Dental</a></li>

                    <li>
                        <a class="<?php if ($module == 'dental_consultation') {
                                        echo 'active';
                                    } ?>" href="transaction_dental_consultation">Record</a>
                    </li>

                    <li>
                        <a class="<?php if ($module == 'transaction_history') {
                                        echo 'active';
                                    } ?>" href="transaction_history">History</a>
                    </li>
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
            <li class="<?php if ($module == 'patient_add' or $module == 'view_patient') {
                            echo 'active';
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
                            echo 'active';
                        } ?>">
                <a href="transaction_history">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Medical Records</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Medical Records</a></li>
                </ul>
            </li>
        </ul>
    </div>
<?php endif ?>