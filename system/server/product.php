<?php
require_once  "model/model.php";
require_once  "model/data_pro.php";


function saveProduct(Product $newproduct)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $prodctname = $newproduct->productname;
    $rate = $newproduct->rate;
    $amount = $newproduct->amount;
    $units= $newproduct->units;


    $sql = "INSERT INTO product (productname, rate,amount ,units)
    VALUES ('$prodctname', '$rate', '$amount','$units')";

    if ($conn->query($sql) === TRUE) {
        return array("message" => "New product created successfully");
    } else {
        return array("message" => "Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
}
function getproducts()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM product";
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
function findProductByName($productname)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT  * from product where productname like ='%".$productname. "%'";
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
function findProductById($id)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT *  FROM product WHERE id ='". $id ."' ";
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
function deleteProductID($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM product WHERE id= '".$id. "' ";
    if (mysqli_query($conn, $sql)) {
        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateProduct(Product $updateProduct)
{
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $productname = $updateProduct->productname;
    $rate = $updateProduct->rate;
    $amount = $updateProduct->amount;
    $units= $updateProduct->units;

    $sql = "UPDATE product SET units='" . $units . "', productname='" . $productname . "', rate='" . $rate . "', amount='" . $amount . "' WHERE acountCode='" . $updateProduct->getID() . "'";
    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
