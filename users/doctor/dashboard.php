<?php
session_start();
include('../../connection.php');
include('../../includes/doctor-auth.php');
$campus = $_SESSION['campus'];
$name = $_SESSION['username'];
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$module = 'dashboard';
$date = date("Y-m-d");

// get the total nr of rows.
$records = $conn->query("SELECT * from appointment");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Doctor Dashboard</title>
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
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Patients for Today</div>
            <div class="number">
              <?php
              $query = "SELECT * from account WHERE accountid = '$userid'";
              $result = mysqli_query($conn, $query);
              //$res = mysqli_fetch_array($result);
              while ($data = mysqli_fetch_array($result)) {
                if (count(explode(" ", $data['middlename'])) > 1) {
                  $middle = explode(" ", $data['middlename']);
                  $letter = $middle[0][0] . $middle[1][0];
                  $middleinitial = $letter . ".";
                } else {
                  $middle = $data['middlename'];
                  if ($middle == "" or $middle == " ") {
                    $middleinitial = "";
                  } else {
                    $middleinitial = substr($middle, 0, 1) . ".";
                  }
                }
                $fullname = strtoupper($data['firstname'] . " " . $middleinitial . " " . $data['lastname']);
              }

              $query = "SELECT * from appointment WHERE date = '$date' AND physician = '$fullname'";
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
        <button type=button class="box" style="border: none;" onclick="window.location.href = 'doc_visit_schedpage'">
          <div class="right-side">
            <div class="box-topic">Doctor's Visit</div>
            <div class="text">
              <?php
              $date = date("Y-m-d");
              $query = "SELECT date, campus FROM schedule WHERE date >= '$date' AND physician='$userid'";
              $result = mysqli_query($conn, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($data = mysqli_fetch_array($result)) {
                  $date = date("Y-m-d");
                  if ($data['date'] == $date) {
                    $sched = "TODAY";
                  } else {
                    $sched = $data['date'];
                    $cam = $data['campus'];
                  }
                }
                echo "<b><h2>" . date("M. d, Y", strtotime($sched)) . "</h2><h5>" . $cam . "</h5></b>";
              } else {
                echo "<b><h1>N/A</h1></b>";
              }
              ?>
            </div>
          </div>
        </button>
        <div class="content">
          <h3>Approved Appointments</h3>
          <div class="row">
            <div class="row">
              <div class="col-md-12">
                <form action="" method="get">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="input-group mb-3">
                        <input type="text" name="patient" value="<?= isset($_GET['patient']) == true ? $_GET['patient'] : '' ?>" class="form-control" placeholder="Search patient">
                        <button type="submit" class="btn btn-primary">Search</button>
                      </div>
                    </div>
                    <div class="col-md-2 mb-3">
                      <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                      <select name="physician" class="form-select">
                        <option value="">Select Physician</option>
                        <option value="NONE" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                        <option value="GODWIN A. OLIVAS" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'GODWIN A. OLIVAS' ? 'selected' : '') : '' ?>>GODWIN A. OLIVAS</option>
                        <option value="EDNA C. MAYCACAYAN" <?= isset($_GET['physician']) == true ? ($_GET['physician'] == 'EDNA C. MAYCACAYAN' ? 'selected' : '') : '' ?>>EDNA C. MAYCACAYAN</option>
                      </select>
                    </div>
                    <div class="col mb-3">
                      <button type="submit" class="btn btn-primary">Filter</button>
                      <a href="dashboard" class="btn btn-danger">Reset</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="table-responsive">
                <table>
                  <thead>
                    <tr>
                      <th>Appointment No.</th>
                      <th>Date</th>
                      <th>Time from</th>
                      <th>Time to</th>
                      <th>Patient</th>
                      <th>Action</th>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['patient']) && $_GET['patient'] != '') {
                      $patient = $_GET['patient'];
                      while ($data = mysqli_fetch_array($result)) {
                        if (count(explode(" ", $data['middlename'])) > 1) {
                          $middle = explode(" ", $data['middlename']);
                          $letter = $middle[0][0] . $middle[1][0];
                          $middleinitial = $letter . ".";
                        } else {
                          $middle = $data['middlename'];
                          if ($middle == "" or $middle == " ") {
                            $middleinitial = "";
                          } else {
                            $middleinitial = substr($middle, 0, 1) . ".";
                          }
                        }
                        $fullname = strtoupper($data['firstname'] . " " . $middleinitial . " " . $data['lastname']);
                      }
                      $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE  CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND ap.status='APPROVED' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                      $result = mysqli_query($conn, $sql);
                    } elseif (isset($_GET['date']) && $_GET['date'] != '' || isset($_GET['physician']) && $_GET['physician'] != '') {
                      $date = $_GET['date'];
                      $physician = $_GET['physician'];
                      while ($data = mysqli_fetch_array($result)) {
                        if (count(explode(" ", $data['middlename'])) > 1) {
                          $middle = explode(" ", $data['middlename']);
                          $letter = $middle[0][0] . $middle[1][0];
                          $middleinitial = $letter . ".";
                        } else {
                          $middle = $data['middlename'];
                          if ($middle == "" or $middle == " ") {
                            $middleinitial = "";
                          } else {
                            $middleinitial = substr($middle, 0, 1) . ".";
                          }
                        }
                        $fullname = strtoupper($data['firstname'] . " " . $middleinitial . " " . $data['lastname']);
                      }
                      $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.date = '$date' or ap.physician = '$physician' AND ap.status='APPROVED' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                      $result = mysqli_query($conn, $sql);
                    } else {
                      $query = "SELECT * from account WHERE accountid = '$userid'";
                      $result = mysqli_query($conn, $query);
                      while ($data = mysqli_fetch_array($result)) {
                        if (count(explode(" ", $data['middlename'])) > 1) {
                          $middle = explode(" ", $data['middlename']);
                          $letter = $middle[0][0] . $middle[1][0];
                          $middleinitial = $letter . ".";
                        } else {
                          $middle = $data['middlename'];
                          if ($middle == "" or $middle == " ") {
                            $middleinitial = "";
                          } else {
                            $middleinitial = substr($middle, 0, 1) . ".";
                          }
                        }
                        $fullname = strtoupper($data['firstname'] . " " . $middleinitial . " " . $data['lastname']);
                      }
                      $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.status='APPROVED' AND date = '$date' AND physician = '$fullname' ORDER BY ap.date, ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                      $result = mysqli_query($conn, $sql);
                    }
                    if ($result) {
                      if (mysqli_num_rows($result) > 0) {
                        foreach ($result as $data) {

                          if (count(explode(" ", $data['middlename'])) > 1) {
                            $middle = explode(" ", $data['middlename']);
                            $letter = $middle[0][0] . $middle[1][0];
                            $middleinitial = $letter . ".";
                          } else {
                            $middle = $data['middlename'];
                            if ($middle == "" or $middle == " ") {
                              $middleinitial = "";
                            } else {
                              $middleinitial = substr($middle, 0, 1) . ".";
                            }
                          }
                          if ($data['physician'] == NULL || $data['physician'] == "") {
                            $physician = "NONE";
                          } else {
                            $physician = $data['physician'];
                          }

                    ?>
                          <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['date'] ?></td>
                            <td><?php echo date("g:i a", strtotime($data['time_from'])) ?></td>
                            <td><?php echo date("g:i a", strtotime($data['time_to'])) ?></td>
                            <td><?php echo $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] ?></td>
                            <td><?php //cancel button; 
                                ?></td>
                          </tr>
                        <?php
                          include('modals/update_account_modal.php');
                        }
                      } else { ?>
                        <td colspan="6">
                          <?php
                          include('../../includes/no-data.php');
                          ?>
                        </td>
                      <?php } ?>
                  </tbody>
                </table>
                <?php include('../../includes/pagination.php') ?>
              <?php
                    } else {
              ?>
                <td colspan="6">
                  <?php
                      include('../../includes/no-data.php');
                  ?>
                </td>
              <?php
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