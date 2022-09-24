<?php include('includes/header.php'); ?>
<?php
session_start();
$errGuest = '';
if (isset($_POST['saveNew'])) {
  if (canSave()) {
    $errGuest = createNewGuest();
  }
  $_REQUEST['p'] = "update";
}

if (isset($_POST['updateRec'])) {
  if (canSaveEdit()) {
    $errGuest = UpdateGuest();
  }
  $_REQUEST['p'] = "update";
}
?>
<style>
  #users.tbody th,
  #users tbody td {
    height: 5px;
  }
</style>

<body class="hold-transition layout-top-nav">

  <div id="app">
    <div class="wrapper">
      <?php include('includes/top_menu.php'); ?>

      <div class="content-wrapper">
        <div class="container">
          <div class="content-header">
            <div class="container">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">RCCG Overcomers Cares</h1>
                  <h3 class="card-title" style="color:cadetblue;"><?php echo userDetails(); ?></h3>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                    <li class="breadcrumb-item acive"> Guests </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="content">
            <div class="container-fluid" style="width:70%;">
              <div class="card card-outline card-primary">
                <div class="card-header">
                  <div class="row">
                    <div class="col-sm-6">
                      <h5>Guest Management</h5>
                      <?php if ($errGuest != '') {
                        echo '<span style="color:red;font-size:15px;">' . $errGuest . '</span>';
                      } ?>
                    </div>
                    <div class="col-sm-6">
                      <?php if (isset($_REQUEST['p']) && ($_REQUEST['p'] == 'new' || $_REQUEST['p'] == 'edit' || $_REQUEST['p'] == 'promote')) { ?>
                        <a href="guests.php" class="btn btn-danger float-right">Back</a>
                      <?php } else { ?>
                        <a href="guests.php?p=new" class="btn btn-secondary float-right">Create New Guest</a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'new') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Create New Guest</h3>
                      </div>
                      <form method="post" target="">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="guestName">Guest</label>
                                <input type="text" class="form-control" name="guestName" id="guestName" placeholder="Enter GuestName" required>                                
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="card-body">
                              <div class="form-group">
                                <button type="submit" id="saveNew" name="saveNew" class="btn btn-success float-right">Create Guest</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php } else if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'promote') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Promote Guest</h3>
                      </div>
                      <form method="post" target="">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="guestName">Guest</label>
                                <input type="text" class="form-control" name="guestName" id="guestName" required value="<?php echo getSpecificGuest($_REQUEST['rid']); ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="card-body">
                              <!-- <div class="form-group"> -->
                                <!-- <label for="deleteRec"></label> -->
                                <button type="submit" id="deleteRec" name="deleteRec" class="btn btn-success float-right">Promote Guest</button>
                              <!-- </d/   iv> -->
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php } else if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'edit') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Edit Guest</h3>
                      </div>
                      <form method="post" target="">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="guestName">Guest</label>
                                <input type="text" class="form-control" name="guestName" id="guestName" required value="<?php echo getSpecificGuest($_REQUEST['rid']); ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="roleStatus">Status</label>
                                <select class="custom-select rounded-0" name="roleStatus" id="roleStatus" required>
                                  <?php echo getGuestStatus($_REQUEST['db_Status']); ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="card-body">
                              <div class="form-group">
                                <button type="submit" id="updateRec" name="updateRec" class="btn btn-success float-right">Update Guest</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="row">
                    <div class="card-body">
                      <table id="guests" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="360px">Guest Name</th>
                            <th width="100px">Status</th>
                            <!-- <th width="100px">Date of Salvation</th> -->
                            <th width="100px">Visit Date</th>
                            <th width="40px">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php echo getAccountRecords(); ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <!-- </div> -->
      </div>
    </div>


    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">
        Powered by <strong>RCCG Overcomers</strong> | Media Unit
      </div>
      Copyright &copy <span id="copy"><?php echo date('Y'); ?></span>
    </footer>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/adminlte.min.js"></script>

  <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="assets/plugins/jszip/jszip.min.js"></script>
  <script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script>
    $(function() {
      $("#guests").DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": ["excel", "pdf", "colvis"]
      }).buttons().container().appendTo('#role_wrapper .col-md-6:eq(0)');;
    });
  </script>
