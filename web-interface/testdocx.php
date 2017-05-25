<?php
	// Include the PHPWord.php, all other classes were loaded by an autoloader
	require_once 'assets/PHPWord_0.6.2_Beta/PHPWord.php';
	
	// Create a new PHPWord Object
	$PHPWord = new PHPWord();
	
	// Every element you want to append to the word document is placed in a section. So you need a section:
	$section = $PHPWord->createSection();
	
	// After creating a section, you can append elements:
	$section->addText('Hello world!');
	
	// You can directly style your text by giving the addText function an array:
	$section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));
	
	// If you often need the same style again you can create a user defined style to the word document
	// and give the addText function the name of the style:
	$PHPWord->addFontStyle('myOwnStyle', array('name'=>'tahoma', 'size'=>14, 'color'=>'1B2232'));
	$section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');
	
	// new styles
	$styleFont = array('bold'=>true, 'size'=>16, 'name'=>'Calibri');
	$styleParagraph = array('align'=>'center', 'spaceAfter'=>100);
	$section->addText('Hello World', $styleFont, $styleParagraph);
	
	// At least write the document to webspace:
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save('exampledocs/helloWorld.docx');
?>