<?php
session_start();
include('../../connection.php');
include('../../includes/dentist-auth.php');
$campus = $_SESSION['campus'];
$name = $_SESSION['username'];
$userid = $_SESSION['userid'];
$fullname = $_SESSION['name'];
$usertype = $_SESSION['usertype'];
$date = date("Y-m-d");
$module = 'dashboard';
$today = date("Y-m-d");
$month = date('Y-m');

// Check if the patient or date filter is set
if (isset($_GET['patient']) || isset($_GET['date'])) {
  // Validate and sanitize input
  $patient = isset($_GET['patient']) ? $_GET['patient'] : '';
  $date = isset($_GET['date']) ? $_GET['date'] : '';

  // Initialize the WHERE clause
  $whereClause = ""; // Start with common conditions

  // Add conditions based on filters
  if ($patient !== '') {
    $whereClause .= " AND (CONCAT(ac.firstname, ' ', ac.middlename, ' ', ac.lastname) LIKE '%$patient%' OR CONCAT(ac.firstname, ' ', ac.lastname) LIKE '%$patient%') "; // Add patient filter
  }
  if ($date !== '') {
    $whereClause .= " AND ap.date = '$date'"; // Add date filter
  }

  // Construct and execute SQL query for counting total rows
  $sql_count = "SELECT COUNT(*) AS total_rows FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE date > '$today'  AND physician = '$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') $whereClause ORDER BY ap.date, ap.time_from, ap.time_to";
} else {
  // If filters are not set, count all rows
  $sql_count = "SELECT COUNT(*) AS total_rows FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE date > '$today'  AND physician = '$fullname' AND (ap.status='APPROVED' OR ap.status='COMPLETED') ORDER BY ap.date, ap.time_from, ap.time_to";
}

// Execute the count query
$count_result = $conn->query($sql_count);

// Check if count query was successful
if ($count_result) {
  // Fetch the total number of rows
  $count_row = $count_result->fetch_assoc();
  $nr_of_rows = $count_row['total_rows'];
} else {
  // Handle count query error
  echo "Error: " . $conn->error;
}

// Setting the number of rows to display in a page.
$rows_per_page = 10;

// determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from, value.
$start = ($page - 1) * $rows_per_page;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);

// calculate the range of page numbers to be displayed
$start_loop = max(1, $page - 2);
$end_loop = min($pages, $page + 2);

// adjust the range if the current page is near the beginning or end
if ($start_loop > 1) {
  $start_loop--;
  $end_loop++;
}

// ensure that the range is never smaller than 4
if ($end_loop - $start_loop < 4) {
  $start_loop = max(1, $end_loop - 4);
}

$previous = $page - 1;
$next = $page + 1;

// calculate the start and end loop variables
$start_loop = $page > 2 ? $page - 2 : 1;
$end_loop = $page < $pages - 2 ? $page + 2 : $pages;

// limit the number of pages displayed to a maximum of 4
if ($pages > 4) {
  if ($page > 2 && $page < $pages - 1) {
    $end_loop = $page + 1;
  } elseif ($page == 1) {
    $start_loop = 1;
    $end_loop = 4;
  } elseif ($page == $pages) {
    $start_loop = $pages - 3;
    $end_loop = $pages;
  }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Dentist Dashboard</title>
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
      <?php
      include('../../includes/alert.php')
      ?>
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Patients for Today</div>
            <div class="number">
              <?php
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

              $query = "SELECT * from appointment WHERE date = '$date' AND physician = '$fullname'";
              $result = mysqli_query($conn, $query);
              $totalCount = mysqli_num_rows($result);
              echo $totalCount;
              ?>
            </div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Appointments for this Month</div>
            <div class="number">
              <?php
              $query = "SELECT * from appointment WHERE physician = '$fullname' AND date LIKE '$month%' AND status = 'APPROVED'";
              $result = mysqli_query($conn, $query);
              $totalCount = mysqli_num_rows($result);
              echo $totalCount;
              ?>
            </div>
          </div>
        </div>
        <button type=button class="box" style="border: none;" onclick="window.location.href = 'doc_visit_schedpage'">
          <div class="right-side">
            <div class="box-topic">Dentist's Visit</div>
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
          <h3>Scheduled Appointments Today</h3>
          <div class="row">
            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table">
                  <thead class="head">
                    <tr>
                      <th>Appointment No.</th>
                      <th>Time from</th>
                      <th>Time to</th>
                      <th>Patient</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_GET['patient']) && $_GET['patient'] != '') {
                      $patient = $_GET['patient'];
                      $query = "SELECT * from account WHERE accountid = '$userid'";
                      $result = mysqli_query($conn, $query);
                      $query = "SELECT * from account WHERE accountid = '$userid'";
                      $result = mysqli_query($conn, $query);
                      $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE CONCAT(ac.firstname, ac.middlename,ac.lastname) LIKE '%$patient%' AND ap.status='APPROVED' AND physician = '$fullname' ORDER BY ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
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
                      $sql = "SELECT ap.id, ap.date, ap.time_from, ap.time_to, ap.physician, ap.status, ac.firstname,  ac.middlename, ac.lastname FROM appointment ap INNER JOIN account ac on ac.accountid=ap.patient WHERE ap.status='APPROVED' AND physician = '$fullname' AND date = '$date' ORDER BY ap.date, ap.time_from, ap.time_to  LIMIT $start, $rows_per_page";
                      $result = mysqli_query($conn, $sql);
                    }
                    if ($result) {
                      if (mysqli_num_rows($result) > 0) {

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

                    ?>
                          <tr>
                            <td><?php echo $data['id'] ?></td>
                            <td><?php echo date("g:i a", strtotime($data['time_from'] . "+ 8 hours")); ?></td>
                            <td><?php echo date("g:i a", strtotime($data['time_to'] . "+ 8 hours")); ?></td>
                            <td><?php echo $data['firstname'] . " " . $middleinitial . " " . $data['lastname'];  ?></td>
                          </tr>
                        <?php
                        }
                      } else { ?>
                        <td colspan="4">
                          <?php
                          include('../../includes/no-data.php');
                          ?>
                        </td>
                      <?php } ?>
                  </tbody>
                <?php
                    } else {
                ?>
                  <td colspan="4">
                    <?php
                      include('../../includes/no-data.php');
                    ?>
                  </td>
                </table>
              <?php
                    }
                    mysqli_close($conn);
              ?>
              </div>
              <ul class="pagination justify-content-end">
                <?php
                if (mysqli_num_rows($result) > 0) : ?>
                  <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                  </li>
                  <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                  </li>
                  <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                      <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                    </li>
                  <?php endfor; ?>
                  <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                  </li>
                  <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?<?= isset($_GET['patient']) ? 'patient=' . $_GET['patient'] . '&' : '', isset($_GET['date']) ? 'date=' . $_GET['date'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
                  </li>
                <?php endif; ?>
              </ul>
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