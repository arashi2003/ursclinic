<?php
session_start();

// Destroy Sessions
if (session_destroy()) {
    //redirect to login
?>
    <script>
        setTimeout(function() {
            window.location = "../../index";
        });
    </script>
<?php
}
