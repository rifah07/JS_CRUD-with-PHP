<?php
session_start();
require_once "pdo.php";
require_once "util.php";

if (!isset($_SESSION['user_id'])) {
    die("ACCESS DENIED");
}

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header("Location: index.php");
    return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :id");
$stmt->execute([':id' => $_GET['profile_id']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    $_SESSION['error'] = "Bad value for profile_id";
    header("Location: index.php");
    return;
}

if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
    $msg = validateProfile();
    if (is_string($msg)) {
        $_SESSION['error'] = $msg;
        header("Location: edit.php?profile_id=" . $_GET['profile_id']);
        return;
    }

    $stmt = $pdo->prepare("UPDATE Profile SET 
        first_name = :fn, last_name = :ln, email = :em, 
        headline = :he, summary = :su 
        WHERE profile_id = :pid");
    $stmt->execute([
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'],
        ':pid' => $_GET['profile_id']
    ]);
    $_SESSION['success'] = "Profile updated";
    header("Location: index.php");
    return;
}
?>
<html>
<head><title>Edit Profile</title></head>
<body>
<h1>Editing Profile</h1>
<?php flashMessages(); ?>
<form method="post">
<p>First Name: <input type="text" name="first_name" value="<?= htmlentities($row['first_name']) ?>"></p>
<p>Last Name: <input type="text" name="last_name" value="<?= htmlentities($row['last_name']) ?>"></p>
<p>Email: <input type="text" name="email" value="<?= htmlentities($row['email']) ?>"></p>
<p>Headline:<br><input type="text" name="headline" value="<?= htmlentities($row['headline']) ?>"></p>
<p>Summary:<br><textarea name="summary" rows="8" cols="80"><?= htmlentities($row['summary']) ?></textarea></p>
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>