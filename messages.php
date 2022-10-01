<?php
//session_start();
$_SESSION['msgErr'] = '';
$errMsg = '';
if (isset($_REQUEST['saveRec'])) {
  if (canSave()) {
    $errMsg = createNewMsg();
    $_REQUEST['v'] = "update";
  } else {
    $errMsg = $_SESSION['msgErr'];
    $_REQUEST['v'] = "new";
  }
}

if (isset($_POST['updateRec'])) {
  if (canSaveEdit()) {
    $errMsg = UpdateMsg();
    $_REQUEST['v'] = "update";
  } else {
    $errMsg = $_SESSION['msgErr'];
    $_REQUEST['v'] = "edit";
  }
}

if (isset($_POST['deleteRec'])) {
  // if (canSaveEdit()) {
  //   $errMsg = UpdateMsg();
  //   $_REQUEST['v'] = "update";
  // }else {
  //   $errMsg=$_SESSION['msgErr'];
  //   $_REQUEST['v'] = "edit";
  // }  
}
?>


<div class="content">
  <div class="container-fluid" style="width:70%;">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <div class="row">
          <div class="col-sm-8">
            <h5>Messages</h5>
            <?php if ($errMsg != '') {
              echo '<span style="color:red;font-size:15px;">' . $errMsg . '</span>';
            } ?>
          </div>
          <div class="col-sm-4">
            <?php if (isset($_REQUEST['v']) && ($_REQUEST['v'] == 'new' || $_REQUEST['v'] == 'edit' || $_REQUEST['v'] == 'delete')) { ?>
              <a href="home?p=messages" class="btn btn-danger float-right">Back</a>
            <?php } else { ?>
              <a href="home?p=messages&v=new" class="btn btn-secondary float-right">Create New Message</a>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php if (isset($_REQUEST['v']) && $_REQUEST['v'] == 'new') { ?>
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
      <?php } else if (isset($_REQUEST['v']) && $_REQUEST['v'] == 'delete') { ?>
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
      <?php } else if (isset($_REQUEST['v']) && $_REQUEST['v'] == 'edit') { ?>
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
            <table id="grids" class="table table-bordered table-striped">
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
      if ($_REQUEST['msgCategory'] == 'Special'){
        $sql = "INSERT INTO message_template (msgBody,msgCategory,msgSpecialName,msgSpecialDate,msgScheduleTime) 
          VALUES (:msgBd,:msgCat,:msgSN,:msgSD,:msgST)";

        $stmt = $con->prepare($sql);
        $stmt->bindparam(":msgBd", $_REQUEST['msgBody'], PDO::PARAM_STR);
        $stmt->bindparam(":msgCat", $_REQUEST['msgCategory'], PDO::PARAM_STR);
        $stmt->bindparam(":msgSN", $_REQUEST['msgSpecialName'], PDO::PARAM_STR);
        $stmt->bindparam(":msgSD", $_REQUEST['msgSpecialDate'], PDO::PARAM_STR);
        $stmt->bindparam(":msgST", $_REQUEST['msgScheduleTime'], PDO::PARAM_STR);
      } else {
        $sql = "INSERT INTO message_template (msgBody,msgCategory) 
          VALUES (:msgBd,:msgCat)";

        $stmt = $con->prepare($sql);
        $stmt->bindparam(":msgBd", $_REQUEST['msgBody'], PDO::PARAM_STR);
        $stmt->bindparam(":msgCat", $_REQUEST['msgCategory'], PDO::PARAM_STR);
      }
      
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The Message Template <b>" . $_REQUEST['msgCategory'] . "</b> has been created!";
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

      $sql = "SELECT msgID,msgCategory,msgBody,msgStatus FROM message_template ORDER BY msgID ASC";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $r1 = $row['msgCategory'];
        $r2 = substr($row['msgBody'],0,40);
        $rID = $row['msgID'];
        $r3 = $row['msgStatus']; // home?p=messages&v=delete&rid=' . $rID . '  home?p=messages&v=edit&rid=' . $rID . '
        $rtn .= '<tr><td>' . $r1 . '</td><td>' . $r2 . '...</td><td>' . $r3 . '</td>'
          . '<td><span class="badge badge-complete"><a href="">'
          . '<i class="nav-icon fas fa-user-lock" title="Disable Message" style="color:red;"></i>'
          . '</a></span><span class="badge badge-edit"><a href="">'
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

      $sql = "SELECT msgID,msgBody,msgCategory,msgSpecialName,msgSpecialDate,
        msgScheduleTime,msgStatus FROM message_template WHERE msgID = $rec";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn = $row;
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
  $rtn = '';
  $msg = array();
  $msg = getSpecificGuest($id);
  if (is_array($msg) && count($msg) >= 1) {
    $dat=new DateTime($msg['msgSpecialDate']);
    $tme=new DateTime($msg['msgScheduleTime']);
    $rtn = '<div class="row"><div class="col-sm-6"><label for="msgCategory">Message Category</label><div class="form-group">';
    $rtn .= '<select class="form-control" id="msgCategory" name="msgCategory" required>';
    $rtn.=($msg['msgCategory'] == "Sunday")? '<option value="Sunday" selected>Sundays</option>': '<option value="Sunday">Sundays</option>';
    $rtn.=($msg['msgCategory'] == "Tuesday")? '<option value="Tuesday" selected>Tuesdays</option>': '<option value="Tuesday">Tuesdays</option>';
    $rtn.=($msg['msgCategory'] == "Thursday")? '<option value="Thursday" selected>Thursdays</option>': '<option value="Thursday">Thursdays</option>';
    $rtn.=($msg['msgCategory'] == "Special")? '<option value="Special" selected>Specials</option>': '<option value="Special">Specials</option>';
    $rtn .= '</select></div>';

    $rtn .= '<div class="form-group"><label for="msgBody">SMS Template</label>';
    $rtn .= '<textarea class="form-control" rows="6" name="msgBody" id="msgBody" spellcheck="true" required>'.$msg['msgBody'].'</textarea></div></div>';

    $rtn .= '<div class="col-sm-6"><div class="form-group"><label for="msgSpecialName">Special Programme</label>';
    $rtn .= '<input type="text" class="form-control" name="msgSpecialName" id="msgSpecialName" value="'.$msg['msgSpecialName'].'"></div>';

    $rtn .= '<div class="form-group"><label for="msgSpecialDate">Special Programme Date</label>';
    $rtn .= '<input type="date" class="form-control" name="msgSpecialDate" id="msgSpecialDate" value="'.$dat->format('D d F, Y').'"></div>';

    $rtn .= '<div class="form-group"><label for="msgScheduleTime">Special Programme Scheduled SMS Time</label>';
    $rtn .= '<input type="time" class="form-control" name="msgScheduleTime" id="msgScheduleTime" value="'.$tme->format('H:m').'"></div>';

    $rtn .= '<div class="form-group"><div id="count" class="float-left"><span id="current">0</span><span id="maximum">/120</span></div>';
    $rtn .= '<button type="submit" id="updateRec" name="updateRec" class="btn btn-success float-right">Update Message</button></div></div></div>';
  }

  // die('the value is '.$rtn);
  $_SESSION['oldRec'] = $msg;
  return $rtn;
}

function buildNewForm()
{
  $rtn = '<div class="row"><div class="col-sm-6"><label for="msgCategory">Message Category</label><div class="form-group">';
  $rtn .= '<select class="form-control" id="msgCategory" name="msgCategory" required >';
  $rtn .= '<option value="Sunday" selected>Sundays</option><option value="Tuesday">Tuesdays</option>';
  $rtn .= '<option value="Thursday">Thursdays</option><option value="Special">Specials</option>';
  $rtn .= '</select></div>';

  $rtn .= '<div class="form-group"><label for="msgBody">SMS Template</label>';
  $rtn .= '<textarea class="form-control" rows="6" name="msgBody" id="msgBody" spellcheck="true" required>Dear {visitor}, we appreciate ...</textarea></div></div>';

  $rtn .= '<div class="col-sm-6"><div class="form-group"><label for="msgSpecialName">Special Programme</label>';
  $rtn .= '<input type="text" class="form-control" name="msgSpecialName" id="msgSpecialName" placeholder="Enter Special Programme Name"></div>';

  $rtn .= '<div class="form-group"><label for="msgSpecialDate">Special Programme Date</label>';
  $rtn .= '<input type="date" class="form-control" name="msgSpecialDate" id="msgSpecialDate" placeholder="Enter Special Programme Date"></div>';

  $rtn .= '<div class="form-group"><label for="msgScheduleTime">Special Programme Scheduled SMS Time</label>';
  $rtn .= '<input type="time" class="form-control" name="msgScheduleTime" id="msgScheduleTime" placeholder="Enter time to send SMS (eg 15:30)"></div>';

  $rtn .= '<div class="form-group"><div id="count" class="float-left"><span id="current">0</span><span id="maximum">/120</span></div>';
  $rtn .= '<button type="submit" id="saveRec" name="saveRec" class="btn btn-success float-right">Save New Message</button></div></div></div>';

  return $rtn;
}

function buildDeleteForm($id)
{
  $rtn = '';
  $gst = array();
  $gst = getSpecificGuest($id);
  // die('the value is '.$gst['guestVisitDate']);
  if (is_array($gst) && count($gst) >= 1) {
    
  }

  // die('the value is '.$rtn);
  $_SESSION['oldRec'] = $gst;
  return $rtn;
}


///--------------------------------------------------
///---------- Data Verification functions -----------
///--------------------------------------------------
function canSave()
{
  $rtn = true;
  try {
    $msgC = $_REQUEST['msgCategory'];
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "SELECT * FROM message_template WHERE msgCategory = '$msgC'";
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
  $rtn = false;
  $cse = array();
  $oldRec = $_SESSION['oldRec'];

  $cse['secUserName'] = $_REQUEST['secUserName'];
  $cse['secFullName'] = $_REQUEST['secFullName'];
  $cse['secPhone'] = $_REQUEST['secPhone'];
  $cse['secEmail'] = $_REQUEST['secEmail'];
  $cse['secRole'] = $_REQUEST['secRole'];

  if (count(array_diff($oldRec, $cse)) >= 1) {
    $rtn = true;
  } else {
    $_SESSION['msgErr'] = 'No new data to update!';
    $rtn = false;
  }
  return $rtn;
}

///--------------------------------------------------
///------------ general-purpose functions -----------
///--------------------------------------------------

function getToday()
{
  $dt = new DateTime('now');
  return $dt->format('Y-m-d');
}

?>