</body>

</html>


<?php

function createNewGuest() 
{

}

function getGuestStatus()
{
  
}

function getAccountRecords()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT guestID,guestVisitDate,guestStatus,CONCAT(guestFirstName,' ',guestLastName) as guestName FROM guests ORDER BY guestID ASC";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rN = $row['guestName'];
        $rVstDate = $row['guestVisitDate'];
        $rID = $row['guestID'];
        $rS = $row['guestStatus'];
        $rtn .= '<tr><td>' . $rN . '</td><td>' . $rS . '</td><td>' . $rVstDate . '</td>'
            . '<td><span class="badge badge-complete"><a href="guests.php?p=promote&rid=' . $rID . '">'
            . '<i class="nav-icon fas fa-user-lock" title="Promote Guest" style="color:green;"></i>'
            . '</a></span><span class="badge badge-edit"><a href="guests.php?p=edit&rid=' . $rID . '">'
            . '<i class="nav-icon fas fa-edit" title="Edit Guest" style="color:blue;"></i></a></span></td></tr>';
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (Exception $e) {
    trigger_error($db->connectionError());
  }
  return ($rtn == '') ? '<tr><td colspan="4" style="color:red;text-align:center;"><b>No Guest Data</b></td></tr>' : $rtn;
}

function getSpecificGuest($rec)
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT roleID,roleName,roleStatus FROM roles WHERE roleID = $rec";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn = $row['roleName'];
        $_REQUEST['db_Status'] = $row['roleStatus'];
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($db->connectionError());
  }
  return ($rtn == '') ? 'No Guest Data' : $rtn;
}

function UpdateGuest()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "UPDATE roles SET roleName= :roleN, roleStatus= :roleS WHERE roleID=:roleID";

      $stmt = $con->prepare($sql);
      $stmt->bindparam(":roleN", $_REQUEST['roleName'], PDO::PARAM_STR);
      $stmt->bindparam(":roleS", $_REQUEST['roleStatus']);
      $stmt->bindparam(":roleID", $_REQUEST['rid']);

      $row = $stmt->execute();

      if ($row) {
        $rtn = "The Account <b>" . $_REQUEST['roleName'] . "</b> has been updated";
        //trigger_error($msg, E_USER_NOTICE);
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($e->getMessage());
  }

  return ($rtn == '') ? 'No Guest Data' : $rtn;
}

function canSave()
{
  $rtn = true;
  try {
    $rol = $_REQUEST['roleName'];
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "SELECT * FROM roles WHERE roleName = '$rol'";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn = false;
        trigger_error("This Guest already exist in the Database!<br>Kindly pick a different Guest Name", E_USER_NOTICE);
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($db->connectionError());
  }

  return $rtn;
}

function canSaveEdit()
{
  $rtn = true;
  try {
    $rol = $_REQUEST['roleName'];
    $rSta = $_REQUEST['roleStatus'];
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "SELECT * FROM roles WHERE roleName = '$rol' AND roleStatus = '$rSta'";
      //trigger_error($sql,E_USER_NOTICE);
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn = false;
        trigger_error("This Guest already exist in the Database!<br>Kindly pick a different Guest Name", E_USER_NOTICE);
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($db->connectionError());
  }

  return $rtn;
}

function userDetails()
{
  $rtn = '';
  if (isset($_SESSION['fullname'])) {
    $rtn = $_SESSION['fullname'] . " (" . $_SESSION['role'] . ")";
  } else {
    $rtn = 'No User Details';
  }

  return $rtn;
}

?>