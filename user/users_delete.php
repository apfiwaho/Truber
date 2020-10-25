<?php
	include 'includes/session.php';

	
	$id = $admin['id'];

	$conn = $pdo->open();

	try
	{
			$stmt = $conn->prepare("DELETE FROM customer WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'User deleted successfully';
			header('location: ../../index.php');
	}
	catch(PDOException $e)
	{
			$_SESSION['error'] = $e->getMessage();
	}
	$pdo->close();

	session_start();
	session_destroy();
	header('location: ../index.php');
	
?>