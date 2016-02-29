<?php

function hash_val($id) {
    return ($id+910)*3;
}

function un_hash_val($id) {
    return (($id)/3)-910;
}
?>

