<div class="modal fade" id="viewdocument<?php echo $data['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-doc">
        <img src="../patient/documents/<?php echo $data['document']; ?>" class="modal-img" alt="modal img">
      </div>
    </div>
  </div>
</div>
</div>