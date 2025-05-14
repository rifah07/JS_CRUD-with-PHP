<?php
session_start();
require_once "pdo.php";
require_once "util.php";
?>
<html>
<head>
<title><?php echo htmlentities($_SESSION['name'] ?? 'Resume Database'); ?></title>
</head>
<body>
<h1>Resume Registry</h1>
<?php
flashMessages();
if (isset($_SESSION['name'])) {
    echo '<p><a href="logout.php">Logout</a></p>';
} else {
    echo '<p><a href="login.php">Please log in</a></p>';
}

$stmt = $pdo->query("SELECT profile_id, first_name, last_name FROM Profile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($rows) {
    echo("<table border=\"1\">\n");
    foreach ($rows as $row) {
        echo("<tr><td>");
        echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.htmlentities($row['first_name'])." ".htmlentities($row['last_name'])."</a>");
        if (isset($_SESSION['user_id'])) {
            echo("</td><td>");
            echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
            echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        }
        echo("</td></tr>\n");
    }
    echo("</table>\n");
}
if (isset($_SESSION['user_id'])) {
    echo('<p><a href="add.php">Add New Entry</a></p>');
}
?>
</body>
</html>