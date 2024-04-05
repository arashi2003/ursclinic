<?php
session_start();
include('connection.php');

// Destroy Sessions
if (session_destroy()) {
    //redirect to login
?>
    <script>
        setTimeout(function() {
            window.location = "index";
        });
    </script>
<?php
}
