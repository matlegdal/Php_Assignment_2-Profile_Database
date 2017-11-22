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
<?php 
	if (!isset($_SESSION['user'])) {
		echo '<a href="login.php">Please login</a>';
	}

	if ($profiles->fetch(PDO::FETCH_ASSOC) === false) {
		echo "<p>No profile found.</p>";
	} else {
		require 'table_profiles.php';
	}
 ?>

</body>
</html>
