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
$pdf->SetTitle('Salary Payments Report');
$pdf->SetSubject('Salary Payments Information');
$pdf->SetKeywords('TCPDF, PDF, Salary Payments Report');

// Add a page header
$pdf->SetHeaderData('', 0, 'Salary Payments Report', 'Generated on ' . date('Y-m-d H:i:s'));
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
$pdf->Cell(0, 10, 'Salary Payments Report', 0, 1, 'C');
$pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
$pdf->Cell(0, 10, 'Salary Payments', 0, 1, 'C');

// Create a database connection
$db = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Execute your SQL query for salary payments
$query = "SELECT reference_id, gl_transaction.id, staff.staffCode, staff.name, transDate, account.accountName, 
          gl_transaction.remarks, gl_transaction.amount
          FROM gl_transaction
          LEFT JOIN staff ON gl_transaction.staff_id = staff.staffCode
          LEFT JOIN account ON gl_transaction.creditaccount_id = account.acountCode
          WHERE gl_transaction.screen_details = 'salary' AND gl_transaction.debitaccount_id IS NULL
          ORDER BY gl_transaction.id DESC";
$result = $db->query($query);

if ($result->num_rows > 0) {
    // Define column widths
    $column_widths = array(10, 25, 30, 25, 30, 30, 40);

    // Table header
    $pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell($column_widths[0], 10, 'No', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[1], 10, 'Staff Code', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[2], 10, 'Staff Name', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[3], 10, 'Trans Date', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[4], 10, 'Account Name', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[5], 10, 'Remarks', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[6], 10, 'Amount', 1, 1, 'C', 1);

    // Data rows
    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 12);
    $total_payments = 0;

    while ($row = $result->fetch_assoc()) {
        $transNo = $row['reference_id'];
        $staffCode = $row['staffCode'];
        $staffName = $row['name'];
        $transDate = $row['transDate'];
        $accountName = $row['accountName'];
        $remarks = $row['remarks'];
        $amount = $row['amount'];

        $pdf->Cell($column_widths[0], 10, $transNo, 1, 0, 'C');
        $pdf->Cell($column_widths[1], 10, $staffCode, 1, 0, 'C');
        $pdf->Cell($column_widths[2], 10, $staffName, 1, 0, 'C');
        $pdf->Cell($column_widths[3], 10, $transDate, 1, 0, 'C');
        $pdf->Cell($column_widths[4], 10, $accountName, 1, 0, 'C');
        $pdf->Cell($column_widths[5], 10, $remarks, 1, 0, 'C');
        $pdf->Cell($column_widths[6], 10, number_format($amount, 0, '.', ','), 1, 1, 'C');

        $total_payments += $amount;
    }

    // Display total payments at the end of the table
    $pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
    $pdf->Cell(array_sum($column_widths) - $column_widths[5], 10, 'Total', 1, 0, 'R', 1);
    $pdf->Cell($column_widths[6], 10, number_format($total_payments, 0, '.', ','), 1, 1, 'C', 1);

    // Close the database connection
    $db->close();

    // Output the PDF to the browser (inline display)
    $pdf->Output('salary_payments_report.pdf', 'I');
} else {
    echo "No records found.";
}
?>
