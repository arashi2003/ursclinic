<?php

session_start();
include('../../connection.php');
include('../../includes/dentist-auth.php');

$module = 'dental_consultation';
$campus = $_SESSION['campus'];
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Transaction</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">DENTAL CONSULTATION</span>
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
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary" onclick="window.location.href = 'transaction_dental_checkup.php'">Dental Checkup</button>
                </div>
                <form method="POST" action="add/transaction_dental_consultation.php" id="form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content">
                                <h3><b>Patient</b></h3>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Patient ID:</span>
                                            <input type="text" class="form-control" name="patientid" id="patientid" onchange="fetchPatientData()">
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
                                            <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="sex" id="sex" required>
                                                <option value="" disabled selected></option>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="designation" id="designation" onchange="enableDesignation(this)">
                                                <option value="" disabled selected></option>
                                                <?php
                                                include('connection.php');
                                                $sql = "SELECT * FROM designation ORDER BY designation";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value="<?= $row['designation']; ?>"><?= $row['designation']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- responsive-->
                                    <div class="col-md-4 mb-2 hidden" id="departmentDiv">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="department" id="departmentSelect" onchange="enableDepartment(this)">
                                                <option value="" selected>-Select Department-</option>
                                                <?php
                                                include('connection.php');
                                                $sql = "SELECT * FROM department ORDER BY department";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value="<?= $row['department']; ?>"><?= $row['department']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-2 hidden" id="collegeDiv">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">College:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="college" id="collegeSelect">
                                                <option value="" disabled selected>-Select College-</option>
                                                <?php
                                                include('connection.php');
                                                $sql = "SELECT * FROM college ORDER BY college";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                    <option value="<?= $row['college']; ?>"><?= $row['college']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2 hidden" id="programDiv">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Program:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="program" id="programSelect">
                                                <option value="" disabled selected>-Select Program-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2 hidden" id="yearlevelDiv">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Year Level:</span>
                                            <select class="form-control" aria-label=".form-select-md example" name="yearlevel" id="yearlevelSelect">
                                                <option value="" disabled selected>-Select Year Level-</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2 hidden" id="section">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Section:</span>
                                            <input type="text" class="form-control" name="section" id="section">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2 hidden" id="block">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Block:</span>
                                            <input type="text" class="form-control" name="block" id="block">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="input-group input-group-md mb-2">
                                            <span class="input-group-text" id="inputGroup-sizing-md">Civl Status:</span>
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
                                            <span class="input-group-text" id="inputGroup-sizing-md">Address:</span>
                                            <input type="text" class="form-control" name="address" id="address">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="content">
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
                            </div>
                        </div>

                        <div class="col-md-12">
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
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <option value="<?= $row['id']; ?>"><?= "(" . ucfirst(strtolower($row['type'])) . ") " . $row['medcase']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Others:</span>
                                    <input type="text" class="form-control" name="medcase_others" id="medcase_others">
                                </div>

                                <div class="modal-footer">
                                    <input type="text" class="form-control" name="type" value="Walk-In" id="type" hidden>
                                    <input type="text" class="form-control" name="transaction" value="Walk-In" hidden>
                                    <input type="text" class="form-control" name="service" value="Dental Consultation" hidden>
                                    <input type="submit" class="btn btn-primary" value="Add Record"></input>
                                    &ThickSpace;
                                    <input type="reset" class="btn btn-danger" value="Cancel"></input>
                                </div>
                            </div>
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

<script>
    function fetchPatientData() {
        var patientId = document.getElementById('patientid').value;
        if (patientId.trim() !== '') {
            // Perform AJAX request to fetch patient data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add/get_patientid.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Process the response
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            // Display Bootstrap form validation error message
                            document.getElementById('patientid').classList.add('is-invalid');
                            document.getElementById('patientid').setCustomValidity(response.error);
                            document.getElementById('patientid').reportValidity();
                        } else {
                            // Update form fields with fetched patient data
                            document.getElementById('firstname').value = response.firstname;
                            document.getElementById('middlename').value = response.middlename;
                            document.getElementById('lastname').value = response.lastname;
                            document.getElementById('designation').value = response.designation;
                            document.getElementById('sex').value = response.sex;
                            document.getElementById('department').value = response.department;
                            document.getElementById('college').value = response.college;
                            document.getElementById('program').value = response.program;
                            document.getElementById('yearlevel').value = response.yearlevel;
                            document.getElementById('section').value = response.section;
                            document.getElementById('block').value = response.block;
                            document.getElementById('address').value = response.address;

                            // Reset form validation state
                            document.getElementById('patientid').classList.remove('is-invalid');
                            document.getElementById('patientid').setCustomValidity('');
                        }
                    } else {
                        // Handle error if AJAX request fails
                        console.error('Error: Unable to fetch patient data');
                    }
                }
            };
            xhr.send('action=fetch_patient_data&patientid=' + encodeURIComponent(patientId));
        } else {
            // Clear form fields if patient ID is empty
            // Also reset form validation state
            document.getElementById('firstname').value = '';
            document.getElementById('middlename').value = '';
            document.getElementById('lastname').value = '';
            document.getElementById('designation').value = '';
            document.getElementById('sex').value = '';
            document.getElementById('department').value = '';
            document.getElementById('college').value = '';
            document.getElementById('program').value = '';
            document.getElementById('yearlevel').value = '';
            document.getElementById('section').value = '';
            document.getElementById('block').value = '';
            document.getElementById('address').value = '';
            document.getElementById('patientid').classList.remove('is-invalid');
            document.getElementById('patientid').setCustomValidity('');
        }
    }
