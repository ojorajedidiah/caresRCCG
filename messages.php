<style>
  #msgs.tbody th,
  #msgs tbody td {
    height: 5px;
  }
</style>

<?php include('includes/header.php'); ?>
<?php
session_start();
$_SESSION['msgErr']='';
$errMsg = '';
if (isset($_REQUEST['saveRec'])) {
  if (canSave()) {
    $errMsg = createNewMsg();
    $_REQUEST['p'] = "update";
  } else {
    $errMsg=$_SESSION['msgErr'];
    $_REQUEST['p'] = "new";
  }
  
}

if (isset($_POST['updateRec'])) {
  if (canSaveEdit()) {
    $errMsg = UpdateMsg();
    $_REQUEST['p'] = "update";
  }else {
    $errMsg=$_SESSION['msgErr'];
    $_REQUEST['p'] = "edit";
  }
  
}

if (isset($_POST['deleteRec'])) {
  // if (canSaveEdit()) {
  //   $errMsg = UpdateMsg();
  //   $_REQUEST['p'] = "update";
  // }else {
  //   $errMsg=$_SESSION['msgErr'];
  //   $_REQUEST['p'] = "edit";
  // }  
}
?>


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
                    <li class="breadcrumb-item acive"> Messages </li>
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
                    <div class="col-sm-8">
                      <h5>Messages</h5>
                      <?php if ($errMsg != '') { echo '<span style="color:red;font-size:15px;">' . $errMsg . '</span>'; } ?>
                    </div>
                    <div class="col-sm-4">
                      <?php if (isset($_REQUEST['p']) && ($_REQUEST['p'] == 'new' || $_REQUEST['p'] == 'edit' || $_REQUEST['p'] == 'delete')) { ?>
                        <a href="messages.php" class="btn btn-danger float-right">Back</a>
                      <?php } else { ?>
                        <a href="messages.php?p=new" class="btn btn-secondary float-right">Create New Message</a>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'new') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Create New Message</h3>
                      </div>
                      <form method="post" target="">
                        <?php echo buildNewForm(); ?>                        
                      </form>
                    </div>
                  </div>
                <?php } else if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'delete') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Disable Message</h3>
                      </div>
                      <form method="post" target="">
                        <?php echo buildPromoteForm($_REQUEST['rid']) ?>
                      </form>
                    </div>
                  </div>
                <?php } else if (isset($_REQUEST['p']) && $_REQUEST['p'] == 'edit') { ?>
                  <div class="row">
                    <div class="card-body card-secondary">
                      <div class="card-header">
                        <h3 class="card-title">Edit Message</h3>
                      </div>
                      <form method="post" target="">
                        <?php echo buildEditForm($_REQUEST['rid']); ?> 
                      </form>
                    </div>
                  </div>
                <?php } else { ?>
                  <div class="row">
                    <div class="card-body">
                      <table id="msgs" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="130px">Message Type</th>
                            <th width="350px">Message</th>
                            <th width="100px">Status</th>
                            <th width="50px">Actions</th>
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
      $("#msgs").DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        //"buttons": ["excel", "pdf", "colvis"]
      }).buttons().container().appendTo('#msgs_wrapper .col-md-6:eq(0)');;
    });
  </script>
</body>

</html>


<?php
///--------------------------------------------------
///------------- Geenral DML functions --------------
///--------------------------------------------------

function createNewMsg() 
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "INSERT INTO sec_cares (secUserName,secPassword,secFullName,secCreatedDate,secPhone,secEmail,secRole) 
        VALUES (:secUN,:secPwd,:secFuN,:secCrD,:secPhn,:secEm,:secRol)";

      $stmt = $con->prepare($sql);
      $stmt->bindparam(":secUN", $_REQUEST['secUserName'], PDO::PARAM_STR);
      $stmt->bindparam(":secPwd", $_REQUEST['secPassword'], PDO::PARAM_STR);
      $stmt->bindparam(":secFuN", $_REQUEST['secFullName'], PDO::PARAM_STR);
      $stmt->bindparam(":secCrD", $_REQUEST['secCreatedDate'], PDO::PARAM_STR);
      $stmt->bindparam(":secPhn", $_REQUEST['secPhone'], PDO::PARAM_STR);
      $stmt->bindparam(":secEm", $_REQUEST['secEmail'], PDO::PARAM_STR);
      $stmt->bindparam(":secRol", $_REQUEST['secRole'], PDO::PARAM_STR);
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The Account <b>" . $_REQUEST['secFullName'] . "</b> has been created!";
        //trigger_error($msg, E_USER_NOTICE);
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($e->getMessage());
  }

  return ($rtn == '') ? 'No Message Data' : $rtn;
}

