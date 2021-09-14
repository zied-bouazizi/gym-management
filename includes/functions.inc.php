<?php

// Allow user to login
function loginUser($conn, $username, $password)
{
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header('location: ../login.php?error=wronglogin');
        exit();
    }

    $passwordHashed = $uidExists['password'];

    $checkPassword = password_verify($password, $passwordHashed);

    if ($checkPassword === false) {
        header('location: ../login.php?error=wronglogin');
        exit();
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION['userid'] = $uidExists['id'];
        $_SESSION['useruid'] = $uidExists['username'];
        header('location: ../index.php');
        exit();
    }
}

// Check if username or email exist
function uidExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../login.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        return false;
    }

    mysqli_stmt_close($stmt);
}
