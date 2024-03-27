<div class="modal fade" id="uploaddocument<?php echo $rowCounter; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?php echo $rowCounter; ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();"></button>
            </div>
            <div class="modal-body">
                <form class="form" id="form" action="../student/upload-document.php" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <input type="hidden" name="applicant" value="<?php echo $data['applicant']; ?>">
                    <input type="hidden" name="document" value="<?php echo $data['doc_desc']; ?>">
                    <input type="hidden" name="type" value="<?php echo $data['type']; ?>">
                    <div class="upload-doc">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="fileImg" id="fileImg<?php echo $rowCounter; ?>" accept=".jpg, .jpeg, .png">
                        </div>
                        <img src="../documents/<?php echo $data['document']; ?>" id="image<?php echo $rowCounter; ?>" alt="Document Preview">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Upload"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    for (let i = 1; i <= <?php echo $rowCounter; ?>; i++) {
        document.getElementById("fileImg" + i).onchange = function() {
            document.getElementById("image" + i).src = URL.createObjectURL(this.files[0]);
        };
    }
</script>