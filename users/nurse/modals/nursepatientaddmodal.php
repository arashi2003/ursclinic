<div class="modal fade" id="addpatient" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Patient</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="nursepatientadd.php">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="firstname" class="col-form-label">Firstname:</label>
                        <input type="text" class="form-control" name="firstname" placeholder="firstname" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="col-form-label">Middlename:</label>
                        <input type="text" class="form-control" name="middlename" placeholder="middlename" required>
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="col-form-label">Lastname:</label>
                        <input type="text" class="form-control" name="lastname" placeholder="lastname" required>
                    </div>
                    <div class="mb-2">
                        <label for="age" class="col-form-label">Age:</label>
                        <input type="number" class="form-control" name="age" placeholder="age" required>
                    </div>
                    <div class="mb-2">
                        <label for="gender" class="col-form-label">Gender:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add"></input>
                </div>
            </form>
        </div>
    </div>
</div>