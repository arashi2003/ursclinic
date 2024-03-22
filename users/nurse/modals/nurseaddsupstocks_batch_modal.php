<div class="modal fade" id="addsupstocks" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Medical Supply Stocks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/sup_stocks_batch'"></button>
            </div>
            <form method="POST" action="modals/inv_supply_batch.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="supply" class="form-label">Medical Supply:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="supply" id="supply" required>
                            <option value="" disabled selected>-Select Medical Supply-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM supply ORDER BY supply";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                if($row['volume'] != "0" || $row['volume'] != ""){
                                    $supply = $row['supply'] . " " . $row['volume'] . $row['unit_measure'];
                                }
                                elseif($row['volume'] == "0" || $row['volume'] == ""){
                                    $supply = $row['supply'] . " " . $row['unit_measure'];
                                }
                            ?>
                                <option value="<?= $row['supid']; ?>" data-status="<?= $row['state']?>"><?= $supply; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="open-close hidden" id="open-closeDiv">
                        <div class="mb-2">
                            <label for="opened" class="form-label">Quantity of Opened Stocks:</label>
                            <input type="number" min="0" class="form-control" name="opened[]" id="opened">
                        </div>
                        <div class="mb-2">
                            <label for="close" class="form-label">Quantity of Unopened Stocks:</label>
                            <input type="number" min="0" class="form-control" name="close[]" id="close">
                        </div>
                    </div>

                    <div class="per-piece hidden" id="perpieceDiv">
                        <div class="mb-2">
                            <label for="close" class="form-label">Quantity:</label>
                            <input type="number" min="0" class="form-control" name="opened[]" id="opened" hidden>
                            <input type="number" min="0" class="form-control" name="close[]" id="close">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="cost" class="form-label">Unit Cost:</label>
                        <input type="number" step=".01" min=”0″ class="form-control" name="unit_cost" id="unit_cost" required>
                    </div>
                    <div class="mb-2">
                        <label for="expiration" class="col-form-label">Expiration Date:</label>
                        <input type="date" name="expiration" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Modal muna to confirm add stocks -->
                    <input type="submit" class="btn btn-primary" value="Add Stocks"></input>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle supply selection
        $("#supply").change(function() {
            var selectedStatus = $(this).find('option:selected').data('status');
            // Show or hide the quantity input fields based on supply status
            if (selectedStatus == 'open-close') {
                $("#open-closeDiv").removeClass('hidden');
                $("#perpieceDiv").addClass('hidden');
                $("#perpieceDiv input[name='opened[]']").prop('disabled', true);
            } else if (selectedStatus == 'per piece') {
                $("#perpieceDiv").removeClass('hidden');
                $("#open-closeDiv").addClass('hidden');
                $("#open-closeDiv input[name='opened[]']").prop('disabled', true);
            } else {
                // Hide both quantity input fields if status is neither 'open-close' nor 'per piece'
                $("#open-closeDiv").addClass('hidden');
                $("#perpieceDiv").addClass('hidden');
                $("#open-closeDiv input[name='opened[]']").prop('disabled', true);
                $("#perpieceDiv input[name='opened[]']").prop('disabled', true);
            }
        });
    });
</script>