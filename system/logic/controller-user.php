<?php
require "server/user.php";
require "globalfunc.php";





function saveUser()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $feedback = findUsername($_POST['username']);
      if ($feedback['message'] == null) {
         $saveUser = new User(test_input($_POST['username']), test_input($_POST['password']), test_input($_POST['email']), false);

         echo json_encode(create_User($saveUser));
      } else {
         echo json_encode(array("message" => "Username Exits"));
      }
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function userupdateByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['id'];
      if ($editid != null) {
         $userupdate = new User(test_input($_POST['username']), test_input($_POST['password']), test_input($_POST['email']), test_input($_POST['islogged']));
         $userupdate->setID($editid);
         $feedback = updateuser($userupdate);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }
}
function findUsers()
{
   $allusers = findUser();
   echo json_encode($allusers);
}
function userfindByID()
{
   if ($_GET['id'] != null) {
      $theuser = getUserById($_GET['id']);
      echo json_encode($theuser);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function userdeleteByID()
{
   if ($_GET['id'] != null) {
      $theuser = deleteByID($_GET['id']);
      echo json_encode($theuser);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function authicateUSer()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      echo json_encode(validateUSer(test_input($_POST['username']), test_input($_POST['password'])));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
