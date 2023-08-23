<?php
require_once  "model/model.php";
require_once "model/data_pro.php";


function savetransaction(Transaction $transaction)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
   
    $debitaccount_id = $transaction->debitaccount_id;
    $creditaccount = $transaction->creditaccount_id;
    $details = $transaction->details;
    $remarks = $transaction->remarks;
    $staff_id = $transaction->staff_id;
    $product_id = $transaction->product_id;
    $transDate = $transaction->transDate;
    $amount = $transaction->amount;


    $sql = "INSERT INTO INSERT INTO transaction (creditaccount_id,debitaccount_id, details, remarks,staff_id,product_id,transDate,amount)
    VALUES ('$creditaccount', '$debitaccount_id', '$details', '$remarks', '$staff_id','$product_id','$transDate','$amount')";

    if ($conn->query($sql) === TRUE) {
        return array("message" => "New product created successfully");
    } else {
        return array("message" => "Error: " . $sql . "<br>" . $conn->error);
    }
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
    $sql = "SELECT * FROM transaction";
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
function findTransactionById($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `transaction` WHERE id = '". $id . "' ";
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
function findTransactionBydetails($details)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `transaction` WHERE details = '. $details  .'";
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
function findTransactionBystaff($staff_id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `transaction` WHERE staff_id ='$staff_id' ";
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
function deleteTransactionID($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM transaction WHERE id= '". $id ."'";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateTransaction(Transaction $transaction)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $debitaccount_id = $transaction->debitaccount_id;
    $creditaccount = $transaction->creditaccount_id;
    $details = $transaction->details;
    $remarks = $transaction->remarks;
    $staff_id = $transaction->staff_id;
    $product_id = $transaction->product_id;
    $transDate = $transaction->transDate;
    $amount = $transaction->amount;

    $editId=$transaction->getID();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE transaction SET debitaccount_id='" . $debitaccount_id ."', creditaccount_id='" . $creditaccount ."', details='" . $details . "', remarks='" . $remarks ."', staff_id='" . $staff_id . "', product_id='" . $product_id . "',transDate='" . $transDate . "',amount='" . $amount . "' WHERE id='" . $editId . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