</script>

<script>
    function fetchPatientData() {
        var patientId = document.getElementById('patientid').value;
        if (patientId.trim() !== '') {
            // Perform AJAX request to fetch patient data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add/get_patientid.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Process the response
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            // Display Bootstrap form validation error message
                            document.getElementById('patientid').classList.add('is-invalid');
                            document.getElementById('patientid').setCustomValidity(response.error);
                            document.getElementById('patientid').reportValidity();
                        } else {
                            // Update form fields with fetched patient data
                            document.getElementById('firstname').value = response.firstname;
                            document.getElementById('middlename').value = response.middlename;
                            document.getElementById('lastname').value = response.lastname;
                            document.getElementById('designation').value = response.designation;
                            document.getElementById('sex').value = response.sex;
                            document.getElementById('department').value = response.department;
                            document.getElementById('college').value = response.college;
                            document.getElementById('program').value = response.program;
                            document.getElementById('yearlevel').value = response.yearlevel;
                            document.getElementById('section').value = response.section;
                            document.getElementById('block').value = response.block;
                            document.getElementById('address').value = response.address;

                            // Reset form validation state
                            document.getElementById('patientid').classList.remove('is-invalid');
                            document.getElementById('patientid').setCustomValidity('');
                        }
                    } else {
                        // Handle error if AJAX request fails
                        console.error('Error: Unable to fetch patient data');
                    }
                }
            };
            xhr.send('action=fetch_patient_data&patientid=' + encodeURIComponent(patientId));
        } else {
            // Clear form fields if patient ID is empty
            // Also reset form validation state
            document.getElementById('firstname').value = '';
            document.getElementById('middlename').value = '';
            document.getElementById('lastname').value = '';
            document.getElementById('designation').value = '';
            document.getElementById('sex').value = '';
            document.getElementById('department').value = '';
            document.getElementById('college').value = '';
            document.getElementById('program').value = '';
            document.getElementById('yearlevel').value = '';
            document.getElementById('section').value = '';
            document.getElementById('block').value = '';
            document.getElementById('address').value = '';
            document.getElementById('patientid').classList.remove('is-invalid');
            document.getElementById('patientid').setCustomValidity('');
        }
    }
</script>

<script type="text/javascript">
    function enableDesignation(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'DEPENDENCE' || answer.value == 'STAFF' || answer.value == 'FACULTY') {
                document.getElementById('departmentDiv').classList.add('hidden');
                document.getElementById('collegeDiv').classList.add('hidden');
                document.getElementById('programDiv').classList.add('hidden');
                document.getElementById('yearlevelDiv').classList.add('hidden');
                document.getElementById('section').classList.add('hidden');
                document.getElementById('block').classList.add('hidden');
            } else if (answer.value == 'STUDENT') {
                document.getElementById('departmentDiv').classList.remove('hidden');
            }
        }
    };

    function enableDepartment(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'ELEMENTARY' || answer.value == 'JUNIOR HIGH SCHOOL') {
                document.getElementById('collegeDiv').classList.add('hidden');
                document.getElementById('programDiv').classList.add('hidden');
                document.getElementById('block').classList.add('hidden');
                document.getElementById('yearlevelDiv').classList.remove('hidden');
            } else if (answer.value == 'COLLEGE') {
                document.getElementById('collegeDiv').classList.remove('hidden');
                document.getElementById('programDiv').classList.remove('hidden');
                document.getElementById('yearlevelDiv').classList.remove('hidden');
                document.getElementById('section').classList.remove('hidden');
                document.getElementById('block').classList.remove('hidden');
            } else if (answer.value == 'SENIOR HIGH SCHOOL') {
                document.getElementById('collegeDiv').classList.add('hidden');
                document.getElementById('programDiv').classList.remove('hidden');
                document.getElementById('yearlevelDiv').classList.remove('hidden');
                document.getElementById('section').classList.remove('hidden');
                document.getElementById('block').classList.remove('hidden');
            }
        }
    };
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#collegeSelect").change(function() {
            var college_id = $(this).val();
            if (college_id == '') {
                $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
            } else {
                $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
                $.ajax({
                    url: "action_college.php",
                    method: "POST",
                    data: {
                        cid: college_id
                    },
                    success: function(data) {
                        console.log(data); // Log received data
                        $("#programSelect").html(data);
                    }
                });
            }
        });
        $("#departmentSelect").change(function() {
            var department_id = $(this).val();
            $.ajax({
                url: "action_college.php",
                method: "POST",
                data: {
                    did: department_id,
                    type: 'department' // Add type parameter
                },
                success: function(data) {
                    $("#yearlevelSelect").html(data);
                }
            });
        });
    });

    $(document).ready(function() {
        $("#departmentSelect").change(function() {
            $("#programSelect").html('<option value="" disable selected>-Select Program-</option>');
        });
    });
</script>

<script>
    function enableButton() {
        var fileInput = document.getElementById('inputGroupFile04');
        var uploadButton = document.getElementById('uploadButton');

        if (fileInput.value) {
            uploadButton.disabled = false;
        } else {
            uploadButton.disabled = true;
        }
    }
</script>

</html>