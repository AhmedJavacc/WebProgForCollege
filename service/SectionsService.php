<?php

include_once 'database_gateway/SectionsGateway.php';
include_once 'model/constantss.php';
include_once 'database_gateway/ValidationException.php';

class SectionsService {

    private $SectionsGateway = NULL;

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
        $this->SectionsGateway = new SectionsGateway();
    }

    public function get_all_sections() {
        try {
            $this->openDb();
            $res = $this->SectionsGateway->select_all_sections();
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }
    public function get_section($section_id) {
        try {
            $this->openDb();
            $res = $this->SectionsGateway->select_section($section_id);
            $this->closeDb();
            return $res[0];
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

}

?>
