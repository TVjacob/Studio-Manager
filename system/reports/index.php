<?php
// Include TCPDF library
require_once('library/tcpdf.php');

// Create a new TCPDF instance with custom page size (A4)
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, 'mm', 'A4', true, 'UTF-8');

// Set document information
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Company');
$pdf->SetTitle('Customer Invoice');
$pdf->SetSubject('Invoice');
$pdf->SetKeywords('TCPDF, Invoice, Customer');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Output invoice content
$pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

$pdf->Cell(0, 5, 'Date: ' . date('F j, Y'), 0, 1);
$pdf->Cell(0, 5, 'Invoice Number: INV-001', 0, 1);
$pdf->Cell(0, 5, 'Customer: John Doe', 0, 1);
$pdf->Cell(0, 5, 'Due Date: ' . date('F j, Y', strtotime('+30 days')), 0, 1);

$pdf->Ln(10);

// Create invoice table
$pdf->SetFillColor(200, 200, 200);
$pdf->SetFont(PDF_FONT_NAME_MAIN, 'B');
$pdf->Cell(45, 10, 'Item', 1, 0, 'C', 1);
$pdf->Cell(25, 10, 'Qty', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Unit Price', 1, 0, 'C', 1);
$pdf->Cell(30, 10, 'Total', 1, 1, 'C', 1);

$pdf->SetFont(PDF_FONT_NAME_MAIN);

// Sample invoice items
$items = [
    ['Product A', 2, '$10.00', '$20.00'],
    ['Product B', 1, '$15.00', '$15.00'],
];

foreach ($items as $item) {
    $pdf->Cell(45, 10, $item[0], 1);
    $pdf->Cell(25, 10, $item[1], 1);
    $pdf->Cell(30, 10, $item[2], 1);
    $pdf->Cell(30, 10, $item[3], 1, 1);
}

// Calculate and display totals
$pdf->Ln(10);
$pdf->Cell(100, 10, 'Subtotal:', 0, 0, 'R');
$pdf->Cell(30, 10, '$35.00', 0, 1, 'C');
$pdf->Cell(100, 10, 'Tax (5%):', 0, 0, 'R');
$pdf->Cell(30, 10, '$1.75', 0, 1, 'C');
$pdf->SetFont(PDF_FONT_NAME_MAIN,'B');
$pdf->Cell(100, 10, 'Total:', 0, 0, 'R');
$pdf->Cell(30, 10, '$36.75', 0, 1, 'C');

// Output the PDF to the browser (inline display)
$pdf->Output('customer_invoice.pdf', 'I');
?>
