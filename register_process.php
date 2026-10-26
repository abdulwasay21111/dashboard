<?php
require_once __DIR__ . "/session_check.php";
require_once __DIR__ . "/db_con.php";

// array for  Errors
$register_errors = [];


if($_SERVER["REQUEST_METHOD"] == "POST"){

// Details Variables
$accName = trim($_POST["fullName"]);
$accMail = trim($_POST["Email"]);
$accPass = trim($_POST["password"]);
$accCP = trim($_POST["confirm_pass"]);



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

$query = mysqli_prepare($connection, "SELECT * from registered_users WHERE Mail = ?") ;
mysqli_stmt_bind_param($query, 's', $accMail);
mysqli_stmt_execute($query);



$query_result = mysqli_stmt_get_result($query);
// echo "<pre>";
// print_r( $query_result);
// echo "</pre>";
// exit;

if(mysqli_num_rows($query_result) > 0){
        $register_errors[] = "THis Email is already registered";
        $_SESSION["registration_errors"] = $register_errors;
       header("Location: register.php");
       exit;
}






 $safe_pass = password_hash($accPass, PASSWORD_DEFAULT);



// For insertion of data in database


$insertion_query = mysqli_prepare($connection, "INSERT INTO registered_users(Full_Name, Mail, Pass) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($insertion_query, 'sss', $accName, $accMail, $safe_pass);
mysqli_stmt_execute($insertion_query);


$_SESSION['success'] = "Email has been registered";
    header("Location: register.php");

  exit;

}
?>
