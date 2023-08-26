<?php
require_once  "model/model.php";
require_once  "model/data_pro.php";


function saveCustomer(Customer $newcustomer)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $customername = $newcustomer->customername;
    $address = $newcustomer->address;
    $emailaddress = $newcustomer->emailaddress;
    $phoneno= $newcustomer->phoneno;


    $sql = "INSERT INTO customer (customername, address,emailaddress ,phoneno)
    VALUES ('$customername', '$address', '$emailaddress','$phoneno')";

    if ($conn->query($sql) === TRUE) {
        return array("message" => "New customer created successfully");
    } else {
        return array("message" => "Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
}
function getcustomers()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM customer";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        return array("message" => "failed to process");
    }
    mysqli_close($conn);
}
function findCustomerByName($customername)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT  * from customer where customername like ='%".$customername. "%'";
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
function findCustomerById($id)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT *  FROM customer WHERE id ='". $id ."' ";
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
function deleteCustomerID($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM customer WHERE id= '$id' ";
    if (mysqli_query($conn, $sql)) {
        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateCustomer(Customer $updateCustomer)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $customername = $updateCustomer->customername;
    $address = $updateCustomer->address;
    $emailaddress = $updateCustomer->emailaddress;
    $phoneno= $updateCustomer->phoneno;

    $sql = "UPDATE customer SET address='" . $address . "', customername='" . $customername . "', phoneno='" . $phoneno . "', emailaddress='" . $emailaddress . "' WHERE id='" . $updateCustomer->getID() . "'";
    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
