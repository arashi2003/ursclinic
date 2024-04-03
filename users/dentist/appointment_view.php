<?php

session_start();
include('../../connection.php');
include('../../includes/dentist-auth.php');

$module = 'appointment_view';
$id = $_REQUEST['id'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

$sql = "SELECT * FROM appointment WHERE id='$id'";
$result = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($result)) {
    $patientid = $data['patient'];
    $date = $data['date'];
    $time_from = $data['time_from'];
    $time_to = $data['time_to'];
    $cc = $data['chiefcomplaint'] . " " . $data['others'];
}
// get the total nr of rows.
$records = $conn->query("SELECT * FROM transaction_history WHERE patient='$patientid' ORDER BY datetime ");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Appointment</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">RECORD APPOINTMENT</span>
            </div>
            <div class="right-nav">
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
                <div class="overview-boxes">
                    <form method="POST" action="add/appointment_dental_consultation.php" id="form">
                        <?php
                        $sql = "SELECT p.patientid, p.address, p.designation, p.sex, p.birthday, p.department, p.college, p.program, p.yearlevel, p.section, p.email, p.contactno, p.emcon_name, p.emcon_number, ac.firstname, ac.middlename, ac.lastname, ac.campus FROM patient_info p INNER JOIN account ac on ac.accountid=p.patientid WHERE patientid='$patientid'";
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
                            <div class="content">
                                <h3><b>Patient Information</b></h3>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Appointment ID:</span>
                                            <input type="text" class="form-control" value="<?= $id ?>" name="id" id="id" hidden>
                                            <input type="text" class="form-control" value="<?= $id ?>" name="id" id="id" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Date:</span>
                                            <input type="text" class="form-control" value="<?= date("F d, Y", strtotime($date)) ?>" name="datetime" id="datetime" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Date:</span>
                                            <input type="text" class="form-control" value="<?= date("g:i A", strtotime($time_from)) . "-" . date("g:i A", strtotime($time_to)) ?>" name="datetime" id="datetime" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Patient Name:</span>
                                            <input type="text" class="form-control" value="<?= $fullname ?>" name="fullname" id="fullname" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                                            <input type="text" class="form-control" value="<?= $designation ?>" name="age" id="age" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Age:</span>
                                            <input type="text" class="form-control" value="<?= $age ?>" name="age" id="age" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                            <input type="text" class="form-control" value="<?= $sex ?>" name="sex" id="sex" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Civil Status:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="civil_status" id="civil_status" required>
                                                <option value="" disabled selected></option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Widowed">Widowed</option>
                                                <option value="Legally Separated">Legally Separated</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Emergency Contact Name:</span>
                                            <input type="text" class="form-control" value="<?= $emcon_name ?>" name="emcon_name" id="emcon_name" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Emergency Contact Number:</span>
                                            <input type="text" class="form-control" value="<?= $emcon_number ?>" name="emcon_number" id="emcon_number" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Chief Complaint/s:</span>
                                            <input type="text" class="form-control" value="<?= $cc?>" name="chief_complaint" id="chief_complaint" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row duplicate_treat">
                                    <div class="col-md-3 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Tooth Number:</span>
                                            <input type="number" min="0" maxlength="2" class="form-control" name="toothno[]" id="toothno">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Diagnosis:</span>
                                            <input type="text" maxlength="20" class="form-control" name="diagnosis[]" id="diagnosis">
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Treatment Done:</span>
                                            <input type="text" maxlength="20" class="form-control" name="treatment[]" id="treatment">
                                            &ThickSpace;
                                            <button type="button" class="btn btn-primary" onclick="duplicate_treat()">+</button>
                                        </div>
                                    </div>
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
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <option value="<?= $row['medcase']; ?>"><?= "(" . ucfirst(strtolower($row['type'])) . ") " . $row['medcase']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Others:</span>
                                    <input type="text" class="form-control" name="medcase_others" id="medcase_others">
                                </div>

                                <div class="modal-footer">
                                    <input type="text" class="form-control" name="type" value="Appointment" id="type" hidden>
                                    <input type="text" class="form-control" name="transaction" value="Appointment" hidden>
                                    <input type="text" class="form-control" name="service" value="Dental Consultation" hidden>
                                    <input type="text" class="form-control" name="patientid" value="<?= $patientid ?>" id="patientid" hidden>
                                    <input type="submit" class="btn btn-primary" value="Save"></input>
                                    &ThickSpace;
                                    <input type="reset" class="btn btn-danger" value="Cancel"></input>
                                </div>
                            </div>
                        <?php } ?>
                    </form>
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
<script>
    function duplicate_treat() {
        var row = $('.duplicate_treat').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_treat(this)');
        $('.duplicate_treat').last().after(row);
        // Increment the index for each duplicated input
        row.find('input[type="number"]').val(''); // Clear the value of the new input
        row.find('input[type="text"]').val(''); // Clear the value of the new input
        row.find('input[name="toothno[]"]').attr('name', 'toothno[]');
        row.find('input[name="diagnosis[]"]').attr('name', 'diagnosis[]');
        row.find('input[name="treatment[]"]').attr('name', 'treatment[]');
    }

    function remove_treat(btn) {
        $(btn).closest('.duplicate_treat').remove();
    }
</script>

</html>