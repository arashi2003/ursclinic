<?php
session_start();
include('connection.php');
$supply = $_POST['supply'];
$unit = $_POST['unit_measure'];
$state = $_POST['state'];

$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$fullname = $_SESSION['name'];
$activity = "added a medical supply entry";
$au_status = "unread";

if ($_POST['volume'] == 0 || $_POST['volume'] == "") {
    $volume = '';
} else {
    $volume = $_POST['volume'];
}

$query = "SELECT * FROM supply WHERE supply = '$supply' AND volume = '$volume' AND unit_measure = '$unit'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    $_SESSION['alert'] = "Medical Supply already exists.";
?>
    <script>
        setTimeout(function() {
            window.location = "../sup_entry";
        });
    </script>
    <?php
} else {
    $query = "INSERT INTO supply (supply, volume, unit_measure, datetime, state) VALUES ('$supply', '$volume', '$unit', now(), '$state')";
    if ($result = mysqli_query($conn, $query)) {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if ($result = mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = "Medical Supply has been added as an entry.";
    ?>
            <script>
                setTimeout(function() {
                    window.location = "../sup_entry";
                });
            </script>
        <?php
        } else {
            $_SESSION['alert'] = "Medical Supply has been added as an entry.";
        ?>
            <script>
                setTimeout(function() {
                    window.location = "../sup_entry";
                });
            </script>
        <?php
        }
    } else {
        $_SESSION['alert'] = "Medical Supply was not added as an entry.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../sup_entry";
            });
        </script>
<?php
    }
}
mysqli_close($conn);
