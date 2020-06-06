<?php

session_start();
require_once('../includes/config.php');
require_once('../includes/functions.php');
unset($_SESSION['admin']);
header('Location:login.php');
