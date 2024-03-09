<?php
    session_start();
    include('connection.php');
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];
    $status = $_POST['status'];
    $istatus = $_POST['istatus'];
    $ldate = date("Y-m-t");
    $te = $_POST['te'];
    $d = $_POST['d'];
    $t = $_POST['t'];
    $fullname = $_SESSION['name'];
    $activity = "added a record to the calibration and maintenance of " . $te;

    $query = "SELECT te_status FROM te_status WHERE id='$status'";    
    $result = mysqli_query($conn, $query);
    if($data=mysqli_fetch_array($result))
    {
      $stat = $data['te_status'];
    }
    
    $query = "INSERT INTO te_calimain (campus, tools_equip, date_from, date_to, status) VALUES ('$campus', '$te', '$date_from', '$date_to', '$status')";    
    if($result = mysqli_query($conn, $query))
    {
      $query = "UPDATE inventory_te SET status = '$status' WHERE teid ='$te' AND date='$d' AND time='$t'";    
      if($result = mysqli_query($conn, $query))
      {
        switch($istatus)
        {
          case 3:
            switch($stat)
            {
              case "Under Maintenance":
                $add = "eum = eum + 1";
                break;
              case "Not Working":
                $add = "enw = enw + 1";
                break;
              default: //good condition
                $add = "egc = egc + 1";
                break;
            }
            $end = "ed= ed - 1, " . $add;
            break;
          case 4:
            switch($stat)
            {
              case "Damaged":
                $add = "ed = ed + 1";
                break;
              case "Not Working":
                $add = "enw = enw + 1";
                break;
              default: //good condition
                $add = "egc = egc + 1";
                break;
            }
            $end = "eum= eum - 1, " . $add;
            break;
          case 2:
            switch($stat)
            {
              case "Damaged":
                $add = "ed = ed + 1";
                break;
              case "Under Maintenance":
                $add = "eum = eum + 1";
                break;
              default: //good condition
                $add = "egc = egc + 1";
                break;
            }
            $end = "enw= enw - 1, " . $add;
            break;
          default: //good condition
            switch($stat)
            {
              case "Damaged":
                $add = "ed = ed + 1";
                break;
              case "Under Maintenance":
                $add = "eum = eum + 1";
                break;
              default: //Not working
                $add = "enw = enw + 1";
                break;
            }
            $end = "egc= egc - 1, " . $add;
            break;
        }
        $sql = "UPDATE report_teinv SET $end WHERE date='$ldate'";
        if($result = mysqli_query($conn, $sql))
        {
          $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
          if($result = mysqli_query($conn, $sql))
          {
            ?>
            <script>
                setTimeout(function() {
                  window.location = "../te_stocks.php";
                });
              </script>
            <?php
            // modal message box saying "Calibration and Maintenance Record was added."
          }
          else
          {
            ?>
            <script>
                setTimeout(function() {
                  window.location = "../te_stocks.php";
                });
              </script>
            <?php
            // modal message box saying "Calibration and Maintenance Record was added."
          }
        }
      }
      else
      {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
        if($result = mysqli_query($conn, $sql))
        {
          ?>
          <script>
              setTimeout(function() {
                window.location = "../te_stocks.php";
              });
            </script>
          <?php
          // modal message box saying "Calibration and Maintenance Record was added."
        }
        else
        {
          ?>
          <script>
              setTimeout(function() {
                window.location = "../te_stocks.php";
              });
            </script>
          <?php
          // modal message box saying "Calibration and Maintenance Record was added."
        }
      }
    }
    else
    {
      // modal message box saying "Calibration and Maintenance Record was not added."
?>
 <script>
    setTimeout(function() {
      window.location = "../te_stocks.php";
    });
  </script>
<?php
}
mysqli_close($conn);