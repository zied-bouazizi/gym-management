<?php

// Display a listing of notifications
function getNotifications($conn)
{
  $sql = "SELECT * FROM notifications WHERE status = 0;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);

  return $resultData;

  mysqli_stmt_close($stmt);
}

// Update a listing of specified notifications
function readNotifications($conn)
{
  $sql = "UPDATE notifications SET status = 1 WHERE status = 0;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}
