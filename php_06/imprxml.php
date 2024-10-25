<?php
	//obtiene raiz del sitio
			$ruta = $_SERVER["DOCUMENT_ROOT"]."/WEB3/php_06/xml/";

	//Seleccionas impresora
	//$impr = printer_open("Epson XP-201 204 208 Series");
	$impr = printer_open("Samsung M2020 Series");

	printer_write($impr, $ruta);
	printer_close($impr);
?>
