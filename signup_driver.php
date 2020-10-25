<?php

	include 'includes/session.php';

	if(isset($_POST['signup'])){


	
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
		$password = $_POST['password'];
		$repassword = $_POST['current_password'];

		$_SESSION['firstname'] = $firstname;
		$_SESSION['lastname'] = $lastname;
		$_SESSION['email'] = $email;
		$_SESSION['username'] = $username;


		if($password != $repassword){
			$_SESSION['error'] = 'Passwords did not match';
			header('location: signup.php');
			exit();	
		}
		else{
			$conn = $pdo->open();

			$stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM driver WHERE email=:email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
				$_SESSION['error'] = 'Email already taken';
				header('location: register_driver.php');
				exit();	
			}
			else{
				
				$now = date('Y-m-d');
				
				try{
					
					$stmt = $conn->prepare("INSERT INTO driver (firstname, lastname, email, contact, password, date_registered) VALUES (:firstname, :lastname, :email, :contact, :password, :now)");
					$stmt->execute(['firstname'=>$firstname, 'lastname'=>$lastname, 'email'=>$email, 'contact'=>$contact, 'password'=>$password, 'now'=>$now]);
					$userid = $conn->lastInsertId();

					// $message = "
					// 	<h2>Thank you for Registering.</h2>
					// 	<p>Your Account:</p>
					// 	<p>Email: ".$email."</p>
					// 	<p>Password: ".$_POST['password']."</p>
					// 	<p>Please click the link below to proceed to the login page</p>
					// 	<a href='http://localhost/Truber/login.php>Login to your Account</a>
					// ";

					$_SESSION['success'] = 'Account created. Proceed to Login';
					header('location: register_driver.php');

					
				}
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
					header('location: register_driver.php');
				}

				$pdo->close();

			}

		
        }
    }
	else{
		$_SESSION['error'] = 'Fill up signup form first';
		header('location: register_driver.php');
    }



?>