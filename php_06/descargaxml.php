<?php
//descargar.xml
	header('Content-disposition: attachment; filename=generales_4.xml'); //se va a descargar con este nombre
	header('Content-type: application/octet-stream .xml; charset=utf-8');

	//obtiene raiz del sitio
    $ruta = $_SERVER["DOCUMENT_ROOT"]."/WEB3/php_06/xml/generales_4.xml"; //xml generado que va a descargar

	readfile($ruta);
?>
