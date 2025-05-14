<?php
session_start();
require_once "pdo.php";
require_once "util.php";

$salt = 'XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    } elseif (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    }

    $check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
}
?>
<html>
<head>
<title>Login</title>
<script>
function validateForm() {
    let email = document.forms["loginForm"]["email"].value;
    let pass = document.forms["loginForm"]["pass"].value;
    if (email == "" || pass == "") {
        alert("Both fields must be filled out");
        return false;
    }
    if (email.indexOf('@') == -1) {
        alert("Invalid email address");
        return false;
    }
    return true;
}
</script>
</head>
<body>
<h1>Please Log In</h1>
<?php
flashMessages();
?>
<form name="loginForm" method="post" onsubmit="return validateForm();">
<p>Email <input type="text" name="email"></p>
<p>Password <input type="password" name="pass"></p>
<p><input type="submit" value="Log In"></p>
</form>
</body>
</html>