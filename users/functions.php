<?php

// Display a specified user 
function getUser($conn, $id)
{
  $sql = "SELECT first_name, last_name, username, email, extension FROM users WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../index.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $id);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);

  return $row;

  mysqli_stmt_close($stmt);
}

// Update the specified user in storage
function updateUser($conn, $id, $firstName, $lastName, $username, $email)
{
  $sql = "UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../profile.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $username, $email, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Change user password
function changePassword($conn, $id, $currentPassword, $newPassword, $repeatPassword)
{
  $passwordExist = passwordExist($conn, $id, $currentPassword);

  if ($passwordExist === false) {
    header('location: ../profile.php?error=wrongpassword');
    exit();
  }

  if ($newPassword != $repeatPassword) {
    header('location: ../profile.php?error=passwordsnotmatch');
    exit();
  }

  $sql = "UPDATE users SET password = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../profile?error=stmtfailed');
    exit();
  }

  $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ss", $newPasswordHashed, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

// Check password if exist
function passwordExist($conn, $id, $currentPassword)
{
  $sql = "SELECT password FROM users WHERE id = ?";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../profile.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $id);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);

  $passwordHashed = $row['password'];
  $checkPassword = password_verify($currentPassword, $passwordHashed);

  if ($checkPassword === true) {
    return true;
  } else {
    return false;
  }
}

// Upload the specified user picture
function uploadImage($conn, $file, $id)
{
  if (isset($file) && $file['name']) {
    // Get the file extension from the file name
    $fileName = $file['name'];
    // Search the dot in the filename
    $dotPosition = strpos($fileName, '.');
    // Take the substring from the dot position till the end of the string
    $extension = substr($fileName, $dotPosition + 1);

    move_uploaded_file($file['tmp_name'], '../images/user.' . $extension);

    // Update the specified membership extension in storage
    $sql = "UPDATE users SET extension = ? WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header('location: ../profile.php?error=stmtfailed');
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

  $sql = "UPDATE users SET extension = ? WHERE id = ?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header('location: ../profile.php?error=stmtfailed');
    exit();
  }

  mysqli_stmt_bind_param($stmt, "si", $extension, $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}
