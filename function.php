<?php

function hash_val($id) {
    return ($id + 910) * 3;
}

function un_hash_val($id) {
    return (($id) / 3) - 910;
}

function validate_session_time_out() {
    $inactive = 300;
    if (isset($_SESSION['user_id'])) {
        if (isset($_SESSION['testing']) && (time() - $_SESSION['testing'] > $inactive)) {
            // last request was more than 2 hours ago
            session_unset();     // unset $_SESSION variable for this page
            session_destroy();   // destroy session data

            return 0;
        } else {
            $_SESSION['testing'] = time(); // Update session 
            return 1;
        }
    } else {

        return 0;
    }
}
?>

