<?php
require_once __DIR__ . "/session_check.php";
require_once __DIR__ . "/db_con.php";

// array for  Errors
$register_errors = [];


if($_SERVER["REQUEST_METHOD"] == "POST"){

// Details Variables

$accMail = $_POST["Email"];
$accPass = $_POST["password"];

if(empty($accMail) || empty($accPass)){
    $register_errors[] = "Email and Password are Required";
}

// checking Email FOrmat
if(filter_var($accMail, FILTER_VALIDATE_EMAIL) == false){
    $register_errors[] = "Entered Email is Incorrect";
}
if(!empty($register_errors)){
    $_SESSION["registration_errors"] = $register_errors;
    header("Location: login.php");
    exit;
}


$query = mysqli_prepare($connection, "SELECT * from registered_users WHERE Mail = ?") ;
mysqli_stmt_bind_param($query, 's', $accMail);
mysqli_stmt_execute($query);
$query_result = mysqli_stmt_get_result($query);

if(mysqli_num_rows($query_result) == 0){
        $register_errors[] = "THis Email is not registered";
        $_SESSION["registration_errors"] = $register_errors;
       header("Location: login.php");
       exit;
}
 $user = mysqli_fetch_assoc($query_result);


 
}