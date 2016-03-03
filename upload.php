<?php

session_start();
include_once 'service/MaterialsService.php';
include_once 'service/SectionsService.php';
include_once 'model/constantss.php';

$MaterialsService = unserialize($_SESSION['material_service']);
$SectionsService = unserialize($_SESSION['section_service']);
$file = $_FILES['file']['name'];

$file_loc = $_FILES['file']['tmp_name'];

$file_size = $_FILES['file']['size'];
$file_type = $_FILES['file']['type'];
$section_id = $_POST['section_id'];
$MaterialsService->insert_material($file, $section_id);
move_uploaded_file($file_loc, constantss::$parent_directory . $MaterialsService->get_course_id() . '/' . $SectionsService->get_section($section_id)->get_folder_name() . '/' . $file);
chmod(constantss::$parent_directory . $MaterialsService->get_course_id() . '/' . $SectionsService->get_section($section_id)->get_folder_name() . '/' . $file, 0777);
?>