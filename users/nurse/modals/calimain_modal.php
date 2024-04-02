<div class="modal fade" id="calimain<?php echo $data['id']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Calibration and Maintenance</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/calimain.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="te" class="form-label">Tool/Equipment:</label>
                        <input type="text" name="id" value="<?php echo $data['id']?>" hidden>
                        <input type="text" name="te" value="<?php echo $data['teid']?>" hidden>
                        <input type="text" name="d" value="<?php echo $data['date']?>" hidden>
                        <input type="text" name="t" value="<?php echo $data['time']?>" hidden>
                        <input type="text" name="istatus" value="<?php echo $data['status']?>" hidden>
                        <input type="text" class="form-control" name="te" id="te" value="<?php echo $data['tools_equip'] . $data['unit_measure']  ?>" readonly disabled>
                    </div>
                    <div class="mb-2">
                        <label for="date_from" class="col-form-label">Date From:</label>
                        <input type="date" name="date_from" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="date_to" class="col-form-label">Date To:</label>
                        <input type="date" name="date_to" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label for="status" class="form-label">Tool/Equipment Status:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="status" id="status" required>
                            <option value="" disabled selected>-Select Status-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM te_status ORDER BY te_status";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['te_status']; ?>"><?= $row['te_status']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Modal muna to confirm save calimain -->
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>