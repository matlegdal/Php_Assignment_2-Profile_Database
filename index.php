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
	<?php require 'partials/headers.php'; ?>
</head>
<body>
	<?php require 'partials/navbar.php'; ?>
	<div class="container">
		<h1>Assignement 2 - Profile Database</h1>
		<?=flash()?>
		<?php
			// Table of profiles
			if (count($profiles)<1) {
				echo "<p>No profile found</p>";
			} else {
				require 'partials/table_profiles.php';;
			}

			// ADD PROFILE BTN
			if (isset($_SESSION['user_id'])) {
				echo '<div><a class="btn btn-primary" href="add.php">Add a new entry</a></div>';
			}
		 ?>
	</div>
</body>
</html>
