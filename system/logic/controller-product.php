<?php

require_once "server/product.php";
require_once "globalfunc.php";





function addproduct()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newproduct = new Product(test_input($_POST['productname']), test_input($_POST['rate']), test_input($_POST['amount']));
      echo json_encode(saveProduct($newproduct));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function productupdateByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['id'];
      if ($editid != null) {
         $newproduct = new Product(test_input($_POST['productname']), test_input($_POST['rate']), test_input($_POST['amount']));
         $newproduct->setID($editid);
         $feedback = updateProduct($newproduct);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }
}
function findproducts()
{
   $studs = getproducts();
   echo json_encode($studs);
}
function productfindByID()
{
   if ($_GET['id'] != null) {
      $studu = findproductById($_GET['id']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function productdeleteByID()
{
   if ($_GET['id'] != null) {
      $delstu = deleteProductID($_GET['id']);
      echo json_encode($delstu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function findProductsName()
{
   if ($_GET['productname'] != null) {
      $studu = findProductByName($_GET['productname']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
