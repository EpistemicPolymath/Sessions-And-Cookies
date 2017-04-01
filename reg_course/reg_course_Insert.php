<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 8:55 PM
 */

session_start();
include_once('../db_error/database.php');

#Check to see if the userID session variable isset
if(isset($_SESSION['userID'])){
    $userID = $_SESSION['userID'];
}

#Get crs_id from POST
$crs_id = $_POST['crs_id'];

#Create Database Query to Insert into courses
$query = $db->prepare("INSERT INTO reg_courses ( crs_ID, userID )
        VALUES
        ( :crs_id, :userID );");
$query->execute(array(
    ":crs_id" => $crs_id,
    ":userID" => $userID
));
header('Location:../student_driver/registered_Courses.php');
//header("Location:../student_driver/registered_Courses.php?crs_ID=" . $crs_id. "&userID=" . $userID);

exit();
