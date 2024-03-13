<div class="modal fade" id="addpatient" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Patient Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../admin/patients'"></button>
            </div>
            <form method="POST" action="modals/update/update_patient.php" id="form">
                <div class="modal-body">
                    <div class="input-group input-group-md">
                        <input class="form-control" type="file" name="acccsv" accept=".jpg, .jpeg, .png, .csv">
                    </div>
                    <br>
                    <div class="mb-2">
                        <label for="patientid" class="form-label">Patient ID:</label>
                        <input type="text" class="form-control" name="patientid" id="patientid" required>
                    </div>
                    <div class="mb-2">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" id="middlename">
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="designation" class="form-label">Designation:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="designation" id="designation" required>
                                <option value="" disabled selected>-Select Designation-</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM designation ORDER BY designation";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['designation']; ?>"><?= $row['designation']; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="age" class="form-label">Age:</label>
                            <input type="number" maxlength="3" class="form-control" name="age" id="age" required>
                        </div>
                        <div class="col mb-2">
                            <label for="sex" class="form-label">Sex:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sex" id="sex" required>
                                <option value="" disabled selected>-Select Sex-</option>
                                    <option value="MALE>">MALE</option>
                                    <option value="FEMALE>">FEMALE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="birthday" class="form-label">Birthday:</label>
                            <input type="date" class="form-control" name="birthday" id="birthday" required>
                        </div>

                        <!-- RESPONSIVE ROR ROR-->
                        <div class="col mb-2">
                            <label for="department" class="form-label">Department:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="department" id="department" required>
                                <option value="" disabled selected>-Select Department-</option>
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
                    <div class="mb-2">
                        <label for="college" class="form-label">College:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="college" id="college">
                            <option value="" selected>-Select College-</option>
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
                    <div class="mb-2">
                        <label for="program" class="form-label">Program:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="program" id="program" >
                            <option value="" selected>-Select Program-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM program ORDER BY program";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['program']; ?>"><?= $row['program']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="yearlevel" class="form-label">Year Level:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="yearlevel" id="yearlevel">
                                <option value="" selected>-Select Year Level-</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM yearlevel ORDER BY yearlevel";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['yearlevel']; ?>"><?= $row['yearlevel']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="section" class="form-label">Section:</label>
                            <input type="text" class="form-control" name="section" id="section" >
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-2">
                        <label for="contactno" class="form-label">Contact Number:</label>
                        <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" required>
                    </div>
                    <div class="mb-2">
                        <label for="emcon_name" class="form-label">Emergency Contact Name:</label>
                        <input type="text" class="form-control" name="emcon_name" id="emcon_name" required>
                    </div>
                    <div class="mb-2">
                        <label for="emcon_number" class="form-label">Emergency Contact Number:</label>
                        <input type="text" maxlength="13" class="form-control" name="emcon_number" id="emcon_number" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add"></input>
                </div>
            </form>
        </div>
    </div>
</div>