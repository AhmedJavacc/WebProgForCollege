<?php

class user {

    private $user_id;
    private $user_name;
    private $user_type;
    private $change_password;
  

    public function __construct($user_id, $user_name, $user_type, $change_password) {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->user_type = $user_type;
        $this->change_password = $change_password;
        
    }
    public function get_user_id() {
        return $this->user_id;
    }

    public function get_user_name() {
        return $this->user_name;
    }
    public function get_user_type() {
        return $this->user_type;
    }
    public function get_change_password() {
        return $this->change_password;
    }
    public function set_user_id($user_id) {
        $this->user_id=$user_id;
    }

    public function set_user_name($user_name) {
        $this->user_name=$user_name;
    }
    public function set_user_type($user_type) {
        $this->user_type=$user_type;
    }
    public function set_change_password($change_password) {
        $this->change_password=$change_password;
    }
    /* getters */
}
?>

