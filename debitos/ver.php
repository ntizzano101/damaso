<?php
	$archivo=$_GET["archivo"];
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($archivo));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($archivo));
    readfile($archivo);
    exit;
?>