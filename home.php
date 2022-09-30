<?php
date_default_timezone_set("Africa/Lagos");
include('includes/header.php');
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == 1) {

?>

<script>
  $(function() {
    $('.knob').knob({
      /*change : function (value) {
      //console.log("change : " + value);
      },
      release : function (value) {
      console.log("release : " + value);
      },
      cancel : function () {
      console.log("cancel : " + this.value);
      },*/
      draw: function() {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv) // Angle
            ,
            sa = this.startAngle // Previous start angle
            ,
            sat = this.startAngle // Start angle
            ,
            ea // Previous end angle
            ,
            eat = sat + a // End angle
            ,
            r = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor &&
            (sat = eat - 0.3) &&
            (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor &&
              (sa = ea - 0.3) &&
              (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return false
        }
      }
    })
  });

  $(function() {
    $("#grids").DataTable({
      "paging": true,
      "lengthChange": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      //"buttons": ["excel", "pdf", "colvis"]
    }).buttons().container().appendTo('#guests_wrapper .col-md-6:eq(0)');;
  });

  $('#msgBody').keyup(function() {

    var characterCount = $(this).val().length,
      current = $('#current'),
      maximum = $('#maximum'),
      theCount = $('#count');

    current.text(characterCount);

    /*This isn't entirely necessary, just playin around*/
    if (characterCount < 70) {
      current.css('color', '#666');
    }
    if (characterCount > 70 && characterCount < 90) {
      current.css('color', '#6d5555');
    }
    if (characterCount > 90 && characterCount < 100) {
      current.css('color', '#793535');
    }
    if (characterCount > 100 && characterCount < 120) {
      current.css('color', '#841c1c');
    }

    if (characterCount >= 120) {
      maximum.css('color', '#ff0001');
      current.css('color', '#ff0001');
      theCount.css('font-weight', 'bold');
    } else {
      maximum.css('color', '#666');
      theCount.css('font-weight', 'normal');
    }
  });
</script>

  <style>
    #grids.tbody th,
    #grids tbody td {
      height: 5px;
    }
  </style>


  <body class="hold-transition layout-top-nav">
    <div id="app">
      <div class="wrapper">
        <?php include('includes/top_menu.php'); ?>
        <div class="content-wrapper">
          <div class="content">
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
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item acive"> <?php echo namePage(); ?> </li>
                      </ol>
                    </div>
                  </div>
                </div>
              </div>

              <?php if (isset($_REQUEST['p'])) {
                grantAccess();
              } else { ?>
                <div class="content">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-3 col-sm-6 col-12">
                        <div class="small-box bg-info">
                          <div class="inner">
                            <h3><?php echo number_format(getTotalNumNCS()); ?></h3>
                            <p>No. of Guests (This Week)</p>
                          </div>
                          <div class="icon"><i class="fas fa-user-secret"></i></div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-12">
                        <div class="small-box bg-secondary">
                          <div class="inner">
                            <h3><?php echo number_format(getTotalNumCAC()); ?></h3>
                            <p>No. of Guests (This Month)</p>
                          </div>
                          <div class="icon"><i class="fas fa-user-shield"></i></div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-12">
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?php echo number_format(getTotalNumTPM()); ?></h3>
                            <p>Total No. of Guests (Quarter)</p>
                          </div>
                          <div class="icon"><i class="fas fa-user-tie"></i></div>
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-6 col-12">
                        <div class="small-box bg-success">
                          <div class="inner">
                            <h3><?php echo number_format(getTotalNumTPM()); ?></h3>
                            <p>Retention Rate (Month)</p>
                          </div>
                          <div class="icon"><i class="fas fa-user-tie"></i></div>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-6 col-md-3 text-center">
                              <input type="text" class="knob" value=40 data-width="120" data-height="120" data-fgColor="red" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;">
                              <div class="knob-label">Guests Registration %</div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                              <input type="text" class="knob" value=100 data-skin="tron" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125" data-width="120" data-height="120" data-fgColor="green">
                              <div class="knob-label">Guests Messages %</div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                              <input type="text" class="knob" value=80 data-width="120" data-height="120" data-fgColor="red" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;">
                              <div class="knob-label">Retention %</div>
                            </div>
                            <div class="col-6 col-md-3 text-center">
                              <input type="text" class="knob" value=20 data-skin="tron" data-thickness="0.2" data-angleArc="250" data-angleOffset="-125" data-width="120" data-height="120" data-fgColor="green">
                              <div class="knob-label">Non-Retention %</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>


      <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
          Powered by <strong>RCCG Overcomers</strong> | Media Unit
        </div>
        Copyright &copy <span id="copy"><?php echo date('Y'); ?></span>
      </footer>
    </div>

  <?php } else {
  die('<head><script LANGUAGE="JavaScript">window.location="index";</script></head>');
} ?>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/adminlte.min.js"></script>
  <script src="assets/js/jquery.knob.min.js"></script>

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
  <!-- <script src="assets/js/demo.js"></script> -->

  <script>
    $(function() {
      $('.knob').knob({
        /*change : function (value) {
        //console.log("change : " + value);
        },
        release : function (value) {
        console.log("release : " + value);
        },
        cancel : function () {
        console.log("cancel : " + this.value);
        },*/
        draw: function() {

          // "tron" case
          if (this.$.data('skin') == 'tron') {

            var a = this.angle(this.cv) // Angle
              ,
              sa = this.startAngle // Previous start angle
              ,
              sat = this.startAngle // Start angle
              ,
              ea // Previous end angle
              ,
              eat = sat + a // End angle
              ,
              r = true

            this.g.lineWidth = this.lineWidth

            this.o.cursor &&
              (sat = eat - 0.3) &&
              (eat = eat + 0.3)

            if (this.o.displayPrevious) {
              ea = this.startAngle + this.angle(this.value)
              this.o.cursor &&
                (sa = ea - 0.3) &&
                (ea = ea + 0.3)
              this.g.beginPath()
              this.g.strokeStyle = this.previousColor
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
              this.g.stroke()
            }

            this.g.beginPath()
            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
            this.g.stroke()

            this.g.lineWidth = 2
            this.g.beginPath()
            this.g.strokeStyle = this.o.fgColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
            this.g.stroke()

            return false
          }
        }
      })
    });

    $(function() {
      $("#grids").DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        //"buttons": ["excel", "pdf", "colvis"]
      }).buttons().container().appendTo('#guests_wrapper .col-md-6:eq(0)');;
    });

    $('#msgBody').onfocus(function() {
      var characterCount = $(this).val().length,
        current = $('#current');
      current.text(characterCount);
    });

    $('#msgBody').keyup(function() {

      var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#count');

      current.text(characterCount);

      /*This isn't entirely necessary, just playin around*/
      if (characterCount < 70) {
        current.css('color', '#666');
      }
      if (characterCount > 70 && characterCount < 90) {
        current.css('color', '#6d5555');
      }
      if (characterCount > 90 && characterCount < 100) {
        current.css('color', '#793535');
      }
      if (characterCount > 100 && characterCount < 120) {
        current.css('color', '#841c1c');
      }

      if (characterCount >= 120) {
        maximum.css('color', '#ff0001');
        current.css('color', '#ff0001');
        theCount.css('font-weight', 'bold');
      } else {
        maximum.css('color', '#666');
        theCount.css('font-weight', 'normal');
      }
    });
  </script>

  </body>

  </html>


  <?php
  function namePage()
  {
    $rtn = '';
    if (isset($_REQUEST['p']) && $_REQUEST['p'] != '') {
      $rtn = ucwords($_REQUEST['p']);
    } else {
      $rtn = 'Dashboard';
    }
    return $rtn;
  }

  function getTotalNumNCS()
  {
    $cnt = 10;
    return $cnt;
  }

  function getTotalNumCAC()
  {
    $cnt = 15;
    return $cnt;
  }

  function getTotalNumTPM()
  {
    $cnt = 15;
    return  $cnt;
  }

  function getNCSPer()
  {
    $tpm = (float) getTotalNumTPM();
    $ncs = (float) getTotalNumNCS();
    return round(($tpm / $ncs) * 100, 2);
  }


  function getCACPer()
  {
    $tpm = (float) getTotalNumTPM();
    $cac = (float) getTotalNumCAC();
    $val = $tpm / $cac;
    // trigger_error('the value is '.$cac);
    return round($val * 100, 2);
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

  function grantAccess()
  {
    $errormsg = ''; ///, $usersOnline, $staffOnline, $allowed
    global $pagePriviledge;

    if (isset($_GET["p"])) {
      $pageRequested = $_GET["p"];
      //die('<br><br><br><br>');var_dump($_SESSION);
      include($pageRequested . '.php');

      // if (isset($_SESSION[$pageRequested])) {
      //     $pagePriviledge = $_SESSION[$pageRequested];

      //     // $fname = @file_get_contents($pagePriviledge . '/' . $pageRequested . '.php');
      //     $fname=@file_get_contents($pageRequested . '.php');         

      //     if ($fname === FALSE) {
      //         $errormsg = 'PLEASE CONTACT YOUR ADMINISTRATOR TO ACCESS THIS PAGE!<br>...ACCESS DENIED...';
      //     } else {
      //         //die('<HEAD><SCRIPT lang="javascript">window.location="'.$pagePriviledge . '/' . $pageRequested .'.php";</SCRIPT></HEAD>');
      //         // include($pagePriviledge . '/' . $pageRequested .'.php');
      //         include($pageRequested .'.php');
      //     }
      // } else {
      //     //$tmp=print_r(array_values($_SESSION));
      //     $errormsg = 'YOU ARE NOT AUTHORISED TO VIEW THIS PAGE!<br>...ACCESS DENIED...';
      // }
    }
    if ($errormsg != '') {
      echo '<center><br><span style="color:red; font-size:20pt;">' . $errormsg . '</span></center>';
    }
  }


  ?>