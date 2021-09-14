<?php

require_once './includes/dbh.inc.php';
require_once './members/functions.php';

session_start();

if (!isset($_SESSION['useruid'])) {
  header('Location: ../login.php');
  exit();
}

$memberId = $_GET['id'];
$member = getMemberById($conn, $memberId);
?>

<?php include './partials/header.php' ?>

<div class="container-fluid">
  <div class="row">

    <?php include './partials/sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-4">

      <!-- Success updated member alert -->
      <?php
      if (isset($_GET['success']) && $_GET['success'] == 'memberwasupdated') {
        include './partials/success_alert.php';
      }
      ?>

      <!-- Success updated membership alert -->
      <?php
      if (isset($_GET['success']) && $_GET['success'] == 'membershipwasupdated') {
        include './partials/success_alert.php';
      }
      ?>

      <h3 class="mb-3"><?php echo $member['first_name'] . ' ' . $member['last_name'] ?>'s Details</h3>

      <div class="card w-100 p-md-4">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4 text-center px-md-4">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="position-relative">
                    <img src="<?php echo $member['extension'] ? "./images/${member['id']}.${member['extension']}" : "./images/default.svg" ?>" alt="" class="w-100">
                    <button class="btn bg-dark text-light bg-opacity-75 position-absolute bottom-0 end-0" data-bs-toggle="modal" data-bs-target="#uploadPicture"><i class="bi bi-camera"></i></button>
                  </div>
                </div>
              </div>
              <div class="btn-group w-100">
                <button type="button" class="btn btn-warning me-1 rounded" data-bs-toggle="modal" data-bs-id="<?php echo $member['id'] ?>" data-bs-first-name="<?php echo $member['first_name'] ?>" data-bs-last-name="<?php echo $member['last_name'] ?>" data-bs-membership-expiry="<?php echo $member['membership_expiry'] ?>" data-bs-target="#renewModal">
                  <i class="bi bi-bootstrap-reboot"></i> Renew
                </button>
                <button type="button" class="btn btn-dark px-4 me-1 rounded" data-bs-toggle="modal" data-bs-id="<?php echo $member['id'] ?>" data-bs-first-name="<?php echo $member['first_name'] ?>" data-bs-last-name="<?php echo $member['last_name'] ?>" data-bs-phone="<?php echo $member['phone'] ?>" data-bs-create-date="<?php echo $member['create_date'] ?>" data-bs-target="#editModal">
                  <i class="bi bi-pencil-square"></i> Edit
                </button>
                <button type="button" class="btn btn-danger rounded" data-bs-toggle="modal" data-bs-id="<?php echo $member['id'] ?>" data-bs-first-name="<?php echo $member['first_name'] ?>" data-bs-last-name="<?php echo $member['last_name'] ?>" data-bs-target="#deleteModal">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </div>
            </div>
            <div class="col-md-8 p-md-5">
              <div class="row g-4 mb-3">
                <div class="col-md">
                  <div class="row">
                    <label for="first_name" class="col-md-4 col-form-label fw-bold">First Name</label>
                    <div class="col-md-8">
                      <input type="text" value="<?php echo $member['first_name'] ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-md ps-md-4">
                  <div class="row g-1">
                    <label for="last_name" class="col-md-4 ps-md-4 col-form-label fw-bold">Last Name</label>
                    <div class="col-md-8">
                      <input type="text" value="<?php echo $member['last_name'] ?>" class="form-control" readonly>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="phone" class="col-md-2 col-form-label fw-bold">Phone</label>
                <div class="col-md-10">
                  <input type="text" value="<?php echo $member['phone'] ?>" class="form-control" readonly>
                </div>
              </div>
              <div class="row mb-3">
                <label for="create_date" class="col-md-2 col-form-label fw-bold">Joined In</label>
                <div class="col-md-10">
                  <input type="text" value="<?php echo $member['create_date'] ?>" class="form-control" readonly>
                </div>
              </div>
              <div class="row mb-3">
                <label for="membership_expiry" class="col-md-2 col-form-label fw-bold">Expires On</label>
                <div class="col-md-10">
                  <input type="text" value="<?php echo $member['membership_expiry'] ?>" class="form-control" readonly>
                </div>
              </div>
              <div class="row mb-3">
                <label for="category" class="col-md-2 col-form-label fw-bold">Category</label>
                <div class="col-md-10">
                  <input type="text" value="<?php echo $member['category'] ?>" class="form-control bg-warning" readonly>
                </div>
              </div>
              <div class="row mb-3">
                <label for="membership_expiry" class="col-md-2 col-form-label fw-bold">Status</label>
                <div class="col-md-10 mt-2">
                  <?php echo $member['status'] === 'active' ? '<span class="bg-success text-light px-3 rounded">' . $member["status"] . '</span>' : '<span class="bg-warning px-2 rounded">' . $member["status"] . '</span>' ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="editModalLabel"></h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="members/edit.php" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="first_name" class="col-form-label">First Name: </label>
            <input name="first_name" type="text" placeholder="Enter first name here" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="last_name" class="col-form-label">Last Name: </label>
            <input name="last_name" type="text" placeholder="Enter last name here" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="phone" class="col-form-label">Phone Number:</label>
            <input name="phone" type="tel" placeholder="Enter phone number here" class="form-control">
          </div>
          <div class="mb-3">
            <label for="create_date" class="col-form-label">Joined In:</label>
            <input name="create_date" type="date" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <input name="id" type="hidden">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="edit_member" type="submit" class="btn btn-warning">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        <form action="members/delete.php" method="post">
          <input name="id" type="hidden">
          <input name="category" type="hidden" value="<?php echo $member['category'] ?>">
          <button name="delete_member" type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="renewModalLabel"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="members/renew.php?id=<?php echo $member['id'] ?>" method="post">
        <div class="modal-body">
          <div class="mb-3">
            <label for="membership_expiry" class="col-form-label">Membership Expiry:</label>
            <input name="membership_expiry" type="date" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <input name="id" type="hidden">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="renew_member" type="submit" class="btn btn-warning">Renew</button>
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
        <h3 class="modal-title" id="uploadPictureLabel">Change <span class="fw-bold"><?php echo $member['full_name'] ?></span> Picture</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="members/change_picture.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input name="id" type="hidden" value="<?php echo $memberId ?>">
          <div class="mb-3">
            <img src="<?php echo $member['extension'] ? "./images/${member['id']}.${member['extension']}" : "./images/default.svg" ?>" alt="" class="w-100">
          </div>
          <div class="input-group mb-3">
            <input name="picture" type="file" class="form-control" required>
            <button name="change_picture" type="submit" class="btn btn-warning"><i class="bi bi-pencil"></i> Change</button>
          </div>
        </div>
      </form>
      <form action="members/remove_picture.php" method="post">
        <div class="modal-footer">
          <input name="id" type="hidden" value="<?php echo $memberId ?>">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="remove_picture" type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Remove</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include './partials/footer.php' ?>