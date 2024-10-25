<?php

// Habilitar la visualización de errores
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Librería para crear documentos PDF
require('codigos/fpdf.php');

class PDF extends FPDF {
    // Atributos para los datos del cliente
    public $companyName;
    public $contactName;
    public $contactTitle;
    public $city;
    public $country;
    public $postalCode;
    public $startDate;
    public $endDate;

    function Header() {
        // Logo
        $this->Image('imagenes/logos/northwind_T.png', 10, 8, 33); 
        
        // Título 
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 30, ('Reporte de Facturas por Cliente'), 0, 1, 'C');
        
        // Fuente del encabezado
        $this->SetFont('Arial', '', 12);
        
        // Información del Cliente
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(17, 8, ('Cliente:'), 0, 0, 'L');
        $this->Cell(10, 8, '', 0, 0, 'L'); // espacio entre cliente y empresa
        $this->SetFont('Arial', '', 12);
        $this->Cell(83, 8, ($this->companyName), 0, 0, 'L');

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 8, ('Fecha de Consulta:'), 0, 1, 'R'); 
        
        // Información del Contacto y título
        $this->Cell(17, 8, ('Contacto:'), 0, 0, 'L');
        $this->Cell(10, 8, '', 0, 0, 'L'); 
        $this->SetFont('Arial', '', 12);
        $this->Cell(83, 8, ($this->contactTitle . ' ' . $this->contactName), 0, 0, 'L');
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(52, 8, ('Inicio:'), 0, 0, 'R'); 
        $this->Cell(5, 8, '', 0, 0, 'L'); 
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, ($this->startDate), 0, 1, 'R'); 

        // Información de Ubicación
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(17, 8, ('Ubicación:'), 0, 0, 'L');
        $this->Cell(10, 8, '', 0, 0, 'L'); 
        $this->SetFont('Arial', '', 12);
        $this->Cell(83, 8, ($this->city . ', ' . $this->country . ', ' . $this->postalCode), 0, 0, 'L');
        
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(52, 8, ('Final:'), 0, 0, 'R'); 
        $this->Cell(5, 8, '', 0, 0, 'L'); // Espacio entre "Inicio:" y valor
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, ($this->endDate), 0, 1, 'R'); 
        
        // Línea divisora
        $this->Ln(2);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(5);
    }
}

// conexion con la bd
include_once("codigos/conexion2.inc"); // Incluye el archivo de conexión

// Nueva instancia del PDF
$pdf = new PDF();
$pdf->AliasNbPages();// es como un contador para contar el maximo de pagina que se van generando

// Parámetros de consulta 
$customerID = 'ALFKI';       // ID de clientes:  ALFKI,HILAA,FURIB,LAMAI,BLAUS,IFKA 
$startDate = '1995-05-01'; 
$endDate = '1995-06-30'; 

// Consulta SQL para obtener los datos del cliente
$sql = "SELECT 
            c.CompanyName, 
            c.ContactName, 
            c.ContactTitle, 
            c.City, 
            c.Country, 
            c.PostalCode 
        FROM 
            customers c 
        WHERE 
            c.CustomerID = '$customerID'" ;

$result = mysqli_query($conex, $sql);

if ($row = mysqli_fetch_assoc($result)) {

    // Asigna los datoos con las variables de la clase PDF
    $pdf->companyName = $row['CompanyName'];
    $pdf->contactName = $row['ContactName'];
    $pdf->contactTitle = $row['ContactTitle'];
    $pdf->city = $row['City'];
    $pdf->country = $row['Country'];
    $pdf->postalCode = $row['PostalCode'];
    $pdf->startDate = $startDate;
    $pdf->endDate = $endDate;

    $pdf->AddPage(); // Agrega una página
} else {
    die('No se encontró el cliente con el ID especificado.');
}

$pdf->Output();

if(isset($regis)){
    mysqli_free_result($regis);
}
mysqli_close($conex);
?>
