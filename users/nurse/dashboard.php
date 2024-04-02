<?php
session_start();

include('../../connection.php');
include('../../includes/nurse-auth.php');
include('../../includes/foreach.php');

$module = 'dashboard';
$userid = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$lastdt = date("Y-m-t");
$today = date("Y-m-d");

// get the total nr of rows.
$records = $conn->query("SELECT * FROM inv_total WHERE qty <= 10 ORDER BY type, qty");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Nurse Dashboard</title>
  <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">

  <?php include('../../includes/sidebar.php') ?>

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">DASHBOARD</span>
      </div>
      <div class="right-nav">
        <div class="notification-button">
          <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
            <i class='bx bx-bell'></i>
            <?php
            $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image FROM audit_trail au INNER JOIN account ac ON ac.accountid = au.user INNER JOIN patient_image i ON i.patient_id = au.user WHERE ((au.activity LIKE '%added a walk-in schedule%' AND au.activity LIKE '%$campus%') OR (au.activity LIKE '%cancelled a walk-in schedule%' AND au.activity LIKE '%$campus%') OR au.activity LIKE 'sent%' OR au.activity LIKE 'cancelled%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%expired%') AND au.status='unread' AND au.user != '$userid' ORDER BY au.datetime DESC";
            $result = mysqli_query($conn, $sql);
            if ($row = mysqli_num_rows($result)) {
            ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $row ?>
              </span>
            <?php
            }
            ?>
          </button>
        </div>

        <div class="profile-details">
          <i class='bx bx-user-circle'></i>
          <div class="dropdown">
            <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="admin_name">
                <?php
                echo $name ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="usertype"><?= $usertype ?></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="profile">Profile</a></li>
              <li><a class="dropdown-item" href="../../logout">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <div class="home-content">
      <?php
      include('../../includes/alert.php')
      ?>
      <div class="overview-boxes">
        <?php
        include('../../includes/alert.php')
        ?>
        <button type=button class="box" style="border: none;" onclick="window.location.href = 'appointment?tab=approved'">
          <div class="right-side">
            <div class="box-topic">Total Approved Appointment</div>
            <div class="number">
              <?php
              $query = "SELECT * from appointment WHERE status='APPROVED' AND date = '$today' AND status != 'COMPLETED'";
              $result = mysqli_query($conn, $query);
              $totalCount = mysqli_num_rows($result);
              echo $totalCount;
              ?>
            </div>
          </div>
        </button>
        <button type=button class="box" style="border: none;" onclick="window.location.href = 'appointment?tab=pending'">
          <div class="right-side">
            <div class="box-topic">Total Pending Appointment</div>
            <div class="number">
              <?php
              $query = "SELECT * from appointment WHERE status='Pending'";
              $result = mysqli_query($conn, $query);
              $totalCount = mysqli_num_rows($result);
              echo $totalCount;
              ?>
            </div>
          </div>
        </button>
        <button type=button class="box" style="border: none;" onclick="window.location.href = 'doc_visit_schedpage'">
          <div class="right-side">
            <div class="box-topic">Doctor's Visit<p>
            </div>
            <div class="number">
              <?php
              $date = date("Y-m-d");
              $query = "SELECT date, campus FROM schedule WHERE date >= '$date' AND campus = '$campus'";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_array($result)) {
                  $date = date("Y-m-d");
                  if ($data['date'] == $date) {
                    $sched = "TODAY";
                  } else {
                    $sched = $data['date'];
                  }
                }
                echo "<h2>" . date("M. d, Y", strtotime($sched)) . "</h2>";
              } else {
                echo "N/A";
              }
              ?>
            </div>
          </div>
        </button>
        <div class="content">
          <h3>Low Inventory Stocks</h3>
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table table-borderless table-inv">
                  <thead>
                    <tr>
                      <th>Stock ID</th>
                      <th>Stock Type</th>
                      <th>Stock</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT * FROM inv_total WHERE qty <= 10 AND campus='$campus' ORDER BY type, qty LIMIT $start, $rows_per_page";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                      if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $data) {
                    ?>
                          <td><?php echo $data['stockid']; ?></td>
                          <td><?php echo $data['type']; ?></td>

                          <?php
                          if ($data['type'] == 'supply') {
                          ?>
                            <td><a class="stock_name" href="sup_stocks_total.php?supply=<?php echo urlencode(substr($data['stock_name'], 0, 10)); ?>"><span><?php echo $data['stock_name']; ?></span></a> &ThickSpace; <i class='bx bx-error error'></i></td>
                          <?php
                          } else {
                          ?>
                            <td><a class="stock_name" href="med_stocks_total.php?medicine=<?php echo urlencode(substr($data['stock_name'], 0, 10)); ?>"><span><?php echo $data['stock_name']; ?></span></a> &ThickSpace; <i class='bx bx-error error'></i></td>
                          <?php } ?>
                          <td><?php echo $data['qty']; ?></td>
                          </tr>
                        <?php
                        }
                        ?>

                      <?php
                      } else {
                      ?>
                        <tr>
                          <td colspan="7">
                            <?php
                            include('../../includes/no-data.php');
                            ?>
                          </td>
                        </tr>
                    <?php
                      }
                    }
                    mysqli_close($conn);
                    ?>
                  </tbody>
                </table>
                <?php include('../../includes/pagination.php'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
</body>

<script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e) => {
      let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
      arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
  });
</script>

</html>