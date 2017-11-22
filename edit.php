<?php
session_start();
require_once 'pdo.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

// POST CONTROLLER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (strlen($_POST['first_name'])>0 && strlen($_POST['last_name'])>0 && strlen($_POST['email'])>0 && strlen($_POST['headline'])>0 && strlen($_POST['summary'])>0 && strlen($_POST['profile_id'])>0) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$query = $pdo->prepare("UPDATE profiles SET first_name=:first_name, last_name=:last_name, email=:email, headline=:headline, summary=:summary WHERE profile_id=:profile_id");
			$query->execute(array(
				':profile_id' => $_POST['profile_id'],
				':first_name' => $_POST['first_name'],
				':last_name' => $_POST['last_name'],
				':email' => $_POST['email'],
				':headline' => $_POST['headline'],
				':summary' => $_POST['summary']
			));

			$_SESSION['success'] = 'Record edited';
			header('Location: index.php');
			return;
		} else {
			$_SESSION['error'] = 'Please enter a valid email address.';
			header("Location: edit.php?profile_id=".$_POST['profile_id']);
			return;
		}
	} else {
		$_SESSION['error'] = 'All fields are required';
		header("Location: edit.php?profile_id=".$_POST['profile_id']);
		return;
	}
}

// GET CONTROLLER
if (!isset($_GET['profile_id'])) {
	$_SESSION['error'] = 'The profile you requested is not found.';
	header('Location: index.php');
	return;
}

$query = $pdo->prepare("SELECT * FROM profiles WHERE profile_id = :profile_id");
$query->execute(array(':profile_id' => $_GET['profile_id']));
$profile = $query->fetch(PDO::FETCH_ASSOC);

if ($profile === false) {
	$_SESSION['error'] = 'The profile you requested is not found.';
	header('Location: index.php');
	return;
}

// flash module
require 'flash.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit a profile</title>
	<?php require 'headers.php'; ?>
</head>
<body>
	<div class="container">
		<h1>Edit a profile - <?= htmlentities($profile['first_name']).' '.htmlentities($profile['last_name']) ?></h1>
		<?=$flash?>
		<form action="edit.php?profile_id=<?=$profile['profile_id']?>" method="POST">
			<p>Contact information:</p>
			<p>
				<input type="text" name="first_name" placeholder="First name" value="<?= htmlentities($profile['first_name'])?>">
				<input type="text" name="last_name" placeholder="Last name" value="<?= htmlentities($profile['last_name'])?>">
				<input type="email" name="email" placeholder="Email" value="<?= htmlentities($profile['email'])?>">
			</p>
			<p>
				Headline:
			</p>
			<p>
				<input type="text" name="headline" placeholder="Enter your headline" value="<?= htmlentities($profile['headline'])?>">
			</p>
			<p>
				Summary:
			</p>
			<p>
				<textarea name="summary" placeholder="Enter a brief summary" ><?= htmlentities($profile['summary'])?></textarea>
			</p>
			<input type="hidden" name="profile_id" value="<?=$profile['profile_id']?>">
			<input type="submit" value="Edit profile">
			<input type="reset" value="Reset">		
		</form>
		<a href="index.php">Retour à l'index</a>
	</div>
</body>
</html>