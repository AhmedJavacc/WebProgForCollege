<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
include_once 'model/section.php';
class SectionsGateway {

    private $sections_table;

    function __construct() {

        $this->sections_table = 'sections';
    }

    public function select_section($section_id) {
        $dbsection_id = mysql_real_escape_string($section_id);
        $sections_rec = mysql_query("SELECT * FROM " . $this->sections_table . " where section_id=$dbsection_id;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        $sections = array();
        while (($obj = mysql_fetch_object($sections_rec)) != NULL) {
            // echo "sss"."<br>";
            $section = new section($obj->section_id, $obj->section_name, $obj->folder_name, $obj->button_name, $obj->button_id);
            $sections[] = $section;
        }

        return $sections;
    }

    public function select_all_sections() {

        $sections_rec = mysql_query("SELECT * FROM " . $this->sections_table . " ORDER BY Section_Id ASC;")or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');

        $sections = array();
        while (($obj = mysql_fetch_object($sections_rec)) != NULL) {
            // echo "sss"."<br>";
            $section = new section($obj->section_id, $obj->section_name, $obj->folder_name, $obj->button_name, $obj->button_id);
            $sections[] = $section;
        }

        return $sections;
    }

    public function delete_section($section_id) {
        $query = "delete from " . $this->sections_table . " where section_id =$section_id ;";
        mysql_query($query)or die('<span class="error_span"><u>MySQL error:</u> ' . htmlspecialchars(mysql_error()) . '</span>');
    }

}

?>
