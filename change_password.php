<?php
include_once 'function.php';
include_once 'service/UsersCoursesController.php';
session_start();
if (validate_session_time_out() == 0) {

    header("Location:login.php");
    exit();
}

if (isset($_POST['user_new_password'])) {
    $user_new_password = $_POST['user_new_password'];

    $UsersCoursesController = new UsersCoursesController();
    $UsersCoursesController->check_old_password($_SESSION['user_id'], $user_new_password);
    if ($_SESSION['change_old_password'] == 1) {
        $UsersCoursesController->change_user_password($_SESSION['user_id'], $user_new_password);
    }
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
    </head>
    <body >
        <?php include('header.php') ?>
        <br>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="account-wall">

                        <form class="form-signin" action="change_password.php" method="post">
                            <input name="user_new_password" id="user_new_password" type="password" class="form-control" placeholder="New password" required>
                            <input name="confirm_user_new_password" id="confirm_user_new_password" type="password" class="form-control" placeholder="Confirm new password" required>
                            <div id="divCheckPasswordMatch"><?php
                                if ($_SESSION['change_old_password'] == -1) {
                                    echo "Change your password";
                                } else if ($_SESSION['change_old_password'] == 0) {
                                    echo "The new password is exactly the same as the old one";
                                } else if ($_SESSION['change_old_password'] == 1) {
                                    echo "Password is changed successfully";
                                }
                                ?>
                            </div>
                            <button id="btn_submit" class="btn btn-lg btn-primary btn-block" type="submit" disabled="true">
                                Update Password</button>

                            <div class="alert alert-info">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong>Important!</strong> Contact Dr.Yousri Taha in case of any problems.
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script src="js/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        <script>
            $(function () {
                function checkPasswordMatch() {
                    var password = $("#user_new_password").val();
                    var confirmPassword = $("#confirm_user_new_password").val();

                    if (password != confirmPassword) {
                        $("#divCheckPasswordMatch").html("Passwords do not match!");
                        $('#btn_submit').prop('disabled', true);
                    } else {

                        $("#divCheckPasswordMatch").html("Passwords match.");
                        $('#btn_submit').prop('disabled', false);
                    }
                }
                $("#confirm_user_new_password").keyup(checkPasswordMatch);

            });
        </script>
    </body>

</html>