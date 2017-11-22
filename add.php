<?php
session_start();
require_once 'pdo.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add a profile</title>
</head>
<body>
	<h1>Add a new profile</h1>
	<form action="add.php" method="POST">
		<p>Contact information:</p>
		<p>
			<input type="text" name="first_name" placeholder="First name" required>
			<input type="text" name="last_name" placeholder="Last name" required>
			<input type="email" name="email" placeholder="Email" required>
		</p>
		<p>
			Headline:
		</p>
		<p>
			<input type="text" name="headline" placeholder="Enter your headline" required>
		</p>
		<p>
			Summary:
		</p>
		<p>
			<textarea name="summary" placeholder="Enter a brief summary" required></textarea>
		</p>
		<p>
			<input type="submit" value="Add profile">
			<input type="reset" value="Reset">
			<button href="index.php">Retour à l'index</button>
		</p>
	</form>
</body>
</html>