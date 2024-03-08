<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $madmin = $_POST['medadmin'];
    $medicine = $_POST['medicine'];
    $dose = $_POST['dosage'];
    $dform = $_POST['dform'];
    $unit = $_POST['unit_measure'];
    $id=$_POST['medid'];

    $query = "UPDATE medicine SET med_admin='$madmin', medicine='$medicine', dosage='$dose', dosage_form='$dform', unit_measure='$unit', datetime=now() WHERE medid='$medid'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'updated a medicine entry', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                window.location = "../med_entry.php";
                });
            </script>
            <?php 
            // modal message box saying "Medicine Entry added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                window.location = "../med_entry.php";
                });
            </script>
            <?php 
            // modal message box saying "Medicine Entry added."
        }
    }
    else
    {
        ?>
        <script>
            setTimeout(function() {
            window.location = "../med_entry.php";
            });
        </script>
        <?php
        // modal message box saying "Medicine Entry was not added."
?>
 <script>
    setTimeout(function() {
      window.location = "../med_entry.php";
    });
  </script>
<?php
}
mysqli_close($conn);