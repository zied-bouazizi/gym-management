<?php

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"], 1);
$active_group = 'default';
$query_builder = TRUE;

// Create connection
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

// Check connection
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

// Display a listing of expired members
function getExpiredMembers($conn)
{
  $yesterday = date('Y-m-d', strtotime('-1 days'));

  $sql = "SELECT * FROM members WHERE membership_expiry = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $yesterday);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);

  return $resultData;

  mysqli_stmt_close($stmt);
}

// Store a newly notifications of expired members in storage
function createNotifications($conn, $member)
{
  $today = date('Y-m-d');
  $message = 'Membership of ' . $member['full_name'] . ' was expired';
  $memberId = $member['id'];

  $sql = "INSERT INTO notifications (message, member_id, create_date) VALUES (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sis", $message, $memberId, $today);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

$expiredMembers = getExpiredMembers($conn);

foreach ($expiredMembers as $expiredMember) {
  createNotifications($conn, $expiredMember);
}
