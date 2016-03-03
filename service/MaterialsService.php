<?php

//echo __DIR__ . " " . __FILE__ . " vv<br>";
include_once 'database_gateway/MaterialsGateway.php';

include_once 'model/constantss.php';
include_once 'database_gateway/ValidationException.php';

class MaterialsService {

    private $MaterialsGateway = NULL;

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

    public function __construct($course_id) {
        $this->MaterialsGateway = new MaterialsGateway($course_id);
    }

    public function get_course_id() {
        return $this->MaterialsGateway->get_course_id();
    }

    public function get_all_materials() {
        try {
            $this->openDb();
            $res = $this->MaterialsGateway->select_all_materials();
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function get_materials_of_section($section_id) {
        try {
            $this->openDb();
            $res = $this->MaterialsGateway->select_materials_by_section($section_id);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function insert_material($file_name, $section_id) {
        try {
            $this->openDb();
            $res = $this->MaterialsGateway->insert_material($file_name, $section_id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function delete_material($file_name, $section_id) {
        try {
            $this->openDb();
            $res = $this->MaterialsGateway->delete_material($file_name, $section_id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

}

?>
