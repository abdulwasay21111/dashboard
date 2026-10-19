<?php

$host_name = "localhost";
$user = "root";
$pass = "";
$database = "students_db";

$connection = mysqli_connect($host_name, $user, $pass, $database);
if(!$connection){
    die("Database coonection Failed : " . mysqli_connect_error());
}


?>