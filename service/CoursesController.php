<?php

require_once 'function.php';
require_once 'service/CoursesService.php';

class CoursesController {

    private $CoursesService = NULL;

    public function __construct() {
        $this->CoursesService = new CoursesService();
    }

    public function list_courses() {
        $courses = $this->CoursesService->get_all_courses();
        $courses_count = count($courses);

            echo "<option value='-1' >" . "" . "</option>";

        for ($i = 0; $i < $courses_count; $i++) {

            $hashed_course_id_local = hash_val($courses[$i]->get_course_id());

                echo "<option value= $hashed_course_id_local  >" . $courses[$i]->get_course_name() . "</option>";

        }
    }

}

?>
