<?php
//echo __DIR__." ".__FILE__." vv<br>";
include_once 'database_gateway/CoursesGateway.php';
include_once 'model/constantss.php';
include_once 'database_gateway/ValidationException.php';

class CoursesService {

    private $CoursesGateway = NULL;

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

    public function __construct() {
        $this->CoursesGateway = new CoursesGateway();
    }

    public function get_all_courses() {
        try {
            $this->openDb();
            $res = $this->CoursesGateway->select_all_courses();
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function get_course($course_id) {
        try {
            $this->openDb();
            $res = $this->CoursesGateway->select_course($course_id);
            $this->closeDb();
            return $res[0];
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function insert_material($course_name, $course_description) {
        try {
            $this->openDb();
            $this->CoursesGateway->insert_course($course_name, $course_description);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function delete_material($course_id) {
        try {
            $this->openDb();
            $this->CoursesGateway->delete_course($course_id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function get_all_courses_related_to_user($user_id) {
        try {
            $this->openDb();
            $res = $this->CoursesGateway->select_all_courses_related_to_user($user_id);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

}

?>
