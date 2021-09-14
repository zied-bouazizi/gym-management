<?php

require_once './includes/dbh.inc.php';
require_once './members/functions.php';

session_start();

if (!isset($_SESSION['useruid'])) {
  header('Location: ../login.php');
  exit();
}

$count = 0;

$category = 'Aerobic';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$previous = $page - 1;
$next = $page + 1;

if (isset($_GET['search'])) {
  $search = $_GET['search'];

  if (!$search) {
    header('location: ../aerobic.php');
    exit();
  }

  $members = searchMembers($conn, $search, $category);
  $pages = getPagesSearch($conn, $search, $category);
} else {
  $category = 'Aerobic';
  $members = getMembers($conn, $category);
  $pages = getPages($conn, $category);
}
?>

<?php include './partials/header.php' ?>

<div class="container-fluid">
  <div class="row">

    <?php include './partials/sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-4">

      <!-- Success saved member alert -->
      <?php
      if (isset($_GET['success']) && $_GET['success'] == 'memberwassaved') {
        include './partials/success_alert.php';
      }
      ?>

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

      <!-- Success deleted member alert -->
      <?php
      if (isset($_GET['success']) && $_GET['success'] == 'memberwasdeleted') {
        include './partials/success_alert.php';
      }
      ?>

      <div class="text-center <?php echo isset($_GET['search']) && $pages == 0 ? '' : 'd-none' ?>">
        <p class="lead">Oops! We couldn’t find results for your search</br>
          <span class="h4 fw-bold"><?php echo isset($_GET['search']) ? $search : '' ?></span>
        </p>
      </div>

      <div class="<?php echo isset($_GET['search']) && $pages == 0 ? 'd-none' : '' ?>">

        <h3 class="mb-3 mb-sm-2">Members List</h3>
        <div class="d-sm-flex">
          <button id="newButton" type="button" class="btn btn-warning me-sm-auto mb-3 mb-sm-2 px-4" data-bs-toggle="modal" data-bs-target="#newModal">
            <i class="bi bi-plus-circle"></i> Create New Member
          </button>

          <form action="members/search.php" method="post" class="mb-3 mb-sm-2">
            <input name="category" type="hidden" value="<?php echo $category ?>">
            <div class="input-group">
              <div id="searchInput" class="form-outline">
                <input name="search_text" type="text" value="<?php echo isset($_GET['search']) ? $search : '' ?>" placeholder="Search" class="form-control" />
              </div>
              <button name="search" type="submit" class="btn btn-dark d-none d-sm-block">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-striped table-sm text-center">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Joined In</th>
                <th scope="col">Expires On</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($members as $member) : ?>
                <tr>
                  <th>
                    <?php
                    $count++;
                    if ($page > 1) {
                      echo $count + (($page - 1) * 10);
                    } else {
                      echo $count;
                    }
                    ?>
                  </th>
                  <td><?php echo $member['first_name'] ?></td>
                  <td><?php echo $member['last_name'] ?></td>
                  <td><?php echo $member['phone'] ?></td>
                  <td><?php echo $member['create_date'] ?></td>
                  <td><?php echo $member['membership_expiry'] ?></td>
                  <td><?php echo $member['status'] === 'active' ? '<span class="bg-success text-light px-3 rounded">' . $member["status"] . '</span>' : '<span class="bg-warning px-2 rounded">' . $member["status"] . '</span>' ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="member.php?id=<?php echo $member['id'] ?>" type="button" class="btn btn-dark btn-sm me-1 rounded">
                        <i class="bi bi-eye"></i>
                      </a>
                      <button type="button" class="btn btn-warning btn-sm me-1 rounded" data-bs-toggle="modal" data-bs-id="<?php echo $member['id'] ?>" data-bs-first-name="<?php echo $member['first_name'] ?>" data-bs-last-name="<?php echo $member['last_name'] ?>" data-bs-membership-expiry="<?php echo $member['membership_expiry'] ?>" data-bs-target="#renewModal">
                        <i class="bi bi-bootstrap-reboot"></i>
                      </button>
                      <button type="button" class="btn btn-dark btn-sm me-1 rounded" data-bs-toggle="modal" data-bs-id="<?php echo $member['id'] ?>" data-bs-first-name="<?php echo $member['first_name'] ?>" data-bs-last-name="<?php echo $member['last_name'] ?>" data-bs-phone="<?php echo $member['phone'] ?>" data-bs-create-date="<?php echo $member['create_date'] ?>" data-bs-target="#editModal">
                        <i class="bi bi-pencil-square"></i>
                      </button>
                      <button type="button" class="btn btn-danger btn-sm rounded" data-bs-toggle="modal" data-bs-id="<?php echo $member['id'] ?>" data-bs-first-name="<?php echo $member['first_name'] ?>" data-bs-last-name="<?php echo $member['last_name'] ?>" data-bs-target="#deleteModal">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <div class="text-center <?php echo $page > $pages ? '' : 'd-none' ?>">
            <p class="lead">Sorry! You have no members</p>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <nav class="d-flex justify-content-center align-self-end <?php echo (isset($_GET['search']) && $pages == 0) || $page > $pages ? 'd-none' : '' ?>">
        <ul class="pagination">
          <li class="page-item <?php echo $page == 1 ? 'disabled' : '' ?>"><a class="page-link bg-dark text-white" href="aerobic.php?page=<?php echo $previous ?>"><span aria-hidden="true">&laquo;</span></a></li>
          <?php for ($i = 1; $i <= $pages; $i++) : ?>
            <li class="page-item <?php echo $page == $i ? 'active' : '' ?>"><a class="page-link <?php echo $page == $i ? 'bg-warning border-warning' : 'text-dark' ?>" href="aerobic.php?page=<?php echo isset($_GET['search']) ? 'search=' . $_GET['search'] . '&page=' . $i : 'page=' . $i ?>">
                <?php echo $i ?>
              </a></li>
          <?php endfor; ?>
          <li class="page-item <?php echo $page == $pages ? 'disabled' : '' ?>"><a class="page-link bg-dark text-white" href="aerobic.php?page=<?php echo $next ?>"><span aria-hidden="true">&raquo;</span></a></li>
        </ul>
      </nav>
    </main>
  </div>
