<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 11:29 PM
 */


require_once("../db_error/database.php");

#Get Variables with POST
$course_id = $_POST['crs_id'];
$course_code = $_POST['course_code'];
$course_title = $_POST['course_title'];
$course_credits = $_POST['course_credits'];
$course_description = $_POST['course_description'];
$dep_id = $_POST['department'];



$updateQuery = $db->prepare("UPDATE courses
        SET crs_code = :course_code, 
        crs_title = :course_title, 
        crs_credits = :course_credits,
        dep_id = :dep_id,
        crs_description = :course_description
              
        WHERE crs_id = :course_id;");

$updateQuery->execute(array(
    ":course_code" => $course_code,
    ":course_title" => $course_title,
    ":course_credits" => $course_credits,
    ":dep_id" => $dep_id,
    ":course_description" => $course_description,
    ":course_id" => $course_id
));
$updateQuery->closeCursor();
header('Location:../manager_driver/index.php?department_id='.$dep_id);