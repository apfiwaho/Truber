<?php
	include 'includes/conn.php';
	session_start();

	if(isset($_SESSION['admin'])){
		header('location: admin/home.php');
	}
	if(isset($_SESSION['driver'])){
		header('location: driver/home.php');
	}



	if(isset($_SESSION['user'])){
		$conn = $pdo->open();
		header('location: user/home.php');

		try{
			$stmt = $conn->prepare("SELECT * FROM customer WHERE id=:id");
			$stmt->execute(['id'=>$_SESSION['user']]);
			$user = $stmt->fetch();
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

		$pdo->close();
		header('location: user/home.php');

	}
?>