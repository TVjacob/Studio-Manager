<?php

$str = "C:/Users/USER/OneDrive/Desktop/bob/system/";
require_once "server/student.php";
require_once "server/Enroll.php";
require_once "globalfunc.php";





function addstudent()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newstud = new Student(test_input($_POST['name']), test_input($_POST['studentCode']), test_input($_POST['sclass']), test_input($_POST['dob']), test_input($_POST['address']), test_input($_POST['parents']), test_input($_POST['phoneno']));
      echo json_encode(saveStudent($newstud));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function studentupdateByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['studentCode'];
      if ($editid != null) {
         $editstu = new Student(test_input($_POST['name']), test_input($_POST['studentCode']), test_input($_POST['sclass']), test_input($_POST['dob']), test_input($_POST['address']), test_input($_POST['parents']), test_input($_POST['phoneno']));
         $editstu->set_StudnetCode($editid);
         $feedback = updateStudent($editstu);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }
}
function findstudents()
{
   $studs = students();
   echo json_encode($studs);
}
function studentfindByID()
{
   if ($_GET['studentCode'] != null) {
      $studu = findstudentById($_GET['studentCode']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function studentdeleteByID()
{
   if ($_GET['studentCode'] != null) {
      $delstu = deleteStudentID($_GET['studentCode']);
      echo json_encode($delstu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}

function enrollStudent(){
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newstud = new Enroll(test_input($_POST['term_end']), test_input($_POST['term_start']), test_input($_POST['amount']), test_input($_POST['student_id']), test_input($_POST['term_id']));
      echo json_encode(saveEnroll($newstud));
   } else {
      echo json_encode(array("message" => "Not Post"));
   } 
}
function enrollments(){
   enrollment();
}

function editEnrollment(){
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['id'];
      if ($editid != null) {
         $editstu = new Enroll(test_input($_POST['term_end']), test_input($_POST['term_start']), test_input($_POST['amount']), test_input($_POST['student_id']), test_input($_POST['term_id']));
         $editstu->setID($editid);
         $feedback = updateEnroll($editstu);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannotupdate this type of post "));
   }  
}
function findEnrolledStudent(){
   if ($_GET['studentCode'] != null) {
      $studu = findEnrollByStudent($_GET['studentCode']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   } 
}
function findEnrollId(){
   if ($_GET['id'] != null) {
      $studu = findstudentById($_GET['id']);
      echo json_encode($studu);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}