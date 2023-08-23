<?php
$str= "C:/Users/USER/OneDrive/Desktop/bob/system/";
require_once $str . "model/model.php";
require_once $str . "model/data_pro.php";



function savetransaction(GeneralTransaction $newtrans)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO GeneralTransaction (account_id, details, remarks,staff_id,student_id,transDate,term_id,amount,transtype,reference_id) VALUES (?, ?, ?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssssss", $account_id, $details, $remarks, $staff_id,$student_id,$transDate,$term_id,$amount,$transtype,$reference_id);
    $account_id = $newtrans->account_id;
    $details = $newtrans->details;
    $remarks = $newtrans->remarks;
    $staff_id = $newtrans->staff_id;
    $student_id = $newtrans->student_id;
    $transDate = $newtrans->transdate;
    $term_id = $newtrans->term_id;
    $amount = $newtrans->amount;
    $transtype= $newtrans->transtype;
    $reference_id=$newtrans->reference_id;
    $stmt->execute();
    return array("message" => "saved");
    $stmt->close();
    $conn->close();
}
function transactions()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM GeneralTransaction";
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
function findtransactionById($transid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `GeneralTransaction` WHERE id = $transid ";
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
function findtransactionBystudnet_Id($transid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `GeneralTransaction` WHERE student_id = $transid ";
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
function findtransactionByRefernceNo($transid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `GeneralTransaction` WHERE reference_id = $transid ";
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
function findTransactionBystaff($transid)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `GeneralTransaction` WHERE staff_id = $transid ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        return array("Message" => "not found");
    }
    mysqli_close($conn);
}
function deleteTransactionID($transid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM GeneralTransaction WHERE id= $transid ";
    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function deleteTransactionreferno($transid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM GeneralTransaction WHERE reference_id= $transid ";
    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateTransaction(GeneralTransaction $updatetrans)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $account_id = $updatetrans->account_id;
    $details = $updatetrans->details;
    $remarks = $updatetrans->remarks;
    $staff_id = $updatetrans->staff_id;
    $student_id = $updatetrans->student_id;
    $transDate = $updatetrans->transdate;
    $term_id = $updatetrans->term_id;
    $amount = $updatetrans->amount;
    $transtype= $updatetrans->transtype;
    $editId=$updatetrans->getID();
    // $reference_id=$updatetrans->reference_id;

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE GeneralTransaction SET transtype='" . $transtype ."', transtype='" . $transtype ."', account_id='" . $account_id ."', details='" . $details . "', remarks='" . $remarks ."', staff_id='" . $staff_id . "', student_id='" . $student_id . "',transDate='" . $transDate . "',term_id='" . $term_id .  "',amount='" . $amount . "' WHERE id='" . $editId . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
