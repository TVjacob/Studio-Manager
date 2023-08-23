<?php
require_once  "model/model.php";
require_once  "model/data_pro.php";


// this is the Studnet //               /
function   saveEnroll(Enroll $enrolled)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO enroll (student_id, term_id, term_end,term_start,amount) VALUES (?, ?, ?,?,?,?)");
    $stmt->bind_param("sssssss", $student_id, $term_id, $term_end, $term_start, $amount);

    // set parameters and execute
    $student_id = $enrolled->student_id;
    $term_id = $enrolled->term_id;
    $term_end = $enrolled->term_end;
    $term_start = $enrolled->term_start;
    $amount = $enrolled->amount;
   

    $stmt->execute();

    return array("message" => "saved");

    $stmt->close();
    $conn->close();
}
function enrollment()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM enroll";
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
function findEnrollByStudent($student_id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM enroll where student_id='$student_id'";
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
function findEnrollById($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `enroll` WHERE id = $id ";
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
function deleteEnrollID($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM enroll WHERE id= $id ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateEnroll(Enroll $enrolled)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $student_id = $enrolled->student_id;
    $term_id = $enrolled->term_id;
    $term_end = $enrolled->term_end;
    $term_start = $enrolled->term_start;
    $amount = $enrolled->amount;

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE enroll SET student_id='" . $student_id . "', term_id='" . $term_id . "', term_end='" . $term_end . "', term_start='" . $term_start . "', amount='" . $amount . "' WHERE id='" . $$enrolled->id . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
