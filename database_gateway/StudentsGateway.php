<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
require_once 'model/student.php';

class StudentsGateway {

    private $students_table;

    function __construct() {
        $this->user_table = 'students_information';
    }

    public function select_all_students() {
        $students_rec = mysql_query("SELECT * FROM " . $this->students_table . " ORDER BY student_id ASC;");

        $students = array();
        while (($obj = mysql_fetch_object($students_rec)) != NULL) {
            $student = new student($obj->student_id, $obj->user_name, $obj->user_password, $obj->change_password);
            $students[] = $student;
        }

        return $students;
    }

    public function select_student($student_id) {
        $students_rec = mysql_query("SELECT * FROM " . $this->students_table . " where student_id = $student_id;");

        $students = array();
        while (($obj = mysql_fetch_object($students_rec)) != NULL) {
            $student = new student($obj->student_id, $obj->user_name, $obj->user_password, $obj->change_password);
            $students[] = $student;
        }

        return $students;
    }

    public function delete_student($student_id) {
        $query = "delete from " . $this->students_table . " where student_id = $student_id;";
        mysql_query($query)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
    }
    
    public function login_student ($student_id, $student_password)
    {
        if (empty($student_id) || empty($student_password))
        {
            echo "Username or Password is invalid";
            return false;
        }
        
        $student_id = stripslashes($student_id);
        $student_password = stripslashes($student_password);
        $student_id = mysql_real_escape_string($student_id);
        $student_password = mysql_real_escape_string($student_password);

        $student_password = sha1($student_password);
        
        $students_rec = mysql_query("SELECT * FROM " . $this->students_table . " where student_id = $student_id;");
        
        if (($obj = mysql_fetch_object($students_rec)) != NULL)
        {
            $student = new student($obj->student_id, $obj->user_name, $obj->user_password, $obj->change_password);
            if ($student->getUser_password() == $student_password)
            {
                echo "welcome " . $student->getUser_name();
                return true;
            }
            else
            {
                echo "Wrong password";
                return false;
            }
        }
        else
        {
            echo "No such user!";
            return false;
        }
    }

}

?>
