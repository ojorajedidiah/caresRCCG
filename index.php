<?php
#   Author of the script
#   Name: Adeleke Ojora
#   Email : ojorajedidiah@gmail.com
#	  Modified by: Adeleke Ojora

session_start();
include('models/databaseConnection.class.php');
$ip = $_SERVER['REMOTE_ADDR'];


$msg = '';
//die();
if (isset($_REQUEST['submit'])) {
  if (!(empty($_REQUEST['username'])) && !(empty($_REQUEST['password']))) {

    $db = new connectDatabase(); //    
    if ($db->isLastQuerySuccessful()) {
      $con = $db->connect();

      try {
        $dn = $_REQUEST['username'];
        $pwd = md5($_REQUEST['password']);

        $sql = "SELECT secID,secUserName,secFullName,secPhone,secRole,secStatus 
        FROM sec_cares WHERE secUserName = '$dn' AND secPassword = '$pwd'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($stmt->fetchAll() as $row) {
          if ($row['secStatus'] !== 'active') {
            $msg = 'Account deactivated, please contact your Admin';
          } else {
            $_SESSION['fullname'] = $row['secFullName'];
            $_SESSION['expiryTime'] = time() + (3 * 60); //set up session to expire within 1 min
            $_SESSION['role'] = $row['secRole'];
            $_SESSION['username'] = $dn;
            $_SESSION['phoneNum'] = $row['secPhone'];
            $_SESSION['loggedIn'] = 1;

            //// Perform insert for login action and insert into logs table
            $action = $_SESSION['fullname'] . ' Logged into RCCG Overcomers Cares';
            $data = [
              'logIP' => $ip,
              'logDate' => date('Y-m-d'),
              'logDescription' => $action,
            ];
            $sql = "INSERT INTO logs (logIP,logDate,logDescription) VALUES (:logIP, :logDate, :logDescription)";
            $stmt = $con->prepare($sql);
            $stmt->execute($data);
            $db->closeConnection();
            die('<head><script language="javascript">window.location="home.php";</script></head>');
          }
        }
      } catch (PDOException $er) {
        $msg = $er->getMessage() . '<br>Please contact RCCG Overcomers Media Unit!';
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RCCG Overcomers Cares | Log in</title>

 <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a class="navbar-brand" href=""><img src="assets/img/logo2.png" alt="Logo" width="105" height="105" /></a>
      <a href="">
        <h5><b>RCCG Overcomers Cares | Log in</b></h5>
      </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <span class="badge badge-danger"><?php echo $msg ?></span>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="username" name="username" class="form-control" required placeholder="Enter username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-check"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" required placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <!-- <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label> -->
              </div>
            </div>
            
            <div class="col-4">
              <button type="submit" name="submit" class="btn btn-danger btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="lockscreen-footer text-center">
          <span style="font-size: 8pt;">Powered by <b>RCCG Overcomers Media Unit</b> &copy; <?php echo date("Y"); ?></span>
        </div>
      </div>
    </div>
  </div>


  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/adminlte.min.js"></script>
</body>

</html>