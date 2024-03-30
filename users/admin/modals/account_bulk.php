<div class="modal fade" id="account_bulk" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">CSV Upload</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <div class="modal-body">
                <form action="modals/import_account.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="file" class="form-control" name="import_file" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                        <button class="btn btn-primary" type="submit" name="save_excel_data" id="uploadButton">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>