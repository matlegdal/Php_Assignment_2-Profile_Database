<?php
session_start();
require_once 'pdo.php';

if (isset($_SESSION['user'])) {
	$_SESSION['success'] = 'You are already logged in.';
	header('Location: index.php');
	return;
}

require 'flash.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<?= $flash ?>

	<form action="login.php" method="POST">
		<input type="email" name="email" id="email" placeholder="Enter your email" required>
		<input type="password" name="password" id="password" placeholder="Type your password" required>
		<input type="submit" value="Login" onclick="return doValidate();">
		<input type="submit" name="cancel" value="Cancel">
	</form>
	<div><a href="index.php">Retour</a></div>

	<script type="text/javascript" src="doValidate.js"></script>
</body>
</html>