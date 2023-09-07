<?php
require_once  "model/model.php";
require_once "model/data_pro.php";

// this is the Studnet ///
function saveStaff(Staff $newstaff)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO Staff (name, dob, staffCode,address,role,phoneno,salary) VALUES (?, ?, ?,?,?,?,?)");
    $stmt->bind_param("ssssssi", $name, $dob, $staffCode, $address, $role, $phoneno, $salary);

    // set parameters and execute
    $name = $newstaff->get_name();
    $dob = $newstaff->get_Dob();
    $role = $newstaff->get_Role();
    $staffCode = $newstaff->get_Staffcode();
    $address = $newstaff->get_Address();
    $salary = $newstaff->get_Salary();
    $phoneno = $newstaff->get_Phone();

    $stmt->execute();

    return array("message" => "saved");

    $stmt->close();
    $conn->close();
}
function staffs()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM Staff";
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
function findstaffName($staffname)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM Staff where name='$staffname'";
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
function findstaffById($staffcode)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `staff` WHERE staffCode = '". $staffcode . "' ";
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
function deletestaffID($staffcode)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM staff WHERE staff.staffCode= '".$staffcode. "' ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updatestaff(Staff $newstaff)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = $newstaff->get_name();
    $dob = $newstaff->get_Dob();
    $role = $newstaff->get_Role();
    $staffCode = $newstaff->get_Staffcode();
    $address = $newstaff->get_Address();
    $salary = $newstaff->get_Salary();
    $phoneno = $newstaff->get_Phone();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE staff SET name='" . $name . "', dob='" . $dob . "', address='" . $address . "', role='" . $role . "', salary='" . $salary . "',phoneno='" . $phoneno . "',staffCode='" . $staffCode . "' WHERE staffCode='" . $staffCode . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
