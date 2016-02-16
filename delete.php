<?php

require_once 'service/MaterialsService.php';
session_start();
$MaterialsService = unserialize($_SESSION['material_service']);
$file_name = $_GET['file'];
$section_id = $_GET['section_id'];
$MaterialsService->delete_material($file_name, $section_id);
$course_id = $MaterialsService->get_course_id();
header('location:course_materials.php?course=' . $course_id);
?>
