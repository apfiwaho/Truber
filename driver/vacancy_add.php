<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){

        $title = $_POST['title'];
        $company = $admin['companyName'];
        $emdID = $admin['id'];
        $description = $_POST['description'];
        $requirements = $_POST['requirements'];
		
		
		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM user WHERE email=:email");
		$stmt->execute(['email'=>$email]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Email already taken';
		}
		else{
			$now = date('Y-m-d');
			try{
				$stmt = $conn->prepare("INSERT INTO vacancy (empID, title, company, description, requirements, date_posted) VALUES (:id,  :title, :company, :description, :requirements, :now)");
				$stmt->execute(['id'=>$emdID, 'title'=>$title, 'company'=>$company, 'description'=>$description, 'requirements'=>$requirements, 'now'=>$now]);
				$_SESSION['success'] = 'Vacancy added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up vacancy form first';
	}

	header('location:vacancies.php');

?>