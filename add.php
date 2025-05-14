<?php
session_start();
require_once "pdo.php";
require_once "util.php";
if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}
if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
    $msg = validateProfile();
    if (is_string($msg)) {
        $_SESSION['error'] = $msg;
        header("Location: add.php");
        return;
    }
    $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES (:uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute([
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary']
    ]);
    $_SESSION['success'] = "Profile added";
    header("Location: index.php");
    return;
}
?>
<html>
<head><title>Add Profile</title></head>
<body>
<h1>Adding Profile</h1>
<?php flashMessages(); ?>
<form method="post">
<p>First Name: <input type="text" name="first_name"></p>
<p>Last Name: <input type="text" name="last_name"></p>
<p>Email: <input type="text" name="email"></p>
<p>Headline:<br><input type="text" name="headline"></p>
<p>Summary:<br><textarea name="summary" rows="8" cols="80"></textarea></p>
<p><input type="submit" value="Add">
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>