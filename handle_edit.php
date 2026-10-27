<?php
require_once __DIR__ . "/session_check.php";
require_once __DIR__ . "/db_con.php";

// array for  Errors
$register_errors = [];

// echo  "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit;
if($_SERVER["REQUEST_METHOD"] == "POST"){

$stid = $_POST["student_id"];
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
$create_info_query = mysqli_prepare($connection, "UPDATE `students_info` SET `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ? WHERE `students_info`.`student_id` =?;");
mysqli_stmt_bind_param($create_info_query, 'ssssi', $first_name, $last_name, $student_email, $student_phone, $stid);
mysqli_stmt_execute($create_info_query);
$create_info_query2 = mysqli_prepare($connection, "UPDATE `students_academics` SET `roll_number` = ?, `class` = ?, `gender` = ?, `dob` = ?, `status` = ? WHERE `students_academics`.`student_id` = ?;");
mysqli_stmt_bind_param($create_info_query2, 'sssssi', $student_rn, $student_grade, $student_gender, $student_dob, $student_status, $stid);
mysqli_stmt_execute($create_info_query2);

$_SESSION['success'] = "Student succesfully updated";
    header("Location: students.php");

  exit;
}

?>