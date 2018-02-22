<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fluid">
      <a class="navbar-brand" href="#">BBK Computer Science </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav mr-auto">
          <?php
            // include registration page only if the access type is == to admin
            if($_SESSION['access_type'] == 'admin'){
              echo '<div class="nav-item"><a class="nav-link" href="pages/registerNewUser.php">Register New User</a></div>';
            }
          ?>
          <div class="nav-item dropdown">
            <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Results
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="pages/DTresults.php">DT</a>
              <a class="dropdown-item" href="pages/P1results.php">P1</a>
              <a class="dropdown-item" href="pages/PfPresults.php">PfP</a>
            </div>
          </div>
        </div>
        <div class="form-inline my-2 my-lg-0">
          <a class="btn btn-outline-light" href="../includes/logout.php">Logout</a>
        </div>
      </div>
    </nav>
</header>
