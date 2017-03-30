<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 7:27 PM
 */

require_once("../db_error/database.php");

#Get Variables with POST
$departmentName = $_POST['departmentName'];
$department_id = $_POST['department_id'];


$updateQuery = $db->prepare("UPDATE department
        SET departmentName =  :departmentName
              
        WHERE departmentID = :department_id;");

$updateQuery->execute(array(
    ":departmentName" => $departmentName,
    ":department_id" => $department_id
));
$updateQuery->closeCursor();
include("../manager_driver/department_list.php");
//header("location:../manager_driver/department_list.php");
//header("location:department_list.php");


