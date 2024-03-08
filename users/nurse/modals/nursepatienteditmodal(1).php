<div class="modal fade" id="nursepatienteditmodal<?php echo $row['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <form method="POST" action="nursepatientedit.php">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Patient</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <input type="hidden" name="patientid" value="<?php echo $row['id'] ?>" />
                    <label for="firstname" class="col-form-label">Firstname:</label>
                    <input type="text" class="form-control" name="firstname" value="<?php echo $row['firstname'] ?>" required>
                </div>
                <div class="mb-2">
                    <label for="middlename" class="col-form-label">Middlename:</label>
                    <input type="text" class="form-control" name="middlename" value="<?php echo $row['middlename'] ?>">
                </div>
                <div class="mb-2">
                    <label for="lastname" class="col-form-label">Lastname:</label>
                    <input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname'] ?>" required>
                </div>
                <div class="mb-2">
                    <label for="age" class="col-form-label">Age:</label>
                    <input type="text" class="form-control" name="age" value="<?php echo $row['age'] ?>" required>
                </div>
                <div class="mb-2">
                    <label for="age" class="col-form-label">Sex:</label>
                    <input type="text" class="form-control" name="gender" value="<?php echo $row['sex'] ?>" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="update">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>