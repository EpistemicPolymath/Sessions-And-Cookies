<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 10:20 PM
 */

session_start();
require_once("../db_error/database.php");

#Check userID Session Variable
if(isset($_SESSION['userID'])){

    $userID = $_SESSION['userID'];
}

#Get the passed variables with POST
$course_id = $_POST["crs_id"];

#Initiate Query to delete a row from the departments table
$query = $db->prepare("DELETE FROM reg_courses
                       WHERE crs_ID = :course_id AND userID = :userID");
#Execute and bind param through array
$query->execute(array(
    "course_id" => $course_id,
    ":userID" => $userID
));
header('Location:../student_driver/registered_Courses.php');
exit();