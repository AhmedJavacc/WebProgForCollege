<?php

class course {

    private $course_id;
    private $course_name;
    private $course_description;

    public function __construct($course_id, $course_name, $course_description) {
        $this->course_id = $course_id;
        $this->course_name = $course_name;
        $this->course_description = $course_description;
    }

    public function get_course_id() {
        return $this->course_id;
    }

    public function get_course_name() {
        return $this->course_name;
    }

    public function get_course_description() {
        return $this->course_description;
    }

}
?>

