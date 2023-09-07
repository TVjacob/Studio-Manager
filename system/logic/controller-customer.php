<?php

require_once "server/customer.php";
require_once "globalfunc.php";

function addcustomer()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newcustomer = new Customer(test_input($_POST['customername']), test_input($_POST['address']), test_input($_POST['phoneno']), test_input($_POST['emailaddress']));
      echo json_encode(saveCustomer($newcustomer));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function customerupdateByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['id'];
      if ($editid != null) {
         $newcustomer =new Customer(test_input($_POST['customername']), test_input($_POST['address']), test_input($_POST['phoneno']), test_input($_POST['emailaddress']));
         $newcustomer->setID($editid);
         $feedback = updateCustomer($newcustomer);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }
}
function findcustomers()
{
   $studs = getcustomers();
   echo json_encode($studs);
}
function customerfindByID()
{
   if ($_GET['id'] != null) {
      $studu = findcustomerById($_GET['id']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function customerdeleteByID()
{
   // header("Delete",true,200);
   if ($_POST['id'] != null) {
      $delstu = deleteCustomerID($_POST['id']);
      echo json_encode($delstu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function findCustomersName()
{
   if ($_GET['customername'] != null) {
      $studu = findCustomerByName($_GET['customername']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
