<?php
session_start();
require_once 'pdo.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (strlen($_POST['first_name'])>0 && strlen($_POST['last_name'])>0 && strlen($_POST['email'])>0 && strlen($_POST['headline'])>0 && strlen($_POST['summary'])>0) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$query = $pdo->prepare("INSERT INTO profiles (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)");
			$query->execute(array(
				':user_id' => $_SESSION['user_id'],
				':first_name' => $_POST['first_name'],
				':last_name' => $_POST['last_name'],
				':email' => $_POST['email'],
				':headline' => $_POST['headline'],
				':summary' => $_POST['summary']
			));

			$_SESSION['success'] = 'Record added';
			header('Location: index.php');
			return;
		} else {
			$_SESSION['error'] = 'Please enter a valid email address.';
			header('Location: add.php');
			return;
		}
	} else {
		$_SESSION['error'] = 'All fields are required';
		header('Location: add.php');
		return;
	}
}

require 'flash.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add a profile</title>
</head>
<body>
	<h1>Add a new profile</h1>
	<?=$flash?>
	<form action="add.php" method="POST">
		<p>Contact information:</p>
		<p>
			<input type="text" name="first_name" placeholder="First name" >
			<input type="text" name="last_name" placeholder="Last name" >
			<input type="email" name="email" placeholder="Email" >
		</p>
		<p>
			Headline:
		</p>
		<p>
			<input type="text" name="headline" placeholder="Enter your headline" >
		</p>
		<p>
			Summary:
		</p>
		<p>
			<textarea name="summary" placeholder="Enter a brief summary" ></textarea>
		</p>
		<input type="submit" value="Add profile">
		<input type="reset" value="Reset">		
	</form>
	<a href="index.php">Retour à l'index</a>
</body>
</html>