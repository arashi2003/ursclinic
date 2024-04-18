<div class="modal fade" id="addtransaction_set" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transaction and Service</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/setnurse_transaction.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="transaction" class="form-label">Transaction: <i style="color: red; font-size: 20px">*</i></label>
                        <select name="transaction" class="form-control" id="transaction" required>
                            <option value="" disabled selected></option>
                            <option value="Appointment">Appointment</option>
                            <option value="Walk-In">Walk-In</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="service" class="form-label">Service: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="service" id="service">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Transaction"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>