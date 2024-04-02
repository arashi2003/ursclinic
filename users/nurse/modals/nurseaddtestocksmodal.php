<div class="modal fade" id="addtestocks" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Tools/Equipment Stocks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/inv_testocks.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="te" class="form-label">Tool/Equipment:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="te" id="te" required>
                            <option value="" disabled selected>-Select Tool/Equipment-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM tools_equip ORDER BY tools_equip";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['teid']; ?>"><?= $row['tools_equip'] . $row['unit_measure'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="cost" class="form-label">Unit Cost:</label>
                        <input type="number" step=".01" min=”0″ class="form-control" name="unit_cost" id="unit_cost" required>
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
                    <!-- Modal muna to confirm add stocks -->
                    <input type="submit" class="btn btn-primary" value="Add Stocks"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#addtestocks').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $("#te").html('<option value="" disable selected>-Select Tool/Equipment-</option>');
        $("#status").html('<option value="" disable selected>-Select Status-</option>');
    });
</script>