<?php
require_once __DIR__ . "/session_check.php";
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


// array for  Errors
$register_errors = [];


if($_SERVER["REQUEST_METHOD"] == "POST"){

// Details Variables
$accName = $_POST["fullName"];
$accMail = $_POST["Email"];
$accPass = $_POST["password"];
$accCP = $_POST["confirm_pass"];


// Checking If email and pass are empty
if(empty($accMail) || empty($accPass)){
    $register_errors[] = "Email and Password are Required";
}

// checking Email FOrmat
if(filter_var($accMail, FILTER_VALIDATE_EMAIL) == false){
    $register_errors[] = "Entered Email is Incorrect";
}

if($accCP != $accPass){
    $register_errors[] = "Passwords is Mismatched";
}
// Inserting errors
if(!empty($register_errors)){
    $_SESSION["registration_errors"] = $register_errors;
    header("Location: register.php");
    exit;
}
}
?>
