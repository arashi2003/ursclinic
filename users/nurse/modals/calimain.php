<?php
    session_start();
    include('connection.php');
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $id = $_POST['id'];
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
    $au_status = "unread";
    $query = "INSERT INTO te_calimain (campus, tools_equip, date_from, date_to, status) VALUES 
    ('$campus', '$te', '$date_from', '$date_to', '$status')";    
    if($result = mysqli_query($conn, $query))
    {
      $query = "UPDATE inventory_te SET status = '$status' WHERE id='$id' AND status='$istatus' AND teid ='$te' AND date='$d' AND time='$t'";    
      if($result = mysqli_query($conn, $query))
      {
        $istatus = $_POST['istatus'];
        switch($istatus)
        {
          case "Damaged":
            switch($status)
            {
              case "Under Maintenance":
                $add = "eum = eum + 1";
                break;
              case "Not Working":
                $add = "enw = enw + 1";
                break;
              case "Good Condition": 
                $add = "egc = egc + 1";
                break;
              default:
                break;
            }
            $end = "ed= ed - 1, " . $add;
            break;
          case "Under Maintenance":
            switch($status)
            {
              case "Damaged":
                $add = "ed = ed + 1";
                break;
              case "Not Working":
                $add = "enw = enw + 1";
                break;
              case "Good Condition": 
                $add = "egc = egc + 1";
                break;
              default:
                break;
            }
            $end = "eum= eum - 1, " . $add;
            break;
          case "Not Working":
            switch($status)
            {
              case "Damaged":
                $add = "ed = ed + 1";
                break;
              case "Under Maintenance":
                $add = "eum = eum + 1";
                break;
              case "Good Condition": 
                $add = "egc = egc + 1";
                break;
              default:
                break;
            }
            $end = "enw= enw - 1, " . $add;
            break;
          case "Good Condition": //good condition
            switch($status)
            {
              case "Damaged":
                $add = "ed = ed + 1";
                break;
              case "Under Maintenance":
                $add = "eum = eum + 1";
                break;
              case "Not working":
                $add = "enw = enw + 1";
                break;
              default: 
                break;
            }
            $end = "egc = egc - 1, " . $add;
            break;
          default: 
            break;
        }
        $sql = "UPDATE report_teinv SET $end WHERE teid='$te' AND date='$ldate'";
        if($result = mysqli_query($conn, $sql))
        {
          $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
          if($result = mysqli_query($conn, $sql))
          {
            $_SESSION['alert'] = "Calibration and Maintenance has been recorded.";
            ?>
            <script>
                setTimeout(function() {
                  window.location = "../te_stocks";
                });
              </script>
            <?php
          }
          else
          {
            $_SESSION['alert'] = "Calibration and Maintenance has been recorded.";
            ?>
            <script>
                setTimeout(function() {
                  window.location = "../te_stocks";
                });
              </script>
            <?php
          }
        }
      }
      else
      {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
          $_SESSION['alert'] = "Calibration and Maintenance has been recorded.";
          ?>
          <script>
              setTimeout(function() {
                window.location = "../te_stocks";
              });
            </script>
          <?php
        }
        else
        {
          $_SESSION['alert'] = "Calibration and Maintenance has been recorded.";
          ?>
          <script>
              setTimeout(function() {
                window.location = "../te_stocks";
              });
            </script>
          <?php
        }
      }
    }
    else
    {
      $_SESSION['alert'] = "Calibration and Maintenance was not recorded.";
?>
 <script>
    setTimeout(function() {
      window.location = "../te_stocks";
    });
  </script>
<?php
}
mysqli_close($conn);