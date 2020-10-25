<?php
	include '../includes/conn.php';
	session_start();

	if(!isset($_SESSION['driver']) || trim($_SESSION['driver']) == ''){
		header('location: ../index.php');
		exit();
	}

	$conn = $pdo->open();

	$stmt = $conn->prepare("SELECT * FROM driver WHERE id=:id");
	$stmt->execute(['id'=>$_SESSION['driver']]);
	$admin = $stmt->fetch();

	$pdo->close();

?>