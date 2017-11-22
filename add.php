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
	
	// VALIDATION
	$message = validate_profile();
	if (is_string($message)) {
		$_SESSION['error'] = $message;
		header("Location: add.php");
		return;
	}

	$message = validate_pos();
	if (is_string($message)) {
		$_SESSION['error'] = $message;
		header("Location: add.php");
		return;
	}

	// INSERT PROFILE
	$query = $pdo->prepare("INSERT INTO profiles (user_id, first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline, :summary)");
	$query->execute(array(
		':user_id' => $_SESSION['user_id'],
		':first_name' => $_POST['first_name'],
		':last_name' => $_POST['last_name'],
		':email' => $_POST['email'],
		':headline' => $_POST['headline'],
		':summary' => $_POST['summary']
	));

	// INSERT POSITION
	$profile_id = $pdo->lastInsertId();
	$rank = 1;
	for ($i=1; $i < 11; $i++) { 
		if (!isset($_POST['year'.$i])) continue;
		if (!isset($_POST['desc'.$i])) continue;
		$query = $pdo->prepare("INSERT INTO positions (profile_id, rank, year, description) VALUES(:profile_id, :rank, :year, :description)");
		$query->execute(array(
			':profile_id' => $profile_id,
			':rank' => $rank,
			'year' => $_POST['year'.$i],
			':description' => $_POST['desc'.$i]
		));
		$rank++;
	}

	// UPON SUCCESS REDIRECT
	$_SESSION['success'] = 'Profile added';
	header('Location: index.php');
	return;
}

$_SESSION['countPos'] = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add a profile</title>
	<?php require 'partials/headers.php'; ?>
</head>
<body>
	<?php require 'partials/navbar.php'; ?>
	
	<div class="container">
		<?=flash()?>
		<div class="card" style="margin-top: 1em">
			<h1 class="card-header">Add a new profile</h1>
			<div class="card-body">
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
					<div class="container-fluid" style="margin-top: 1em; margin-bottom: 1em">
						<h4>Positions:</h4>
						<div id="position_fields"></div>
						<div><button id="add_pos" class="btn btn-success btn-sm" style="margin-top: 1em; margin-bottom: 1em">+</button></div>
					</div>
					<button class="btn btn-primary" type="submit">Add profile</button>
					<a class="btn btn-secondary" href="add.php">Reset</a>
				</form>
			</div>
		</div>
		<a href="index.php"><button class="btn btn-secondary" style="margin-top: 1em; margin-bottom: 1em">Return home</button></a>
		
	</div>
</body>
</html>





