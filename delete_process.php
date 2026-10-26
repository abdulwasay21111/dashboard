<?php
require_once __DIR__ . "/session_check.php";
require_once __DIR__ . "/db_con.php";
require_once __DIR__ . "/auth.php";
// array for  Errors
$register_errors = [];

// print_r($_GET);
// exit;

$st_id = $_GET["id"] ?? "";

// print_r($st_id);
// exit;
// echo $st_id;

if(empty($st_id)){
    $register_errors[] = "Student id is required";
}
if(!empty($register_errors)){
    $_SESSION["registration_errors"] = $register_errors;
    header("Location: students.php");
    exit;
}

$query = mysqli_prepare($connection, "SELECT * from students_info WHERE student_id = ?") ;
mysqli_stmt_bind_param($query, 'i', $st_id);
mysqli_stmt_execute($query);


$query_result = mysqli_stmt_get_result($query);

if(mysqli_num_rows($query_result) == 0){
        $register_errors[] = "Student Not found";
        $_SESSION["registration_errors"] = $register_errors;
       header("Location: students.php");
       exit;
}

$query2 = mysqli_prepare($connection, "DELETE  from students_info WHERE student_id = ?") ;
mysqli_stmt_bind_param($query2, 'i', $st_id);
mysqli_stmt_execute($query2);
$query3 = mysqli_prepare($connection, "DELETE  from students_academics WHERE student_id = ?") ;
mysqli_stmt_bind_param($query3, 'i', $st_id);
mysqli_stmt_execute($query3);

$_SESSION['success'] = "Student has been deleted";
    header("Location: students.php");

  exit;
// print_r($query_result);

?>

