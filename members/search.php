<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['search'])) {
  $searchText = $_POST['search_text'];
  $category = $_POST['category'];

  if ($category == 'Bodybuilding') {
    header('location: ../bodybuilding.php?search=' . $searchText);
    exit();
  }

  if ($category == 'Kickboxing') {
    header('location: ../kickboxing.php?search=' . $searchText);
    exit();
  }

  if ($category == 'Aerobic') {
    header('location: ../aerobic.php?search=' . $searchText);
    exit();
  }

  if ($category == 'Gymnastic') {
    header('location: ../gymnastic.php?search=' . $searchText);
    exit();
  }

  if ($category == 'Taekwondo A1') {
    header('location: ../taekwondo_a1.php?search=' . $searchText);
    exit();
  }

  if ($category == 'Taekwondo A2') {
    header('location: ../taekwondo_a2.php?search=' . $searchText);
    exit();
  }
}
