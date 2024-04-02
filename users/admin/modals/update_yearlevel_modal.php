<div class="modal fade" id="updateyearlevel<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Year Level</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/yearlevel.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="department" class="form-label">Department:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="department" id="department" required>
                            <option value="" disabled selected>-Select Department-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM department ORDER BY department";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                if ($data['department'] == $row['department'])
                                {
                            ?>
                                <option value="<?= $row['department']; ?>" selected><?= $row['department']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $row['department']; ?>"><?= $row['department']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="yearlevel" class="form-label">Year Level:</label>
                        <input type="text" name="ylid" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="yearlevel" id="yearlevel" value="<?php echo $data['yearlevel']?>" required>
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
<script type="text/javascript">
    $('#addyearlevel').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        //add ung sa dropdown
    });
</script>