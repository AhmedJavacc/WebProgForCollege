<?php

/**
 * Table data gateway.
 * 
 *  OK I'm using old MySQL driver, so kill me ...
 *  This will do for simple apps but for serious apps you should use PDO.
 */
require_once 'model/UsersGateway.php';

class UsersService {

    private $UsersGateway;

    function __construct() {
        $this->UsersGateway = new UsersGateway();
    }

    public function get_all_users() {
        
    }

    public function get_all_users_of_type() {
        
    }

    public function get_user($user_id) {
        
    }

    public function delete_user($user_id) {
        
    }

}

?>
