<div class="modal fade" id="updatetransaction_set<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Transaction and Service</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_transaction.php" id="form">
                <div class="modal-body">
                <?php $trans = $data['transaction_type']?>
                    <div class="mb-2">
                        <label for="transaction" class="form-label">Transaction:</label>
                        <input type="text" name="id" value="<?php echo $data['id']?>" hidden>
                        <select name="transaction" class="form-control" id="transaction" required>
                            <?php
                            if ($trans == 'Appointment') { ?>
                                <option value="Appointment" selected>Appointment</option>
                                <option value="Walk-In">Walk-In</option>
                            <?php } elseif($trans == 'Walk-In') { ?>
                                <option value="Appointment">Appointment</option>
                                <option value="Walk-In" selected>Walk-In</option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="service" class="form-label">Service:</label>
                        <input type="text" class="form-control" name="service" value="<?php echo $data['service'] ?>" id="service">
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