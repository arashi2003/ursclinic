<div class="modal fade" id="addmedstocks" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Medicine Stocks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/med_stocks'"></button>
            </div>
            <form method="POST" action="modals/inv_medstocks_exp.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="admin" class="form-label">Medicine Administration:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="admin" id="admin" required>
                            <option value="" disabled selected>-Select Medicine Administration-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM med_admin ORDER BY med_admin";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['id']; ?>"><?= $row['med_admin']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="medicine" class="form-label">Medicine:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medicine" id="medicine" required>
                            <option value="" disabled selected>-Select Medicine-</option>
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#admin").change(function() {
            var medadmin_id = $(this).val();
            if (medadmin_id == '') {
                $("#medicine").html('<option value="" disable selected>-Select Medicine-</option>');
                $("#open-closeDiv").addClass('hidden');
                $("#perpieceDiv").addClass('hidden');
            } else {
                $("#medicine").html('<option value="" disable selected>-Select Medicine-</option>');
                $.ajax({
                    url: "action_medicine.php",
                    method: "POST",
                    data: {
                        medadmin: medadmin_id
                    },
                    success: function(data) {
                        $("#medicine").html(data);
                        // Trigger change event to handle medicine selection
                        $("#medicine").trigger("change");
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        // Handle medicine selection
        $("#medicine").change(function() {
            var selectedStatus = $(this).find('option:selected').data('status');
            // Show or hide the quantity input fields based on medicine status
            if (selectedStatus == 'open-close') {
                $("#open-closeDiv").removeClass('hidden');
                $("#perpieceDiv").addClass('hidden');
                $("#open-closeDiv input[name='opened[]']").prop('disabled', false);
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

    $(document).ready(function() {
        $('#showDate').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0, // Disable past dates
            beforeShowDay: function(date) {
                var day = date.getDay();
            }
        });
    });
</script>