
<?php
require_once "server/payment.php";
require_once "server/general.php";
require_once "globalfunc.php";

function addPayment()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPay = new Payment(test_input($_POST['details']), test_input($_POST['remarks']), test_input($_POST['transDate']), test_input($_POST['amount']), test_input($_POST['creditaccount']), test_input($_POST['debitaccount']), test_input($_POST['student_id']), test_input($_POST['staff_id']), test_input($_POST['term_id']));

        $response = savepayment($newPay);
        if ($response["id"] == 0) {
            echo json_encode(array("message" => "Error Occured"));
        } else {
            // debit and credit
            // $trans= new GeneralTransaction();
            $reference_id = $response["id"];
            $student_id = $newPay->student_id;
            $staff_id = $newPay->staff_id;
            $term_id = $newPay->term_id;
            $amount = $newPay->amount;
            $transtype = "debit";
            $details = $newPay->details;
            $remarks = $newPay->remarks;
            $transdate = $newPay->transDate;
            $account_id = $newPay->debitaccount_id;
            //credit 
            $debit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Dr", $amount, $student_id, $term_id, $reference_id, $staff_id);
            $credit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Cr", $amount, $student_id, $term_id, $reference_id, $staff_id);
            savetransaction($debit);
            savetransaction($credit);
        }
    } else {
        echo json_encode(array("message" => "Not Post"));
    }
}
function editPayment()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $editid  = $_POST['id'];
        if ($editid != null) {
            $editpay = new  Payment(test_input($_POST['details']), test_input($_POST['remarks']), test_input($_POST['transDate']), test_input($_POST['amount']), test_input($_POST['creditaccount']), test_input($_POST['debitaccount']), test_input($_POST['student_id']), test_input($_POST['staff_id']), test_input($_POST['term_id']));
            $editpay->setID($editid);
            $feedback = updatePayment($editpay);
            deleteTransactionreferno($editid);
            // debit and credit
            // $trans= new GeneralTransaction();
            $reference_id = $editid;
            $student_id = $editpay->student_id;
            $staff_id = $editpay->staff_id;
            $term_id = $editpay->term_id;
            $amount = $editpay->amount;
            $details = $editpay->details;
            $remarks = $editpay->remarks;
            $transdate = $editpay->transDate;
            $account_id = $editpay->debitaccount_id;
            //credit 
            $debit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Dr", $amount, $student_id, $term_id, $reference_id, $staff_id);
            $credit = new GeneralTransaction($account_id, $transdate, $remarks, $details, "Cr", $amount, $student_id, $term_id, $reference_id, $staff_id);
            savetransaction($debit);
            savetransaction($credit);

            echo json_encode($feedback);
        } else {
            echo json_encode(array("message" => "failed to find the id "));
        }
    } else {
        echo json_encode(array("message" => "Cannotupdate this type of post "));
    }
}
function findPayments()
{
    $payments = payments();
    echo json_encode($payments);
}
function findPaymentsByID()
{
    if ($_GET['id'] != null) {
        $payments = findPaymentById($_GET['id']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function findPaymentsBystaffID()
{
    if ($_GET['staff_id'] != null) {
        $payments = findPaymentBystaff($_GET['staff_id']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function findPaymentsBystudentID()
{
    if ($_GET['student_id'] != null) {
        $payments = findPaymentBystudnet_Id($_GET['student_id']);
        echo json_encode($payments);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
function deletePaymentByID()
{
    if ($_GET['id'] != null) {
        $delpay = deletePaymentID($_GET['id']);
        echo json_encode($delpay);
    } else {
        echo json_encode(array("message" => "failed to find the id "));
    }
}
