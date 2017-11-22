<?php
session_start();
require_once 'modules/pdo.php';
require_once 'modules/util.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$message = validate_profile();
	if (is_string($message)) {
		$_SESSION['error'] = $message;
		header("Location: add.php");
		return;
	}

	$query = $pdo->prepare("INSERT INTO profiles (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)");
	$query->execute(array(
		':user_id' => $_SESSION['user_id'],
		':first_name' => $_POST['first_name'],
		':last_name' => $_POST['last_name'],
		':email' => $_POST['email'],
		':headline' => $_POST['headline'],
		':summary' => $_POST['summary']
	));

	$_SESSION['success'] = 'Profile added';
	header('Location: index.php');
	return;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add a profile</title>
	<?php require 'headers.php'; ?>
</head>
<body>
	<div class="container">
		<h1>Add a new profile</h1>
		<?=flash()?>
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
	</div>
</body>
</html>