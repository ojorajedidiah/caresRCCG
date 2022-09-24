<?php include('includes/header.php'); ?>
<?php
session_start();
$errRole = '';
if (isset($_POST['saveNew'])) {
  if (canSave()) {
    $errRole = createNewRole();
  }
  $_REQUEST['p'] = "update";
}

if (isset($_POST['updateRec'])) {
  if (canSaveEdit()) {
    $errRole = UpdateRole();
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
                    <li class="breadcrumb-item acive"> User Roles </li>
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
                      <h5>User Role Management</h5>
                      <?php if ($errRole != '') {
                        echo '<span style="color:red;font-size:15px;">' . $errRole . '</span>';
                      } ?>
                    </div>
                    <div class="col-sm-6">
                      <?php if (isset($_REQUEST['p']) && ($_REQUEST['p'] == 'new' || $_REQUEST['p'] == 'edit' || $_REQUEST['p'] == 'delete')) { ?>
                        <a href="roleMgt.php" class="btn btn-danger float-right">Back</a>
                      <?php } else { ?>
                        <a href="roleMgt.php?p=new" class="btn btn-secondary float-right">Create New Role</a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'new') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Create New Role</h3>
                      </div>
                      <form method="post" target="">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="roleName">Role</label>
                                <input type="text" class="form-control" name="roleName" id="roleName" placeholder="Enter RoleName" required>                                
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="card-body">
                              <div class="form-group">
                                <button type="submit" id="saveNew" name="saveNew" class="btn btn-success float-right">Create Role</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php } else if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'delete') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Disable Role</h3>
                      </div>
                      <form method="post" target="">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="roleName">Role</label>
                                <input type="text" class="form-control" name="roleName" id="roleName" required value="<?php echo getSpecificRole($_REQUEST['rid']); ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="card-body">
                              <!-- <div class="form-group"> -->
                                <!-- <label for="deleteRec"></label> -->
                                <button type="submit" id="deleteRec" name="deleteRec" class="btn btn-success float-right">Disable Role</button>
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
                        <h3 class="card-title">Edit Role</h3>
                      </div>
                      <form method="post" target="">
                        <div class="row">
                          <div class="col-sm-8">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="roleName">Role</label>
                                <input type="text" class="form-control" name="roleName" id="roleName" required value="<?php echo getSpecificRole($_REQUEST['rid']); ?>">
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="roleStatus">Status</label>
                                <select class="custom-select rounded-0" name="roleStatus" id="roleStatus" required>
                                  <?php echo getRoleStatus($_REQUEST['db_Status']); ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="card-body">
                              <div class="form-group">
                                <button type="submit" id="updateRec" name="updateRec" class="btn btn-success float-right">Update Role</button>
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
                      <table id="roles" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="460px">Role Name</th>
                            <th width="100px">Status</th>
                            <!-- <th width="100px">Date Created</th> -->
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
      $("#roles").DataTable({
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
function getAccountRecords()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT roleID,roleName,roleStatus,roleAccess FROM roles r ORDER BY roleID ASC";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rN = $row['roleName'];
        $rAcc = $row['roleAccess'];
        $rID = $row['roleID'];
        $rS = $row['roleStatus'];
        $rtn .= '<tr><td>' . $rN . '</td><td>' . $rS . '</td><td><span class="badge badge-complete"><a href="roleMgt.php?p=delete&rid=' . $rID . '">
                    <i class="nav-icon fas fa-user-lock" title="Disable Role" style="color:red;"></i>
                    </a></span><span class="badge badge-edit"><a href="roleMgt.php?p=edit&rid=' . $rID . '">
                    <i class="nav-icon fas fa-edit" title="Edit Role" style="color:green;"></i></a></span></td></tr>';
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($db->connectionError());
  }
  return ($rtn == '') ? '<tr><td colspan="5"><b>No Role Data</b></td></tr>' : $rtn;
}

function getSpecificRole($rec)
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
  return ($rtn == '') ? 'No Role Data' : $rtn;
}

function UpdateRole()
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

  return ($rtn == '') ? 'No Role Data' : $rtn;
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
        trigger_error("This Role already exist in the Database!<br>Kindly pick a different Role Name", E_USER_NOTICE);
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
        trigger_error("This Role already exist in the Database!<br>Kindly pick a different Role Name", E_USER_NOTICE);
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

function createNewRole()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "INSERT INTO roles (roleName) VALUES (:roleN)";
      $stmt = $con->prepare($sql);
      $stmt->bindparam(":roleN", $_REQUEST['roleName'], PDO::PARAM_STR);
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The new Account <b>" . $_REQUEST['roleName'] . "</b> has been created";
        //trigger_error($msg, E_USER_NOTICE);
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($e->getMessage());
  }

  return ($rtn == '') ? 'No Role Data' : $rtn;
}

function getRoleStatus($rec)
{
  $rtn = '<option selected value="' . $rec . '" >' . ucwords($rec) . '</option>';
  if ($rec == 'active') {
    $rtn .= '<option value="not active" >Not Active</option>';
  } else {
    $rtn .= '<option value="active" >Active</option>';
  }

  return $rtn;
  // try {
  //   $db = new connectDatabase();
  //   if ($db->isLastQuerySuccessful()) {
  //     $con = $db->connect();

  //     $sql = "SELECT roleStatus FROM roles WHERE roleID=$rec";
  //     $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  //     $stmt->execute();
  //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

  //     foreach ($stmt->fetchAll() as $row) {
  //       $sN = $row['roleName'];
  //       $sID = $row['roleID'];
  //       if ($sID == $rec) {
  //         $rtn .= '<option selected value="' . $sID . '" >' . $sN . '</option>';
  //       } else {
  //         $rtn .= '<option value="' . $sID . '" >' . $sN . '</option>';
  //       }
  //     }
  //   } else {
  //     trigger_error($db->connectionError());
  //   }
  //   $db->closeConnection();
  // } catch (PDOException $e) {
  //   trigger_error($db->connectionError());
  // }
  // return ($rtn == '') ? '<option value="">No Role Data</option>' : $rtn;
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