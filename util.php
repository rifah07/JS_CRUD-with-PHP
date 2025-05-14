<?php
function flashMessages() {
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red">'.htmlentities($_SESSION['error'])."</p>\n";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p style="color: green">'.htmlentities($_SESSION['success'])."</p>\n";
        unset($_SESSION['success']);
    }
}

function validateProfile() {
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 ||
        strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        return "All fields are required";
    }
    if (strpos($_POST['email'], '@') === false) {
        return "Email address must contain @";
    }
    return true;
}

?>