<?php
$str= "C:/Users/USER/OneDrive/Desktop/bob/system/";
require_once $str . "model/model.php";
require_once $str . "model/data_pro.php";

function saveExpense(Expense $expense){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO expense (creditaccount_id,debitaccount_id, details, remarks,staff_id,student_id,transDate,term_id,amount) VALUES (?, ?, ?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss",$creditaccount, $debitaccount_id, $details, $remarks, $staff_id,$student_id,$transDate,$term_id,$amount);

    // set parameters and execute
    $debitaccount_id = $expense->debitaccount_id;
    $creditaccount = $expense->creditaccount_id;
    $details = $expense->details;
    $remarks = $expense->remarks;
    $staff_id = $expense->staff_id;
    $student_id = $expense->student_id;
    $transDate = $expense->transDate;
    $term_id = $expense->term_id;
    $amount = $expense->amount;

    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return array("message" => "saved","id"=> currentExpenseid());

    
}
function expenses()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM expense";
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
function findExpenseById($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `expense` WHERE id = $userid ";
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
function findExpenseBystudnet_Id($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `expense` WHERE student_id = $userid ";
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

function findExpenseBystaff($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `expense` WHERE staff_id = $userid ";
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

function deleteExpenseID($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM expense WHERE id= $userid ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}

function updateExpense(Expense $updateExpense)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $debitaccount_id = $updateExpense->debitaccount_id;
    $creditaccount = $updateExpense->creditaccount_id;
    $details = $updateExpense->details;
    $remarks = $updateExpense->remarks;
    $staff_id = $updateExpense->staff_id;
    $student_id = $updateExpense->student_id;
    $transDate = $updateExpense->transDate;
    $term_id = $updateExpense->term_id;
    $amount = $updateExpense->amount;
    $editId=$updateExpense->getID();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE expense SET debitaccount_id='" . $debitaccount_id ."', creditaccount_id='" . $creditaccount ."', details='" . $details . "', remarks='" . $remarks ."', staff_id='" . $staff_id . "', student_id='" . $student_id . "',transDate='" . $transDate . "',term_id='" . $term_id .  "',amount='" . $amount . "' WHERE id='" . $editId . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
function currentExpenseid(){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT max(expense.id)as id  FROM expense";
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
