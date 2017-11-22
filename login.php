<?php
session_start();
require_once 'modules/pdo.php';
require_once 'modules/util.php';

if (isset($_SESSION['user_id'])) {
	$_SESSION['success'] = 'You are already logged in.';
	header('Location: index.php');
	return;
}

if (isset($_POST['email']) && isset($_POST['password'])) {
	$salt = 'XyZzy12*_';
	$check = hash('md5', $salt.$_POST['password']);
	$query = $pdo->prepare("SELECT user_id, name FROM users WHERE email = :email AND password = :password");
	$query->execute(array(':email' => $_POST['email'], ':password' => $check));
	$user = $query->fetch(PDO::FETCH_ASSOC);

	if ($user !== false) {
		$_SESSION['name'] = $user['name'];
		$_SESSION['user_id'] = $user['user_id'];
		$_SESSION['success'] = "You are now logged in.";
		header('Location: index.php');
		return;
	} else {
		$_SESSION['error'] = "Your email and password are not valid.";
		header('Location: login.php');
		return;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<?php require 'headers.php'; ?>
</head>
<body>
	<div class="container">
		<h1>Login</h1>
		<?=flash()?>

		<form action="login.php" method="POST">
			<input type="email" name="email" id="email" placeholder="Enter your email" required>
			<input type="password" name="password" id="password" placeholder="Type your password" required>
			<input type="submit" value="Login" onclick="return doValidate();">
			<input type="reset" value="Cancel">
		</form>
		<div><a href="index.php">Retour</a></div>
	</div>

	<script type="text/javascript" src="validate_login.js"></script>
</body>
</html>