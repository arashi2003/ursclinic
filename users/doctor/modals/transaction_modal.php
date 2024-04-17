<form action="modals/transaction_include.php" method="POST">
    <div class="modal fade" id="addpatient" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addpatient">Add Patient</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
                </div>
                <?php
                include('connection.php');
                $physician = $_SESSION['userid'];
                $rn = date("Y-m-d");
                $bedoo = "SELECT campus FROM schedule WHERE physician = '$userid' AND date = '$rn'";
                $result = mysqli_query($conn, $bedoo);
                if(mysqli_num_rows($result) > 0){
                    while($fr=mysqli_fetch_array($result)){
                        $campus = $fr['campus'];
                    }
                }else{
                    $campus = "MORONG";
                }
                ?>
                <div class="modal-body patients">
                    <div class="patient_info">
                        <div class="row">
                            <div class="mb-2">
                                <label for="patientid" class="form-label">Patient ID:</label>
                                <input type="text" class="form-control" name="patientid" id="patientid" onchange="fetchPatientData()">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">First Name:</label>
                                <input type="text" maxlength="45" class="form-control" name="firstname" id="firstname" required>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Middle Name:</label>
                                <input type="text" maxlength="45" class="form-control" name="middlename" id="middlename">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Last Name:</label>
                                <input type="text" maxlength="45" class="form-control" name="lastname" id="lastname" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Birthday:</label>
                                <input type="date" class="form-control" name="birthday" id="birthday" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Sex:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="sex" id="sex" required>
                                    <option value="" disabled selected></option>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="designation" class="form-label">Designation:</label>
                                <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="designation" id="designation" onchange="enableDesignation(this)">
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
                            <div class="col-md-6 mb-2" id="departmentDiv">
                                <label for="department" class="form-label">Department:</label>
                                <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="department" id="departmentSelect" onchange="enableDepartment(this)">
                                    <option value="" disabled selected></option>
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

                        <div class="row">
                            <!-- RESPONSIVE ROR ROR-->
                            <div class="mb-2" id="collegeDiv">
                                <label for="college" class="form-label">College:</label>
                                <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="college" id="collegeSelect">
                                    <option value="" disabled selected></option>
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
                            <div class="mb-2" id="programDiv">
                                <label for="program" class="form-label">Program:</label>
                                <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="program" id="programSelect">
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM program";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['abbrev']; ?>"><?= $row['program']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2" id="yearlevelDiv">
                                    <label for="yearlevel" class="form-label">Year Level:</label>
                                    <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="yearlevel" id="yearlevelSelect">
                                        <option value="" disabled selected></option>
                                        <?php
                                        include('connection.php');
                                        $sql = "SELECT * FROM yearlevel";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?= $row['yearlevel']; ?>"><?= $row['yearlevel']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2" id="sectionDiv">
                                    <label for="section" class="form-label">Section:</label>
                                    <input type="text" class="form-control" name="section" id="section">
                                </div>
                                <div class="col-md-4 mb-2" id="blockDiv">
                                    <label for="section" class="form-label">Block:</label>
                                    <input type="text" class="form-control" name="block" id="block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="nextButton" data-bs-toggle="modal" data-bs-target="#addtransaction">Next</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addtransaction" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addtransaction">Add Medical Record</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-2">
                            <select name="type" class="form-select" onchange="enableTransaction(this)">
                                <option value="" disabled selected>Select Transaction Type</option>
                                <option value="Walk-In">Walk-In</option>
                                <option value="Medical History">Medical History</option>
                            </select>
                        </div>
                    </div>
                    <div class="transaction hidden" id="transactDiv">
                        <div class="row">
                            <div class="mb-2">
                                <label for="" class="form-label">Transaction:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="service" id="service" onchange="enableService(this)">
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT DISTINCT service FROM transaction WHERE transaction_type = 'Walk-In' AND service NOT LIKE '%Medicine%' AND service NOT LIKE '%Medical Supply%' ORDER BY service";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['service']; ?>"><?= $row['service']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="default hidden" id="defaultDiv">
                        <div class="vitals hidden" id="vitalsDiv">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Blood Pressure:</label>
                                    <input type="text" maxlength="7" class="form-control" name="bp" id="bp">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Pulse Rate:</label>
                                    <input type="number" min="0" maxlength="4" class="form-control" name="pr" id="pr">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Temperature:</label>
                                    <input type="text" maxlength="4" class="form-control" name="temp" id="temp">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Respiratory Rate:</label>
                                    <input type="number" min="0" maxlength="4" class="form-control" name="respiratory" id="respiratory">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Oxygen Saturation:</label>
                                    <input type="text" maxlength="4" class="form-control" name="oxygen" id="oxygen">
                                </div>
                            </div>
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2 hidden" id="ccDiv">
                            <label for="" class="form-label">Chief Complaints:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="chief_complaint" id="chief_complaint" onchange="enableCc(this)">
                                <option value="" disabled selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM chief_complaint ORDER BY chief_complaint";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['chief_complaint']; ?>"><?= $row['chief_complaint']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 hidden" id="medicineDiv">
                            <label for="" class="form-label">Prescription:</label>
                            <textarea style="resize: none;" class="form-control" name="medicine" id="medicine"></textarea>
                        </div>
                        <div class="mb-2 hidden" id="ccOthersDiv">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="chief_complaint_others" id="chief_complaint_others">
                        </div>
                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2 hidden" id="fdDiv">
                            <label for="" class="form-label">Findings/Diagnosis:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="findiag" id="findiag" onchange="enableFd(this)">
                                <option value="" disabled selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM findiag ORDER BY findiag";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['findiag']; ?>"><?= $row['findiag']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 hidden" id="fdOthersDiv">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="findiag_others" id="findiag_others">
                        </div>
                        <div class="mb-2 hidden" id="remarksDiv">
                            <label for="" class="form-label">Remarks:</label>
                            <input type="text" class="form-control" name="remarks" id="remarks">
                        </div>
                        <div class="mb-2 hidden" id="referralDiv">
                            <label for="" class="form-label">Referral:</label>
                            <input type="text" class="form-control" name="referral" id="referral">
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2 hidden" id="medCaseDiv">
                            <label for="" class="form-label">Medical Case:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase" onchange="enableMedCase(this)">
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
                        <div class="mb-2 hidden" id="medCaseOthersDiv">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="medcase_others" id="medcase_others">
                        </div>
                    </div>

                    <div class="medhist hidden" id="medHistoryDiv">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Height (cm):</label>
                                <input type="number" min="0" maxlength="7" class="form-control" name="height" id="height">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Weight:</label>
                                <input type="text" maxlength="7" class="form-control" name="weight" id="weight">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Blood Pressure:</label>
                                <input type="text" maxlength="7" class="form-control" name="bp" id="bp">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Pulse Rate:</label>
                                <input type="number" min="0" maxlength="3" class="form-control" name="pr" id="pr">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Temperature:</label>
                                <input type="text" maxlength="4" class="form-control" name="temp" id="temp">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2">
                                <label for="" class="form-label">H.E.E.N.T.:</label>
                                <input type="text" maxlength="65" class="form-control" name="heent" id="heent">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Chest/Lungs:</label>
                                <input type="text" maxlength="65" class="form-control" name="chest_lungs" id="chest_lungs">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Heart:</label>
                                <input type="text" maxlength="65" class="form-control" name="heart" id="heart">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Abdomen:</label>
                                <input type="text" maxlength="65" class="form-control" name="abdomen" id="abdomen">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Extremities:</label>
                                <input type="text" maxlength="65" class="form-control" name="extremities" id="extremities">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Last Menstrual Period:</label>
                                <input type="date" class="form-control" name="lmp" id="lmp">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Bronchial Asthma:</label>
                                <input type="date" class="form-control" name="bronchial_asthma" id="bronchial_asthma">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Surgery:</label>
                                <input type="date" class="form-control" name="surgery" id="" surgery>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Heart Disease:</label>
                                <input type="date" class="form-control" name="heart_disease" id="heart_disease">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Allergies:</label>
                                <input type="date" class="form-control" name="allergies" id="allergies">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Epilepsy:</label>
                                <input type="date" class="form-control" name="epilepsy" id="epilepsy">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Hernia:</label>
                                <input type="date" class="form-control" name="hernia" id="hernia">
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="form-label">Dental:</label>
                            <div class="mb-2">
                                <input type="text" id="ddefects" name="ddefects" value="" hidden>
                                <input type="checkbox" id="ddefects" name="ddefects" value="x">
                                <label for="ddefects"> No Dental Defects</label>
                            </div>
                            <div class="mb-2">
                                <input type="text" id="dcs" name="dcs" value="" hidden>
                                <input type="checkbox" id="dcs" name="dcs" value="x">
                                <label for="dcs"> Presence of Oral Debris, Calculi (tartar) deposits, Stains/discoloration</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2">
                                <input type="text" id="gp" name="gp" value="" hidden>
                                <input type="checkbox" id="gp" name="gp" value="x">
                                <label for="gp"> Presence of GINGIVITIS and/or PERIODONTITIS</label>
                            </div>
                            <div class="mb-2">
                                <input type="text" id="scaling_polish" name="scaling_polish" value="" hidden>
                                <input type="checkbox" id="scaling_polish" name="scaling_polish" value="x">
                                <label for="scaling_polish"> For Tooth Scaling and Polishing</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2">
                                <label for="" class="form-label">Other Dento-Facial Findings:</label>
                                <input type="text" maxlength="45" class="form-control" name="dento_facial" id="dento_facial">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Remarks:</label>
                                <input type="text" class="form-control" name="remark" id="remark">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Recommendation:</label>
                                <input type="text" class="form-control" name="refer" id="refer">
                            </div>
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2">
                            <label for="" class="form-label">Medical Case:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase">
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
                        <div class="mb-2">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" maxlength="45" class="form-control" name="medcase_other" id="medcase_other">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addpatient">Back</button>
                    <input type="submit" class="btn btn-primary" value="Add Record"></input>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function fetchPatientData() {
        var patientId = document.getElementById('patientid').value;
        if (patientId.trim() !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add/get_patientid.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        console.log(response); // Check response in console
                        if (response.error) {
                            document.getElementById('patientid').classList.add('is-invalid');
                            document.getElementById('patientid').setCustomValidity(response.error);
                            document.getElementById('patientid').reportValidity();
                        } else {
                            document.getElementById('firstname').value = response.firstname;
                            document.getElementById('middlename').value = response.middlename;
                            document.getElementById('lastname').value = response.lastname;
                            document.getElementById('designation').value = response.designation;
                            document.getElementById('sex').value = response.sex;
                            document.getElementById('birthday').value = response.birthday;
                            document.getElementById('departmentSelect').value = response.department;
                            document.getElementById('collegeSelect').value = response.college;
                            document.getElementById('programSelect').value = response.program;
                            document.getElementById('yearlevelSelect').value = response.yearlevel;
                            document.getElementById('section').value = response.section; // Check this line
                            document.getElementById('block').value = response.block; // Check this line
                            var nextButton = document.getElementById('nextButton');
                            nextButton.disabled = false;

                            document.getElementById('patientid').classList.remove('is-invalid');
                            document.getElementById('patientid').setCustomValidity('');
                        }
                    } else {
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
            document.getElementById('birthday').value = '';
            document.getElementById('departmentSelect').value = '';
            document.getElementById('collegeSelect').value = '';
            document.getElementById('programSelect').value = '';
            document.getElementById('yearlevelSelect').value = '';
            document.getElementById('section').value = '';
            document.getElementById('block').value = '';
            document.getElementById('patientid').classList.remove('is-invalid');
            document.getElementById('patientid').setCustomValidity('');
            var nextButton = document.getElementById('nextButton');
            nextButton.disabled = true;
        }
    }
