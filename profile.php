<?php

require_once './includes/dbh.inc.php';
require_once './users/functions.php';

session_start();

if (!isset($_SESSION['useruid'])) {
  header('Location: ../login.php');
  exit();
}

$id = $_SESSION['userid'];

$user = getUser($conn, $id);
?>

<?php include './partials/header.php' ?>

<div class="container-fluid">
  <div class="row">

    <?php include './partials/sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-4">

      <!-- Success changed profile alert -->
      <?php
      if (isset($_GET['success']) && $_GET['success'] == 'userwaschanged') {
        include './partials/success_alert.php';
      }
      ?>

      <!-- Success changed password alert -->
      <?php
      if (isset($_GET['success']) && $_GET['success'] == 'passwordwaschanged') {
        include './partials/success_alert.php';
      }
      ?>

      <!-- Wrong password alert -->
      <div class="alert alert-danger d-flex align-items-center <?php echo $_GET['error'] == 'wrongpassword' ? 'd-block' : 'd-none' ?>" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
          <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        <div>
          OOps!! Old password not correct, please try again
        </div>
      </div>

      <!-- Passwords not match alert -->
      <div class="alert alert-danger d-flex align-items-center <?php echo $_GET['error'] == 'passwordsnotmatch' ? 'd-block' : 'd-none' ?>" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
          <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        <div>
          OOps!! New password and repeat password should match, please try again
        </div>
      </div>

      <h3 class="mb-3"><?php echo $user['first_name'] . ' ' . $user['last_name'] ?>'s Profile</h3>

      <div class="card w-100 p-md-4">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4 text-center px-md-4">
              <div class="card mb-3">
                <div class="card-body">
                  <img src="<?php echo $user['extension'] ? "./images/user.${user['extension']}" : "./images/default.svg" ?>" alt="" class="w-100">
                  <button class="btn bg-dark text-light bg-opacity-75 position-absolute bottom-0 end-0" data-bs-toggle="modal" data-bs-target="#uploadPicture"><i class="bi bi-camera"></i></button>
                </div>
              </div>
              <div class="row g-2">
                <button type="button" class="btn btn-warning me-sm-1 rounded col-sm" data-bs-toggle="modal" data-bs-id="<?php echo $id ?>" data-bs-name="<?php echo $user['name'] ?>" data-bs-username="<?php echo $user['username'] ?>" data-bs-email="<?php echo $user['email'] ?>" data-bs-target="#editProfileModal"><i class="bi bi-pencil-square"></i> Edit Profile</button>
                <button type="button" class="btn btn-dark rounded col-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal"><i class="bi bi-key-fill"></i> Change Password</button>
              </div>
            </div>
            <div class="col-md-8 p-md-5 mt-4">
              <h4>Details</h4>
              <hr class="border-bottom">
              <div class="row g-4 mb-3">
                <div class="col-md">
                  <div class="row">
                    <label for="first_name" class="col-md-4 col-form-label fw-bold">First Name</label>
                    <div class="col-md-8">
                      <input type="text" value="<?php echo $user['first_name'] ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md ps-md-4">
                  <div class="row g-1">
                    <label for="last_name" class="col-md-4 ps-md-2 col-form-label fw-bold">Last Name</label>
                    <div class="col-md-8">
                      <input type="text" value="<?php echo $user['last_name'] ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="username" class="col-md-2 col-form-label fw-bold">Username</label>
                <div class="col-md-10">
                  <input type="text" value="<?php echo $user['username'] ?>" class="form-control" readonly>
                </div>
              </div>
              <div class="row mb-3">
                <label for="username" class="col-md-2 col-form-label fw-bold">Email</label>
                <div class="col-md-10">
                  <input type="text" value="<?php echo $user['email'] ?>" class="form-control" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="editProfileModalLabel">Update <?php echo $user['first_name'] . ' ' . $user['last_name'] ?></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="users/edit.php" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="first_name" class="col-form-label">First Name:</label>
            <input name="first_name" type="text" value="<?php echo $user['first_name'] ?>" placeholder="Enter your first name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="last_name" class="col-form-label">Last Name:</label>
            <input name="last_name" type="text" value="<?php echo $user['last_name'] ?>" placeholder="Enter your last name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="username" class="col-form-label">Username:</label>
            <input name="username" type="text" value="<?php echo $user['username'] ?>" placeholder="Enter your username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="col-form-label">Email:</label>
            <input name="email" type="email" value="<?php echo $user['email'] ?>" placeholder="Enter your email" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <input name="id" value="<?php echo $_SESSION['userid'] ?>" type="hidden">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="edit" type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="changePasswordModalLabel">Change Password</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="users/change_password.php" method="post">
        <div class="modal-body">
          <div class="row g-1 mb-3">
            <div class="col-md-5">
              <label for="current_password" class="col-form-label">Current password:</label>
            </div>
            <div class="col-md-7">
              <input name="current_password" type="password" placeholder="Type your current password" class="form-control" required>
            </div>
          </div>
          <div class="row g-1 mb-3">
            <div class="col-md-5">
              <label for="new_password" class="col-form-label">New password:</label>
            </div>
            <div class="col-md-7">
              <input name="new_password" type="password" placeholder="Type your new password" class="form-control" required>
            </div>
          </div>
          <div class="row g-1 mb-3">
            <div class="col-md-5">
              <label for="repeat_password" class="col-form-label">Repeat new password:</label>
            </div>
            <div class="col-md-7">
              <input name="repeat_password" type="password" placeholder="Repeat type your new password" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input name="id" value="<?php echo $_SESSION['userid'] ?>" type="hidden">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="change_password" type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Upload Picture -->
<div class="modal fade" id="uploadPicture" tabindex="-1" aria-labelledby="uploadPictureLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="uploadPictureLabel">Change Profile Picture</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="users/change_picture.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input name="id" type="hidden" value="<?php echo $id ?>">
          <div class="mb-3">
            <img src="<?php echo $user['extension'] ? "./images/user.${user['extension']}" : "./images/default.svg" ?>" alt="" class="w-100">
          </div>
          <div class="input-group mb-3">
            <input name="picture" type="file" class="form-control" required>
            <button name="change_picture" type="submit" class="btn btn-warning"><i class="bi bi-pencil"></i> Change</button>
          </div>
        </div>
      </form>
      <form action="users/remove_picture.php" method="post">
        <div class="modal-footer">
          <input name="id" type="hidden" value="<?php echo $id ?>">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="remove_picture" type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Remove</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include './partials/footer.php' ?>