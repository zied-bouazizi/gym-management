<?php

require_once '../includes/dbh.inc.php';
require_once './functions.php';

readNotifications($conn);

header('location: ../index.php');
exit();
