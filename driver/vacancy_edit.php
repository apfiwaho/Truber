<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){

        $id = $_POST['id'];

        $title = $_POST['title'];
        $company = $admin['companyName'];
        $emdID = $admin['id'];
        $description = $_POST['description'];
        $requirements = $_POST['requirements'];
		
		
		$conn = $pdo->open();

			$now = date('Y-m-d');
			try{
                $stmt = $conn->prepare("UPDATE vacancy SET title=:title, description=:description, requirements=:requirements WHERE vacancyID=:id");
                $stmt->execute(['title'=>$title, 'description'=>$description, 'requirements'=>$requirements, 'id'=>$id]);

				$_SESSION['success'] = 'Vacancy updated successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up vacancy form first';
	}

	header('location:vacancies.php');

?>