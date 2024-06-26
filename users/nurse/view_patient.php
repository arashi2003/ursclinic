<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');

$module = 'view_patient';
$patientid = $_REQUEST['patientid'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$campus = $_SESSION['campus'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM transaction_history WHERE (transaction LIKE '%Medical History%' or transaction LIKE '%Vitals%' OR purpose LIKE '%Medical History%' OR purpose LIKE '%Vitals%') AND patient='$patientid' ORDER BY datetime ");
$nr_of_rows = $records->num_rows;

// Setting the number of rows to display in a page.
$rows_per_page = 5;

// determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from, value.
$start = ($page - 1) * $rows_per_page;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);

// calculate the range of page numbers to be displayed
$start_loop = max(1, $page - 2);
$end_loop = min($pages, $page + 2);

// adjust the range if the current page is near the beginning or end
if ($start_loop > 1) {
    $start_loop--;
    $end_loop++;
}

// ensure that the range is never smaller than 4
if ($end_loop - $start_loop < 4) {
    $start_loop = max(1, $end_loop - 4);
}

$previous = $page - 1;
$next = $page + 1;

// calculate the start and end loop variables
$start_loop = $page > 2 ? $page - 2 : 1;
$end_loop = $page < $pages - 2 ? $page + 2 : $pages;

// limit the number of pages displayed to a maximum of 4
if ($pages > 4) {
    if ($page > 2 && $page < $pages - 1) {
        $end_loop = $page + 1;
    } elseif ($page == 1) {
        $start_loop = 1;
        $end_loop = 4;
    } elseif ($page == $pages) {
        $start_loop = $pages - 3;
        $end_loop = $pages;
    }
}

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
                <span class="dashboard">PATIENT INFORMATION</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.usertype, ac.lastname, ac.campus, i.image FROM audit_trail au INNER JOIN account ac ON ac.accountid = au.user INNER JOIN patient_image i ON i.patient_id = au.user WHERE ((au.activity LIKE '%added a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE '%uploaded%'  AND au.campus ='$campus') OR (au.activity LIKE '%cancelled a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE 'sent%' AND au.campus ='$campus') OR (au.activity LIKE 'cancelled%' AND au.campus ='$campus') OR (au.activity LIKE 'uploaded medical document%' AND au.campus ='$campus') OR (au.activity LIKE '%expired%' AND au.campus ='$campus')) AND au.status='unread' AND au.user != '$userid' ORDER BY au.datetime DESC";
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
            <div class="profile">
                <div class="profile-pic box">
                    <?php
                    $image = "SELECT * FROM patient_image WHERE patient_id = '$patientid'";
                    $result = mysqli_query($conn, $image);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="upload">
                        <img src="../../images/<?php echo $row['image']; ?>" id="image">
                    </div>
                </div>
                <div class="profile-info box">
                    <?php
                    $sql = "SELECT p.patientid, p.designation, p.address, p.sex, p.birthday, p.block, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid WHERE patientid='$patientid'";
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
                            $pys = $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'] . $data['block'];
                        }
                        $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($data['lastname']));
                        $designation = $data['designation'];
                        $age = floor((time() - strtotime($data['birthday'])) / 31556926);
                        $sex = $data['sex'];
                        $birthday = $data['birthday'];
                        $department = $data['department'];
                        $campus = $data['campus'];
                        $college = $data['college'];
                        $email = $data['email'];
                        $contactno = $data['contactno'];
                        $emcon_name = $data['emcon_name'];
                        $emcon_number = $data['emcon_number'];
                        $address = $data['address'];
                    ?>
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
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Patient ID:</span>
                                                    <input type="text" class="form-control" name="patientname" value="<?php echo $patientid ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Patient Name:</span>
                                                    <input type="text" class="form-control" name="patientname" value="<?php echo $fullname ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                                                    <input type="text" class="form-control" name="designation" value="<?php echo $designation ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Age:</span>
                                                    <input type="text" class="form-control" name="age" value="<?php echo $age ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                                    <input type="text" class="form-control" name="sex" value="<?php echo $sex ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Birthday:</span>
                                                    <input type="text" class="form-control" name="birthday" value="<?php echo date("F d, Y", strtotime($birthday)) ?>" readonly disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-2">
                                                <div class="input-group input-group-md mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-md">Address:</span>
                                                    <input type="text" class="form-control" name="birthday" value="<?php echo $address ?>" readonly disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($designation == "STUDENT" && $designation != "FACULTY" && $designation != "STAFF") { ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            <h5>Academic Information</h5>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <div class="input-group input-group-md mb-2">
                                                        <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                                        <input type="text" class="form-control" name="department" value="<?php echo $department ?>" readonly disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <div class="input-group input-group-md mb-2">
                                                        <span class="input-group-text" id="inputGroup-sizing-md">College:</span>
                                                        <input type="text" class="form-control" name="college" value="<?php echo $college ?>" readonly disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <div class="input-group input-group-md mb-2">
                                                        <span class="input-group-text" id="inputGroup-sizing-md">Program, Year and Section:</span>
                                                        <input type="text" class="form-control" name="pys" value="<?php echo $pys ?>" readonly disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($designation == "FACULTY" && $designation != "STUDENT" && $designation != "STAFF") { ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                            <h5>Academic Information</h5>
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <div class="input-group input-group-md mb-2">
                                                        <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                                        <input type="text" class="form-control" name="department" value="<?php echo $department ?>" readonly disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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
            </div>
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="head">
                                        <tr>
                                            <th>Type of Transaction</th>
                                            <th>Service</th>
                                            <th>Date and Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM transaction_history WHERE (transaction LIKE '%Medical History%' OR transaction LIKE '%Vitals%' OR purpose LIKE '%Medical History%' OR purpose LIKE '%Vitals%') AND patient='$patientid' ORDER BY datetime DESC LIMIT $start, $rows_per_page";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            if ($row = mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                                    $id = $data['patient'];
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
                                                    $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));
                                        ?>
                                                    <tr>
                                                        <td><?= $data['transaction'] ?></td>
                                                        <td><?= $data['purpose'] ?></td>
                                                        <td><?= date("M. d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime'])) ?></td>
                                                        <td>
                                                            <?php
                                                            if ($data['purpose'] == 'Dental Checkup') { ?>
                                                                <button type="button" class="btn btn-primary btn-sm" onclick="window.open('reports/reports_dentalform.php?id=<?= $id ?>')" target="_blank">Expand</button>
                                                            <?php } else { ?>
                                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewtrans<?php echo $data['id']; ?>">Expand</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    if ($data['purpose'] == 'Vitals') {
                                                        include('modals/view_trans_vitals_modal.php');
                                                    } elseif ($data['purpose'] == 'Medical History') {
                                                        include('modals/view_trans_medhist_modal.php');
                                                    }
                                                }
                                                ?>
                                            <?php
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <?php
                                                        include('../../includes/no-data.php');
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        <?php }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                ?>
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="view_patient?patientid=<?php echo $patientid ?>&page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="view_patient?patientid=<?php echo $patientid ?>&page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="view_patient?patientid=<?php echo $patientid ?>&page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="view_patient?patientid=<?php echo $patientid ?>&page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="view_patient?patientid=<?php echo $patientid ?>&page=<?= $pages; ?>">&raquo;</a>
                                        </li>
                                    </ul>
                                <?php
                                }
                                ?>
                            </div>
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