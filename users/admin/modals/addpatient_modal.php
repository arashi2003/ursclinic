<div class="modal fade" id="addpatient" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Patient Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_patient.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="patientid" class="form-label">Patient ID:</label>
                        <input type="text" class="form-control" name="patientid" id="patientid">
                    </div>
                    <div class="mb-2">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname">
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" id="middlename">
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname">
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="birthday" class="form-label">Birthday:</label>
                            <input type="date" class="form-control" name="birthday" id="birthday">
                        </div>
                        <div class="col mb-2">
                            <label for="sex" class="form-label">Sex:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sex" id="sex">
                                <option value="" disabled selected>-Select Sex-</option>
                                <option value="MALE>">MALE</option>
                                <option value="FEMALE>">FEMALE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="designation" class="form-label">Designation:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="designation" id="designation" onchange="enableDesignation(this)">
                                <option value="" disabled selected>-Select Designation-</option>
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
                        <!-- RESPONSIVE ROR ROR-->
                        <div class="col mb-2 hidden" id="departmentDiv">
                            <label for="department" class="form-label">Department:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="department" id="departmentSelect" onchange="enableDepartment(this)">
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
                    <div class="mb-2 hidden" id="collegeDiv">
                        <label for="college" class="form-label">College:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="college" id="collegeSelect">
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
                    <div class="mb-2 hidden" id="programDiv">
                        <label for="program" class="form-label">Program:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="program" id="programSelect">
                            <option value="" disabled selected>-Select Program-</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2 hidden" id="yearlevelDiv">
                            <label for="yearlevel" class="form-label">Year Level:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="yearlevel" id="yearlevelSelect">
                                <option value="" disabled selected>-Select Year Level-</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 hidden" id="section">
                            <label for="section" class="form-label">Section:</label>
                            <input type="text" class="form-control" name="section" id="section">
                        </div>
                        <div class="col-md-4 mb-2 hidden" id="block">
                            <label for="section" class="form-label">Block:</label>
                            <input type="text" class="form-control" name="block" id="block">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="text" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-2">
                        <label for="contactno" class="form-label">Contact Number:</label>
                        <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno">
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Home Address:</label>
                        <textarea class="form-control" name="address" id="address" style="resize: none;"></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="emcon_name" class="form-label">Emergency Contact Name:</label>
                        <input type="text" class="form-control" name="emcon_name" id="emcon_name">
                    </div>
                    <div class="mb-2">
                        <label for="emcon_number" class="form-label">Emergency Contact Number:</label>
                        <input type="text" maxlength="13" class="form-control" name="emcon_number" id="emcon_number">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add"></input>
                </div>
            </form>
        </div>
    </div>
</div>

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