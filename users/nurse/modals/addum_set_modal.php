<div class="modal fade" id="addum_set" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Unit Measure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/setnurse_unitmeasure.php" id="form">
                <div class="modal-body">
                    <label for="type" class="form-label">Type:</label>
                    <div class="mb-2">
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="type" id="type" required>
                            <option value="" disabled selected>-Select Type-</option>
                            <option value="medicine">Medicine</option>
                            <option value="set">Supply/Tools/Equipment</option>
                        </select>
                    </div>
                </div>
                <div class="modal-body">
                    <label for="um" class="form-label">Unit Measure:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="unit_measure" id="unit_measure" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Unit Measure"></input>
                </div>
            </form>
        </div>
    </div>
</div>