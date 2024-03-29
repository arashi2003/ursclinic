<?php

if (isset($_SESSION['alert'])) {
?>
    <div class="alert-message">
        <div class="alert alert-info alert-dismissible fade show" role="alert" id="success-alert">
            <?= $_SESSION['alert']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>
<?php
    unset($_SESSION['alert']);
}

?>