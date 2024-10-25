<?php
// Libreria en php para crear documentos .pdf
require('codigos/fpdf.php');

// para procesamiento de datos binarios en el pdf
ob_start();

// Declara herencia entre clases para definir el encabezado
// y pie de pagina del documento
class PDF extends FPDF {
    // imprime encabezado
    function Header() {
        $this->Image('imagenes/logos/php.gif', 10, 8, 33);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        $this->Cell(20, 10, utf8_decode('Universidad Técnica Nacional'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(80);
        $this->Cell(20, 10, utf8_decode('Listado de Clientes'), 0, 0, 'C');
        $this->Ln(15);
    }

    // Imprime el pie de pagina
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Imprime datos de clientes
    function DatClientes($Id, $Nombre, $Contacto, $Pais) {
        // Ancho de las columnas
        $ancho = array(20, 60, 60, 40);

        // Imprime el dato
        $this->Cell($ancho[0], 6, $Id);
        $this->Cell($ancho[1], 6, utf8_decode($Nombre));
        $this->Cell($ancho[2], 6, utf8_decode($Contacto));
        $this->Cell($ancho[3], 6, utf8_decode($Pais));
        $this->Ln();
    }
}

// Agrega nueva instancia de PDF e inicializa el contador de estas
$pdf = new PDF();
$pdf->AliasNbPages();

// Agrega pagina y define tipo de fuente
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

// Realiza conexion con la base de datos
include_once("codigos/conexion2.inc");

// Define y ejecuta una linea de consulta sobre la BD.
$auxSql = 'SELECT CustomerID, CompanyName, ContactName, Country FROM customers';

$regis = mysqli_query($conex, $auxSql) or die(mysqli_error($conex));

// Imprime encabezado de la tabla
$pdf->Cell(20, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Nombre de la Compañía', 1);
$pdf->Cell(60, 10, 'Contacto', 1);
$pdf->Cell(40, 10, 'País', 1);
$pdf->Ln();

// Recorre las tuplas recuperadas de la consulta.
// Imprime juego de valores para reporte
while ($row_Regis = mysqli_fetch_assoc($regis)) {
    // Invoca metodo para imprimir datos de clientes
    $pdf->DatClientes($row_Regis['CustomerID'],
                      $row_Regis['CompanyName'],
                      $row_Regis['ContactName'],
                      $row_Regis['Country']);
}

// Finaliza la construccion del pdf y lo envia al navegador
$pdf->Output();

// descarga de memoria el dato binario colocado
ob_end_flush();
?>

<?php
// Limpia el registro de datos
if (isset($regis)) {
    mysqli_free_result($regis);
}
?>
