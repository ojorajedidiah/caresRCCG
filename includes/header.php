<?php
    include('error_handler.php');
    include('models/databaseConnection.class.php');
    $_SESSION['activePage']=basename($_SERVER['REQUEST_URI']);
    session_start();
    
    //include('includes/auditLogs.php');
    
    // check if the user has been inactive then log user out
  //   $now=time();
  //   $_SESSION['activePage']=basename($_SERVER['REQUEST_URI']);
  //   if (isset($_SESSION['username'])){
  //       if ($now > $_SESSION['expiryTime']) {
  //           //unset($_SESSION['fullname']);
  //           unset($_SESSION['role']);
  //           unset($_SESSION['expiryTime']);
  //           die('<head><script LANGUAGE="JavaScript">window.location="lockscreen.php";</script></head>');
  //       }
  //   } else {

  //   }
	// // check if user is logged in
  //   if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']!=''){

  //   }else{
  //      header('location:index.php');
  //      die();
  //   }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RCCG Overcomers Cares</title>
    <link rel="stylesheet" href="assets/css/fontawesome-css/all.min.css">
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    
    <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <script src="assets/js/jquery-3.6.0.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#dialog").dialog();
        });
    </script>
    
</head>