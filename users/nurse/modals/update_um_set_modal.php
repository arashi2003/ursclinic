<div class="modal fade" id="updateum_set<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Unit Measure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_unitmeasure.php" id="form">
                <div class="modal-body">
                    <label for="type" class="form-label">Type:</label>
                    <div class="mb-2">
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="type" id="type" required>
                            <option value="" disabled selected>-Select Type-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT DISTINCT type FROM unit_measure ORDER BY type";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                if ($row['type'] == 'set')
                                {
                                    $type = "supply/tools/equipment";
                                }
                                else
                                {
                                    $type = $row['type'];
                                }

                                if ($data['type'] == $row['type'])
                                {
                            ?>
                                <option value="<?= $type; ?>" selected><?= $type; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $type; ?>"><?= $type; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <label for="um" class="form-label">Unit Measure:</label>
                    <div class="mb-2">
                        <input type="text" name="id" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="unit_measure" id="unit_measure" value="<?php echo $data['unit_measure']?>" required>
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