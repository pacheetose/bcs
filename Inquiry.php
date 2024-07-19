<?php
include 'connect.php';
include 'session.php';
$email = $_SESSION['email'];
$id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inquiry</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
              <a href="Dashboard.php" class="nav-link">
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
              <h1>Inquiry</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="Dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Scheduled</a></li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">

        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">

                <div class="container">
                  <Br><br>
                  <table id="datatableid" class="table table-hover">

                    <thead>
                      <tr>


                        <th scope="col">Name</th>
                        <th scope="col">Phone No.</th>
                        <th scope="col">Email</th>
                        <th scope="col">Inquiry</th>
                        <th scope="col">Date</th>
                        <th scope="col"> </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $sql = "select * from inquiry";
                      $result = mysqli_query($conn, $sql);
                      if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {

                          $id = $row['id'];
                          $FNAME = $row['FNAME'];
                          $LNAME = $row['LNAME'];
                          $PNUM = $row['PNUM'];
                          $EMAIL = $row['EMAIL'];
                          $INQUIRY = $row['INQUIRY'];
                          $Date = $row['Date'];



                          echo '<tr>
        <th scope="row">' . $FNAME . ' ' . $LNAME . '</th>
           <td>' . $PNUM . '</td>
           <td>' . $EMAIL . '</td>
           <td>' . $INQUIRY . '</td>
           <td>' . $Date . '</td>


           <td>
           <a href="Inquiry_views.php? viewmsg=' . $id . '"><i class="fa fa-search" style="color:blue"></i></a>
           <a href="delete_inquiry.php? deletemsg=' . $id . '"><i class="fa fa-trash" style="color:red"></i></a>

           
           </td>
           
       </tr>';
                        }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; 2023 <a href="#">BCS</a>.</strong> All rights reserved.
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

  <script>
    $(document).ready(function() {
      $("#datatableid").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,


      }).buttons().container().appendTo('#datatableid_wrapper .col-md-6:eq(0)');

      /* $('#datatableid').DataTable({
           lengthMenu: [
               [10, 25, 50, -1],
               [10, 25, 50, 'All'],
           ],

           pagingType: 'full_numbers',*/

    });
  </script>

</body>

</html>