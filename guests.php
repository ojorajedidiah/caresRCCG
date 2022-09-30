<?php
//session_start();
$_SESSION['guestErr']='';
$errGuest = '';
if (isset($_REQUEST['saveRec'])) {
  //die('<br><br>the value is '.$_REQUEST);
  if (canSave()) {
    $errGuest = createNewGuest();
    $_REQUEST['v'] = "update";
  } else {
    $errGuest=$_SESSION['guestErr'];
    $_REQUEST['v'] = "new";
  }
  
}

if (isset($_POST['updateRec'])) {
  if (canSaveEdit()) {
    $errGuest = UpdateGuest();
    $_REQUEST['v'] = "update";
  }else {
    $errGuest=$_SESSION['guestErr'];
    $_REQUEST['v'] = "edit";
  }
  
}

if (isset($_POST['promoteRec'])) {
  // if (canSaveEdit()) {
  //   $errGuest = UpdateGuest();
  //   $_REQUEST['v'] = "update";
  // }else {
  //   $errGuest=$_SESSION['guestErr'];
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
            <h5>Guest Management</h5>
            <?php if ($errGuest != '') { echo '<span style="color:red;font-size:15px;">' . $errGuest . '</span>'; } ?>
          </div>
          <div class="col-sm-4">
            <?php if (isset($_REQUEST['v']) && ($_REQUEST['v'] == 'new' || $_REQUEST['v'] == 'edit' || $_REQUEST['v'] == 'promote')) { ?>
              <a href="home?p=guests" class="btn btn-danger float-right">Back</a>
            <?php } else { ?>
              <a href="home?p=guests&v=new" class="btn btn-secondary float-right">Create New Guest</a>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php if (isset($_REQUEST['v']) && $_REQUEST['v'] == 'new') { ?>
        <div class="row">
          <div class="card-body card-secondary">
            <div class="card-header">
              <h3 class="card-title">Create New Guest</h3>
            </div>
            <form method="post" target="">
              <?php echo buildNewForm(); ?>                        
            </form>
          </div>
        </div>
      <?php } else if (isset($_REQUEST['v']) && $_REQUEST['v'] == 'promote') { ?>
        <div class="row">
          <div class="card-body card-secondary">
            <div class="card-header">
              <h3 class="card-title">Promote Guest</h3>
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
              <h3 class="card-title">Edit Guest</h3>
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




<?php
///--------------------------------------------------
///------------- Geenral DML functions --------------
///--------------------------------------------------

function createNewGuest() 
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "INSERT INTO guests 
        (guestVisitDate,guestFirstName,guestLastName,guestSex,guestAgeRange,guestPhone,guestEmail,guestHomeAddress,
        guestServiceReport,guestResident,guestMembership,guestOccupation) 
        VALUES (:gstVD,:gstFN,:gstLN,:gstSx,:gstAR,:gstPh,:gstEm,:gstHAdd,:gstSRpt,:gstRed,:gstMem,:gstOccp)";

      $stmt = $con->prepare($sql);
      $stmt->bindparam(":gstVD", $_REQUEST['guestVisitDate'], PDO::PARAM_STR);
      $stmt->bindparam(":gstFN", $_REQUEST['guestFirstName'], PDO::PARAM_STR);
      $stmt->bindparam(":gstLN", $_REQUEST['guestLastName'], PDO::PARAM_STR);
      $stmt->bindparam(":gstSx", $_REQUEST['guestSex'], PDO::PARAM_STR);
      $stmt->bindparam(":gstAR", $_REQUEST['guestAgeRange'], PDO::PARAM_STR);
      $stmt->bindparam(":gstPh", $_REQUEST['guestPhone'], PDO::PARAM_STR);
      $stmt->bindparam(":gstEm", $_REQUEST['guestEmail'], PDO::PARAM_STR);
      $stmt->bindparam(":gstHAdd", $_REQUEST['guestHomeAddress'], PDO::PARAM_STR);
      $stmt->bindparam(":gstSRpt", $_REQUEST['guestServiceReport'], PDO::PARAM_STR);
      $stmt->bindparam(":gstRed", $_REQUEST['guestResident'], PDO::PARAM_STR);
      $stmt->bindparam(":gstMem", $_REQUEST['guestMembership'], PDO::PARAM_STR);
      $stmt->bindparam(":gstOccp", $_REQUEST['guestOccupation'], PDO::PARAM_STR);
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The Account <b>" . $_REQUEST['guestFirstName'] ." ". $_REQUEST['guestLastName']. "</b> has been created!";
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

function UpdateGuest()
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "UPDATE guests SET guestFirstName= :gstFN, 
        guestLastName=:gstLN, guestSex=:gstSx, guestAgeRange=:gstAgR, guestPhone=:gstPhn,
        guestEmail=:gstEm, guestHomeAddress=:gstHmA, guestServiceReport=:gstSvR, 
        guestResident=:gstRes, guestMembership=:gstMem, guestOccupation=:gstOcc 
        WHERE guestID=:gstID";

      $stmt = $con->prepare($sql);
      $stmt->bindparam(":gstID", $_REQUEST['rid'], PDO::PARAM_INT);
      $stmt->bindparam(":gstFN", $_REQUEST['guestFirstName'], PDO::PARAM_STR);      
      $stmt->bindparam(":gstLN", $_REQUEST['guestLastName'], PDO::PARAM_STR);
      $stmt->bindparam(":gstSx", $_REQUEST['guestSex'], PDO::PARAM_STR);
      $stmt->bindparam(":gstAgR", $_REQUEST['guestAgeRange'], PDO::PARAM_STR);
      $stmt->bindparam(":gstPhn", $_REQUEST['guestPhone'], PDO::PARAM_STR);
      $stmt->bindparam(":gstEm", $_REQUEST['guestEmail'], PDO::PARAM_STR);
      $stmt->bindparam(":gstHmA", $_REQUEST['guestHomeAddress'], PDO::PARAM_STR);
      $stmt->bindparam(":gstSvR", $_REQUEST['guestServiceReport'], PDO::PARAM_STR);
      $stmt->bindparam(":gstRes", $_REQUEST['guestResident'], PDO::PARAM_STR);
      $stmt->bindparam(":gstMem", $_REQUEST['guestMembership'], PDO::PARAM_STR);
      $stmt->bindparam(":gstOcc", $_REQUEST['guestOccupation'], PDO::PARAM_STR);
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The Account <b>" . $_REQUEST['guestFirstName'] 
          ." " . $_REQUEST['guestLastName'] . "</b> has been updated";
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
            . '<td><span class="badge badge-complete"><a href="home?p=guests&v=promote&rid=' . $rID . '">'
            . '<i class="nav-icon fas fa-user-lock" title="Promote Guest" style="color:green;"></i>'
            . '</a></span><span class="badge badge-edit"><a href="home?p=guests&v=edit&rid=' . $rID . '">'
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
  $rtn = array();
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT * FROM guests WHERE guestID = $rec";
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
  return (count($rtn) >= 1) ? $rtn : 'No Guest Data';
}

///--------------------------------------------------
///-------------- Build Form functions --------------
///--------------------------------------------------
function buildEditForm($id)
{
  $rtn='';$gst=array();
  $gst=getSpecificGuest($id);
  // die('the value is '.$gst['guestVisitDate']);
  if (is_array($gst) && count($gst) >= 1){
    $dat=new DateTime($gst['guestVisitDate']); //$dat->format('D d M, Y');
    $rtn.='<div class="row"><div class="col-sm-4"><div class="form-group"><label for="guestVisitDate">Date as Guest</label>';
    $rtn.='<input type="text" class="form-control" name="guestVisitDate" id="guestVisitDate" value="'.$dat->format('D d F, Y').'" readonly></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestFirstName">Guest FirstName</label>';
    $rtn.='<input type="text" class="form-control" name="guestFirstName" id="guestFirstName" value="'.$gst['guestFirstName'].'" required></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestLastName">Guest Surname</label>';
    $rtn.='<input type="text" class="form-control" name="guestLastName" id="guestLastName" value="'.$gst['guestLastName'].'" required></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-3"><label for="guestSex">Guest Sex</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestSex" name="guestSex">'; //<option value="Male">Male</option>';
    if ($gst['guestSex'] == "Male") { $rtn.='<option value="Male" selected>Male</option><option value="Female">Female</option></select></div></div>'; }
    else {$rtn.='<option value="Male">Male</option><option value="Female" selected>Female</option></select></div></div>';}

    $rtn.='<div class="col-sm-3"><label for="guestLastName">Resident in Abuja?</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestResident" name="guestResident">';
    if ($gst['guestResident'] == "yes") { $rtn.='<option value="yes" selected>Yes</option><option value="no">No</option></select></div></div>'; }
    else {$rtn.='<option value="yes">Yes</option><option value="no" selected>No</option></select></div></div>';}

    $rtn.='<div class="col-sm-3"><label for="guestMembership">Member of RCCG?</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestMembership" name="guestMembership">';
    if ($gst['guestMembership'] == "yes") { $rtn.='<option value="yes" selected>Yes</option><option value="no">No</option></select></div></div>'; }
    else {$rtn.='<option value="yes">Yes</option><option value="no" selected>No</option></select></div></div>';}

    $rtn.='<div class="col-sm-3"><label for="guestAgeRange">Age Range</label><div class="form-group">';
    $rtn.='<select class="form-control" id="guestAgeRange" name="guestAgeRange">';
    $rtn.=($gst['guestAgeRange'] == "13-20")? '<option value="13-20" selected>13-20</option>': '<option value="13-20">13-20</option>';
    $rtn.=($gst['guestAgeRange'] == "21-40")? '<option value="21-40" selected>21-40</option>': '<option value="21-40">21-40</option>';
    $rtn.=($gst['guestAgeRange'] == "41-50")? '<option value="41-50" selected>41-50</option>': '<option value="41-50">41-50</option>';
    $rtn.=($gst['guestAgeRange'] == "50 and Above")? '<option value="50 and Above" selected>50 and Above</option>': '<option value="50 and Above">50 and Above</option></select></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-4"><div class="form-group"><label for="guestPhone">Guest Mobilenumber</label>';
    $rtn.='<input type="text" class="form-control" name="guestPhone" id="guestPhone" value="'.$gst['guestPhone'].'" required></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestEmail">Guest email</label>';
    $rtn.='<input type="email" class="form-control" name="guestEmail" id="guestEmail" value="'.$gst['guestEmail'].'"></div></div>';

    $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestOccupation">Guest Occupation</label>';
    $rtn.='<input type="text" class="form-control" name="guestOccupation" id="guestOccupation" value="'.$gst['guestOccupation'].'"></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="guestHomeAddress">Guest Home Address</label>';
    $rtn.='<textarea class="form-control" rows="5" name="guestHomeAddress" id="guestHomeAddress" required>'.$gst['guestHomeAddress'].'</textarea></div></div>';

    $rtn.='<div class="col-sm-6"><div class="form-group"><label for="guestServiceReport">Tell us about the Service</label>';
    $rtn.='<textarea class="form-control" rows="5" name="guestServiceReport" id="guestServiceReport" spellcheck="true">'.$gst['guestServiceReport'].'</textarea></div></div></div>';

    $rtn.='<div class="row"><div class="col-sm-12"><div class="form-group">';
    $rtn.='<button type="submit" id="updateRec" name="updateRec" class="btn btn-success float-right">Update Guest</button></div></div></div>';
  }

  // die('the value is '.$rtn);
  $_SESSION['oldRec']=$gst;
  return $rtn;
}

function buildNewForm()
{
  $rtn= '<div class="row"><div class="col-sm-4"><div class="form-group"><label for="guestVisitDate">Date as Guest</label>';
  $rtn.='<input type="date" class="form-control" name="guestVisitDate" id="guestVisitDate" value="'. getToday() .'" required></div></div>';

  $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestFirstName">Guest FirstName</label>';
  $rtn.='<input type="text" class="form-control" name="guestFirstName" id="guestFirstName" placeholder="Guest FirstName" required></div></div>';

  $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestLastName">Guest Surname</label>';
  $rtn.='<input type="text" class="form-control" name="guestLastName" id="guestLastName" placeholder="Guest Surname" required></div></div></div>';

  $rtn.='<div class="row"><div class="col-sm-3"><label for="guestSex">Guest Sex</label><div class="form-group">';
  $rtn.='<select class="form-control" id="guestSex" name="guestSex"><option value="Male">Male</option><option value="Female" selected>Female</option></select></div></div>';

  $rtn.='<div class="col-sm-3"><label for="guestLastName">Resident in Abuja?</label><div class="form-group"><select class="form-control" id="guestResident" name="guestResident">';
  $rtn.='<option value="yes" selected>Yes</option><option value="no">No</option></select></div></div>';

  $rtn.='<div class="col-sm-3"><label for="guestMembership">Member of RCCG?</label><div class="form-group"><select class="form-control" id="guestMembership" name="guestMembership">';
  $rtn.='<option value="yes" selected>Yes</option><option value="no">No</option></select></div></div>';

  $rtn.='<div class="col-sm-3"><label for="guestAgeRange">Age Range</label><div class="form-group"><select class="form-control" id="guestAgeRange" name="guestAgeRange">';
  $rtn.='<option value="13-20">13-20</option><option value="21-40" selected>21-40</option><option value="41-50">41-50</option><option value="50 and Above">50 and Above</option></select></div></div></div>';
  
  $rtn.='<div class="row"><div class="col-sm-4"><div class="form-group"><label for="guestPhone">Guest Mobilenumber</label>';
  $rtn.='<input type="text" class="form-control" name="guestPhone" id="guestPhone" placeholder="Guest PhoneNumber" required></div></div>';

  $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestEmail">Guest email</label>';
  $rtn.='<input type="email" class="form-control" name="guestEmail" id="guestEmail" placeholder="Guest email"></div></div>';

  $rtn.='<div class="col-sm-4"><div class="form-group"><label for="guestOccupation">Guest Occupation</label>';
  $rtn.='<input type="text" class="form-control" name="guestOccupation" id="guestOccupation" placeholder="Guest Occupation"></div></div></div>';

  $rtn.='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="guestHomeAddress">Guest Home Address</label>';
  $rtn.='<textarea class="form-control" rows="5" name="guestHomeAddress" id="guestHomeAddress" required>What\'s you Home Address?</textarea></div></div>';

  $rtn.='<div class="col-sm-6"><div class="form-group"><label for="guestServiceReport">Tell us about the Service</label>';
  $rtn.='<textarea class="form-control" rows="5" name="guestServiceReport" id="guestServiceReport" spellcheck="true">Which segment of the service did you enjoy most?</textarea></div></div></div>';
  
  $rtn.='<div class="row"><div class="col-sm-12"><div class="form-group">';
  $rtn.='<button type="submit" id="saveRec" name="saveRec" class="btn btn-success float-right">Save New Guest</button></div></div></div>';

  return $rtn;
}

function buildPromoteForm($id)
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
    $rtn.=($gst['guestAgeRange'] == "50 and Above")? '<option value="50 and Above" selected>50 and Above</option>': '<option value="50 and Above">50 and Above</option></select></div></div></div>';

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
    $phone = $_REQUEST['guestPhone'];
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "SELECT * FROM guests WHERE guestPhone = '$phone'";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $rtn = false;
        trigger_error("This Guest already exist in the Database!<br>Kindly pick a different Guest", E_USER_NOTICE);
      }
      if (strlen($phone) != 11) {
        $rtn = false;
        $_SESSION['guestErr']="The Phone Number is incorrect! Kindly correct Guest Phonenumber";
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

  $cse['guestFirstName']=$_REQUEST['guestFirstName'];
  $cse['guestLastName']=$_REQUEST['guestLastName'];
  $cse['guestSex']=$_REQUEST['guestSex'];
  $cse['guestAgeRange']=$_REQUEST['guestAgeRange'];
  $cse['guestPhone']=$_REQUEST['guestPhone'];
  $cse['guestEmail']=$_REQUEST['guestEmail'];
  $cse['guestHomeAddress']=$_REQUEST['guestHomeAddress'];
  $cse['guestServiceReport']=$_REQUEST['guestServiceReport'];
  $cse['guestResident']=$_REQUEST['guestResident'];
  $cse['guestMembership']=$_REQUEST['guestMembership'];

  if (count(array_diff($oldRec,$cse)) >= 1){
    $rtn=true;
  } else {
    $_SESSION['guestErr']='No new data to update!';
    $rtn = false;
  }

  if (strlen($_REQUEST['guestPhone']) != 11) {
    $rtn = false;
    $_SESSION['guestErr']="The Phone Number is incorrect! Kindly correct Guest Phonenumber";
  }
  return $rtn;
}

///--------------------------------------------------
///------------ general-purpose functions -----------
///--------------------------------------------------

// function userDetails()
// {
//   $rtn = '';
//   if (isset($_SESSION['fullname'])) {
//     $rtn = $_SESSION['fullname'] . " (" . $_SESSION['role'] . ")";
//   } else {
//     $rtn = 'No User Details';
//   }

//   return $rtn;
// }

function getToday()
{
  $dt=new DateTime('now');
  return $dt->format('Y-m-d'); 
}

?>