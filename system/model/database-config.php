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
    
} else {
    
}


// sql to create table
$sql = "CREATE  TABLE IF NOT EXISTS `customer` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `customername` varchar(30) NOT NULL,
    `address` varchar(30) DEFAULT NULL,
    `phoneno` varchar(50) DEFAULT NULL,
    `emailaddress` varchar(50) DEFAULT NULL
  );
  ";
if ($conn->query($sql) === TRUE) {
    
} else {
    
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
    
} else {
    
}





// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS`product` (
  `id`INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
  `productname` varchar(10) NOT  NULL,
  `units` varchar(8)  NULL,
  `rate` INT(12) ,
  amount DOUBLE
);
";

if ($conn->query($sql) === TRUE) {
    
} else {
    
}




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
    
} else {
    
}




$sql = "CREATE TABLE IF NOT EXISTS`gl_transaction` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `debitaccount_id` varchar(10) Default NULL,
    `creditaccount_id` varchar(10) Default NULL,
    `screen_details` varchar(30)  NULL,
    `remarks` varchar(30)  NULL,
    `staff_id` varchar(30)  NULL,
    `customer_id` varchar(30)  NULL,
    `reference_id` varchar(30)  NULL,
    `product_id` varchar(30)  NULL,
    `transDate` DATE NOT NULL,
     amount DOUBLE
  );
  ";

if ($conn->query($sql) === TRUE) {
    
} else {
    
}


$sql = "CREATE TABLE IF NOT EXISTS`transactionaltracker` (
    `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `screen_details` varchar(30)  NULL
  );
  ";

if ($conn->query($sql) === TRUE) {
} else {
}

$sql = "CREATE TABLE IF NOT EXISTS`account` (
    `id` INT(11) NOT NULL AUTO_INCREMENT  PRIMARY KEY,
    `acountCode` INT(30)  NOT NULL,
    `accountName` varchar(30) NOT NULL,
    `isincome` varchar(11)  NULL,
    `account_type` varchar(30) NOT NULL
   
  );
  ";

if ($conn->query($sql) === TRUE) {
    
} else {
    
}


function configUser($conn)
{
    // $sql = "ALTER TABLE `account` ADD UNIQUE(`acountCode`);";
    $sql = "ALTER TABLE `account` ADD UNIQUE (`acountCode`);";
    if ($conn->query($sql) === TRUE) {
        
    }
}
$sql = "select * from user";
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) <= 0) {
    configUser($conn);
    $sql = "INSERT INTO `user` (`id`, `username`, `password`, `email`, `tdate`, `islogged`) VALUES (NULL, 'Admin', '1234', 'jacobvictortendo@gmail.com', current_timestamp(), NULL);";

    if ($conn->query($sql) === TRUE) {
        
    }
} else {

    
}
//////////////////


function makecustomerNameUnquie($conn)
{
    // $sql = "ALTER TABLE `account` ADD UNIQUE(`acountCode`);";
    $sql = "ALTER TABLE `customer` ADD UNIQUE (`customername`);";
    if ($conn->query($sql) === TRUE) {
        
    }
}
$sql = "select * from customer";
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) <= 0) {
    makecustomerNameUnquie($conn);
} else {
}
/////////////////



$sql = "select * from accounttype";
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) <= 0) {

    $sql = "INSERT INTO `accounttype` (`id`, `name`, `isincome`, `balanceSheet`, `accountcode`) VALUES 
('ACA', 'ASSET CURRENT	(CASH/BANK)', null, true, '1004'),
('ACU', 'ASSETS/CURRENT(OTHER)', null, true, '1200'),
('AFI', 'ASSETS FIXED', false, null, '1407'),
('CPT', 'CAPITAL/WORKING FUND', null, true, '2000'),
('LIC', 'LIABILITY(CURRENT)', null, true, '4000'),
('LIO', 'LIABILITY(OTHER)', null, true, '4200'),
('NML', 'NORMINAL', true, null, '6005')
;";

    if ($conn->query($sql) === TRUE) {
        
    }
}


$sql = "select * from account";
$result = mysqli_query($conn, $sql);
$data = array();
if (mysqli_num_rows($result) <= 0) {

    $sql = "INSERT INTO `account` ( `acountCode`, `accountName`, `isincome`, `account_type`) VALUES
    ( 1400, 'Camera', 'NULL', 'AFI'),
    ( 1401, 'Lights', 'NULL', 'AFI'),
    ( 1402, 'Computer', 'NULL', 'AFI'),
    ( 1403, 'Printer', 'NULL', 'AFI'),
    ( 1404, 'Background', 'NULL', 'AFI'),
    ( 1405, 'Furniture', 'NULL', 'AFI'),
    ( 1003, 'Income Receivable', 'NULL', 'ACA'),
    ( 1000, 'Cash', 'NULL', 'ACA'),
    ( 1001, 'MobileMoney', 'NULL', 'ACA'),
    ( 6000, 'Income', 'Income', 'NML'),
    ( 6001, 'Rent', 'Expense', 'NML'),
    ( 6002, 'Salaries', 'Expense', 'NML'),
    ( 6003, 'Food Expense', 'Expense', 'NML'),
    ( 6004, 'transports', 'Expense', 'NML');";

    if ($conn->query($sql) === TRUE) {
        
    }
}








$conn->close();
?>

