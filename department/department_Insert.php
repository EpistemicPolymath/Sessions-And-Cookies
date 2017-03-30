<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 5:24 PM
 */

include_once('../db_error/database.php');

#Get variable name from the form POST
$newDepartmentName = $_POST["newDepartmentName"];

#Create Database Query to Insert into department
$query = $db->prepare("INSERT INTO department (departmentName)
        VALUES
        ( :newDepartmentName );");
$query->execute(array(
    ":newDepartmentName" => $newDepartmentName
));
$query->closeCursor();
include("../manager_driver/department_list.php");
//header("location:../manager_driver/department_list.php");
//header("location:department_list.php");
