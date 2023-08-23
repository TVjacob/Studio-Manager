<?php

require "server/account.php";
require_once "globalfunc.php";





function addAccount()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newaccount = new Account(test_input($_POST['acountCode']), test_input($_POST['accountName']), test_input($_POST['account_type']), test_input($_POST['isincome']));
      echo json_encode(saveAccount($newaccount));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function accountupdateByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['id'];
      if ($editid != null) {
         $newaccount = new Account(test_input($_POST['acountCode']), test_input($_POST['accountName']), test_input($_POST['account_type']), test_input($_POST['isincome']));
         $newaccount->setID($editid);
         $feedback = updateAccount($newaccount);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }
}
function findaccounts()
{
   $accountds = accounts();
   echo json_encode($accountds);
}
function accountfindByID()
{
   if ($_GET['id'] != null) {
      $accountdu = findAccountById($_GET['id']);
      echo json_encode($accountdu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function accountfindByaccountcode($url)
{
   if ($_GET['accountCode'] != null) {
      $accountdu = findAccountBycode($_GET['accountCode']);
      echo json_encode($accountdu);
   // echo json_encode($_GET['accountCode'] );
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function accountdeleteByID()
{
   if ($_GET['acountCode'] != null) {
      $delaccount = deleteAccountID($_GET['acountCode']);
      echo json_encode($delaccount);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function findaccounttypes(){
   echo json_encode(accounttypes());
}