function UpdateMsg()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "UPDATE sec_cares SET secUserName= :secUN, secFullName=:secFuN, secPhone=:secPhn, secEmail=:secEm, secRole=:secRol WHERE secID=:recID";

      $stmt = $con->prepare($sql);
      $stmt->bindparam(":recID", $_REQUEST['rid'], PDO::PARAM_INT);
      $stmt->bindparam(":secUN", $_REQUEST['secUserName'], PDO::PARAM_STR);      
      $stmt->bindparam(":secFuN", $_REQUEST['secFullName'], PDO::PARAM_STR);
      $stmt->bindparam(":secPhn", $_REQUEST['secPhone'], PDO::PARAM_STR);
      $stmt->bindparam(":secEm", $_REQUEST['secEmail'], PDO::PARAM_STR);
      $stmt->bindparam(":secRol", $_REQUEST['secRole'], PDO::PARAM_STR);
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The Account <b>" . $_REQUEST['secFullName'] . "</b> has been updated";
        //trigger_error($msg, E_USER_NOTICE);
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($e->getMessage());
  }

  return ($rtn == '') ? 'No Message Data' : $rtn;
}

function getAccountRecords()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      
      $sql = "SELECT secID,secFullName,secCreatedDate,secRole FROM sec_cares ORDER BY secID ASC";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rFN = $row['secFullName'];
        $rCDate = $row['secCreatedDate'];
        $rID = $row['secID'];
        $rS = $row['secRole'];
        $rtn .= '<tr><td>' . $rFN . '</td><td>' . $rS . '</td><td>' . $rCDate . '</td>'
            . '<td><span class="badge badge-complete"><a href="messages.php?p=delete&rid=' . $rID . '">'
            . '<i class="nav-icon fas fa-user-lock" title="Disable Message" style="color:red;"></i>'
            . '</a></span><span class="badge badge-edit"><a href="messages.php?p=edit&rid=' . $rID . '">'
            . '<i class="nav-icon fas fa-edit" title="Edit Message" style="color:blue;"></i></a></span></td></tr>';
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (Exception $e) {
    trigger_error($db->connectionError());
  }
  return ($rtn == '') ? '<tr><td colspan="4" style="color:red;text-align:center;"><b>No Message</b></td></tr>' : $rtn;
}

function getSpecificGuest($rec)
{
  $rtn = array();
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT secUserName,secFullName,secPhone,secEmail,secRole FROM sec_cares WHERE secID = $rec";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn=$row;
      }
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    trigger_error($db->connectionError());
  }
  return (count($rtn) >= 1) ? $rtn : 'No Message Data';
}

///--------------------------------------------------
///-------------- Build Form functions --------------
///--------------------------------------------------
function buildEditForm($id)
{
  $rtn='';$sec=array();
  $sec=getSpecificGuest($id);
  // die('the value is '.$sec['guestVisitDate']);
  //secUserName,,,,,,secRole
  if (is_array($sec) && count($sec) >= 1){
    // $dat=new DateTime($sec['secCreatedDate']); 
    $rtn.='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="secFullName">User FullName</label>';
    $rtn.='<input type="text" class="form-control" name="secFullName" id="secFullName" value="'.$sec['secFullName'].'" required></div></div>';

    $rtn.='<div class="col-sm-6"><div class="form-group"><label for="secUserName">UserName</label>';
    $rtn.='<input type="text" class="form-control" name="secUserName" id="secUserName" value="'.$sec['secUserName'].'" required></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-4"><label for="secRole">User Role</label><div class="form-group">';
    $rtn.='<select class="form-control" id="secRole" name="secRole" required>';

    $rtn.=($sec['secRole'] == "Administrator")? '<option value="Administrator" selected>Administrator</option>': '<option value="Administrator">Administrator</option>';
    $rtn.=($sec['secRole'] == "Media")? '<option value="Media" selected>Media</option>': '<option value="Media">Media</option>';
    $rtn.=($sec['secRole'] == "Pastorate")? '<option value="Pastorate" selected>Pastorate</option>': '<option value="Pastorate">Pastorate</option>';
    $rtn.=($sec['secRole'] == "Hospitality")? '<option value="Hospitality" selected>Hospitality</option>': '<option value="Hospitality">Hospitality</option>';
    $rtn.='</select></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="secPhone">User Mobilenumber</label>';
    $rtn.='<input type="text" class="form-control" name="secPhone" id="secPhone" value="'.$sec['secPhone'].'" required></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="secEmail">User email</label>';
    $rtn.='<input type="email" class="form-control" name="secEmail" id="secEmail" value="'.$sec['secEmail'].'" required></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-12"><div class="form-group">';
    $rtn.='<button type="submit" id="updateRec" name="updateRec" class="btn btn-success float-right">Update User</button></div></div></div>';
  }

  // die('the value is '.$rtn);
  $_SESSION['oldRec']=$sec;
  return $rtn;
}

