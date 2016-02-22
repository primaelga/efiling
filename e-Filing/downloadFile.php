<?php

	$pathfile =  $_GET['pathFile'];
	$fName = $_GET['fileName'];
	$file = $pathfile.$fName;

	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/pdf');		
		header('Content-Disposition: attachment; filename="'.basename($file).'"');		
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		//ob_clean();
		//flush();
		readfile($file);
		//echo $file;
		exit;
		
		
	}
	else 
	{
		// file couldn't be opened
		header("HTTP/1.0 500 Internal Server Error");
		exit;
	}

?>
