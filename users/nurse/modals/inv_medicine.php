<?php
    session_start();
    include('connection.php');
    $user = $_SESSION['userid'];
    $fullname = $_SESSION['name'];
    $activity = "added a medicine entry";
    $campus = $_SESSION['campus'];
    $madmin = $_POST['medadmin'];
    $medicine = $_POST['medicine'];
    $dose = $_POST['dosage'];
    $dform = $_POST['dform'];
    $unit = $_POST['unit_measure'];
    $state = $_POST['state'];
    $au_status = "unread";

    $query = "SELECT * FROM medicine WHERE med_admin = '$madmin' AND medicine = '$medicine' AND dosage = '$dose' AND dosage_form = '$dform' AND unit_measure = '$unit'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
      ?>
       <script>
          setTimeout(function() {
            window.location = "../med_entry.php";
          });
        </script>
      <?php
      // modal message box saying "Medicine already exists."
    }
    else
    {
      $query = "INSERT INTO medicine (med_admin, medicine, dosage, dosage_form, unit_measure, datetime, state) VALUES ('$madmin', '$medicine', '$dose', '$dform', '$unit', now(), '$state')";
      if($result = mysqli_query($conn, $query))
      {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
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
        {?>
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
          // modal message box saying "Medicine Entry was not added."
      
?>
 <script>
    setTimeout(function() {
      window.location = "../med_entry.php";
    });
  </script>
<?php
}}
mysqli_close($conn);