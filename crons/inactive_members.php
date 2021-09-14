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

// Update the specified member where membership expired
$today = date('Y-m-d');

$sql = "UPDATE members SET status = 'inactive' WHERE membership_expiry < ?;";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
  header('location: ../index.php?error=stmtfailed');
  exit();
}

mysqli_stmt_bind_param($stmt, "s", $today);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