</script>


<script type="text/javascript">
    function enableTransaction(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Walk-In') {
                document.getElementById('medHistoryDiv').setAttribute('disabled', 'disabled');
                document.getElementById('medHistoryDiv').classList.add('hidden');
                document.getElementById('transactDiv').classList.remove('hidden');
            } else if (answer.value == 'Medical History') {
                document.getElementById('transactDiv').classList.add('hidden');
                document.getElementById('defaultDiv').classList.add('hidden');
                document.getElementById('medHistoryDiv').classList.remove('hidden');
                document.getElementById('medHistoryDiv').removeAttribute('disabled');
                document.getElementById('transactDiv').setAttribute('disabled', 'disabled');
                document.getElementById('defaultDiv').setAttribute('disabled', 'disabled');
            }
        }
    };

    function enableService(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Checkup' || answer.value == 'Consultation' || answer.value == 'Emergency') {
                document.getElementById('medHistoryDiv').classList.add('hidden');
                document.getElementById('defaultDiv').classList.remove('hidden');
                document.getElementById('vitalsDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('ccOthersDiv').classList.add('hidden');
                document.getElementById('fdDiv').classList.remove('hidden');
                document.getElementById('fdOthersDiv').classList.add('hidden');
                document.getElementById('remarksDiv').classList.remove('hidden');
                document.getElementById('medicineDiv').classList.remove('hidden');
                document.getElementById('referralDiv').classList.remove('hidden');
                document.getElementById('medCaseDiv').classList.remove('hidden');
                document.getElementById('medCaseOthersDiv').classList.add('hidden');
            } else if (answer.value == 'Request for Medicine') {
                document.getElementById('medHistoryDiv').classList.add('hidden');
                document.getElementById('defaultDiv').classList.remove('hidden');
                document.getElementById('vitalsDiv').classList.add('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('ccOthersDiv').classList.add('hidden');
                document.getElementById('fdDiv').classList.add('hidden');
                document.getElementById('fdOthersDiv').classList.add('hidden');
                document.getElementById('remarksDiv').classList.remove('hidden');
                document.getElementById('medicineDiv').classList.remove('hidden');
                document.getElementById('referralDiv').classList.add('hidden');
                document.getElementById('medCaseDiv').classList.remove('hidden');
                document.getElementById('medCaseOthersDiv').classList.add('hidden');
            } else if (answer.value == 'Request for Medical Supply') {
                document.getElementById('medHistoryDiv').classList.add('hidden');
                document.getElementById('defaultDiv').classList.remove('hidden');
                document.getElementById('vitalsDiv').classList.add('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('ccOthersDiv').classList.add('hidden');
                document.getElementById('fdDiv').classList.add('hidden');
                document.getElementById('fdOthersDiv').classList.add('hidden');
                document.getElementById('medicineDiv').classList.add('hidden');
                document.getElementById('medCaseDiv').classList.remove('hidden');
                document.getElementById('medCaseOthersDiv').classList.add('hidden');
            }
        }
    };

    function enableCc(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Others:') {
                document.getElementById('ccOthersDiv').classList.remove('hidden');
            } else {
                document.getElementById('ccOthersDiv').classList.add('hidden');
            }
        }
    };

    function enableMedCase(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Others:') {
                document.getElementById('medCaseOthersDiv').classList.remove('hidden');
            } else {
                document.getElementById('medCaseOthersDiv').classList.add('hidden');
            }
        }
    };

    function enableFd(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Others:') {
                document.getElementById('fdOthersDiv').classList.remove('hidden');
            } else {
                document.getElementById('fdOthersDiv').classList.add('hidden');
            }
        }
    };
