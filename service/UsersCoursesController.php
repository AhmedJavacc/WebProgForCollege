<?php

require_once 'function.php';
require_once 'model/constantss.php';

class UsersCoursesController {

    private $hashed_course_id;
    private $hashed_user_type;

    public function __construct() {
        
    }

    private function openDb() {
        if (!mysql_connect("localhost", "root", "")) {
            throw new Exception("Connection to the database server failed!");
        }
        if (!mysql_select_db("project")) {
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

            $query = mysql_query("select * from users_information where user_id=$arr[0] and user_type=$unhashed_user_type;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
            //echo "select * from users_information where user_id=$arr[0] and user_type=$unhashed_user_type;";
            if (mysql_num_rows($query) == 1) {
                mysql_query("insert into users_courses(user_id,course_id)values($arr[0],$unhashed_course_id);")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
            }
        }
//mysql_query("insert into users_courses(user_id,course_id)values($arr[0],$unhashed_course_id);")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        for ($i = 1; $i < $arr_count; $i++) {
            if ($arr[$i] != "") {

                $query = mysql_query("select * from users_information where user_id=$arr[$i] and user_type=$unhashed_user_type;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
                // echo "select * from users_information where user_id=$arr[$i] and user_type=$unhashed_user_type;";
                if (mysql_num_rows($query) == 1) {
                    mysql_query("insert into users_courses(user_id,course_id)values($arr[$i],$unhashed_course_id);")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
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
            mysql_query("delete from users_courses where user_id=$arr[$i] and course_id=$unhashed_course_id;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
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

}

?>