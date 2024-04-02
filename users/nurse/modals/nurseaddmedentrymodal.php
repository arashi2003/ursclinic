<div class="modal fade" id="addmedentry" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Medicine Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/inv_medicine.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="medadmin" class="form-label">Medicine Administration:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medadmin" id="medadmin" required>
                            <option value="" disabled selected>-Select Medicine Administration-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM med_admin ORDER BY med_admin";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['med_admin']; ?>"><?= $row['med_admin']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="dform" class="form-label">Dosage Form:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="dform" id="dform" required>
                            <option value="" disabled selected>-Select Dosage Form-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM dosage_form ORDER BY dosage_form";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['dosage_form']; ?>"><?= $row['dosage_form']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="medicine" class="form-label">Medicine:</label>
                        <input type="text" class="form-control" name="medicine" id="medicine">
                    </div>
                    <div class="mb-2">
                        <label for="dosage" class="form-label">Dosage:</label>
                        <input type="number" class="form-control" name="dosage" id="dosage" step=".01">
                    </div>
                    <div class="mb-2">
                        <label for="um" class="form-label">Unit Measure:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="unit_measure" id="unit_measure" required>
                            <option value="" disabled selected>-Select Unit Measure-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM unit_measure WHERE type = 'medicine' ORDER BY unit_measure";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['unit_measure']; ?>"><?= $row['unit_measure']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="um" class="form-label">Issuance:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="state" id="state" required>
                            <option value="" disabled selected>-Select Issuance State-</option>
                            <option value="per piece">Per Piece</option>
                            <option value="open-close">Opened/Close</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Medicine"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>