<?php

require_once "server/staff.php";
require_once "globalfunc.php";





function addstaff()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newstud = new Staff(test_input($_POST['name']), test_input($_POST['staffCode']), test_input($_POST['role']),test_input($_POST['dob']),test_input($_POST['address']), test_input($_POST['salary']), test_input($_POST['phoneno']));
      echo json_encode(saveStaff($newstud));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function staffupdateByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['staffCode'];
      if ($editid != null) {
         $editstu = new Staff(test_input($_POST['name']), test_input($_POST['staffCode']), test_input($_POST['dob']), test_input($_POST['address']), test_input($_POST['salary']), test_input($_POST['phoneno']), test_input($_POST['role']));
         $editstu->set_staffCode($editid);
         $feedback = updatestaff($editstu);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }
}
function findstaffs()
{
   $studs = staffs();
   echo json_encode($studs);
}
function stafffindByID()
{
   if ($_GET['staffCode'] != null) {
      $studu = findstaffById($_GET['staffCode']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function staffdeleteByID()
{
   if ($_GET['studentCode'] != null) {
      $delstu = deleteStudentID($_GET['studentCode']);
      echo json_encode($delstu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
