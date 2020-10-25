<?php

include 'includes/session.php';
include 'includes/class.pdf2text.php';

$a = new PDF2Text();


$empID = $admin['id'];
$username = $admin['username'];

if(isset($_POST['submit']))
{
     //Handling file upload to directory 

     $fileName = $_FILES['file']['name'];
     $fileTmpName = $_FILES['file']['tmp_name'];
     $fileSize = $_FILES['file']['size'];
     $fileError = $_FILES['file']['error'];
     $fileType = $_FILES['file']['type'];
 
     $fileExt = explode('.', $fileName);
     $fileActualExt = strtolower(end($fileExt));

     header('location: home.php');

     if($fileActualExt !== "pdf")
     {
        $_SESSION['error'] = "Please upload a PDF Document";
        exit();
     }
 
     if ($fileError === 0)
     {
        try{
            $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM comparison WHERE username=:username");
            $stmt->execute(['username'=>$username]);
            $row = $stmt->fetch();
			if($row['numrows'] > 0){
				$stmt = $conn->prepare("DELETE FROM comparison WHERE username=:username");
                $stmt->execute(['username'=>$username]);;	
			}
        }
         catch(PDOException $e)
         {
            $_SESSION['error'] = $e->getMessage();
        }
         $fileNameNew = $username.".".$fileActualExt;
         $fileDestination = 'files/'.$fileNameNew;
         move_uploaded_file($fileTmpName, $fileDestination);
         $a->setFilename('files/'.$username.'.pdf');
         $a->decodePDF();
         $cv_data = $a->output();

         if($cv_data=== '')
         {
            $_SESSION['error'] = "Please upload an editable PDF document";
            exit();
         }
         $now = date('Y-m-d');
         try{
            $stmt = $conn->prepare("INSERT INTO comparison (empID, username, cv_data, date_entered) VALUES (:empID, :username, :cv_data, :now)");
            $stmt->execute(['empID'=>$empID, 'username'=>$username, 'cv_data'=>$cv_data, 'now'=>$now]);
            $_SESSION['success'] = "Document uploaded successfully";

        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
        }
 
     }
     else
     {
         $_SESSION['error'] = "There was a error uploading file ";
         echo $fileError;
         exit();
     }
    
     
}
else
{
    echo "Submit not pressed";
}




?>