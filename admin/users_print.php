<?php
	include 'includes/session.php';

	function generateRow($from, $to, $conn){
		$contents = '';
	 	
		$stmt = $conn->prepare("SELECT * FROM user WHERE date_created BETWEEN '$from' AND '$to' ORDER BY date_created DESC");
		$stmt->execute();
		$total = 0;
		foreach($stmt as $row){
			$total++;
			$contents .= '
			<tr>
				<td>'.date('M d, Y', strtotime($row['date_created'])).'</td>
				<td>'.$row['username'].'</td>
				<td>'.$row['firstname'].' '.$row['lastname'].'</td>
				<td>'.$row['email'].'</td>
			</tr>
			';
		}

		$contents .= '
			<tr>
				<td colspan="3" align="left"><b>Total No Of User Registered between Selected Date: '.$total.'</b></td>
			</tr>
		';
		return $contents;
	}

	if(isset($_POST['print'])){
		$ex = explode(' - ', $_POST['date_range']);
		$from = date('Y-m-d', strtotime($ex[0]));
		$to = date('Y-m-d', strtotime($ex[1]));
		$from_title = date('M d, Y', strtotime($ex[0]));
		$to_title = date('M d, Y', strtotime($ex[1]));

		$conn = $pdo->open();

		require_once('../tcpdf/tcpdf.php');  
	    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
	    $pdf->SetCreator(PDF_CREATOR);  
	    $pdf->SetTitle('user Registered: '.$from_title.' - '.$to_title);  
	    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
	    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
	    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
	    $pdf->SetDefaultMonospacedFont('helvetica');  
	    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
	    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
	    $pdf->setPrintHeader(false);  
	    $pdf->setPrintFooter(false);  
	    $pdf->SetAutoPageBreak(TRUE, 10);  
	    $pdf->SetFont('helvetica', '', 11);  
	    $pdf->AddPage();  
	    $content = '';  
	    $content .= '
	      	<h2 align="center">Solution Developers</h2>
	      	<h4 align="center">USERS REPORT</h4>
	      	<h4 align="center">'.$from_title." - ".$to_title.'</h4>
	      	<table border="1" cellspacing="0" cellpadding="3">  
	           <tr>  
	           		<th width="15%" align="center"><b>Date Added</b></th>
	                <th width="30%" align="center"><b>Username</b></th>
					<th width="40%" align="center"><b>Full Name</b></th> 
					<th width="20%" align="center"><b>Email</b></th> 
	           </tr>  
	      ';  
	    $content .= generateRow($from, $to, $conn);  
	    $content .= '</table>';  
		$pdf->writeHTML($content);  
		ob_end_clean();
	    $pdf->Output('user.pdf', 'I');

	    $pdo->close();

	}
	else{
		$_SESSION['error'] = 'Need date range to provide sales print';
		header('location: users.php');
	}
?>