</script>

<script>
    // Function to check if all required fields except middle name are filled
    function checkRequiredFields() {
        var requiredFields = document.querySelectorAll('.patients [required]:not(#middlename)');
        var allFilled = true;
        requiredFields.forEach(function(field) {
            if (field.value.trim() === '') {
                allFilled = false;
            }
        });
        return allFilled;
    }

    // Function to enable/disable Next button based on required fields
    function toggleNextButton() {
        var nextButton = document.getElementById('nextButton');
        if (checkRequiredFields()) {
            nextButton.disabled = false;
        } else {
            nextButton.disabled = true;
        }
    }
    // Event listener for input change to toggle Next button
    document.querySelectorAll('.patients input, .patients select').forEach(function(element) {
        element.addEventListener('change', toggleNextButton);
    });

    // Initial check on page load
    toggleNextButton();
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
                document.getElementById('sectionDiv').classList.add('hidden');
                document.getElementById('blockDiv').classList.add('hidden');
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
                document.getElementById('blockDiv').classList.add('hidden');
            } else if (answer.value == 'COLLEGE') {
                document.getElementById('collegeDiv').classList.remove('hidden');
                document.getElementById('programDiv').classList.remove('hidden');
                document.getElementById('yearlevelDiv').classList.remove('hidden');
                document.getElementById('sectionDiv').classList.remove('hidden');
                document.getElementById('blockDiv').classList.remove('hidden');
            } else if (answer.value == 'SENIOR HIGH SCHOOL') {
                document.getElementById('collegeDiv').classList.add('hidden');
                document.getElementById('programDiv').classList.remove('hidden');
                document.getElementById('yearlevelDiv').classList.remove('hidden');
                document.getElementById('sectionDiv').classList.remove('hidden');
                document.getElementById('blockDiv').classList.add('hidden');
            }
        }
    };
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#collegeSelect").change(function() {
            var college_id = $(this).val();
            if (college_id != '') {
                // Fetch programs based on college_id
                $.ajax({
                    url: "action_college.php",
                    method: "POST",
                    data: {
                        cid: college_id
                    },
                    success: function(data) {
                        // Update program options
                        $("#programSelect").html(data);

                        // Reset year level options
                        $("#yearlevelSelect").html('<option value="" disabled selected></option>');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                // Reset program and year level options if college_id is empty
                $("#programSelect").html('<option value="" disabled selected></option>');
                $("#yearlevelSelect").html('<option value="" disabled selected></option>');
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
            $("#programSelect").html('<option value="" disable selected></option>');
        });
    });
</script>