<?php

class section {

    private $section_id;
    private $section_name;
    private $folder_name;
    private $button_name;
    private $button_id;

    public function __construct($section_id, $section_name, $folder_name, $button_name, $button_id) {
        $this->section_id = $section_id;
        $this->section_name = $section_name;
        $this->folder_name = $folder_name;
        $this->button_name = $button_name;
        $this->button_id = $button_id;
    }

    public function get_section_id() {
        return $this->section_id;
    }

    public function get_section_name() {
        return $this->section_name;
    }

    public function get_folder_name() {
        return $this->folder_name;
    }

    public function get_button_name() {
        return $this->button_name;
    }

    public function get_button_id() {
        return $this->button_id;
    }

}
?>

