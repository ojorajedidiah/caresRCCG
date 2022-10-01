<?php
include('models/SMS.class.php');
include('models/databaseConnection.class.php');

//$sndSMS=new SMS($sendername,$messagetext, $recipients);
// select recipients records from db
// get message from db
// configure sms class (message, recipients list, sender details etc)
// attempt sending sms
// report (message_report scheme)

$sendername='2348052345157';
$messagetext='Good Evening, Leke, '.getMessage();
// $tmp=getRecipients();
// if (is_array($tmp) && count($tmp) > 1)
// {
  $recipients='08082908001';
  $sndSMS=new SMS($sendername,$messagetext, $recipients);
  echo var_dump($sndSMS);
// } else {

// }




function getMessage()
{
  $rtn = "Drinks, Chops, Thoughts and Talks with Pst. Femi and Pst. Mrs Yemi Ipinlaye at the City of Champions. Exclusively for you our Highly Esteemed 2022 guests. Date: 2nd October 2022 by 11:30am at RCCG Overcomers Parish Gwarinpa. We are looking forward to seeing you there.";
  // try {
  //   $db = new connectDatabase();
  //   if ($db->isLastQuerySuccessful()) {
  //     $con = $db->connect();

  //     $sql = "SELECT guestID,guestFirstName,guestPhone FROM guests WHERE guestVisitDate < '2022-10-01' ORDER BY guestID ASC";
  //     $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  //     $stmt->execute();
  //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

  //     foreach ($stmt->fetchAll() as $row) {
  //       $rtn[$ctn]['id'] = $row['guestID'];
  //       $rtn[$ctn]['fn'] = $row['guestFirstName'];
  //       $rtn[$ctn]['ph'] = $row['guestPhone'];        
  //     }
  //     $rtn[0]['count']=$ctn;
  //   } else {
  //     trigger_error($db->connectionError());
  //   }
  //   $db->closeConnection();
  // } catch (Exception $e) {
  //   trigger_error($db->connectionError());
  // }
  return $rtn;
}

function getRecipients()
{
  $rtn = array();$ctn=0;
  try {
    $db = new connectDatabase();
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      $sql = "SELECT guestID,guestFirstName,guestPhone FROM guests WHERE guestVisitDate < '2022-10-01' ORDER BY guestID ASC";
      $stmt = $con->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $row) {
        $ctn++;
        $rtn[$ctn]['id'] = $row['guestID'];
        $rtn[$ctn]['fn'] = $row['guestFirstName'];
        $rtn[$ctn]['ph'] = $row['guestPhone'];        
      }
      $rtn[0]['count']=$ctn;
    } else {
      trigger_error($db->connectionError());
    }
    $db->closeConnection();
  } catch (Exception $e) {
    trigger_error($db->connectionError());
  }
  return $rtn;
}


?>