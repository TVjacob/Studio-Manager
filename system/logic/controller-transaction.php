
<?php
require_once "server/transaction.php";
require_once "globalfunc.php";

function addTransaction()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPay = new Transaction(test_input($_POST['details']), test_input($_POST['remarks']), test_input($_POST['transDate']), test_input($_POST['amount']), test_input($_POST['creditaccount']), test_input($_POST['debitaccount']), test_input($_POST['product_id']), test_input($_POST['staff_id']));
        $response = savetransaction($newPay);
        echo json_encode($response);
        // if ($response["id"] == 0) {
        //     echo json_encode(array("message" => "Error Occured"));
        // } else {
        //     // debit and credit
        //     // $trans= new GeneralTransaction();
        //     $reference_id = $response["id"];
        //     $student_id = $newPay->student_id;
        //     $staff_id = $newPay->staff_id;
        //     $term_id = $newPay->term_id;
        //     $amount = $newPay->amount;
        //     $transtype = "debit";
        //     $details = $newPay->details;
        //     $remarks = $newPay->remarks;
        //     $transdate = $newPay->transDate;
        //     $account_id = $newPay->debitaccount_id;
        //     //credit 
        //     $debit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Dr", $amount, $student_id, $term_id, $reference_id, $staff_id);
        //     $credit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Cr", $amount, $student_id, $term_id, $reference_id, $staff_id);
        //     savetransaction($debit);
        //     savetransaction($credit);
        // }
    } else {
        echo json_encode(array("message" => "Not Post"));
    }
}
function editTransaction()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $editid  = $_POST['id'];
        if ($editid != null) {
            $editpay = new Transaction(test_input($_POST['details']), test_input($_POST['remarks']), test_input($_POST['transDate']), test_input($_POST['amount']), test_input($_POST['creditaccount']), test_input($_POST['debitaccount']), test_input($_POST['product_id']), test_input($_POST['staff_id']));
            $editpay->setID($editid);
            $feedback = updateTransaction($editpay);
            // deleteTransactionreferno($editid);
            // // debit and credit
            // // $trans= new GeneralTransaction();
            // $reference_id = $editid;
            // $student_id = $editpay->student_id;
            // $staff_id = $editpay->staff_id;
            // $term_id = $editpay->term_id;
            // $amount = $editpay->amount;
            // $details = $editpay->details;
            // $remarks = $editpay->remarks;
            // $transdate = $editpay->transDate;
            // $account_id = $editpay->debitaccount_id;
            // //credit 
            // $debit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Dr", $amount, $student_id, $term_id, $reference_id, $staff_id);
            // $credit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Cr", $amount, $student_id, $term_id, $reference_id, $staff_id);
            // savetransaction($debit);
            // savetransaction($credit);

            echo json_encode($feedback);
        } else {
            echo json_encode(array("message" => "failed to find the id "));
        }
    } else {
        echo json_encode(array("message" => "Cannotupdate this type of post "));
    }
}
function findTransactions()
{
    $payments = transactions();
    echo json_encode($payments);
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
