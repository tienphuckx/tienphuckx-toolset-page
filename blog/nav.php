<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand devlogo" href="#">DEVNOTE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            SERIES
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">C</a></li>
            <li><a class="dropdown-item" href="#">C++</a></li>
            <li><a class="dropdown-item" href="#">Java</a></li>
            <li><a class="dropdown-item" href="#">Qt Frameworks</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">TAGS</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <?php
            if (!isset($_SESSION['user']['email']) || empty($_SESSION['user']['email'])) {
                echo '<button id="loginBtn" class="btn ms-2">Login</button>';
                echo '<button id="registerBtn" class="btn ms-2">Register</button>';
            } else {
                echo '<button id="logoutBtn" class="btn btn-danger">Logout</button>';
                }
        ?>
    </div>
  </div>
</nav>