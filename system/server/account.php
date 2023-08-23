<?php
require_once  "model/model.php";
require_once  "model/data_pro.php";


function saveAccount(Account $newaccount)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // $stmt = $conn->prepare("INSERT INTO account (acountCode, accountName, account_type,isincome) VALUES (?, ?, ?,?");
    // $stmt->bind_param("ssss", $acountCode, $accountName, $account_type,$isincome);

    // set parameters and execute
    $acountCode = $newaccount->acountCode;
    $accountName = $newaccount->accountName;
    $account_type = $newaccount->account_type;
    $isincome = $newaccount->isincome;


    $sql = "INSERT INTO account (acountCode, accountName, account_type,isincome)
    VALUES ('$acountCode', '$accountName', '$account_type','$isincome')";

    if ($conn->query($sql) === TRUE) {
       $code= generateaccountCode($account_type);
        return array("message" => "New record created successfully","Code"=>$code);
    } else {
        return array("message" => "Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
}
function accounttypes()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM accounttype";
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
function generateaccountCode($id)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    $code=0;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM accounttype where id ='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $row = $result->fetch_assoc();
        // echo $row;

        $code = $row['accountcode']+1;
        
        $sql = "update accounttype set accountcode='$code' where id='$id';";
        mysqli_query($conn, $sql);
        return $code;
    } else {
        return   $code;
    }
    mysqli_close($conn);
}


function accounts()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT account.acountCode, account.id,account_type,account.isincome,account.accountName,accounttype.name,accounttype.balanceSheet,(account.isincome) as pl from account INNER JOIN accounttype on accounttype.id= account.account_type;";
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
function findAccountBycode($acountCode)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT  account.id,account.acountCode,account.isincome, accounttype.name,account.account_type,account.accountName FROM account inner join accounttype on account.account_type = accounttype.id where account.acountCode='".$acountCode. "'";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        return array("message" => "failed to process");
    }
    mysqli_close($conn);
}

function findAccountById($accountcode)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT SELECT *, accounttype.name,accounttype.id FROM account inner join accounttype on account.accounttype = accounttype.id WHERE account.id = $accountcode ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
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

function deleteAccountID($accountcode)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM account WHERE id= $accountcode ";
    if (mysqli_query($conn, $sql)) {
        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}

function updateAccount(Account $updateAccount)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $acountCode = $updateAccount->acountCode;
    $accountName = $updateAccount->accountName;
    $account_type = $updateAccount->account_type;
    $isincome = $updateAccount->isincome;

    $editid = $updateAccount->getID();
    $sql = "UPDATE account SET isincome='" . $isincome . "', acountCode='" . $acountCode . "', accountName='" . $accountName . "', account_type='" . $account_type .  "' WHERE acountCode='" . $acountCode . "'";
    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
function getaccountCode($id)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT *  FROM `accounttype` WHERE id = $id ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
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
