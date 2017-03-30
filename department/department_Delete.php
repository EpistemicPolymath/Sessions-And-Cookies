<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 6:36 PM
 */


require_once("../db_error/database.php");

#Get the passed variables with POST
$department_id = $_POST["department_id"];

#Initiate Query to delete a row from the departments table
$query = $db->prepare("DELETE FROM department
                       WHERE departmentID = :department_id;");
#Execute and bind param through array
$query->execute(array(
    "department_id" => $department_id
));
$query->closeCursor();
include("../manager_driver/department_list.php");
//header("location:../manager_driver/department_list.php");
