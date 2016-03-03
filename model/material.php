<?php

include_once 'model/section.php';
include_once 'model/constantss.php';

class material {

    private $course_id;
    private $section;
    private $file_name;
    private $add_date;

    public function __construct($course_id, $section, $file_name, $add_date) {
        $this->section = $section;
        $this->file_name = $file_name;
        $this->course_id = $course_id;
        $this->add_date = $add_date;
    }

    public function get_section_id() {
        return $this->section->get_section_id();
    }

    public function get_file_name() {
        return $this->file_name;
    }

    public function get_add_date() {
        return $this->add_date;
    }

    public function get_full_path_file() {
        $section=$this->section;
        return constantss::$parent_directory . $this->course_id.'/' . $section->get_folder_name() . '/' . $this->file_name;
    }

}
?>

