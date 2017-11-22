<?php
session_start();
require_once 'modules/pdo.php';
require_once 'modules/util.php';

$query = $pdo->query('SELECT profile_id, first_name, last_name, headline FROM profiles');
$profiles = $query->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Assignement 2 - Profile Database</title>
	<?php require 'headers.php'; ?>
</head>
<body>
	<div class="container">
		<h1>Assignement 2 - Profile Database</h1>
		<?=flash()?>
		<?php
			// Login
			if (!isset($_SESSION['user_id'])) {
				echo '<a href="login.php">Please login</a>';
			}

			// Table of profiles
			if (count($profiles)<1) {
				echo "<p>No profile found</p>";
			} else {
				require 'table_profiles.php';;
			}

			// Logout buttons
			if (isset($_SESSION['user_id'])) {
				echo '<div><a href="add.php">Add a new entry</a></div>';
				echo '<div><a href="logout.php">Logout</a></div>';
			}
		 ?>
	</div>
</body>
</html>
