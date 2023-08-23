<?php
$str = "C:/Users/USER/OneDrive/Desktop/bob/system/";
require_once  "model/model1.php";
require_once "model/data_pro.php";

// define("SERVERNAME", $servername);
// define("USERNAME", $dbusername);
// define("PASSWORD", $dbpassword);
// define("DB_NAME", $dbname);




// this is the Studnet ///
function saveStudent(Student $studentcode)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO student (name, sclass, dob,studentCode,address,parents,phoneno) VALUES (?, ?, ?,?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $sclass, $dob, $studentCode, $address, $parents, $phoneno);

    // set parameters and execute
    $name = $studentcode->name;
    $sclass = $studentcode->sclass;
    $dob = $studentcode->dob;
    $studentCode = $studentcode->get_StudnetCode();
    $address = $studentcode->address;
    $parents = $studentcode->parents;
    $phoneno = $studentcode->phoneno;

    $stmt->execute();

    return array("message" => "saved");

    $stmt->close();
    $conn->close();
}

function students()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM student";
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
function findStudentName($studentname)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM student where name='$studentname'";
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

function findstudentById($studentCode)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = 'SELECT * FROM student WHERE studentCode = "'. $studentCode .'"';
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

function deleteStudentID($studentCode)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM student WHERE id= $studentCode ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}

function updateStudent(Student $updateStudent)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = $updateStudent->name;
    $sclass = $updateStudent->sclass;
    $dob = $updateStudent->dob;
    $studentCode = $updateStudent->get_StudnetCode();
    $address = $updateStudent->address;
    $parents = $updateStudent->parents;
    $phoneno = $updateStudent->phoneno;

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE student SET name='" . $name . "', phoneno='" . $phoneno . "', address='" . $address . "', parents='" . $parents . "', sclass='" . $sclass . "',dob='" . $dob . "',studentCode='" . $studentCode . "' WHERE studentCode='" . $studentCode . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
