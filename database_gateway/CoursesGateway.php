<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
require_once 'model/course.php';

class CoursesGateway {

    private $course_table;

    function __construct() {
        $this->course_table = 'courses_information';
    }

    public function select_all_courses() {
        $courses_rec = mysql_query("SELECT * FROM " . $this->course_table . "  ORDER BY course_id;");

        $courses = array();
        while (($obj = mysql_fetch_object($courses_rec)) != NULL) {
            $course = new course($obj->course_id, $obj->course_name, $obj->course_description);
            $courses[] = $course;
        }

        return $courses;
    }

    public function select_course($course_id) {
        $courses_rec = mysql_query("SELECT * FROM " . $this->course_table . " where course_id = $course_id  ;");

        $courses = array();
        while (($obj = mysql_fetch_object($courses_rec)) != NULL) {
            $course = new course($obj->course_id, $obj->course_name, $obj->course_description);
            $courses[] = $course;
        }

        return $courses;
    }

    public function insert_course($course_name, $course_description) {
        mysql_query("INSERT INTO " . $this->course_table . " (`course_name`, `course_description`) VALUES ('$course_name', '$course_description');")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
    }

    public function delete_course($course_id) {

        $query = "delete from " . $this->course_table . " where course_id ='$course_id' ;";

        mysql_query($query)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
    }


}

?>
