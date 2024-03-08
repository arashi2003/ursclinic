<div class="modal fade" id="addtransaction_set" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transaction and Service</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/services.php'"></button>
            </div>
            <form method="POST" action="modals/setnurse_transaction.php" id="form">
                <div class="modal-body">
                    <label for="transaction" class="form-label">Transaction:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="transaction" id="transaction" required>
                    </div>
                </div>
                <div class="modal-body">
                    <label for="service" class="form-label">Service:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="service" id="service">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Transaction"></input>
                </div>
            </form>
        </div>
    </div>
</div>