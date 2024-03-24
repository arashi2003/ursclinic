<div class="modal fade" id="updateappcc_set<?php echo $data['id'];?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Appointment Chief Complaint</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_appcc.php" id="form">
                <div class="modal-body">
                    <label for="purpose" class="form-label">Appointment Purpose:</label>
                    <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="purpose" id="purpose" required>
                        <option value="" disabled selected>-Select Appointment Purpose-</option>
                        <?php
                        include('connection.php');
                        $sql = "SELECT p.id, t.type, p.purpose FROM appointment_purpose p INNER JOIN appointment_type t ON t.id=p.type ORDER BY type";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            if ($data['purpose'] == $row['purpose'])
                            {
                        ?>
                            <option value="<?= $row['id']; ?>" selected><?= $row['purpose']; ?></option>
                        <?php } else
                        {?>
                            <option value="<?= $row['id']; ?>"><?= $row['purpose']; ?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="modal-body">
                    <label for="appcc" class="form-label">Appointment Chief Complaint:</label>
                    <div class="mb-2">
                        <input type="text" name="id" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="appcc" id="appcc" value="<?php echo $data['chief_complaint']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                </div>
            </form>
        </div>
    </div>
</div>