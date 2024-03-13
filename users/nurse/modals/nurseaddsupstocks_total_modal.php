<div class="modal fade" id="addsupstocks" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Medical Supply Stocks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/sup_stocks_total'"></button>
            </div>
            <form method="POST" action="modals/inv_supply_total.php" id="form">
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
                            ?>
                                <option value="<?= $row['supid']; ?>"><?= $row['supply'] . " ". $row['volume'] . $row['unit_measure'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="mb-2">
                        <label for="opened" class="form-label">Quantity of Opened Stocks:</label>
                        <input type="number" min="0" class="form-control" name="opened" id="opened" required>
                    </div>
                    <div class="mb-2">
                        <label for="close" class="form-label">Quantity of Unopened Stocks:</label>
                        <input type="number" min="0" class="form-control" name="close" id="close" required>
                    </div>

                    
                    <div class="mb-2">
                        <label for="close" class="form-label">Quantity:</label>
                        <input type="text" class="form-control" name="opened" id="opened" value="0" hidden>
                        <input type="number" min="0" class="form-control" name="close" id="close" required>
                    </div>

                    <div class="mb-2">
                        <label for="cost" class="form-label">Unit Cost:</label>
                        <input type="number" step=".01" min=”0″ class="form-control" name="unit_cost" placeholder="Unit Cost" id="unit_cost" required>
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