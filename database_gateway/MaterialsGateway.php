<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
require_once 'model/material.php';
require_once 'database_gateway/SectionsGateway.php';
require_once 'model/constantss.php';

class MaterialsGateway {

    private $material_table;
    private $course_id;
    private $section_gateway;

    function __construct($course_id) {
        $this->material_table = 'materials';
        $this->section_gateway = new SectionsGateway();
        $this->course_id = $course_id;
    }

    private function get_material_table_name() {
        return 'course_' . $this->course_id . '_' . $this->material_table;
    }

    public function get_course_id() {
        return $this->course_id;
    }

    public function select_all_materials() {
        $materials_rec = mysql_query("SELECT * FROM " . $this->get_material_table_name() . " ORDER BY Add_Date ASC;");

        $materials = array();
        while (($obj = mysql_fetch_object($materials_rec)) != NULL) {
            $section = $this->section_gateway->select_section($obj->section_id)[0];
            $material = new material($this->course_id, $section, $obj->file_name, $obj->add_date);
            $materials[] = $material;
        }

        return $materials;
    }

    public function select_materials_by_section($section) {

        $query = "SELECT * FROM " . $this->get_material_table_name() . " where section_id=$section ORDER BY Add_Date ASC;";


        $materials_rec = mysql_query($query);

        $materials = array();
        while (($obj = mysql_fetch_object($materials_rec)) != NULL) {
            $section = $this->section_gateway->select_section($obj->section_id)[0];
            $material = new material($this->course_id, $section, $obj->file_name, $obj->add_date);
            $materials[] = $material;
        }

        return $materials;
    }

    public function select_material($file_name, $section_id) {

        $materials_rec = mysql_query("SELECT * FROM " . $this->get_material_table_name() . " where section_id =$section_id and file_name='$file_name';");

        $materials = array();
        while (($obj = mysql_fetch_object($materials_rec)) != NULL) {
            $section = $this->section_gateway->select_section($obj->section_id)[0];
            $material = new material($this->course_id, $section, $obj->file_name, $obj->add_date);

            $materials[] = $material;
        }

        return $materials;
    }

    public function insert_material($file_name, $section_id) {
        mysql_query("INSERT INTO " . $this->get_material_table_name() . " (`section_id`, `file_name`) VALUES ('$section_id', '$file_name');")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
    }

    public function delete_material($file_name, $section_id) {

        $query = "delete from " . $this->get_material_table_name() . " where section_id ='$section_id' and file_name='$file_name' ;";

        mysql_query($query)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
        $this->deleteFile($file_name, $section_id);
    }

    private function deleteFile($file_name, $section_id) {
        $section = $this->section_gateway->select_section($section_id)[0];
        unlink(constantss::$parent_directory . $this->course_id . '/' . $section->get_folder_name() . '/' . $file_name);
    }

}

?>
