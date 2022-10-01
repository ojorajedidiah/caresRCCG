<?php
date_default_timezone_set("Africa/Lagos");
include('models/databaseConnection.class.php');

//get the various dates for the search
//build sql statmentss
//execute sql and send to table 

$rg['ch4']['e']=new DateTime();
$rg['ch4']['s']=new DateTime();
$rg['ch3']['e']=new DateTime();
$rg['ch3']['s']=new DateTime();
$rg['ch2']['e']=new DateTime();
$rg['ch2']['s']=new DateTime();
$rg['ch1']['e']=new DateTime();
$rg['ch1']['s']=new DateTime();

$rg['ch4']['e']->modify('-7 days');
$rg['ch4']['s']->modify('-13 days');
$rg['ch3']['e']->modify('-14 days');
$rg['ch3']['s']->modify('-20 days');
$rg['ch2']['e']->modify('-21 days');
$rg['ch2']['s']->modify('-27 days');
$rg['ch1']['e']->modify('-28 days');
$rg['ch1']['s']->modify('-34 days');

// echo $rg['ch4']['s']->format('Y-m-d').'<br>';
// echo $rg['ch4']['e']->format('Y-m-d').'<br>';
// echo $rg['ch3']['s']->format('Y-m-d').'<br>';
// echo $rg['ch3']['e']->format('Y-m-d').'<br>';
// echo $rg['ch2']['s']->format('Y-m-d').'<br>';
// echo $rg['ch2']['e']->format('Y-m-d').'<br>';
// echo $rg['ch1']['s']->format('Y-m-d').'<br>';
// echo $rg['ch1']['e']->format('Y-m-d').'<br>';

$status=cleanBarChart();
foreach($rg as $dat)
{
  $val=getCount($dat['s']->format('Y-m-d'),$dat['e']->format('Y-m-d'));
  $Tit=getSundayinRange($dat['s']->format('Y-m-d'),$dat['e']->format('Y-m-d'));
  $status.=updateBarChart($Tit,$val);
}

echo $status;


function getCount($sD,$eD)
{
  $rtn=0;
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT getGuestCountByDate('$sD','$eD') as cnt";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $tmp=$stmt->fetch();
      $rtn=(int) $tmp['cnt'];

    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (Exception $e) {
    trigger_error($db->connectionError());
  }
  return $rtn;

}

function getSundayinRange($sD,$eD)
{
  $cD=$sD;$rtn='';
  while ($cD<=$eD){
    $sD = date('w', strtotime($cD));
    if ($sD == 0)
    {
      $rtn=$cD;
      break;
    } 
    $cD=date('Y-m-d', strtotime($cD . ' +1 day'));
  }

  return $rtn;
}

function updateBarChart($sTitle,$sValue)
{
  $rtn = '';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "INSERT INTO bar_chart (chtTitle,chtValue) VALUES (:chtTit,:chtVal)";

      $stmt = $con->prepare($sql);
      $stmt->bindparam(":chtTit", $sTitle, PDO::PARAM_STR);
      $stmt->bindparam(":chtVal", $sValue, PDO::PARAM_INT);
      $row = $stmt->execute();

      if ($row) {
        $rtn = "The $sTitle has been created with entry $sValue!<br>";
      }
    } else {
      $rtn = "Database Error --> ". $db->connectionError();
    }
    $db->closeConnection();
  } catch (PDOException $e) {
    $rtn = "PDOException Error --> ". $e->getMessage();
  }

  return $rtn;
}

function cleanBarChart()
{
  $rtn='';
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();
      $sql = "DELETE FROM bar_chart";

      $stmt = $con->prepare($sql);
      $row = $stmt->execute();
      $rtn='Old Scheme records deleted<br>';
    }
  } catch (PDOException $e) {
    $rtn = "PDOException Error --> ". $e->getMessage();
  }
  return $rtn;
}
