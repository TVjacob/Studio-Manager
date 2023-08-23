<?php

require_once "server/schoolTerm.php";
require_once "globalfunc.php";



function addTerm()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $newTerm = new schoolTerm(test_input($_POST['term_status']), test_input($_POST['term_end']), test_input($_POST['term_start']));
      echo json_encode(saveterm($newTerm));
   } else {
      echo json_encode(array("message" => "Not Post"));
   }
}
function updateTermByID()
{
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $editid  = $_POST['id'];
      if ($editid != null) {
         $newTerm = new schoolTerm(test_input($_POST['term_status']), test_input($_POST['term_end']), test_input($_POST['term_start']));
         $newTerm->id=$editid;
         $feedback = updateterm($newTerm);
         echo json_encode($feedback);
      } else {
         echo json_encode(array("message" => "failed to find the id "));
      }
   } else {
      echo json_encode(array("message" => "Cannot update this type of post "));
   }
}
function getTerms()
{
   $schoolTerms = terms();
   echo json_encode($schoolTerms);
}
function findschoolTermByID()
{
   if ($_GET['id'] != null) {
      $schoolterm = findtermById($_GET['id']);
      echo json_encode($schoolterm);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function deleteSchoolTermByID()
{
   if ($_GET['id'] != null) {
      $schoolTerm = deleteSchoolTerm($_GET['id']);
      echo json_encode($schoolTerm);
   } else {
      echo json_encode(array("message" => "failed to find the id "));
   }
}
function activePeriod(){
   echo json_encode(searchActiveperiod());
}