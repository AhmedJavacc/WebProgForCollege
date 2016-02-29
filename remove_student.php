<?php

require_once 'service/UsersCoursesController.php';
session_start();
if (isset($_POST['user_id'])) {
    $student_arr = $_POST['user_id'];
} else {
    $student_arr = array();
}
$course_id = $_POST['course_id_hidden'];
echo $course_id."<br>";
$user_type = $_POST['user_type_hidden'];
echo $user_type."<br>";
$UsersCoursesController = new UsersCoursesController();
$UsersCoursesController->set_id($course_id);
$UsersCoursesController->set_user_type($user_type);
//echo $course_id;
$UsersCoursesController->remove_user($student_arr);

$_SESSION['course']=$course_id;
$_SESSION['user_type']=$user_type;
header("Location:manage_courses.php");
?>

