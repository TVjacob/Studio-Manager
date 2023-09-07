<?php
// Include TCPDF library
require_once('library/tcpdf.php');

// Database connection settings
$hostname = 'localhost';
$username = 'mca';
$password = 'password_mca';
$database = 'kayeDB';

// Create a new TCPDF instance with custom page size (A4)
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Tendo Jacob');
$pdf->SetAuthor('Tendo Jaynel');
$pdf->SetTitle('Services Report');
$pdf->SetSubject('Services Offered');
$pdf->SetKeywords('TCPDF, PDF, Services Report');

// Add a page header
$pdf->SetHeaderData('', 0, 'Services Report', 'Generated on ' . date('Y-m-d H:i:s'));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// Add a page footer
$pdf->SetFooterData(array(0, 0, 'Page {PAGENO}'), 0);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins (with smaller left margin)
$pdf->SetMargins(10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Add a page
$pdf->AddPage();

// Add the page title and sub-title
$pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 16);
$pdf->Cell(0, 10, 'Kanyike Studio', 0, 1, 'C');
$pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 14);
$pdf->Cell(0, 10, 'Services Report', 0, 1, 'C');
$pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
$pdf->Cell(0, 10, 'Services Offered', 0, 1, 'C');

// Create a database connection
$db = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Execute your SQL query for services offered
$query = "SELECT id, productname AS servicename, units, rate, amount FROM product";
$result = $db->query($query);

if ($result->num_rows > 0) {
    // Define column widths
    $column_widths = array(20, 60, 20, 20, 30);

    // Table header
    $pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell($column_widths[0], 10, 'ID', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[1], 10, 'Service Name', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[2], 10, 'Units', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[3], 10, 'Rate', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[4], 10, 'Amount', 1, 1, 'C', 1);

    // Data rows
    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 12);
    $total_services = 0;

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell($column_widths[0], 10, $row['id'], 1, 0, 'C');
        $pdf->Cell($column_widths[1], 10, $row['servicename'], 1, 0, 'C');
        $pdf->Cell($column_widths[2], 10, $row['units'], 1, 0, 'C');
        $pdf->Cell($column_widths[3], 10, $row['rate'], 1, 0, 'C');
        // Format and display Amount with 'UGX X,XXX,XXX' format
        $pdf->Cell($column_widths[4], 10, 'UGX ' . number_format($row['amount'], 0, '.', ','), 1, 1, 'C');
        
        $total_services++;
    }

    // Display total number of services
    $pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
    $pdf->Cell(array_sum($column_widths) - $column_widths[3], 10, 'Total Services', 1, 0, 'R', 1);
    $pdf->Cell($column_widths[3], 10, $total_services, 1, 1, 'C');

    // Close the database connection
    $db->close();

    // Output the PDF to the browser (inline display)
    $pdf->Output('services_report.pdf', 'I');
} else {
    echo "No records found.";
}
?>
