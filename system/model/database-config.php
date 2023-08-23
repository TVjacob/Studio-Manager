<?php
require_once 'data_pro.php';


// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS kayeDB";
if ($conn->query($sql) === TRUE) {
    // echo "Database created successfully";
} else {
    // echo "Error creating database: " . $conn->error;
}

$conn->close();
?>

<?php

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE  TABLE IF NOT EXISTS `user` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` varchar(30) NOT NULL,
    `password` varchar(30) NOT NULL,
    `email` varchar(50) DEFAULT NULL,
    `tdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `islogged` BOOLEAN  DEFAULT NULL
  );
  ";
if ($conn->query($sql) === TRUE) {
    // echo "Table User created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}

//////////////////////////

$sql = "CREATE  TABLE IF NOT EXISTS `accounttype` (
    `id` varchar(11) NOT NULL  PRIMARY KEY,
    `name` varchar(30) NOT NULL,
    `accountcode` INT(11),
    `isincome` varchar(11),
    `balanceSheet` BOOLEAN
  );
  ";
if ($conn->query($sql) === TRUE) {
    // echo "Table User created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}




// $conn->close();
// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS`product` (
  `id`INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
  `productname` varchar(6)  NULL,
  `rate` INT(12) ,
  amount DOUBLE
);
";

if ($conn->query($sql) === TRUE) {
    // echo "Table User created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}

// $conn->close();


$sql = "CREATE TABLE IF NOT EXISTS`Staff` (
    `staffCode` varchar(11) NOT NULL  PRIMARY KEY,
    `dob` DATE ,
     address varchar(30)  NULL,
    `role` varchar(30)  NULL,
    phoneno varchar(24) NULL,
    `name` varchar(24) NOT NULL,
    salary DOUBLE

  );
  ";

if ($conn->query($sql) === TRUE) {
    // echo "Table User created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}

//   $conn->close();


$sql = "CREATE TABLE IF NOT EXISTS`transaction` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `debitaccount_id` varchar(6) NOT NULL,
    `creditaccount_id` varchar(6) NOT NULL,
    `details` varchar(30)  NULL,
    `remarks` varchar(30)  NULL,
    `staff_id` varchar(30)  NULL,
    `product_id` varchar(30)  NULL,
    `term_id` varchar(30) NOT  NULL,
    `transDate` DATE NOT NULL,
     amount DOUBLE
  );
  ";

if ($conn->query($sql) === TRUE) {
    // echo "Table User created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}

//   $conn->close();



// $sql = "CREATE TABLE IF NOT EXISTS`expense` (
//     `id` INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
//     `debitaccount_id` varchar(6) NOT NULL,
//     `creditaccount_id` varchar(6) NOT NULL,
//     `details` varchar(30)  NULL,
//     `remarks` varchar(30)  NULL,
//     `staff_id` varchar(30)  NULL,
//     `student_id` varchar(30)  NULL,
//     `term_id` varchar(30) NOT NULL,
//     `transDate` DATE NOT NULL,
//      amount DOUBLE 
//   );
//   ";

// if ($conn->query($sql) === TRUE) {
//     // echo "Table User created successfully";
// } else {
//     // echo "Error creating table: " . $conn->error;
// }

// //   $conn->close();




// $sql = "CREATE TABLE IF NOT EXISTS`generalTransaction` (
//     `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
//     `account_id` varchar(6) NOT NULL,
//     `details` varchar(30)  NULL,
//     `remarks` varchar(30)  NULL,
//     `staff_id` varchar(30)  NULL,
//     `student_id` varchar(30)  NULL,
//     `term_id` varchar(30) NOT NULL,
//     `transDate` DATE NOT NULL,
//      amount DOUBLE, 
//      reference_id varchar(30) NULL,
//      transtype varchar(5) NOT NULL

//   );
//   ";

// if ($conn->query($sql) === TRUE) {
//     // echo "Table User created successfully";
// } else {
//     // echo "Error creating table: " . $conn->error;
// }

// //   $conn->close();

// $sql = "CREATE TABLE IF NOT EXISTS`enroll` (
//     `id` INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
//     `student_id` varchar(30)  NULL,
//     `term_id` varchar(30) NOT NULL,
//     `term_end` DATE NOT NULL,
//      amount DOUBLE, 
//      `term_start` DATE NOT NULL
//   );
//   ";

// if ($conn->query($sql) === TRUE) {
//     // echo "Table User created successfully";
// } else {
//     // echo "Error creating table: " . $conn->error;
// }

// $sql = "CREATE TABLE IF NOT EXISTS`school_term` (
//     `id` INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
//     `term_status` varchar(30)  NULL,
//     `term_end` DATE NOT NULL, 
//      `term_start` DATE NOT NULL
//   );
//   ";

// if ($conn->query($sql) === TRUE) {
//     // echo "Table User created successfully";
// } else {
//     // echo "Error creating table: " . $conn->error;
// }

//   $conn->close();

$sql = "CREATE TABLE IF NOT EXISTS`account` (
    `id` INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    `acountCode` INT(30)  NOT NULL,
    `accountName` varchar(30) NOT NULL,
    `isincome` varchar(11)  NULL,
    `account_type` varchar(30) NOT NULL
   
  );
  ";

if ($conn->query($sql) === TRUE) {
    // echo "Table User created successfully";
} else {
    // echo "Error creating table: " . $conn->error;
}


function configUser($conn)
{
    // $sql = "ALTER TABLE `account` ADD UNIQUE(`acountCode`);";
    $sql = "ALTER TABLE `account` ADD UNIQUE (`acountCode`);";
    if ($conn->query($sql) === TRUE) {
        // echo "Table User created successfully";
    }
}
$sql = "select * from user";
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) <= 0) {
    configUser($conn);
    $sql = "INSERT INTO `user` (`id`, `username`, `password`, `email`, `tdate`, `islogged`) VALUES (NULL, 'Admin', '1234', 'jacobvictortendo@gmail.com', current_timestamp(), NULL);";

    if ($conn->query($sql) === TRUE) {
        // echo "Table User created successfully";
    }
} else {

    // echo "Error creating table: " . $conn->error;
}
//////////////////


/////////////////



$sql = "select * from accounttype";
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) <= 0) {

    $sql = "INSERT INTO `accounttype` (`id`, `name`, `isincome`, `balanceSheet`, `accountcode`) VALUES 
('ACA', 'ASSET CURRENT	(CASH/BANK)', null, true, '1000'),
('ACU', 'ASSETS/CURRENT(OTHER)', null, true, '1200'),
('AFI', 'ASSETS FIXED', false, null, '1400'),
('CPT', 'CAPITAL/WORKING FUND', null, true, '2000'),
('LIC', 'LIABILITY(CURRENT)', null, true, '4000'),
('LIO', 'LIABILITY(OTHER)', null, true, '4200'),
('NML', 'NORMINAL', true, null, '6000')
;";

    if ($conn->query($sql) === TRUE) {
        // echo "Table User created successfully";
    }
}



$conn->close();
?>

