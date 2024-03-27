<div class="modal fade" id="medclear<?php echo $patientid; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Remarks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <form method="POST" action="reports/reports_medclearance.php?patientid=<?php echo $patientid; ?>" id="form" target="_blank" >
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="te" class="form-label">Dental Examination:</label>
                        <input type="text" maxlength="200" class="form-control" name="rem_den" id="rem_den">
                    </div>
                    <div class="mb-2">
                        <label for="rem_dem" class="form-label">Medical Examination:</label>
                        <input type="text" class="form-control" maxlength="200"  name="rem_med" id="rem_med">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="View"></input>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#medclear<?php echo $patientid; ?>').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
    });
</script>