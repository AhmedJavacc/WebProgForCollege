<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
include_once 'model/user.php';

class UsersGateway {

    private $user_table;

    function __construct() {
        $this->user_table = 'users_information';
    }

    public function select_all_users_of_type($user_type, $course_id) {
        $students_rec = mysql_query("SELECT * FROM " . $this->user_table . " where user_type=$user_type and user_id in (select user_id from users_courses and course_id=$course_id) ORDER BY student_id ASC;");

        $students = array();
        while (($obj = mysql_fetch_object($students_rec)) != NULL) {
            $student = new student($obj->student_id, $obj->user_name, $obj->user_password, $obj->change_password);
            $students[] = $student;
        }

        return $students;
    }

    public function select_user($user_id, $user_password) {
        $user_rec = mysql_query("SELECT * FROM " . $this->user_table . " where user_id = '$user_id' and user_password=md5('$user_password') ;");

        if (mysql_num_rows($user_rec) == 1) {
            $_SESSION['user_id'] = $user_rec->user_id;
            $_SESSION['user_name'] = $user_rec->user_name;
            $_SESSION['user_type'] = $user_rec->user_type;
            $_SESSION['change_password'] = $user_rec->change_password;
        }
    }

    public function change_user_password($user_id, $user_new_password) {
        mysql_query("update " . $this->user_table . " set user_password = md5('$user_id'),change_password=1 where user_id = '$user_id';");
        $_SESSION['change_password'] = 1;
    }

}

?>
