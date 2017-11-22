<?php
session_start();
require_once 'pdo.php';

if (!isset($_SESSION['user_id'])) {
	$_SESSION['error'] = "Access denied. Please login first.";
	header('Location: index.php');
	return;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add a profile</title>
</head>
<body>
<h1>Add a new profile</h1>

</body>
</html>