function buildNewForm()
{
  $rtn='<div class="row"><div class="col-sm-6"><label for="msgCategory">Message Category</label><div class="form-group">';
  $rtn.='<select class="form-control" id="msgCategory" name="msgCategory" required >';
  $rtn.='<option value="Sunday" selected>Sundays</option><option value="Tuesday">Tuesdays</option>';
  $rtn.='<option value="Thursday">Thursdays</option><option value="Special">Specials</option>';
  $rtn.='</select></div>';
  
  $rtn.='<div class="form-group"><label for="msgBody">SMS Template</label>';
  $rtn.='<textarea class="form-control" rows="6" name="msgBody" id="msgBody" spellcheck="true">Dear {visitor}, we appreciate ...</textarea></div></div>';

  $rtn.='<div class="col-sm-6"><div class="form-group"><label for="msgSpecialName">Special Programme</label>';
  $rtn.='<input type="text" class="form-control" name="msgSpecialName" id="msgSpecialName" placeholder="Enter Special Programme Name"></div>';

  $rtn.='<div class="form-group"><label for="msgSpecialDate">Special Programme Date</label>';
  $rtn.='<input type="text" class="form-control" name="msgSpecialDate" id="msgSpecialDate" placeholder="Enter Special Programme Date"></div>';

  $rtn.='<div class="form-group"><label for="msgScheduleTime">Special Programme Scheduled SMS Time</label>';
  $rtn.='<input type="text" class="form-control" name="msgScheduleTime" id="msgScheduleTime" placeholder="Enter time to send SMS"></div>';

  $rtn.='<div class="form-group">';
  $rtn.='<button type="submit" id="saveRec" name="saveRec" class="btn btn-success float-right">Save New Message</button></div></div></div>';

  return $rtn;
}

