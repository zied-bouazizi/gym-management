<?php

// Display a listing of members
function getMembers($conn, $category)
{
  $limit = 10;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($page - 1) * $limit;

  $sql = "SELECT * FROM members WHERE category = ? ORDER BY create_date DESC LIMIT $start, $limit;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $category);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);

  return $resultData;

  mysqli_stmt_close($stmt);
}

// Display number of all pages
function getPages($conn, $category)
{
  $limit = 10;

  $sql = "SELECT count(id) AS countMembers FROM members WHERE category = ?;";

  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $category);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);
  $total = $row['countMembers'];
  $pages = ceil($total / $limit);

  return $pages;

  mysqli_stmt_close($stmt);
}

// Display a specified member from storage
function getMemberById($conn, $id)
{
  $sql = "SELECT * FROM members WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);

  return $row;

  mysqli_stmt_close($stmt);
}

// Store a newly created member in storage
function createMember($conn, $firstName, $lastName, $phone, $createDate, $membershipExpiry, $category)
{
  $fullName = $firstName . ' ' . $lastName;

  $sql = "INSERT INTO members (full_name, first_name, last_name, phone, create_date, membership_expiry, category) VALUES (?, ?, ? , ? , ? , ?, ?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sssssss", $fullName, $firstName, $lastName, $phone, $createDate, $membershipExpiry, $category);
  mysqli_stmt_execute($stmt);

  $id = mysqli_insert_id($conn);

  return $id;

  mysqli_stmt_close($stmt);
}

// Update the specified member in storage
function updateMember($conn, $id, $firstName, $lastName, $phone, $createDate)
{
  $sql = "UPDATE members SET first_name = ?, last_name = ?, phone = ?, create_date = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ssssi", $firstName, $lastName, $phone, $createDate, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Update the specified membership in storage
function renewMembership($conn, $id, $membershiExpiry)
{
  $status = 'active';

  $sql = "UPDATE members SET membership_expiry = ?, status = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ssi", $membershiExpiry, $status, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Remove the specified member from storage
function deleteMember($conn, $id)
{
  $sql = "DELETE FROM members WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Display a listing of specified members
function searchMembers($conn, $search, $category)
{
  $limit = 10;

  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $start = ($page - 1) * $limit;

  $sql = "SELECT * FROM members WHERE (full_name = ? OR first_name = ? OR last_name = ? OR phone = ? OR create_date = ? OR membership_expiry = ? OR status = ?) AND category = ?  ORDER BY create_date DESC LIMIT $start, $limit;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ssssssss", $search, $search, $search, $search, $search, $search, $search, $category);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  return $resultData;

  mysqli_stmt_close($stmt);
}

// Display number of search pages
function getPagesSearch($conn, $search, $category)
{
  $limit = 10;

  $sql = "SELECT count(id) AS countMembers FROM members WHERE (full_name = ? OR first_name = ? OR last_name = ? OR phone = ? OR create_date = ? OR membership_expiry = ? OR status = ?) AND category = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ssssssss", $search, $search, $search, $search, $search, $search, $search, $category);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);
  $total = $row['countMembers'];
  $pages = ceil($total / $limit);

  return $pages;

  mysqli_stmt_close($stmt);
}

// Upload the specified member picture
function uploadImage($conn, $file, $id)
{
  if (isset($file) && $file['name']) {
    // Get the file extension from the file name
    $fileName = $file['name'];
    // Search the dot in the filename
    $dotPosition = strpos($fileName, '.');
    // Take the substring from the dot position till the end of the string
    $extension = substr($fileName, $dotPosition + 1);

    move_uploaded_file($file['tmp_name'], '../images/' . $id . '.' . $extension);

    // Update the specified membership extension in storage
    $sql = "UPDATE members SET extension = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header('location: ../index.php?error=stmtfailed');
      exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $extension, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
}

// Remove the specified extension in storage
function deleteImage($conn, $id)
{
  $extension = '';

  $sql = "UPDATE members SET extension = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "si", $extension, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Display number of members by category
function getCountMembers($conn, $category)
{
  $sql = "SELECT count(id) AS countMembers FROM members WHERE category = ?;";

  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $category);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);
  $count = $row['countMembers'];

  return $count;

  mysqli_stmt_close($stmt);
}

// Display number of members by status
function getCountByStatus($conn, $category, $status)
{
  $sql = "SELECT count(id) AS countMembers FROM members WHERE category = ? AND status = ?;";

  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ss", $category, $status);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);
  $count = $row['countMembers'];

  return $count;

  mysqli_stmt_close($stmt);
}
