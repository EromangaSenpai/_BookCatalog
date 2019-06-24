<?php
require 'db.php';
session_start();
$_SESSION['id'] = $_GET['id'];
header("Location: ../InfoPage.php");
?>