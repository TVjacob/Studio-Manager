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
    $reference_id = $gl_transaction->reference_id;
    $screen_details = $gl_transaction->screen_details;


    if ($creditaccount !== null) {
        $sql = "INSERT INTO gl_transaction (reference_id,customer_id,creditaccount_id, remarks,staff_id,product_id,transDate,amount,screen_details)
    VALUES ('" . $reference_id . "','" . $customer_id . "','" . ($creditaccount = !null ? $creditaccount : "null") . "',  '" . $remarks . "', '" . $staff_id . "','" . $product_id . "','" . $transDate . "','" . $amount . "','" . $screen_details . "')";
    } else {
        $sql = "INSERT INTO gl_transaction (reference_id,customer_id,debitaccount_id, remarks,staff_id,product_id,transDate,amount,screen_details)
    VALUES ('" . $reference_id . "','" . $customer_id . "', '" . ($debitaccount_id != null ? $debitaccount_id : "null") . "',  '" . $remarks . "', '" . $staff_id . "','" . $product_id . "','" . $transDate . "','" . $amount . "','" . $screen_details . "')";
    }
    if ($conn->query($sql) === TRUE) {
        return array("message" => "New product created successfully", "response" => true,);
    } else {
        return array("response" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
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
    $data = [];
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
    $sql = "SELECT * FROM `gl_transaction` WHERE id = '" . $id . "' ";
    $result = mysqli_query($conn, $sql);
    $data = [];
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
    $sql = "SELECT * FROM `gl_transaction` WHERE details = '" .  $details . "'";
    $result = mysqli_query($conn, $sql);
    $data = [];
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
    $sql = "SELECT * FROM `gl_transaction` WHERE reference_id ='" . $reference_id . "' ";
    $result = mysqli_query($conn, $sql);
    $data = [];
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
    $sql = "SELECT * FROM `gl_transaction` WHERE staff_id ='" . $staff_id . "' ";
    $result = mysqli_query($conn, $sql);
    $data = [];
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
    $sql = "Delete  FROM gl_transaction WHERE id= '" . $id . "'";
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
    $sql = "Delete  FROM gl_transaction WHERE reference_id= '" . $reference_id . "'";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function deleteTransreferidAnddetails($reference_id,$details)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM gl_transaction WHERE reference_id= '" . $reference_id . "' And screen_details='" . $details . "'";
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


    $editId = $gl_transaction->getID();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE gl_transaction SET customer_id='" . $customer_id . "',debitaccount_id='" . $debitaccount_id . "', creditaccount_id='" . $creditaccount . "', remarks='" . $remarks . "', staff_id='" . $staff_id . "', product_id='" . $product_id . "',transDate='" . $transDate . "',amount='" . $amount . "' WHERE id='" . $editId . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
function getBalances()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,
    screen_details,remarks,product_id,customer_id,transDate,
     customer.customername,customer.phoneno,
     product.productname,
     account.accountName,
      (sum(if(debitaccount_id <> "1003",debitaccount_id,0))) as payaccount, 
      (sum(if(debitaccount_id ="1003",gl_transaction.amount,0))) as totalbill,  
      (sum(if(creditaccount_id ="1003",gl_transaction.amount,0)))as totalpayments
      from gl_transaction
      left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
      left JOIN account on gl_transaction.debitaccount_id = account.acountCode
      where debitaccount_id is NOT null or creditaccount_id is NOT null
      GROUP  by reference_id
      HAVING ((sum(if(debitaccount_id ="1003",gl_transaction.amount,0)))-(sum(if(creditaccount_id ="1003",gl_transaction.amount,0))))>0;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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

function getTotalBalances()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT  
    COUNT(customer.customername) as totalamt,
     (sum(if(debitaccount_id ="1003",gl_transaction.amount,0))) as totalbill,  
     (sum(if(creditaccount_id ="1003",gl_transaction.amount,0)))as totalpayments
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on gl_transaction.debitaccount_id = account.acountCode
     where debitaccount_id is NOT null or creditaccount_id is NOT null
     HAVING ((sum(if(debitaccount_id ="1003",gl_transaction.amount,0)))-(sum(if(creditaccount_id ="1003",gl_transaction.amount,0))))>0;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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
function getPayments()
{
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
     left JOIN account on gl_transaction.debitaccount_id = account.acountCode
     WHERE gl_transaction.screen_details="recipt" and gl_transaction.creditaccount_id is  null
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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

function getTotalPayments()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT  count(customer.customername) as totalnum,
    sum(gl_transaction.amount) as totalamount
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on gl_transaction.debitaccount_id = account.acountCode
     WHERE gl_transaction.screen_details="recipt" and gl_transaction.creditaccount_id is  null
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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
function gettransactions()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,screen_details,remarks,product_id,customer_id,transDate,
    customer.customername,customer.phoneno,
    product.productname,
    (if(debitaccount_id is null,creditaccount_id,debitaccount_id)) as acctCodes,
    account.accountName,gl_transaction.amount
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on (if(gl_transaction.creditaccount_id is NOT null,gl_transaction.creditaccount_id,gl_transaction.debitaccount_id)) = account.acountCode
     WHERE gl_transaction.screen_details="DoubleEntry" 
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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

function getTotaltransactions()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT COUNT(customer.customername) as totalnum,
    sum(gl_transaction.amount) as totalpayments
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on (if(gl_transaction.creditaccount_id is NOT null,gl_transaction.creditaccount_id,gl_transaction.debitaccount_id)) = account.acountCode
     WHERE gl_transaction.screen_details="DoubleEntry" 
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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

function getsalaryPayments()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   reference_id, gl_transaction.id,debitaccount_id,creditaccount_id,screen_details,remarks,product_id,customer_id,transDate,
    staff.name,staff.phoneno,
    account.accountName,gl_transaction.amount
     from gl_transaction
     left JOIN staff on gl_transaction.staff_id= staff.staffCode  left JOIN account on gl_transaction.creditaccount_id = account.acountCode
     WHERE gl_transaction.screen_details="salary" and gl_transaction.debitaccount_id is  null
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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

function getBillings()
{
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
     left JOIN account on gl_transaction.creditaccount_id = account.acountCode
     WHERE gl_transaction.screen_details="billing" and gl_transaction.debitaccount_id is  null
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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


function getTotalBillings()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT   count(screen_details) as totalnum,
    sum(gl_transaction.amount) as totalamount
     from gl_transaction
     left JOIN customer on gl_transaction.customer_id= customer.id LEFT JOIN product on  gl_transaction.product_id = product.id
     left JOIN account on gl_transaction.creditaccount_id = account.acountCode
     WHERE gl_transaction.screen_details="billing" and gl_transaction.debitaccount_id is  null
     ORDER by gl_transaction.id DESC;';
    $result = mysqli_query($conn, $sql);
    $data = [];
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
    $sql = "INSERT INTO `transactionaltracker` (`screen_details`) VALUES ( '" . $screen_details . "');";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        return array("message" => "New product created successfully", "refer_id" => $last_id);
    } else {
        return array("response" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
}
