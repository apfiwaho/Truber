<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){

		$username = $_POST['username'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM user WHERE username=:username");
		$stmt->execute(['username'=>$username]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Username already taken';
			exit();
		}

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM user WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
		}
		else{
			$password = $password;
			$filename = $_FILES['photo']['name'];
			$now = date('Y-m-d');
			try{
				$stmt = $conn->prepare("INSERT INTO user (username, firstname, lastname, email, password, date_created) VALUES (:username, :firstname, :lastname, :email, :password, :now)");
				$stmt->execute(['username'=>$username, 'firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'password'=>$password, 'now'=>$now]);
				$_SESSION['success'] = 'User added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up user form first';
	}

	header('location: users.php');

?>