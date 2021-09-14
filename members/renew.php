<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

if (isset($_POST['renew'])) {
  $id = $_POST['id'];
  $membershiExpiry = $_POST['membership_expiry'];
  $page = $_POST['page'];
  $category = $_POST['category'];

  renewMembership($conn, $id, $membershiExpiry);

  if ($page > 1 && $category == 'Bodybuilding') {
    header('location: ../bodybuilding.php?success=membershipwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Kickboxing') {
    header('location: ../kickboxing.php?success=membershipwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Aerobic') {
    header('location: ../aerobic.php?success=membershipwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Gymnastic') {
    header('location: ../gymnastic.php?success=membershipwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Taekwondo A1') {
    header('location: ../taekwondo_a1.php?success=membershipwasupdated&&page=' . $page);
    exit();
  } else if ($page > 1 && $category == 'Taekwondo A2') {
    header('location: ../taekwondo_a2.php?success=membershipwasupdated&&page=' . $page);
    exit();
  } else if ($category == 'Bodybuilding') {
    header('location: ../bodybuilding.php?success=membershipwasupdated');
    exit();
  } else if ($category == 'Kickboxing') {
    header('location: ../kickboxing.php?success=membershipwasupdated');
    exit();
  } else if ($category == 'Aerobic') {
    header('location: ../aerobic.php?success=membershipwasupdated');
    exit();
  } else if ($category == 'Gymnastic') {
    header('location: ../gymnastic.php?success=membershipwasupdated');
    exit();
  } else if ($category == 'Taekwondo A1') {
    header('location: ../taekwondo_a1.php?success=membershipwasupdated');
    exit();
  } else if ($category == 'Taekwondo A2') {
    header('location: ../taekwondo_a2.php?success=membershipwasupdated');
    exit();
  }
} else if (isset($_POST['renew_member'])) {
  $id = $_POST['id'];
  $membershiExpiry = $_POST['membership_expiry'];

  renewMembership($conn, $id, $membershiExpiry);

  header('location: ../member.php?id=' . $id . '&&success=membershipwasupdated');
  exit();
}
