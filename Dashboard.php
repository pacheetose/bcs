<?php
include 'connect.php';
include 'session.php';
$email = $_SESSION['email'];
$id = $_SESSION['id'];

function build_calendar($month, $year)
{
  $mysqli = new mysqli('localhost', 'root', '', 'crud');
  $stmt = $mysqli->prepare("SELECT * FROM pending_scheduled WHERE MONTH(cusdate) = ? AND YEAR(cusdate) = ?");
  $stmt->bind_param('ss', $month, $year);
  $bookings = array();
  if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $bookings[] = $row['cusdate'];
      }

      $stmt->close();
    }
  }


  $daysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
  $firstDayOfMonth = mktime(0, 0, 0, intval($month), 1, $year);
  $numberDays = date('t', $firstDayOfMonth);
  $dateComponents = getdate($firstDayOfMonth);
  $monthName = $dateComponents['month'];
  $dayOfWeek = $dateComponents['wday'];

  $datetoday = date('Y-m-d');

  $calendar = "<table class='table table-bordered'>";
  $calendar .= "<center><h2>$monthName $year</h2>";
  $calendar .= "<a class='btn btn-xs btn-success elevation-2'style='text-decoration: none;' href='?month=" . date('m', mktime(0, 0, 0, intval($month) - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, intval($month) - 1, 1, $year)) . "'>Previous Month</a> ";
  $calendar .= " <a class='btn btn-xs btn-danger elevation-2'style='text-decoration: none;' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a> ";
  $calendar .= "<a class='btn btn-xs btn-primary elevation-2'style='text-decoration: none;' href='?month=" . date('m', mktime(0, 0, 0, intval($month) + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, intval($month) + 1, 1, $year)) . "'>Next Month</a></center><br>";


  $calendar .= "<tr>";
  foreach ($daysOfWeek as $day) {
    $calendar .= "<th  class='header'>$day</th>";
  }

  $currentDay = 1;
  $calendar .= "</tr><tr>";


  if ($dayOfWeek > 0) {
    for ($k = 0; $k < $dayOfWeek; $k++) {
      $calendar .= "<td  class='empty'></td>";
    }
  }

  $month = str_pad($month, 2, "0", STR_PAD_LEFT);

  while ($currentDay <= $numberDays) {

    if ($dayOfWeek == 7) {

      $dayOfWeek = 0;
      $calendar .= "</tr><tr>";
    }

    $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
    $date = "$year-$month-$currentDayRel";

    $dayname = strtolower(date('l', strtotime($date)));
    $eventNum = 0;
    $today = $date == date('Y-m-d') ? "today" : "";
    if ($date < date('Y-m-d')) {
      $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs' disabled>N/A</button>";
    } elseif (in_array($date, $bookings)) {
      $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Booked</button>";
    } else {
      $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='addingscheduled.php?date=" . $date . "' class='btn btn-success btn-xs' style='text-decoration: none;'> Book Now</a>";
    }

    $calendar .= "</td>";
    $currentDay++;
    $dayOfWeek++;
  }

  if ($dayOfWeek != 7) {

    $remainingDays = 7 - $dayOfWeek;
    for ($l = 0; $l < $remainingDays; $l++) {
      $calendar .= "<td class='empty'></td>";
    }
  }

  $calendar .= "</tr>";
  $calendar .= "</table>";
  echo $calendar;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    @media only screen and (max-width: 760px),
    (min-device-width: 802px) and (max-device-width: 1020px) {
      table,
      thead,
      tbody,
      th,
      td,
      tr {
        display: block;
      }

      .empty {
        display: none;
      }

      th {
        position: absolute;
        top: -9999px;
        left: -9999px;
      }

      tr {
        border: 1px solid #ccc;
      }

      td {
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
      }

      td:nth-of-type(1):before {
        content: "Sunday";
      }

      td:nth-of-type(2):before {
        content: "Monday";
      }

      td:nth-of-type(3):before {
        content: "Tuesday";
      }

      td:nth-of-type(4):before {
        content: "Wednesday";
      }

      td:nth-of-type(5):before {
        content: "Thursday";
      }

      td:nth-of-type(6):before {
        content: "Friday";
      }

      td:nth-of-type(7):before {
        content: "Saturday";
      }

    }

    @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
      body {
        padding: 0;
        margin: 0;
      }
    }

    @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
      body {
        width: 495px;
      }
    }

    @media (min-width:641px) {
      table {
        table-layout: fixed;
      }

      td {
        width: 33%;
      }
    }

    .row {
      margin-top: 20px;
    }

    .today {
      background: rgb(91, 192, 248);
      color: black;

    }
  </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="wrapper">

    <nav class="main-header navbar navbar-expand">

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="logout.php" role="button" style="color: red;">
            <p> Log out <i class="ion ion-log-out"></i></p>
          </a>
          <div class="navbar-search-block">
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#0e386e;">

      <a href="#" class="brand-link">
        <img src="headerbareng.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">BCS | Admin</span>
      </a>

      <div class="sidebar">

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="dashboard.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="Scheduled_Customers.php" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Scheduled Customer
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="Pending.php" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Pending
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="Inquiry.php" class="nav-link">
                <i class="nav-icon fas fa-users "></i>
                <p>
                  Inquiry
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="Admin Account.php" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Admin Account
                </p>
              </a>
            </li>

          </ul>
        </nav>
      </div>
    </aside>



    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>

              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger elevation-4">
                <div class="inner">
                  <?php
                  $sql = "select *from pending";
                  $sql_run = mysqli_query($conn, $sql);
                  $id = 0;
                  if ($sql_run) {
                    while ($row = mysqli_fetch_assoc($sql_run)) {
                      $id++;
                    }
                  }
                  echo '<h3> ' . $id . ' </h3>';
                  ?>
                  <p>Pending</p>
                </div>
                <div class="icon">
                  <i class="fas fa-table"></i>
                </div>
                <a href="Pending.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success elevation-4">
                <div class="inner">

                  <?php
                  $sql = "select *from pending_scheduled";
                  $sql_run = mysqli_query($conn, $sql);
                  $id = 0;
                  if ($sql_run) {
                    while ($row = mysqli_fetch_assoc($sql_run)) {
                      $id++;
                    }
                  }
                  echo '<h3> ' . $id . ' </h3>';
                  ?>

                  <p>Scheduled Customers</p>
                </div>
                <div class="icon">
                  <i class="nav-icon far fa-calendar"></i>
                </div>
                <a href="Scheduled_Customers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info elevation-4">
                <div class="inner">
                  <?php
                  $sql = "select *from inquiry";
                  $sql_run = mysqli_query($conn, $sql);
                  $id = 0;
                  if ($sql_run) {
                    while ($row = mysqli_fetch_assoc($sql_run)) {
                      $id++;
                    }
                  }
                  echo '<h3> ' . $id . ' </h3>';
                  ?>
                  <p>Inquiries</p>
                </div>
                <div class="icon">
                  <i class="fas fa-users"></i>
                </div>
                <a href="Inquiry.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-indigo elevation-4">
                <div class="inner">
                  <?php
                  $sql = "select *from admin";
                  $sql_run = mysqli_query($conn, $sql);
                  $id = 0;
                  if ($sql_run) {
                    while ($row = mysqli_fetch_assoc($sql_run)) {
                      $id++;
                    }
                  }
                  echo '<h3> ' . $id . ' </h3>';
                  ?>
                  <p>Admin Account</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="Admin Account.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


          </div>

        </div>
        <div class="container">
          <div class="row">
            <div class="alert alert-danger elevation-4" style="background: rgb(0, 129, 201); border:none; color:#fff; border-radius:5px;">
              <?php
              $dateComponents = getdate();
              if (isset($_GET['month']) && isset($_GET['year'])) {
                $month = $_GET['month'];
                $year = $dateComponents['year'];
              } else {
                $month = $dateComponents['month'];
                $year = $dateComponents['year'];
              }

              echo build_Calendar($month, $year);
              ?>

            </div>
          </div>
        </div>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2023 <a href="#">BCSs</a>.</strong> All rights reserved.
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>



</body>

</html>