<?php
include_once 'function.php';
include_once 'service/CoursesService.php';

include_once 'model/constantss.php';
session_start();

if (validate_session_time_out() == 0) {

    header("Location:login.php");
    exit();
}
if ($_SESSION['change_password'] == 0) {
    header("Location:change_password.php");
    exit();
}

if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_admin) {
    header("Location:manage_courses.php");
    exit();
}

$CoursesService = new CoursesService();
$courses = $CoursesService->get_all_courses_related_to_user($_SESSION['user_id']);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>instructor</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css?<?php echo time(); ?>" rel="stylesheet">
    </head>
    <body >

        <br>
        <?php include('header.php') ?>
        <br>
        <br>
        <div class="container">
            <div class="center_class">
                <div class="well">
                    <h3>
                        Hi, <?php echo $_SESSION['user_name'] . "..."; ?> Theses are courses you <?php
        if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_instructor) {
            echo "teaches";
        } else {
            echo "have enrolled in";
        }
        ?>
                    </h3></div> </div>
            <div class="list-group center_class" >
                <?php foreach ($courses as $course): ?>
                    <h3> <a href= <?php echo "\"course_materials.php?course=" . hash_val($course->get_course_id()) . "\""; ?> class="list-group-item"><div class="bg-primary"><?php echo $course->get_course_name(); ?></div></a></h3>
                        <?php endforeach; ?>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

    </body>
</html> 
