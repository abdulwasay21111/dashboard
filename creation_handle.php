<?php
require_once __DIR__ . "/session_check.php";
require_once __DIR__ . "/db_con.php";

// array for  Errors
$register_errors = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$student_email = $_POST["student_email"];
$student_phone = $_POST["student_phone"];
$student_rn = $_POST["student_rn"];
$student_grade = $_POST["student_grade"];
$student_gender = $_POST["student_gender"];
$student_dob = $_POST["student_dob"];
$student_status = $_POST["student_status"];


if(empty($first_name) || empty($last_name) || empty($student_email) 
   || empty($student_phone) || empty($student_rn) || empty($student_grade)
 || empty($student_gender) || empty($student_dob) || empty($student_status)){

    $register_errors[] = "All Fields are required";

}
if(filter_var($student_email, FILTER_VALIDATE_EMAIL) == false){
    $register_errors[] = "Entered Email is Incorrect";
}
if(!empty($register_errors)){
    $_SESSION["registration_errors"] = $register_errors;
    header("Location: student-create.php");
    exit;
}

$create_info_query = mysqli_prepare($connection, "INSERT INTO students_info (first_name, last_name, email, phone) VALUES (?, ?, ?,?)");
mysqli_stmt_bind_param($create_info_query, 'ssss', $first_name, $last_name, $student_email, $student_phone);
mysqli_stmt_execute($create_info_query);

$info_lastid = mysqli_insert_id($connection);


$create_academic_query = mysqli_prepare($connection, "INSERT INTO students_academics (student_id, roll_number, class, gender, dob, status) VALUES (?, ?, ?,?,?,?)");
mysqli_stmt_bind_param($create_academic_query, 'isssss', $info_lastid, $student_rn, $student_grade, $student_gender, $student_dob, $student_status);
mysqli_stmt_execute($create_academic_query);


$_SESSION['success'] = "Student added succesfully";
    header("Location: student-create.php");

  exit;


}


// Details Variables


//  echo  "<pre>";
//  print_r($_POST);
//  echo "</pre>";
//  exit;

?>