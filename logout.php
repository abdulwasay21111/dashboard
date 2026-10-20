<?php
require_once __DIR__ . "/session_check.php";

unset($_SESSION["id"]);
session_destroy();
header("Location: login.php");
?>