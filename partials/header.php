<?php

require_once './notifications/functions.php';

$notifications = getNotifications($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <link rel="stylesheet" href="../resources/css/index.css">

  <title>Gym Management</title>
</head>

<body>

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
  </svg>

  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">Gym Management</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="w-100 invisible"></div>
    <div class="dropdown ms-3 mt-2">
      <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownMenuNotification" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell-fill text-light"></i>
        <span class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger">
          <?php echo mysqli_num_rows($notifications) ?>
          <span class="visually-hidden">unread messages</span>
        </span>
      </a>
      <ul id="dropdownNotifications" class="dropdown-menu">
        <?php if (mysqli_num_rows($notifications) > 0) : ?>
          <?php foreach ($notifications as $notification) : ?>
            <li class="dropdown-item">
              <a href="member.php?id=<?php echo $notification['member_id'] ?>" class="text-decoration-none text-dark">
                <?php echo $notification['message'] ?>
              </a>
            </li>
            <hr class="dropdown-divider">
          <?php endforeach; ?>
          <li class="text-center">
            <a href="notifications/read.php" type="button" class="text-decoration-none text-warning">Mark all notifications as read</a>
          </li>
        <?php elseif (mysqli_num_rows($notifications) == 0) : ?>
          <li class="dropdown-item"><span class="fw-bold">Sorry!</span> You have no notfications</li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="dropdown ms-3 me-4 py-2">
      <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="images/default.svg" alt="" width="32" height="32" class="rounded-circle">
      </a>
      <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li><a class="dropdown-item" href="includes/logout.inc.php">Sign out</a></li>
      </ul>
    </div>
  </header>