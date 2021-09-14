<?php

require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

session_start();

if (isset($_SESSION['useruid'])) {
  header('Location: ../index.php');
  exit();
}

$username = '';
$password = '';
$errors = [];
$isValid = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (!$username) {
    $errors['username'] = 'The username is empty, please enter your username.';
    $isValid = false;
  }

  if (!$password) {
    $errors['password'] = 'The password is empty, please enter your password.';
    $isValid = false;
  }

  if ($isValid) {
    loginUser($conn, $username, $password);
  }
}
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

  <link rel="stylesheet" href="resources/css/login.css">

  <title>Gym Management</title>
</head>

<body class="text-center">
  <main class="form-signin">
    <form action="" method="post">
      <img class="mb-4" src="images/login.svg" alt="" width="120" height="120">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

      <div class="form-floating">
        <input name="username" type="text" id="floatingInput" placeholder="name@example.com" value="<?php echo $username ?>" class="form-control <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>">
        <div class="invalid-feedback text-start mb-2">
          <?php echo $errors['username'] ?? '' ?>
        </div>
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input name="password" type="password" id="floatingPassword" placeholder="Password" value="<?php echo $password ?>" class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>">
        <div class="invalid-feedback text-start">
          <?php echo $errors['password'] ?? '' ?>
        </div>
        <label for="floatingPassword">Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-warning mt-3" type="submit">Sign in</button>

      <?php if (isset($_GET['error'])) : ?>
        <div class="text-start text-danger mt-2">
          <i class="bi bi-exclamation-circle"></i> The username or password you entered was invalid.
        </div>
      <?php endif; ?>

      <p class="mt-5 mb-3 text-muted">Copyright &copy; 2021</p>
    </form>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</body>

</html>