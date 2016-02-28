<?php

require_once 'database_gateway/StudentsGateway.php';
require_once 'database_gateway/ValidationException.php';

class StudentsService {

    private $StudentsGateway = NULL;

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
        $this->StudentsGateway = new StudentsGateway();
    }

    public function get_all_students() {
        try {
            $this->openDb();
            $res = $this->StudentsGateway->select_all_students();
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function get_student($student_id) {
        try {
            $this->openDb();
            $res = $this->StudentsGateway->select_student($student_id);
            $this->closeDb();
            return $res[0];
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function delete_student($student_id) {
        try {
            $this->openDb();
            $res = $this->StudentsGateway->delete_student($student_id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function login($student_id, $student_password) {
        try {
            $this->openDb();
            $res = $this->StudentsGateway->login_student($student_id, $student_password);
            if (res) {
                echo "Login success";
            } else {
                echo "Login falied";
            }
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

}

?>
