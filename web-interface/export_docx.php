<?php
	include('include/connect_db.php');
	
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
		$numch = 'a';
		$tfname = '';
		
		// set phpword
		require_once 'assets/PHPWord_Thai_Patch/PHPWord.php';
		$PHPWord = new PHPWord();
		$styleFont = array('bold'=>false, 'size'=>14, 'name'=>'AngsanaUPC');
		$styleParagraph = array('align'=>'left', 'spaceBefore'=>120);
		
		$section = $PHPWord->createSection();
		// set header
		$header_text = 'ชื่อ_______________________นามสกุล_______________________เลขทะเบียน________________เลขที่นั่งสอบ_____';
		$header = $section->createHeader();
		$header->addText($header_text, array('name'=>'AngsanaUPC', 'size'=>14, 'bold'=>true));
		// set footer
		$footer = $section->createFooter();
		$footer->addPreserveText('หน้า {PAGE} / {NUMPAGES}', array('align'=>'both', 'bold'=>true));
		
		// get query
		$tfQuery = mysqli_query($conn,$tfSQL);
		while($tfResult = mysqli_fetch_array($tfQuery)){
			$id = $tfResult['item_id'];
			if($id != $currID){
				$tfname = $tfResult['name'];
				$currID = $id;
				$i++;
				$pic = $tfResult['pic_link'];
				
				$section->addText("");
				$section->addText(($numi++).". ".$tfResult['question'], $styleFont, $styleParagraph);
				if($pic != NULL){
					$section->addImage($pic, array('width'=>200, 'height'=>200, 'align'=>'center'));
				}
				$numch = 'a';
			}
			$section->addText(($numch++).". ".$tfResult['content'], $styleFont);
		}
		
		/* $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		//$objWriter->save('example_docs/test_export.docx');
		
		// // save as a random file in temp file
		$temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');
		$objWriter->save($temp_file);

		// Your browser will name the file "myFile.docx"
		// regardless of what it's named on the server 
		header("Content-Disposition: attachment; filename=".$tfname.".docx");
		readfile($temp_file); // or echo file_get_contents($temp_file);
		unlink($temp_file);  // remove temp file */
		
		$filename = $tfname.'.docx';
		header( "Content-Type:   application/octet-stream" );// you should look for the real header that a word2007 document needs!!!
		header( 'Content-Disposition: attachment; filename='.$filename );

		$h2d_file_uri = tempnam( "", "htd" );
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save( "php://output" );// this would output it like echo, but in combination with header: it will be sent
		
	}
	
	/* require_once 'assets/PHPWord_Thai_Patch/PHPWord.php';
	
	$PHPWord = new PHPWord();
	$section = $PHPWord->createSection();
	
	$styleFont = array('bold'=>false, 'size'=>14, 'name'=>'AngsanaUPC');
	$styleParagraph = array('align'=>'left', 'spaceAfter'=>100);
	//$section->addText('Hello World', $styleFont, $styleParagraph);
	
	$header_text = 'ชื่อ_______________________นามสกุล_______________________เลขทะเบียน________________เลขที่นั่งสอบ_____';
	$header = $section->createHeader();
	$header->addText($header_text, array('name'=>'AngsanaUPC', 'size'=>14, 'bold'=>true));
	
	$footer = $section->createFooter();
	$footer->addPreserveText('หน้า {PAGE} / {NUMPAGES}', array('align'=>'center', 'bold'=>true));
	
	$section->addImage('_earth.jpg', array('width'=>200, 'height'=>200, 'align'=>'center'));
	
	$question = 'นี่คือดาวอะไร?';
	$section->addText($question,$styleFont);
	$alp = 'a';
	$ans1 = ($alp++).'. ดวงจันทร์';
	$section->addText($ans1, $styleFont, $styleParagraph);
	$ans1 = ($alp++).'. ดาวอังคาร';
	$section->addText($ans1, $styleFont, $styleParagraph);
	$ans1 = ($alp++).'. ดาวพุธ';
	$section->addText($ans1, $styleFont, $styleParagraph);
	$ans1 = ($alp++).'. โลก';
	$section->addText($ans1, $styleFont, $styleParagraph);
	
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save('example_docs/test.docx'); */
?>