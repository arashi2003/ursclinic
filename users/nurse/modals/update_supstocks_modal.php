<div class="modal fade" id="updatesup<?php echo $data['stockid']?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Medical Supply Stocks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/sup_stocks_total'"></button>
            </div>
            <form method="POST" action="modals/update/supply.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="supply" class="form-label">Medical Supply:</label>
                        <input type="text"  class="form-control" name="supid" id="supid" value="<?= $data['stockid'] ?>" hidden>
                        <input type="text"  class="form-control" name="supply" id="supply" value="<?= $data['stock_name'] ?>" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="opened" class="form-label">Quantity of Opened Stocks:</label>
                        <input type="number" min="0" class="form-control" name="opened" id="opened" value="<?= $data['open']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="close" class="form-label">Quantity of Unopened Stocks:</label>
                        <input type="number" min="0" class="form-control" name="close" id="close" value="<?= $data['closed']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Modal muna to confirm add stocks -->
                    <input type="submit" class="btn btn-primary" value="Update"></input>
                </div>
            </form>
        </div>
    </div>
</div>