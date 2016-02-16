<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
require_once 'model/user.php';

class UsersGateway {

    private $user_table;

    function __construct() {
        $this->user_table = 'users_information';
    }

    public function select_all_users() {
        
    }

    public function select_all_users_of_type() {
        
    }

    public function select_user($user_id) {
        
    }

    public function delete_user($user_id) {
        
    }

}

?>
