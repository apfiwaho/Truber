<?php
	include 'includes/session.php';
	$conn = $pdo->open();

	if(isset($_POST['login'])){
		
		$email = $_POST['email'];
		$password = $_POST['password'];

		try{

			
			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM customer WHERE email=:email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
			if($row['numrows'] > 0){
					if($password == $row['password'])
					{
							$_SESSION['user'] = $row['id'];
					}
					else{
						$_SESSION['error'] = 'Incorrect Password';
					}
			}
			else
			{

				$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows1 FROM administrator WHERE email = :email");
				$stmt->execute(['email'=>$email]);
				$row = $stmt->fetch();

				if($row['numrows1'] > 0){
					if($password == $row['password']){
							$_SESSION['admin'] = $row['id'];
					}
					else{
						$_SESSION['error'] = 'Incorrect Password';
					}
				}
				else
				{
					$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows2 FROM driver WHERE email = :email");
					$stmt->execute(['email'=>$email]);
					$row = $stmt->fetch();

					if($row['numrows2'] > 0){
						if($password == $row['password']){
								$_SESSION['driver'] = $row['id'];
						}
						else{
							$_SESSION['error'] = 'Incorrect Password';
						}
					}
					else
					{
						$_SESSION['error'] = 'Email not found';
					}

				}

			}
			

			
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

	}
	else{
		$_SESSION['error'] = 'Input login credentails first';
	}

	$pdo->close();

	header('location: login.php');

?>