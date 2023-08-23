<?php
require_once  "model/model.php";
require_once  "model/data_pro.php";



function create_User(User $newUser)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // $sql = "INSERT INTO user (username, lastname, email,islogged)
    // VALUES (?)";
    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged) VALUES (?, ?, ?,?)");
    $stmt->bind_param("sssb", $username, $password, $email, $islogged);

    // set parameters and execute
    $username = $newUser->getusername();
    $password = $newUser->getpassword();
    $email = $newUser->getemail();
    $islogged = $newUser->getislogged();

    $stmt->execute();

    return array("message" => "saved");

    $stmt->close();
    $conn->close();
}

function findUser()
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM user";
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
function findUsername($username)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM user where username='$username'";
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
function deleteByID($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "Delete  FROM user WHERE id= $userid ";
    // $result = mysqli_query($conn, $sql);

    if (mysqli_query($conn, $sql)) {

        return array("message" => "deleted successful");
    } else {
        return array("message" => "failed to delete");
    }
    mysqli_close($conn);
}

function getUserById($userid)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `user` WHERE id = $userid ";
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


function updateuser(User $updateUser)
{

    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $updateUser->getusername();
    $password = $updateUser->getpassword();
    $email = $updateUser->getemail();
    $islogged = $updateUser->getislogged();
    $theid = $updateUser->getID();

    // $stmt = $conn->prepare("INSERT INTO user (username, password, email,islogged,id) VALUES (?, ?, ?,?,?)");
    $sql = "UPDATE user SET username='" . $username . "', password='" . $password . "',email='" . $email . "',islogged='" . $islogged . "' WHERE id='" . $theid . "'";

    if (mysqli_query($conn, $sql)) {
        return array("message" => "Record updated successfully");
    } else {
        return array("message" => "Error updating record");
    }
    $conn->close();
}
// echo json_encode(getUserById(1));
// echo json_encode( deleteByID(2));
$jsonobj = '{"id":"3","username":"victor","password":"123456","email":"tv@gmail.com","tdate":"2023-08-03 22:39:59","islogged":"0"}';

$edit = json_decode($jsonobj);
$obj = new User($edit->username, $edit->password, $edit->email, $edit->islogged);
$obj->setID(4);
// echo json_encode(updateuser($obj));
// // echo json_encode(getusers());

function validateUSer($username,$u_pass)
{
    // Create connection
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM `user` WHERE username = '$username' and password= '$u_pass' ";
    $result = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        return $data;
    } else {
        return array("Message" => "not found");
    }

    mysqli_close($conn);
}
// echo json_encode(validateUSer('Admin', 'password'));


