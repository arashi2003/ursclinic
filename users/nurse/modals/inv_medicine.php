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

    $query = "SELECT * FROM medicine WHERE med_admin = '$madmin' AND medicine = '$medicine' AND dosage = '$dose' AND dosage_form = '$dform' AND unit_measure = '$unit'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
      // modal message box saying "Medicine already exists."
    }
    else
    {
      $query = "INSERT INTO medicine (med_admin, medicine, dosage, dosage_form, unit_measure, datetime, state) VALUES ('$madmin', '$medicine', '$dose', '$dform', '$unit', now(), '')";
      if($result = mysqli_query($conn, $query))
      {
          // modal message box saying "Medicine Entry added."
          // audit trail
      }
      else
      {
          // modal message box saying "Medicine Entry was not added."
      }
?>
 <script>
    setTimeout(function() {
      window.location = "../med_entry.php";
    });
  </script>
<?php
}
mysqli_close($conn);