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
$pdf->SetTitle('Customer Balances Report');
$pdf->SetSubject('Customer Balances Information');
$pdf->SetKeywords('TCPDF, PDF, Customer Balances Report');

// Add a page header
$pdf->SetHeaderData('', 0, 'Customer Balances Report', 'Generated on ' . date('Y-m-d H:i:s'));
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
$pdf->Cell(0, 10, 'Customer Balances Report', 0, 1, 'C');
$pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
$pdf->Cell(0, 10, 'Customer Balances', 0, 1, 'C');

// Create a database connection
$db = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Execute your SQL query for customer balances
$query = "SELECT reference_id, gl_transaction.id, customer.customername, transDate, product.productname, customer.phoneno, 
          (SUM(IF(debitaccount_id <> '1003', debitaccount_id, 0))) AS payaccount, 
          (SUM(IF(debitaccount_id = '1003', gl_transaction.amount, 0))) AS totalbill, 
          (SUM(IF(creditaccount_id = '1003', gl_transaction.amount, 0))) AS totalpayments 
          FROM gl_transaction 
          LEFT JOIN customer ON gl_transaction.customer_id = customer.id 
          LEFT JOIN product ON gl_transaction.product_id = product.id 
          WHERE debitaccount_id IS NOT NULL OR creditaccount_id IS NOT NULL 
          GROUP BY reference_id 
          HAVING (SUM(IF(debitaccount_id = '1003', gl_transaction.amount, 0)) - 
          SUM(IF(creditaccount_id = '1003', gl_transaction.amount, 0))) > 0";
$result = $db->query($query);

if ($result->num_rows > 0) {
    // Define column widths
    $column_widths = array(10, 35, 25, 20, 25, 25, 25, 25);

    // Table header
    $pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell($column_widths[0], 10, 'No', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[1], 10, 'Customer Name', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[2], 10, 'Trans Date', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[3], 10, 'Service', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[4], 10, 'Phone No', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[5], 10, 'Total Bill', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[6], 10, 'Payments', 1, 0, 'C', 1);
    $pdf->Cell($column_widths[7], 10, 'Balance', 1, 1, 'C', 1);

    // Data rows
    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', 12);
    $total_customers = 0;
    $total_bill = 0;
    $total_payments = 0;
    $total_balance = 0;

    while ($row = $result->fetch_assoc()) {
        $transNo = $row['reference_id'];
        $customerName = $row['customername'];
        $transDate = $row['transDate'];
        $service = $row['productname'];
        $phoneno = $row['phoneno'];
        $totalBill = $row['totalbill'];
        $totalPayments = $row['totalpayments'];
        $balance = $totalBill - $totalPayments;

        $pdf->Cell($column_widths[0], 10, $transNo, 1, 0, 'C');
        $pdf->Cell($column_widths[1], 10, $customerName, 1, 0, 'C');
        $pdf->Cell($column_widths[2], 10, $transDate, 1, 0, 'C');
        $pdf->Cell($column_widths[3], 10, $service, 1, 0, 'C');
        $pdf->Cell($column_widths[4], 10, $phoneno, 1, 0, 'C');
        $pdf->Cell($column_widths[5], 10, number_format($totalBill, 0, '.', ','), 1, 0, 'C');
        $pdf->Cell($column_widths[6], 10, number_format($totalPayments, 0, '.', ','), 1, 0, 'C');
        $pdf->Cell($column_widths[7], 10, number_format($balance, 0, '.', ','), 1, 1, 'C');

        $total_customers++;
        $total_bill += $totalBill;
        $total_payments += $totalPayments;
        $total_balance += $balance;
    }

    // Display totals at the end of the table
    $pdf->SetFont(PDF_FONT_NAME_MAIN, 'B', 12);
    $pdf->Cell($column_widths[0] + $column_widths[1] + $column_widths[2] + $column_widths[3] + $column_widths[4], 10, 'Total', 1, 0, 'R', 1);
    $pdf->Cell($column_widths[5], 10, number_format($total_bill, 0, '.', ','), 1, 0, 'C', 1);
    $pdf->Cell($column_widths[6], 10, number_format($total_payments, 0, '.', ','), 1, 0, 'C', 1);
    $pdf->Cell($column_widths[7], 10, number_format($total_balance, 0, '.', ','), 1, 1, 'C', 1);

    // Display total number of customers with balances
    $pdf->Cell($column_widths[0] + $column_widths[1] + $column_widths[2] + $column_widths[3], 10, 'Total Customers', 1, 0, 'R', 1);
    $pdf->Cell($column_widths[4], 10, $total_customers, 1, 0, 'C', 1);

    // Close the database connection
    $db->close();

    // Output the PDF to the browser (inline display)
    $pdf->Output('customer_balances_report.pdf', 'I');
} else {
    echo "No records found.";
}
?>
