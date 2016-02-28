<?php

class student {

    private $student_id;
    private $user_name;
    private $user_password;
    private $change_password;

    public function __construct($student_id, $user_name, $user_password, $change_password) {
        $this->student_id = $student_id;
        $this->user_name = $user_name;
        $this->user_password = $user_password;
        $this->change_password = $change_password;
    }

    public function getStudent_id() {
        return $this->student_id;
    }

    public function getUser_name() {
        return $this->user_name;
    }

    public function getUser_password() {
        return $this->user_password;
    }

    public function getChange_password() {
        return $this->change_password;
    }
}
?>

