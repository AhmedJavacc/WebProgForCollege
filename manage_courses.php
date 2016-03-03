<!DOCTYPE html>
<?php
include_once 'function.php';
include_once 'service/CoursesController.php';
include_once 'service/UsersCoursesController.php';
include_once 'model/constantss_ui.php';
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
if (un_hash_val($_SESSION['current_user_type']) != constantss::$user_type_admin) {
    header("Location:main_page.php");
    exit();
}
if (isset($_SESSION['course'])) {
    $hashed_course_id = $_SESSION['course'];
} else {
    $hashed_course_id = -1;
}
if (isset($_SESSION['user_type'])) {

    $hashed_user_type = $_SESSION['user_type'];
} else {
    $hashed_user_type = -1;
}
$CoursesController = new CoursesController();
$UsersCoursesController = new UsersCoursesController();

$UsersCoursesController->set_id($hashed_course_id);
$UsersCoursesController->set_user_type($hashed_user_type);
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css?<?php echo time(); ?>" rel="stylesheet">
    </head>
    <body >
        <?php include('header.php') ?>
        <br>
        <br>
        <div class="container">
            <form role="form" action="add_student.php" method="post">
                <div class="form-group">
                    <label for="course_id" >   Select Course : </label>
                    <select class="form-control" name="course_id" id="course_id">
                        <?php $CoursesController->list_courses(); ?>
                    </select>

                </div>
                <div class="form-group" >
                    <label for="user_type" >   Select User Type: </label>
                    <select class="form-control" name="user_type" id="user_type" >
                        <?php $UsersCoursesController->list_user_types(); ?>
                    </select>

                </div>

                <div class="form-group">
                    <label for="textarea">Add Users</label>
                    <textarea id="textarea" name="textarea" class="form-control" rows="5"  ></textarea>
                </div>
                <button id="save" type="submit" class="btn btn-primary" >save</button>
            </form>
            <form role="form" action="remove_student.php" method="post">
                <div id="user_container" id="user_container" class="not_loaded">
                    <div id="users">
                        <?php $UsersCoursesController->list_users_enrolled_in(); ?>
                    </div>

                </div>
                <div id='div_s'> </div>
                <input type="hidden" id="course_id_hidden" name="course_id_hidden" value="">
                <input type="hidden" id="user_type_hidden" name="user_type_hidden" value="">
                <div class="btn-group">

                    <button id="delete" type="submit" class="btn btn-primary" >Delete Selected</button>

                </div>
            </form>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(function () {

                state = 0;
                function update_session(course_id, user_type) {
                    $('#div_s').load('update_s.php?c=' + course_id + "&u_t=" + user_type);
                }
                function change_controls_status() {
                    //course isn't selected 

                    if (state == 0) {
                        $('#textarea').prop('disabled', true);
                        $('#textarea').val("");
                        $("#user_type").prop('disabled', true);
                        $('select[id=user_type]').val(-1);
                        update_session(-1, -1);
                        var class_name = $('#user_container').attr('class');
                        if (class_name ==<?php echo "'" . constantss_ui::$information_is_loaded_class . "'" ?>) {

                            $("#user_container").load("manage_courses.php #users");
                            $('#user_container').attr('class',<?php echo "'" . constantss_ui::$information_is_unloaded_class . "'" ?>);
                        }
                        //course is selected 
                        //user type isn't selected
                    } else if (state == 1) {
                        $('#textarea').prop('disabled', true);
                        $('#textarea').val("");
                        $("#user_type").prop('disabled', false);

                        var course_id = $('select[id=course_id]').val();

                        update_session(course_id, -1);

                        var class_name = $('#user_container').attr('class');

                        if (class_name ==<?php echo "'" . constantss_ui::$information_is_loaded_class . "'" ?>) {

                            $("#user_container").load("manage_courses.php #users");
                            $('#user_container').attr('class',<?php echo "'" . constantss_ui::$information_is_unloaded_class . "'" ?>);
                        }
                        //course is selected 
                        //user type is selected
                    } else if (state == 2) {
                        $('#textarea').prop('disabled', false);
                        $('#textarea').val("");
                        var course_id = $('select[id=course_id]').val();
                        var user_type = $('select[id=user_type]').val();

                        $('#course_id_hidden').val(course_id);
                        $('#user_type_hidden').val(user_type);
                        update_session(course_id, user_type);
                        $("#user_container").load("manage_courses.php #users");
                        $('#user_container').attr('class',<?php echo "'" . constantss_ui::$information_is_loaded_class . "'" ?>);
                    }
                }

                var course_id =<?php echo $hashed_course_id; ?>;
                var user_type =<?php echo $hashed_user_type; ?>;

                if (course_id == -1) {
                    state = 0;
                } else {
                    if (state == 0) {
                        state = 1;
                    }
                }
                if (user_type != -1) {
                    state = 2;
                }
                //alert(state);
                $('select[id=course_id]').val(course_id);
                $('select[id=user_type]').val(user_type);
                $('#course_id_hidden').val(course_id);
                $('#user_type_hidden').val(user_type);
                change_controls_status();
                $('#logout').click(function (e) {

                    $('#div_s').load("logout.php");
                    e.preventDefault();
                });

                $('#user_type').on('change', function ()
                {

                    var user_type = $('select[id=user_type]').val();
                    if (user_type == -1) {
                        state = 1;

                    } else {
                        state = 2;
                    }
                    change_controls_status();


                });
                $(document).on("change", "input[id='select_all']", function () {
                    $(".checkbox1").prop('checked', $(this).prop("checked"));
                });
                $('#course_id').on('change', function () {

                    var course_id = $('select[id=course_id]').val();

                    if (course_id == -1) {
                        state = 0;

                    } else {

                        if (state == 0) {
                            state = 1;
                        }



                    }
                    change_controls_status();
                });
            });
        </script>
    </body>
</html> 
