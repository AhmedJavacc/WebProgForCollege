<?php

include_once 'database_gateway/StudentsGateway.php';
include_once 'model/constantss.php';
include_once 'database_gateway/ValidationException.php';

class UsersService {

    private $UsersGateway = NULL;

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
        $this->UsersGateway = new UsersGateway();
    }

    public function get_all_students() {
        try {
            $this->openDb();
            $res = $this->UsersGateway->select_all_students();
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
            $res = $this->UsersGateway->select_student($student_id);
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
            $res = $this->UsersGateway->delete_student($student_id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function login($student_id, $student_password) {
        try {
            $this->openDb();
            $res = $this->UsersGateway->login_student($student_id, $student_password);
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
