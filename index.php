<?php

require_once './includes/dbh.inc.php';
require_once './members/functions.php';

session_start();

if (!isset($_SESSION['useruid'])) {
  header('Location: ../login.php');
  exit();
}

$bodybuildingMembers = getCountMembers($conn, 'Bodybuilding');
$activeBodybuildingMembers = getCountByStatus($conn, 'Bodybuilding', 'active');
$inactiveBodybuildingMembers = getCountByStatus($conn, 'Bodybuilding', 'inactive');

$taekwondoA1Members = getCountMembers($conn, 'Taekwondo A1');
$activeTaekwondoA1Members = getCountByStatus($conn, 'Taekwondo A1', 'active');
$inactiveTaekwondoA1Members = getCountByStatus($conn, 'Taekwondo A1', 'inactive');

$taekwondoA2Members = getCountMembers($conn, 'Taekwondo A2');
$activeTaekwondoA2Members = getCountByStatus($conn, 'Taekwondo A2', 'active');
$inactiveTaekwondoA2Members = getCountByStatus($conn, 'Taekwondo A2', 'inactive');

$kickboxingMembers = getCountMembers($conn, 'Kickboxing');
$activeKickboxingMembers = getCountByStatus($conn, 'Kickboxing', 'active');
$inactiveKickboxingMembers = getCountByStatus($conn, 'Kickboxing', 'inactive');

$gymnasticMembers = getCountMembers($conn, 'Gymnastic');
$activeGymnasticMembers = getCountByStatus($conn, 'Gymnastic', 'active');
$inactiveGymnasticMembers = getCountByStatus($conn, 'Gymnastic', 'inactive');

$aerobicMembers = getCountMembers($conn, 'Aerobic');
$activeAerobicMembers = getCountByStatus($conn, 'Aerobic', 'active');
$inactiveAerobicMembers = getCountByStatus($conn, 'Aerobic', 'inactive');
?>

<?php include './partials/header.php' ?>

<div class="container-fluid">
  <div class="row">

    <?php include './partials/sidebar.php' ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 p-4">
      <h3 class="mb-3 mb-sm-4">Dashboard</h3>
      <div class="row text-center g-4">
        <div class="col-md">
          <div class="card bg-white">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-people"></i>
              </div>
              <h4 class="card-title mb-3">Bodybuilding</h4>
              <div class="h6">
                <?php echo $bodybuildingMembers ?> Members
              </div>
              <div class="mb-3">
                <?php echo $activeBodybuildingMembers ?> <span class="bg-success text-light px-3 me-1 rounded">active</span>
                <?php echo $inactiveBodybuildingMembers ?> <span class="bg-warning px-2 rounded">inactive</span>
              </div>
              <a href="bodybuilding.php" class="btn btn-dark">Memebers List</a>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card bg-white">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-people"></i>
              </div>
              <h4 class="card-title mb-3">Taekwondo A1</h4>
              <div class="h6">
                <?php echo $taekwondoA1Members ?> Members
              </div>
              <div class="mb-3">
                <?php echo $activeTaekwondoA1Members ?> <span class="bg-success text-light px-3 me-1 rounded">active</span>
                <?php echo $inactiveTaekwondoA1Members ?> <span class="bg-warning px-2 rounded">inactive</span>
              </div>
              <a href="taekwondo_a1.php" class="btn btn-dark">Members List</a>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card bg-white">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-people"></i>
              </div>
              <h4 class="card-title mb-3">Taekwondo A2</h4>
              <div class="h6">
                <?php echo $taekwondoA2Members ?> Members
              </div>
              <div class="mb-3">
                <?php echo $activeTaekwondoA2Members ?> <span class="bg-success text-light px-3 me-1 rounded">active</span>
                <?php echo $inactiveTaekwondoA2Members ?> <span class="bg-warning px-2 rounded">inactive</span>
              </div>
              <a href="taekwondo_a2.php" class="btn btn-dark">Members List</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row text-center g-4 pt-4">
        <div class="col-md">
          <div class="card bg-white">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-people"></i>
              </div>
              <h4 class="card-title mb-3">Kickboxing</h4>
              <div class="h6">
                <?php echo $kickboxingMembers ?> Members
              </div>
              <div class="mb-3">
                <?php echo $activeKickboxingMembers ?> <span class="bg-success text-light px-3 me-1 rounded">active</span>
                <?php echo $inactiveKickboxingMembers ?> <span class="bg-warning px-2 rounded">inactive</span>
              </div>
              <a href="kickboxing.php" class="btn btn-dark">Members List</a>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card bg-white">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-people"></i>
              </div>
              <h4 class="card-title mb-3">Gymnastic</h4>
              <div class="h6">
                <?php echo $gymnasticMembers ?> Members
              </div>
              <div class="mb-3">
                <?php echo $activeGymnasticMembers ?> <span class="bg-success text-light px-3 me-1 rounded">active</span>
                <?php echo $inactiveGymnasticMembers ?> <span class="bg-warning px-2 rounded">inactive</span>
              </div>
              <a href="gymnastic.php" class="btn btn-dark">Members List</a>
            </div>
          </div>
        </div>
        <div class="col-md">
          <div class="card bg-white">
            <div class="card-body text-center">
              <div class="h1 mb-3">
                <i class="bi bi-people"></i>
              </div>
              <h4 class="card-title mb-3">Aerobic</h4>
              <div class="h6">
                <?php echo $aerobicMembers ?> Members
              </div>
              <div class="mb-3">
                <?php echo $activeAerobicMembers ?> <span class="bg-success text-light px-3 me-1 rounded">active</span>
                <?php echo $inactiveAerobicMembers ?> <span class="bg-warning px-2 rounded">inactive</span>
              </div>
              <a href="aerobic.php" class="btn btn-dark">Members List</a>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include './partials/footer.php' ?>