function buildDeleteForm($id)
{
  $rtn='';$gst=array();
  $gst=getSpecificGuest($id);
  // die('the value is '.$gst['guestVisitDate']);
  if (is_array($gst) && count($gst) >= 1){
    $dat=new DateTime($gst['guestVisitDate']); //$dat->format('D d M, Y');
    $rtn.='<div class="row"><div class="col-sm-4"><div class="form-group"><label for="guestVisitDate">Date as Guest</label>';
    $rtn.='<input type="text" class="form-control" name="guestVisitDate" id="guestVisitDate" value="'.$dat->format('D d F, Y').'" readonly></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestFirstName">Guest FirstName</label>';
    $rtn.='<input type="text" class="form-control" name="guestFirstName" id="guestFirstName" value="'.$gst['guestFirstName'].'" readonly></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestLastName">Guest Surname</label>';
    $rtn.='<input type="text" class="form-control" name="guestLastName" id="guestLastName" value="'.$gst['guestLastName'].'" readonly></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-3"><label for="guestSex">Guest Sex</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestSex" name="guestSex" disabled>'; //<option value="Male">Male</option>';
    if ($gst['guestSex'] == "Male") { $rtn.='<option value="Male" selected>Male</option><option value="Female">Female</option></select></div></div>'; }
    else {$rtn.='<option value="Male">Male</option><option value="Female" selected>Female</option></select></div></div>';}

    $rtn.='<div class="col-sm-3"><label for="guestLastName">Resident in Abuja?</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestResident" name="guestResident" disabled>';
    if ($gst['guestResident'] == "yes") { $rtn.='<option value="yes" selected>Yes</option><option value="no">No</option></select></div></div>'; }
    else {$rtn.='<option value="yes">Yes</option><option value="no" selected>No</option></select></div></div>';}

    $rtn.='<div class="col-sm-3"><label for="guestMembership">Member of RCCG?</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestMembership" name="guestMembership" disabled>';
    if ($gst['guestMembership'] == "yes") { $rtn.='<option value="yes" selected>Yes</option><option value="no">No</option></select></div></div>'; }
    else {$rtn.='<option value="yes">Yes</option><option value="no" selected>No</option></select></div></div>';}

    $rtn.='<div class="col-sm-3"><label for="guestAgeRange">Age Range</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestAgeRange" name="guestAgeRange" disabled>';
    $rtn.=($gst['guestAgeRange'] == "13-20")? '<option value="13-20" selected>13-20</option>': '<option value="13-20">13-20</option>';
    $rtn.=($gst['guestAgeRange'] == "21-40")? '<option value="21-40" selected>21-40</option>': '<option value="21-40">21-40</option>';
    $rtn.=($gst['guestAgeRange'] == "41-50")? '<option value="41-50" selected>41-50</option>': '<option value="41-50">41-50</option>';
    $rtn.=($gst['guestAgeRange'] == "50+")? '<option value="50+" selected>50+</option>': '<option value="50+">50+</option></select></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-4"><div class="form-group"><label for="guestPhone">Guest Mobilenumber</label>';
    $rtn.='<input type="text" class="form-control" name="guestPhone" id="guestPhone" value="'.$gst['guestPhone'].'" readonly></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestEmail">Guest email</label>';
    $rtn.='<input type="email" class="form-control" name="guestEmail" id="guestEmail" value="'.$gst['guestEmail'].'" readonly></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestOccupation">Guest Occupation</label>';
    $rtn.='<input type="text" class="form-control" name="guestOccupation" id="guestOccupation" value="'.$gst['guestOccupation'].'" readonly></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="guestHomeAddress">Guest Home Address</label>';
    $rtn.='<textarea class="form-control" rows="5" name="guestHomeAddress" id="guestHomeAddress" readonly>'.$gst['guestHomeAddress'].'</textarea></div></div>';

    $rtn.='<div class="col-sm-6"><div class="form-group"><label for="guestServiceReport">Tell us about the Service</label>';
    $rtn.='<textarea class="form-control" rows="5" name="guestServiceReport" id="guestServiceReport" spellcheck="true" readonly>'.$gst['guestServiceReport'].'</textarea></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-12"><div class="form-group">';
    $rtn.='<button type="submit" id="promoteRec" name="promoteRec" class="btn btn-success float-right">Promote Guest</button></div></div></div>';
  }

  // die('the value is '.$rtn);
  $_SESSION['oldRec']=$gst;
  return $rtn;
}


///--------------------------------------------------
///---------- Data Verification functions -----------
///--------------------------------------------------
function canSave()
{
  $rtn = true;
  try {
    $phone = $_REQUEST['secPhone'];
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "SELECT * FROM sec_cares WHERE secPhone = '$phone'";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn = false;
        trigger_error("This Message already exist in the Database!", E_USER_NOTICE);
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
  $rtn = false;$cse=array();$oldRec=$_SESSION['oldRec'];

  $cse['secUserName']=$_REQUEST['secUserName'];
  $cse['secFullName']=$_REQUEST['secFullName'];
  $cse['secPhone']=$_REQUEST['secPhone'];
  $cse['secEmail']=$_REQUEST['secEmail'];
  $cse['secRole']=$_REQUEST['secRole'];

  if (count(array_diff($oldRec,$cse)) >= 1){
    $rtn=true;
  } else {
    $_SESSION['msgErr']='No new data to update!';
    $rtn = false;
  }
  return $rtn;
}

///--------------------------------------------------
///------------ general-purpose functions -----------
///--------------------------------------------------

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

function getToday()
{
  $dt=new DateTime('now');
  return $dt->format('Y-m-d'); 
}

?>