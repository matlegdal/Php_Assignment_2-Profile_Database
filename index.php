<?php
session_start();
require_once 'pdo.php';

$profiles = $pdo->query('SELECT * FROM profiles');

require 'flash.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Assignement 2 - Profile Database</title>
</head>
<body>
<h1>Assignement 2 - Profile Database</h1>
<?= $flash ?>
<?php
	// Login
	if (!isset($_SESSION['user'])) {
		echo '<a href="login.php">Please login</a>';
	}

	// Table of profiles
	if ($profiles->fetch(PDO::FETCH_ASSOC) === false) {
		echo "<p>No profile found.</p>";
	} else {
		require 'table_profiles.php';
	}

	// Logout buttons
	if (isset($_SESSION['user'])) {
		echo '<div><a href="add.php">Add a new entry</a></div>';
		echo '<div><a href="logout.php">Logout</a></div>';
	}
 ?>

</body>
</html>
