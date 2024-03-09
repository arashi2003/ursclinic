<?php
session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'dashboard';

// get the total nr of rows.
$lastdt = date("Y-m-t");
$records = $conn->query("SELECT * FROM report_medsupinv WHERE eqty <= 10 AND type != 'med_admin' AND date = '$lastdt'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Nurse Dashboard</title>
  <?php include('../../includes/header.php');?>
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
          <i class='bx bx-bell'></i>
        </div>
        <div class="profile-details">
          <i class='bx bx-user-circle'></i>
          <div class="dropdown">
              <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="admin_name">
                      <?php
                      echo $_SESSION['usertype'] . ' ' . $_SESSION['username'] ?>
                  </span>
              </a>
              <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="profile">Profile</a></li>
                  <li><a class="dropdown-item" href="../../logout">Logout</a></li>
              </ul>
          </div>
      </div>
    </nav>
    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Approved Appointment</div>
            <div class="number">
              <?php
              $query = "SELECT * from appointment WHERE status='APPROVED'";
              $result = mysqli_query($conn, $query);
              $totalCount = mysqli_num_rows($result);
              echo $totalCount;
              ?>
            </div>
          </div>
        </div>
        <div class="box">
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
        </div>
        <button type=button class="box" style="border: none;">
          <a href="services.php" style="color:black; text-decoration: none;">
            <div class="right-side">
              <div class="box-topic">Available Services</div>
              <div class="number">
                <?php
                  $query = "SELECT * from transaction";
                  $result = mysqli_query($conn, $query);
                  $totalCount = mysqli_num_rows($result);
                  echo $totalCount;
                ?>
              </div>
            </div>
          </a>
        </button>
        <button type=button class="box" style="border: none;">
          <a href="doc_visit_schedpage.php" style="color:black; text-decoration: none;">
            <div class="right-side">
              <div class="box-topic">Doctor's Visit</div>
              <div class="number">
                <?php
                  $date = date("Y-m-d");
                  $query = "SELECT date, campus FROM schedule WHERE date >= '$date' AND campus = '$campus'";
                  $result = mysqli_query($conn, $query);
                  if (mysqli_num_rows($result) > 0)
                  {
                    while($data=mysqli_fetch_array($result))
                    {
                      $date = date("Y-m-d");
                      if($data['date'] == $date)
                      {
                        $sched = "TODAY";
                      }
                      else
                      {
                        $sched = $data['date'];
                      }
                      
                    }
                    echo date("M. d, Y", strtotime($sched));
                  }
                  else
                  {
                    echo "N/A";
                  }
                ?>
              </div>
            </div>
          </a>
        </button>
        <div class="content">
          <h3>Low Inventory Stocks</h3>
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
              <?php
                $sql = "SELECT * FROM report_medsupinv WHERE eqty <= 10 AND type != 'med_admin' AND date = '$lastdt' ORDER BY type, eqty LIMIT $start, $rows_per_page";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                  if (mysqli_num_rows($result) > 0) {
                ?>
                    <table>
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
                        foreach ($result as $data) {
                        ?>
                            <td><?php echo $data['medid']; ?></td>
                            <td><?php echo $data['type']; ?></td>
                            <td><?php echo $data['medicine']; ?></td>
                            <td><?php echo $data['eqty']; ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <?php include('../../includes/pagination.php');?>
                    <?php
                        } else {
                    ?>
                        <tr>
                            <td colspan="7">
                                <h4>No record Found</h4>
                            </td>
                        </tr>
                  <?php
                      }
                    }
                    mysqli_close($conn);
                  ?>
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