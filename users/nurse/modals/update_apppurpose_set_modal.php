<div class="modal fade" id="updateapppurpose_set<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Appointment Purpose</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_apppurpose.php" id="form">
                <div class="modal-body">
                    <label for="type" class="form-label">Appointment Type:</label>
                    <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="type" id="type" required>
                        <option value="" disabled selected>-Select Appointment Type-</option>
                        <?php
                        include('connection.php');
                        $sql = "SELECT * FROM appointment_type ORDER BY type";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            if ($data['type'] == $row['type'])
                            {
                        ?>
                            <option value="<?= $row['id']; ?>" selected><?= $row['type']; ?></option>
                        <?php } else
                        {?>
                            <option value="<?= $row['id']; ?>"><?= $row['type']; ?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="modal-body">
                    <label for="apppurpose" class="form-label">Appointment Purpose:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="id" id="apppurpose" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="apppurpose" id="apppurpose" value="<?php echo $data['purpose']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>