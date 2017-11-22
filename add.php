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
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="first_name">First name</label>
					<input class="form-control" type="text" name="first_name" placeholder="Enter your first name" >
				</div>
				<div class="form-group col-md-6">
					<label for="last_name">Last name</label>
					<input class="form-control" type="text" name="last_name" placeholder="Enter your last name" >
				</div>
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input class="form-control" type="email" name="email" placeholder="Enter your email" >
			</div>
			<div class="form-group">
				<label for="headline">Headline</label>
				<input class="form-control" type="text" name="headline" placeholder="Enter your headline" >
			</div>
			<div class="form-group">
				<label for="summary">Summary</label>
				<textarea class="form-control" name="summary" placeholder="Enter a brief summary" ></textarea>
			</div>
			<button class="btn btn-primary" type="submit">Add profile</button>
			<button class="btn btn-secondary" type="reset">Reset</button>
		</form>

		<a href="index.php"><button class="btn btn-secondary" style="margin-top: 1em; margin-bottom: 1em">Return home</button></a>
		<div><h4>Position: </h4><button id="add_pos" class="btn btn-success btn-sm">+</button></div>
		<div id="position_fields"></div>
		
	</div>

	<script type="text/javascript" src="main.js"></script>
</body>
</html>





