<?php
// Librería para crear documentos PDF
require('codigos/fpdf.php');

// Incluye el archivo de conexión (por ahora solo es necesario para estructura)
include_once("codigos/conexion.inc");

// Declara herencia para definir encabezado y pie de página en el documento
class PDF extends FPDF {
    // Imprime encabezado
    function Header() {
        // Logo
        $this->Image('imagenes/logos/northwind_T.png', 10, 8, 33); 
        
        // Título del reporte centrado
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 30, utf8_decode('Reporte de Facturas por Cliente'), 0, 1, 'C');
        
        // Fuente para el contenido del encabezado
        $this->SetFont('Arial', '', 12);
        
 // Información del Cliente
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(17, 8, utf8_decode('Cliente:'), 0, 0, 'L');
        $this->Cell(10, 8, '', 0, 0, 'L'); //espacio entre cliente y empresa
        $this->SetFont('Arial', '', 12);
        $this->Cell(83, 8, utf8_decode('Nombre de la Empresa'), 0, 0, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, utf8_decode('Fecha de Consulta:'), 0, 1, 'R'); // Se alinea a la derecha
        
        // Información del Contacto y titulo
        $this->Cell(17, 8, utf8_decode('Contacto:'), 0, 0, 'L');
        $this->Cell(10, 8, '', 0, 0, 'L'); //espacio entre cliente y empresa
        $this->SetFont('Arial', '', 12);
        $this->Cell(83, 8, utf8_decode('El titulo y nombre completo del contacto.'), 0, 0, 'L');
        

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(52, 8, utf8_decode('Inicio:'), 0, 0, 'R'); // Etiqueta alineada a la derecha
        $this->Cell(5, 8, '', 0, 0, 'L'); // Espacio entre "Inicio:" y valor
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, utf8_decode('dd/MMM/yyyy'), 0, 1, 'R'); // Valor de la fecha

        // Información de Ubicación
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(17, 8, utf8_decode('Ubicación:'), 0, 0, 'L');
        $this->Cell(10, 8, '', 0, 0, 'L'); //espacio entre cliente y empresa
        $this->SetFont('Arial', '', 12);
        $this->Cell(83, 8, utf8_decode('Ciudad, País, Código Postal'), 0, 0, 'L');
        

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(52, 8, utf8_decode('Final:'), 0, 0, 'R'); // Etiqueta alineada a la derecha
        $this->Cell(5, 8, '', 0, 0, 'L'); // Espacio entre "Inicio:" y valor
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, utf8_decode('dd/MMM/yyyy'), 0, 1, 'R'); // Valor de la fecha



        
        // Línea divisora
        $this->Ln(2);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(5);
    }
}

// Nueva instancia del PDF
$pdf = new PDF();
$pdf->AliasNbPages();

// Genera el PDF con solo el encabezado
$pdf->Output();
?>
