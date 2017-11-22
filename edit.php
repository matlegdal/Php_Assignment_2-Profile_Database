<?php
session_start();
require_once 'modules/pdo.php';
require_once 'modules/util.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

// POST CONTROLLER
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	$message = validate_profile();
	if (is_string($message)) {
		$_SESSION['error'] = $message;
		header("Location: edit.php?profile_id=".$_POST['profile_id']);
		return;
	}

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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit a profile</title>
	<?php require 'partials/headers.php'; ?>
</head>
<body>
	<?php require 'partials/navbar.php'; ?>
	<div class="container">
		<h1>Edit a profile - <?= htmlentities($profile['first_name']).' '.htmlentities($profile['last_name']) ?></h1>
		<?=flash()?>
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