<div class="modal fade" id="updatete<?php echo $data['teid']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Tools or Equipment Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../te_entry.php'"></button>
            </div>
            <form method="POST" action="modals/update/update_te.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="te" class="form-label">Tool/Equipment:</label>
                        <input type="text" value="<?php echo $data['teid']?>" hidden>
                        <input type="text" class="form-control" name="tools_equip" value="<?php echo $data['tools_equip']?>" id="tools_equip">
                    </div>
                    <div class="mb-2">
                        <label for="um" class="form-label">Unit Measure:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="unit_measure" id="unit_measure" required>
                            <option value="" disabled selected>-Select Unit Measure-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM unit_measure WHERE type = 'set' ORDER BY unit_measure";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                if ($data['unit_measure'] == $row['unit_measure'])
                                {
                            ?>
                                <option value="<?= $row['unit_measure']; ?>" selected><?= $row['unit_measure']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $row['unit_measure']; ?>"><?= $row['unit_measure']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#addsupentry').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $("#unit_measure").html('<option value="" disable selected>-Select Unit Measure-</option>');
    });
</script>