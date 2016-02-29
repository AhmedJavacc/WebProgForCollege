<?php

require_once 'service/UsersCoursesController.php';
session_start();
$course_id = $_POST['course_id'];
$user_type=$_POST['user_type'];

$textval = $_POST['textarea'];

$UsersCoursesController = new UsersCoursesController();
$UsersCoursesController->set_id($course_id);
$UsersCoursesController->set_user_type($user_type);
$arr = preg_split('/\r\n|[\r\n]/', $textval);

$UsersCoursesController->enroll_user($arr);
$_SESSION['course']=$course_id;
$_SESSION['user_type']=$user_type;
header("Location:manage_courses.php");
?>
