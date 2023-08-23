<?php
require_once  "model/model1.php";
require_once  "model/data_pro.php";



function saveterm(schoolTerm $termed)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $term_end = $termed->term_end;
    $term_start = $termed->term_start;
    $term_status = $termed->term_status;
    $sql = "INSERT INTO school_term (term_end,term_start,term_status)
    VALUES ('$term_end', '$term_start', '$term_status')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        if($term_status=="Active"){
       
        $sql = " update school_Term set term_status='InActive' where id<>'". $last_id . "'";
        $conn->query($sql) ;

        
    }
        return array("message" => "New record created successfully");
    } else {
        return array("message" => "Error: " . $sql . "<br>" . $conn->error);
    }
    $conn->close();
}
function terms()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM school_term";
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
function findtermById($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `school_term` WHERE id ='" . $id . "'";
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
function deleteSchoolTerm($id)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM school_term WHERE id= $id ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}
function updateterm(schoolTerm $schoolterm)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $term_end = $schoolterm->term_end;
    $term_start = $schoolterm->term_start;
    $term_status = $schoolterm->term_status;

    $sql = "UPDATE school_term SET  term_status='" . $term_status . "', term_end='" . $term_end . "', term_start='" . $term_start . "' WHERE id='" . $schoolterm->id . "'";

    if (mysqli_query($conn, $sql)) {
        if($term_status=="Active"){
       
            $sql = " update school_Term set term_status='InActive' where id<>'". $schoolterm->id . "'";
            $conn->query($sql) ;
    
            
        }
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
function searchActiveperiod()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `school_term` WHERE term_status ='Active'";
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