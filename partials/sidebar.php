<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?php echo $_SERVER['PHP_SELF'] === '/bodybuilding.php' ? 'active' : '' ?>" aria-current="page" href="bodybuilding.php">
          <span data-feather="users"></span>
          Bodybuilding
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" type="button" data-bs-toggle="collapse" data-bs-target="#taekwondo-collapse" aria-expanded="true">
          <span data-feather="users"></span>
          Taekwondo
        </a>
        <div class="collapse show ps-4" id="taekwondo-collapse">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link <?php echo $_SERVER['PHP_SELF'] === '/taekwondo_a1.php' ? 'active' : '' ?>" aria-current="page" href="taekwondo_a1.php">
                <span data-feather="users"></span>
                A1
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo $_SERVER['PHP_SELF'] === '/taekwondo_a2.php' ? 'active' : '' ?>" aria-current="page" href="taekwondo_a2.php">
                <span data-feather="users"></span>
                A2
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo $_SERVER['PHP_SELF'] === '/kickboxing.php' ? 'active' : '' ?>" aria-current="page" href="kickboxing.php">
          <span data-feather="users"></span>
          Kickboxing
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo $_SERVER['PHP_SELF'] === '/gymnastic.php' ? 'active' : '' ?>" aria-current="page" href="gymnastic.php">
          <span data-feather="users"></span>
          Gymnastic
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo $_SERVER['PHP_SELF'] === '/aerobic.php' ? 'active' : '' ?>" aria-current="page" href="aerobic.php">
          <span data-feather="users"></span>
          Aerobic
        </a>
      </li>
    </ul>
  </div>
</nav>