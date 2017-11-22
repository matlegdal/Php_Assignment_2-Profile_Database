<?php
session_start();
require_once 'pdo.php';

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
	<title>Show a Profile - <?= htmlentities($profile['first_name']).' '.htmlentities($profile['last_name']) ?></title>
	<?php require 'headers.php'; ?>
</head>
<body>
	<div class="container">
		<h1>Profile - <?= htmlentities($profile['first_name']).' '.htmlentities($profile['last_name']) ?></h1>
		<p>First name: <?= htmlentities($profile['first_name'])?></p>
		<p>Last name: <?= htmlentities($profile['last_name'])?></p>
		<p>Email: <?= htmlentities($profile['email'])?></p>
		<p>Headline: <?= htmlentities($profile['headline'])?></p>
		<p>Summary: <?= htmlentities($profile['summary'])?></p>
		<p><a href="index.php">Done</a></p>
	</div>
</body>
</html>