<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="home.php" class="navbar-brand">
      <img src="assets/img/logo2.png" alt="rccg Logo" class="mr-2" style="width: 40px; height: 40px;">
      <span class="brand-text font-weight-light">RCCG Cares</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
          aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="guests.php" class="nav-link">Guests</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">Approve</a>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reports</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="" class="dropdown-item">Report 1</a></li>
            <li><a href="" class="dropdown-item">Report 2</a></li>
            <li class="dropdown-divider"></li>
            <li><a href="" class="dropdown-item">Report 3</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu2" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Administration</a>
          <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
            <li><a href="roleMgt.php" class="dropdown-item">Role Management</a></li>
            <li><a href="" class="dropdown-item">User Management</a></li>
          </ul>
          </a>
        </li>
      </ul>
    </div>
    
    <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>