<?php

include_once 'function.php';
include_once 'model/constantss.php';

class UsersCoursesController {

    private $hashed_course_id;
    private $hashed_user_type;
    private $user_table;

    public function __construct() {
        $this->user_table = 'users_information';
    }

    private function openDb() {
        if (!mysql_connect(constantss::$host, constantss::$user, constantss::$password)) {
            throw new Exception("Connection to the database server failed!");
        }
        if (!mysql_select_db(constantss::$database_name)) {
            throw new Exception("No mvc-crud database found on database server.");
        }
        mysql_set_charset('utf8');
    }

    private function closeDb() {
        mysql_close();
    }

    public function set_id($hashed_course_id) {
        $this->hashed_course_id = $hashed_course_id;
    }

    public function set_user_type($hashed_user_type) {
        $this->hashed_user_type = $hashed_user_type;
    }

    public function list_users_enrolled_in() {
        if ($this->hashed_course_id == -1 || $this->hashed_user_type == -1) {
            return;
        }
        $unhashed_course_id = un_hash_val($this->hashed_course_id);
        $unhashed_user_type = un_hash_val($this->hashed_user_type);

        $this->openDb();

        $query = mysql_query("SELECT user_id,user_name FROM users_information WHERE user_id in (select user_id from users_courses where course_id=$unhashed_course_id) and user_type=$unhashed_user_type;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        while ($user = mysql_fetch_array($query)) {
            $user_id = $user['user_id'];
            $user_name = $user['user_name'];
            if ($unhashed_user_type === constantss::$user_type_student) {
                echo "<div class=\"checkbox\"><br> <label><input class =\"checkbox1\"type=\"checkbox\" name=\"user_id[]\" value=$user_id><p>$user_id - $user_name</p></label><br></div>";
            } else {
                echo "<div class=\"checkbox\"><br> <label><input class =\"checkbox1\"type=\"checkbox\" name=\"user_id[]\" value=$user_id><p>$user_name</p></label><br></div>";
            }
        }
        if (mysql_num_rows($query) >= 1) {
            echo "<div class=\"checkbox\"><br> <label><input type=\"checkbox\" name=\"select_all\" id=\"select_all\" ><p>Select All</p></label><br></div>";
        } else {
            echo "<div class=\"checkbox\"><br> <label><input type=\"checkbox\" name=\"select_all\" id=\"select_all\" disabled><p>Select All</p></label><br></div>";
        }

        $this->closeDb();
    }

    public function enroll_user($arr) {
        if ($this->hashed_course_id == -1 || $this->hashed_user_type == -1) {
            return;
        }
        //echo $this->hashed_user_type;
        $unhashed_course_id = un_hash_val($this->hashed_course_id);
        $unhashed_user_type = un_hash_val($this->hashed_user_type);

        $this->openDb();
        $arr_count = count($arr);
        if ($arr[0] != "") {

            $query = mysql_query("select * from users_information where user_id='$arr[0]' and user_type=$unhashed_user_type;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
            //echo "select * from users_information where user_id=$arr[0] and user_type=$unhashed_user_type;";
            if (mysql_num_rows($query) == 1) {
                mysql_query("insert into users_courses(user_id,course_id)values('$arr[0]',$unhashed_course_id);")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
            }
        }
//mysql_query("insert into users_courses(user_id,course_id)values($arr[0],$unhashed_course_id);")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        for ($i = 1; $i < $arr_count; $i++) {
            if ($arr[$i] != "") {

                $query = mysql_query("select * from users_information where user_id='$arr[$i]' and user_type=$unhashed_user_type;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
                // echo "select * from users_information where user_id=$arr[$i] and user_type=$unhashed_user_type;";
                if (mysql_num_rows($query) == 1) {
                    mysql_query("insert into users_courses(user_id,course_id)values('$arr[$i]',$unhashed_course_id);")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
                }
            }
        }
//       or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        $this->closeDb();
    }

    public function remove_user($arr) {
        if ($this->hashed_course_id == -1) {
            return;
        }

        $unhashed_course_id = un_hash_val($this->hashed_course_id);


        $this->openDb();
        $arr_count = count($arr);
        for ($i = 0; $i < $arr_count; $i++) {
            //echo "delete from users_courses where user_id=$arr[$i] and course_id=$unhashed_course_id;" . "<br>";
            mysql_query("delete from users_courses where user_id='$arr[$i]' and course_id=$unhashed_course_id;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
        }

        $this->closeDb();
    }

    public function list_user_types() {

        $student_user_type_hashed = hash_val(constantss::$user_type_student);
        $insturctor_user_type_hashed = hash_val(constantss::$user_type_instructor);
//        if ($this->hashed_user_type == -1) {
//            echo "<option value= -1  selected>" . "" . "</option>";
//        } else {
        echo "<option value= -1 >" . "" . "</option>";
//        }
//        if ($this->hashed_user_type == $student_user_type_hashed) {
//            echo "<option value= $student_user_type_hashed  selected >" . "Student" . "</option>";
//        } else {
        echo "<option value= $student_user_type_hashed  >" . "Student" . "</option>";
//        }
//        if ($this->hashed_user_type == $insturctor_user_type_hashed) {
//            echo "<option value= $insturctor_user_type_hashed  selected>" . "Instructor" . "</option>";
//        } else {
        echo "<option value= $insturctor_user_type_hashed  >" . "Instructor" . "</option>";
//        }
    }

    public function select_user($user_id, $user_password) {
        $this->openDb();
        $user_rec = mysql_query("SELECT * FROM " . $this->user_table . " where user_id = '$user_id' and user_password=md5('$user_password');")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
        if (mysql_num_rows($user_rec) == 1) {
            $user = mysql_fetch_object($user_rec);
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['user_name'] = $user->user_name;
            $_SESSION['current_user_type'] = hash_val($user->user_type);
            $_SESSION['change_password'] = $user->change_password;
            $_SESSION['change_old_password'] = -1;
            echo $_SESSION['current_user_type'];
            return 1;
        } else {
            return 0;
        }
        $this->closeDb();
    }

    public function change_user_password($user_id, $user_new_password) {
        $this->openDb();
        mysql_query("update " . $this->user_table . " set user_password = md5('$user_new_password'),change_password=1 where user_id = '$user_id';");
        if ($_SESSION['change_password'] == 0) {
            $_SESSION['change_password'] = 1;
        }

        $this->closeDb();
    }

    public function check_old_password($user_id, $user_new_password) {
        $this->openDb();

        $user_rec = mysql_query("SELECT * FROM " . $this->user_table . " where user_id = '$user_id' and user_password=md5('$user_new_password');")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        if (mysql_num_rows($user_rec) == 1) {
            $_SESSION['change_old_password'] = 0;
        } else {
            $_SESSION['change_old_password'] = 1;
        }
        $this->closeDb();
    }

}

?>