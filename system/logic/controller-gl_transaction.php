
<?php
require_once "server/gl_transaction.php";
require_once "globalfunc.php";

function saveRecipt()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $creditincome = "1003"; // income Reciable income reciable*
        $debitaccount = $_POST['debit'];
        $customer = $_POST['customer'];
        $remarks = $_POST['remarks'];
        $amount = (float)$_POST['amount'];
        $transdate = $_POST['tdate'];
        $product = $_POST["product"];
        $screen_details = "recipt";
        $reference_id = $_POST["reference_id"];;
        $debit = new GL_Transaction($reference_id, $customer, $screen_details, $remarks, $transdate, $amount, null, $debitaccount, $product, null);
        $credit = new GL_Transaction($reference_id, $customer, $screen_details, $remarks, $transdate, $amount, $creditincome, null, $product, null);
        $feedback = savetransaction($debit);
        $feedback1 = savetransaction($credit);
        if ($feedback['response'] && $feedback1['response']) {
                echo json_encode($feedback);
        } else {
            echo json_encode(array("message" => "Failed to save successfully "));
        }
    }
}
function saveBill()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $creditincome = "6000";//$_POST['credit']; //income
        $debitaccount = "1003";//$_POST['debit']; //debit income reciva*
        $customer = $_POST['customer'];
        $remarks = $_POST['remarks'];
        $amount = (float)$_POST['amount'];
        $transdate = $_POST['tdate'];
        $product = $_POST["service"];
        $screen_details = "BILLING";
       $transobj= savetrack($screen_details);
        $reference_id = $transobj['refer_id'];
        $debit = new GL_Transaction($reference_id, $customer, $screen_details, $remarks, $transdate, $amount, null, $debitaccount, $product, null);
        $credit = new GL_Transaction($reference_id, $customer, $screen_details, $remarks, $transdate, $amount, $creditincome, null, $product, null);

        $feedback = savetransaction($debit);
        $feedback1 = savetransaction($credit);
        if ($feedback['response'] && $feedback1['response']) {
            echo json_encode($feedback);
        } else {
            echo json_encode(array("message" => "Failed to save successfully "));
        }
    }
}
function saveDoubleEntry()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $creditincome = $_POST['credit']; //credit
        $debitaccount = $_POST['debit']; //debit 
        $remarks = $_POST['remarks'];
        $amount = (float)$_POST['amount'];
        $transdate = $_POST['tdate'];
        $product  =  null;//$_POST["product"];

        $screen_details = "DoubleEntry";

        $transobj= savetrack($screen_details);
        $reference_id = $transobj['refer_id'];
        $debit = new GL_Transaction($reference_id, null, $screen_details, $remarks, $transdate, $amount, null, $debitaccount, $product, null);
        $credit = new GL_Transaction($reference_id, null, $screen_details, $remarks, $transdate, $amount, $creditincome, null, $product, null);
        $feedback = savetransaction($debit);
        $feedback1 = savetransaction($credit);
        if ($feedback['response'] && $feedback1['response']) {
            echo json_encode(array("message" => "Saved successfully "));
        } else {
            echo json_encode(array("message" => "Failed to save successfully "));
        }
    }
}
function saveSalary()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $creditaccount = $_POST['credit']; //credit from user
        $debitaccount ="6002"; // salary expense*
        $staffid = $_POST['staff']; //stafff
        $remarks = $_POST['remarks'];
        $amount = (float)$_POST['amount'];
        $transdate = $_POST['tdate'];
        $product = null;//$_POST["product"];
        $screen_details = "Salary";
        $transobj= savetrack($screen_details);
        $reference_id = $transobj['refer_id'];
        $debit = new GL_Transaction($reference_id, null, $screen_details, $remarks, $transdate, $amount, null, $debitaccount, $product, $staffid);
        $credit = new GL_Transaction($reference_id, null, $screen_details, $remarks, $transdate, $amount, $creditaccount, null, $product, $staffid);
        $feedback = savetransaction($debit);
        $feedback1 = savetransaction($credit);
        if ($feedback['response'] && $feedback1['response']) {
            echo json_encode(array("message" => "Saved successfully "));
        } else {
            echo json_encode(array("message" => "Failed to save successfully "));
        }
    }
}
function balances()
{
        $balances = getBalances();
        echo json_encode($balances);
}
function payments()
{
        $payments = getPayments();
        echo json_encode($payments);
}
function billings()
{
        $bills = getBillings();
        echo json_encode($bills);
}

function totalbalances()
{
        $balances = getTotalBalances();
        echo json_encode($balances);
}
function totalpayments()
{
        $payments = getTotalPayments();
        echo json_encode($payments);
}
function totalbillings()
{
        $bills = getTotalBillings();
        echo json_encode($bills);
}
function findTransactions()
{
        $payments = gettransactions();
        echo json_encode($payments);
}

function salarypayments()
{
        $salpay = getsalaryPayments();
        echo json_encode($salpay);
}
function findTransactionsByID()
{
    if ($_GET['id'] != null) {
        $payments = findTransactionById($_GET['id']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function findTransactionsByreferID()
{
    if ($_GET['id'] != null) {
        $payments = findTransactionByRefernce_id($_GET['id']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function findTransactionsBystaffID()
{
    if ($_GET['staff_id'] != null) {
        $payments = findTransactionBystaff($_GET['staff_id']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function getTransactionBydetails()
{
    if ($_GET['details'] != null) {
        $payments = findTransactionBydetails($_GET['details']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function deleteTransactionByID()
{
    if ($_GET['id'] != null) {
        $delpay = deleteTransactionID($_GET['id']);
        echo json_encode($delpay);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function deleteTransactionByreferID()
{
    if ($_POST['id'] != null) {
        $delpay = deleteTransactionreference_id($_POST['id']);
        echo json_encode($delpay);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function deleteByreferIDAndRecipt()
{
    if ($_POST['id'] != null) {
        $delpay = deleteTransreferidAnddetails($_POST['id'],$_POST['detail']);
        echo json_encode($delpay);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
