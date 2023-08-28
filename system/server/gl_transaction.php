<?php
require_once  "model/model.php";
require_once "model/data_pro.php";


function savetransaction(GL_Transaction $gl_transaction)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
   
    $debitaccount_id = $gl_transaction->debitaccount_id;
    $creditaccount = $gl_transaction->creditaccount_id;
    $remarks = $gl_transaction->remarks;
    $staff_id = $gl_transaction->staff_id;
    $product_id = $gl_transaction->product_id;
    $transDate = $gl_transaction->transDate;
    $amount = $gl_transaction->amount;
    $customer_id = $gl_transaction->customer_id;
    $reference_id=$gl_transaction->reference_id;



    $sql = "INSERT INTO INSERT INTO gl_transaction (reference_id,customer_id,creditaccount_id,debitaccount_id, remarks,staff_id,product_id,transDate,amount)
    VALUES ('$reference_id','$customer_id','$creditaccount', '$debitaccount_id',  '$remarks', '$staff_id','$product_id','$transDate','$amount')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        return array("message" => "New product created successfully","response"=>true,);
    } else {
        return array(,"response"=>false,"message" => "Error: " . $sql . "<br>" . $conn->error);
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
    $sql = "SELECT * FROM gl_transaction";
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
    $sql = "SELECT * FROM `gl_transaction` WHERE id = '". $id . "' ";
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
    $sql = "SELECT * FROM `gl_transaction` WHERE details = '. $details  .'";
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
function findTransactionByRefernce_id($reference_id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `gl_transaction` WHERE reference_id ='$reference_id' ";
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
    $sql = "SELECT * FROM `gl_transaction` WHERE staff_id ='$staff_id' ";
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
    $sql = "Delete  FROM gl_transaction WHERE id= '". $id ."'";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function deleteTransactionreference_id($reference_id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM gl_transaction WHERE reference_id= '". $reference_id ."'";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateTransaction(GL_Transaction $gl_transaction)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $debitaccount_id = $gl_transaction->debitaccount_id;
    $creditaccount = $gl_transaction->creditaccount_id;
    $remarks = $gl_transaction->remarks;
    $staff_id = $gl_transaction->staff_id;
    $product_id = $gl_transaction->product_id;
    $transDate = $gl_transaction->transDate;
    $amount = $gl_transaction->amount;
    $customer_id = $gl_transaction->customer_id;


    $editId=$gl_transaction->getID();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE gl_transaction SET customer_id='" . $customer_id ."',debitaccount_id='" . $debitaccount_id ."', creditaccount_id='" . $creditaccount ."', remarks='" . $remarks ."', staff_id='" . $staff_id . "', product_id='" . $product_id . "',transDate='" . $transDate . "',amount='" . $amount . "' WHERE id='" . $editId . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
function getBalances(){
 // Create connection
 $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,screen_details,remarks,product_id,customer_id,transDate,
 customer.customername,customer.phoneno,
 product.productname,
 account.accountName,
  (sum(if(debitaccount_id <> "1406",debitaccount_id,0))) as acc, 
  (sum(if(debitaccount_id ="1406",gl_transaction.amount,0))) as amt,  
  (sum(if(creditaccount_id ="1406",gl_transaction.amount,0)))as payment
  from gl_transaction
  left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
  left JOIN account on gl_transaction.creditaccount_id = account.id
 GROUP  by reference_id;';
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

function getPayments(){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,screen_details,remarks,product_id,customer_id,transDate,
    customer.customername,customer.phoneno,
    product.productname,
    account.accountName,gl_transaction.amount
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on gl_transaction.creditaccount_id = account.id
     WHERE gl_transaction.screen_details="recipt" and gl_transaction.creditaccount_id is  null
     ORDER by gl_transaction.id DESC;';
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

function getsalaryPayments(){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,screen_details,remarks,product_id,customer_id,transDate,
    staff.staffname,staff.phoneno,
    account.accountName,gl_transaction.amount
     from gl_transaction
     left JOIN staff on gl_transaction.staff_id= staff.id  left JOIN account on gl_transaction.creditaccount_id = account.id
     WHERE gl_transaction.screen_details="salary" and gl_transaction.debitaccount_id is  null
     ORDER by gl_transaction.id DESC;';
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

function getBillings(){
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,screen_details,remarks,product_id,customer_id,transDate,
    customer.customername,customer.phoneno,
    product.productname,
    account.accountName,gl_transaction.amount
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on gl_transaction.creditaccount_id = account.id
     WHERE gl_transaction.screen_details="billing" and gl_transaction.debitaccount_id is  null
     ORDER by gl_transaction.id DESC;';
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
////thead
function savetrack($screen_details)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO INSERT INTO transactionaltracker (screen_details)
    VALUES ('$screen_details')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        return array("message" => "New product created successfully","refer"=>$last_id,);
    } else {
        return array(,"response"=>false,"message" => "Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
    
}
