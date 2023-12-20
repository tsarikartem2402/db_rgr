<?php

function sanitize_input($input) {
    return filter_var($input, FILTER_SANITIZE_STRING);
}


function validate_username($username) {

    return preg_match('/^[a-zA-Z0-9_]+$/', $username);
}


function validate_password($password) {
    return strlen($password) >= 8;

}
function validate_birthdate($birthdate) {
    return !empty($birthdate);
}
?>
