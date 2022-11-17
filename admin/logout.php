<?php

include './inc/config.php';

session_start();
session_destroy();

header('Location: '.SITE_URL.'admin/login.php');

?>