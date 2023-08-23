<?php
$str= "C:/Users/USER/OneDrive/Desktop/bob/system/";
require_once $str . "model/model.php";
require_once $str . "model/data_pro.php";

// define("SERVERNAME", $servername);
// define("USERNAME", $dbusername);
// define("PASSWORD", $dbpassword);
// define("DB_NAME", $dbname);


function savepayment(Payment $payment)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO payment (creditaccount_id,debitaccount_id, details, remarks,staff_id,student_id,transDate,term_id,amount) VALUES (?, ?, ?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss",$creditaccount, $debitaccount_id, $details, $remarks, $staff_id,$student_id,$transDate,$term_id,$amount);

    // set parameters and execute
    $debitaccount_id = $payment->debitaccount_id;
    $creditaccount = $payment->creditaccount_id;
    $details = $payment->details;
    $remarks = $payment->remarks;
    $staff_id = $payment->staff_id;
    $student_id = $payment->student_id;
    $transDate = $payment->transDate;
    $term_id = $payment->term_id;
    $amount = $payment->amount;

    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return array("message" => "saved","id"=> getcurrentid());

    
}

function payments()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM payment";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        // $row = mysqli_fetch_assoc($result);
        return $data;
    } else {
        return array("message" => "failed to process");
    }
    mysqli_close($conn);
}
function findPaymentById($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `payment` WHERE id = $userid ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        // echo "0 results";
        return array("Message" => "not found");
    }

    mysqli_close($conn);
}
function findPaymentBystudnet_Id($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `payment` WHERE student_id = $userid ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        // echo "0 results";
        return array("Message" => "not found");
    }

    mysqli_close($conn);
}

function findPaymentBystaff($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `payment` WHERE staff_id = $userid ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        // echo "0 results";
        return array("Message" => "not found");
    }

    mysqli_close($conn);
}

function deletePaymentID($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM payment WHERE id= $userid ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}

function updatePayment(Payment $updatePayment)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $debitaccount_id = $updatePayment->debitaccount_id;
    $creditaccount = $updatePayment->creditaccount_id;
    $details = $updatePayment->details;
    $remarks = $updatePayment->remarks;
    $staff_id = $updatePayment->staff_id;
    $student_id = $updatePayment->student_id;
    $transDate = $updatePayment->transDate;
    $term_id = $updatePayment->term_id;
    $amount = $updatePayment->amount;
    $editId=$updatePayment->getID();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE payment SET debitaccount_id='" . $debitaccount_id ."', creditaccount_id='" . $creditaccount ."', details='" . $details . "', remarks='" . $remarks ."', staff_id='" . $staff_id . "', student_id='" . $student_id . "',transDate='" . $transDate . "',term_id='" . $term_id .  "',amount='" . $amount . "' WHERE id='" . $editId . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
function getcurrentid(){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT max(payment.id)as id  FROM payment";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        // echo "0 results";
        return array("id" => 0);
    }

    mysqli_close($conn);
}
