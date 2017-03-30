<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 10:20 PM
 */


require_once("../db_error/database.php");

#Get the passed variables with POST
$course_id = $_POST["crs_id"];
$dep_id = $_POST['department_id'];

#Initiate Query to delete a row from the departments table
$query = $db->prepare("DELETE FROM courses
                       WHERE crs_ID = :course_id;");
#Execute and bind param through array
$query->execute(array(
    "course_id" => $course_id
));
$query->closeCursor();
header('Location:../manager_driver/index.php?department_id='.$dep_id);
exit();