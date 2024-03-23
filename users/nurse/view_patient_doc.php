<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'medical';
$patientid = $_REQUEST['patientid'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM patient_info WHERE patientid='$patientid'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php')
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Patient Information</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL DOCUMENT</span>
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
                                echo $name ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="usertype"><?= $usertype ?></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
                    <?php
                    $sql = "SELECT p.patientid, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid WHERE patientid='$patientid'";
                    $result = mysqli_query($conn, $sql);
                    while ($data = mysqli_fetch_array($result)) {
                        if (count(explode(" ", $data['middlename'])) > 1) {
                            $middle = explode(" ", $data['middlename']);
                            $letter = $middle[0][0] . $middle[1][0];
                            $middleinitial = $letter . ".";
                        } else {
                            $middle = $data['middlename'];
                            if ($middle == "" or $middle == " ") {
                                $middleinitial = "";
                            } else {
                                $middleinitial = substr($middle, 0, 1) . ".";
                            }
                        }
                        if ($data['designation'] != 'STUDENT') {
                            $pys = "N/A";
                        } else {
                            $pys = $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'];
                        }
                        $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($data['lastname']));
                        $designation = $data['designation'];
                        $sex = $data['sex'];
                        $birthday = $data['birthday'];
                        $department = $data['department'];
                        $campus = $data['campus'];
                        $college = $data['college'];
                        $email = $data['email'];
                        $contactno = $data['contactno'];
                        $emcon_name = $data['emcon_name'];
                        $emcon_number = $data['emcon_number'];
                    ?>

                        <div class="d-flex justify-content-end">
                            <div class="mb-2">
                                <button type="button" class="btn btn-primary" onclick="window.open('reports/reports_medcert.php?patientid=<?php echo $patientid ?>');" target="_blank">Export Medical Certificate</button>
                            </div>
                            <div class="mb-2 ms-2">
                                <?php
                                if (strtoupper($designation) != 'STUDENT') { ?>
                                    <button type="button" class="btn btn-primary" hidden>Export Clearance Slip</button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#medclear<?php echo $patientid; ?>">Export Clearance Slip</button>
                                <?php include('modals/medclear_modal.php');
                                } ?>
                            </div>
                        </div>

                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        <h5>Personal Information</h5>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Patient ID:</span>
                                                    <input type="text" class="form-control" name="patientname" value="<?php echo $patientid ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Patient Name:</span>
                                                    <input type="text" class="form-control" name="patientname" value="<?php echo $fullname ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                                                    <input type="text" class="form-control" name="designation" value="<?php echo $designation ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                                    <input type="text" class="form-control" name="sex" value="<?php echo $sex ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Birthday:</span>
                                                    <input type="text" class="form-control" name="birthday" value="<?php echo date("F d, Y", strtotime($birthday)) ?>" readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                        <h5>Academic Information</h5>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                                    <input type="text" class="form-control" name="department" value="<?php echo $department ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">College:</span>
                                                    <input type="text" class="form-control" name="college" value="<?php echo $college ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Program, Year and Section:</span>
                                                    <input type="text" class="form-control" name="pys" value="<?php echo $pys ?>" readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <h5>Contact Information</h5>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Email Address:</span>
                                                    <input type="text" class="form-control" name="email" value="<?php echo $email ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Contact Number:</span>
                                                    <input type="text" class="form-control" name="contactno" value="<?php echo $contactno ?>" readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                        <h5>Emergency Information</h5>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Name:</span>
                                                    <input type="text" class="form-control" name="emcon_name" value="<?php echo $emcon_name ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Contact Number:</span>
                                                    <input type="text" class="form-control" name="emcon_number" value="<?php echo $emcon_number ?>" readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
                include('medical-doc.php');
                ?>
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