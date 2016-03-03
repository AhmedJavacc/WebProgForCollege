<?php
include_once 'service/UsersCoursesController.php';
include_once 'model/constantss.php';
include_once 'function.php';
session_start();

if (validate_session_time_out() == 1) {
    if ($_SESSION['change_password'] == 0) {
        header("Location:change_password.php");
    } else {
        if (un_hash_val($_SESSION['current_user_type']) == constantss::$user_type_admin) {
            header("Location:manage_courses.php");
            exit();
        }
        header("Location:main_page.php");
    }
    exit();
}
if (isset($_POST['user_id']) && isset($_POST['user_password'])) {
    $user_id = $_POST['user_id'];
    $user_password = $_POST['user_password'];
    $UsersCoursesController = new UsersCoursesController();
    
    if ($UsersCoursesController->select_user($user_id, $user_password) == 1) {
        
        $_SESSION['testing'] = time();
        echo "ssss";
        if ($_SESSION['change_password'] == 0) {
            header("Location:change_password.php");
        } else {
            header("Location:main_page.php");
        }
        $_SESSION['wrong_password'] = 0;

        exit();
    } else {
        $_SESSION['wrong_password'] = 1;
    }
} else {
    $_SESSION['wrong_password'] = 0;
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>instructor</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
    </head>
    <body >
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <h1 class="text-center login-title">Sign in</h1>
                    <div class="account-wall">

                        <form class="form-signin" action="login.php" method="post">
                            <input name = "user_id" id="user_id" type="text" class="form-control" placeholder="ID" required autofocus>
                            <input name="user_password" id="user_password" type="password" class="form-control" placeholder="Password" required>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">
                                Sign in</button>

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
<?php
if ($_SESSION['wrong_password'] == 1) {
    echo "alert('Wrong Password');";
}
?>

            });
        </script>
    </body>

</html>