</div>

<!-- New Modal -->
<div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="newModalLabel">Create New Member</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="members/new.php" method="post" enctype="multipart/form-data">
        <input name="category" type="hidden" value="<?php echo $category ?>">
        <div class="modal-body">
          <div class="row g-3 mb-3">
            <div class="col-6">
              <label for="first_name" class="col-form-label">First Name: </label>
              <input name="first_name" type="text" placeholder="Type first name here" class="form-control" required>
            </div>
            <div class="col-6">
              <label for="last_name" class="col-form-label">Last Name: </label>
              <input name="last_name" type="text" placeholder="Type last name here" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="phone" class="col-form-label">Phone Number:</label>
            <input name="phone" type="tel" placeholder="Type phone number here" class="form-control">
          </div>
          <div class="mb-3">
            <label for="create_date" class="col-form-label">Start Date:</label>
            <input name="create_date" type="date" class="form-control" required>
          </div>
          <div class="mb-4">
            <label for="membership_expiry" class="col-form-label">Expires On:</label>
            <input name="membership_expiry" type="date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="picture" class="col-form-label">Image:</label>
            <input name="picture" type="file" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="new" type="submit" class="btn btn-warning">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="renewModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="members/renew.php" method="post">
        <input name="page" type="hidden" value="<?php echo $page ?>">
        <input name="category" type="hidden" value="<?php echo $category ?>">
        <div class="modal-body">
          <div class="mb-3">
            <label for="membership_expiry" class="col-form-label">Membership Expiry:</label>
            <input name="membership_expiry" type="date" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <input name="id" type="hidden">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
          <button name="renew" type="submit" class="btn btn-warning">Renew</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="editModalLabel"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="members/edit.php" method="post">
        <input name="page" type="hidden" value="<?php echo $page ?>">
        <input name="category" type="hidden" value="<?php echo $category ?>">
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
          <button name="edit" type="submit" class="btn btn-warning">Update</button>
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
          <input name="page" type="hidden" value="<?php echo $page ?>">
          <input name="category" type="hidden" value="<?php echo $category ?>">
          <button name="delete" type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include './partials/footer.php' ?>