<div class="modal fade" id="addsupentry" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Supply Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/sup_entry'"></button>
            </div>
            <form method="POST" action="modals/inv_supply.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="supply" class="form-label">Medical Supply:</label>
                        <input type="text" class="form-control" name="supply" id="supply">
                    </div>
                    <div class="mb-2">
                        <label for="volume" class="form-label">Volume:</label>
                        <input type="number" class="form-control" name="volume" id="dosage" step=".01">
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
                    <input type="submit" class="btn btn-primary" value="Add Supply"></input>
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