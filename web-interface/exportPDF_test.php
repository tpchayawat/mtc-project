<?php
	include('include/connect_db.php');
	require('fpdf.php');
	define('FPDF_FONTPATH','assets/fpdf-font/');
	
	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
			// Logo
			//$this->Image('logo.png',10,6,30);
			// Arial bold 15
			$this->AddFont('angsa','','angsa.php');
			$this->SetFont('angsa','',14);
			// Move to the right
			$this->Cell(80);
			// Title
			$this->Cell(30,10,iconv('UTF-8','TIS-620','ชื่อ_______________________นามสกุล_______________________เลขทะเบียน________________เลขที่นั่งสอบ_____'),0,0,'C');
			// Line break
			$this->Ln(20);
		}
		
		// Page footer
		function Footer()
		{
			// Position at 1.5 cm from bottom
			$this->SetY(-15);
			// Arial italic 8
			//$this->SetFont('Arial','I',8);
			$this->AddFont('angsa','','angsa.php');
			$this->SetFont('angsa','',14);
			// Page number
			$this->Cell(0,10,iconv( 'UTF-8','TIS-620','หน้า ').$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->SetFont('angsa','',15);
	
	// get data
	if(isset($_GET["tf_id"])){
		$conn = connectDB();
		$tf_id = $_GET["tf_id"];
		$tfSQL = "SELECT tf.name,i.item_id,i.question,i.pic_link,ch.content FROM testform tf,form f,item i,choice ch 
					WHERE tf.testform_id=f.testform_id AND f.item_id=i.item_id 
					AND i.item_id=ch.item_id AND tf.testform_id=".$tf_id;
		
		$currID = -1;
		$i = -1;
		$numi = 1;
		$numch = 1;
		$tfname = '';
		
		$tfQuery = mysqli_query($conn,$tfSQL);
		while($tfResult = mysqli_fetch_array($tfQuery)){
			$id = $tfResult['item_id'];
			if($id != $currID){
				$tfname = $tfResult['name'];
				$currID = $id;
				$i++;
				$pdf->SetX(25);
				$pic = $tfResult['pic_link'];
				if($pic != NULL){
					$pdf->Cell( 40, 40, $pdf->Image($pic, $pdf->GetX(), $pdf->GetY(), 33.78), 0, 0, 'L', false );
					$pdf->Ln(25);
				}
				$pdf->Cell(0,10,($numi++).'. '.iconv('UTF-8','TIS-620',$tfResult['question']),0,1);
				$numch = 1;
			}
			$pdf->SetX(40);
			$pdf->Cell(0,10,($numch++).'. '.iconv('UTF-8','TIS-620',$tfResult['content']),0,1);
		}
		
		// print data
		/*for($i=1;$i<=20;$i++){
			$pdf->SetX(25);
			$pdf->Cell(0,10,iconv('UTF-8','TIS-620',),0,1);
			//$pdf->Cell(0,10,iconv('UTF-8','TIS-620','ทำไมมวะ สาดดดดดดด'),0,1);
			$pdf->SetX(40);
			//$pdf->Cell(0,10,iconv('UTF-8','TIS-620','ขยับไปนิดนึงดิ้'),0,1);
		}*/

		$pdf->Output($tfname.".pdf","D");
	
	}
?>
