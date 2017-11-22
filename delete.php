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
	if (strlen($_POST['profile_id']>0) && isset($_POST['delete'])) {
		$query = $pdo->prepare("DELETE FROM profiles WHERE profile_id=:profile_id");
		$query->execute(array(':profile_id' => $_POST['profile_id']));
		$_SESSION['success'] = "Profile deleted";
		header('Location: index.php');
		return;
	}
}


// GET CONTROLLER
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
	<title>Delete a profile</title>
	<?php require 'partials/headers.php'; ?>
</head>
<body>
	<?php require 'partials/navbar.php'; ?>
	<div class="container">
		<h1>Delete a profile - <?= htmlentities($profile['first_name']).' '.htmlentities($profile['last_name']) ?></h1>
		<?=flash()?>
		<div class="alert alert-warning">Are you sure you want to delete this profile?</div>
		<p>First name: <?= htmlentities($profile['first_name'])?></p>
		<p>Last name: <?= htmlentities($profile['last_name'])?></p>
		<p>Email: <?= htmlentities($profile['email'])?></p>
		<p>Headline: <?= htmlentities($profile['headline'])?></p>
		<p>Summary: <?= htmlentities($profile['summary'])?></p>

		<form action="delete.php" method="POST">
			<input type="hidden" name="profile_id" value="<?=$profile['profile_id']?>">
			<input type="submit" value="Delete profile" name="delete">
		</form>
		<p><a href="index.php">Cancel</a></p>
	</div>
</body>
</html>