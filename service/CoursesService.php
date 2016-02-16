<?php

require_once 'database_gateway/CoursesGateway.php';
require_once 'database_gateway/ValidationException.php';

class CoursesService {

    private $CoursesGateway = NULL;

    private function openDb() {
        if (!mysql_connect("localhost", "root", "")) {
            throw new Exception("Connection to the database server failed!");
        }
        if (!mysql_select_db("project")) {
            throw new Exception("No mvc-crud database found on database server.");
        }
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
            $res = $this->CoursesGateway->insert_course($course_name, $course_description);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function delete_material($course_id) {
        try {
            $this->openDb();
            $res = $this->CoursesGateway->delete_course($course_id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

}

?>
