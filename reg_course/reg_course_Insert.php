<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/26/2017
 * Time: 8:55 PM
 */

include_once('../db_error/database.php');


$crs_id = $_POST['crs_id'];
echo $crs_id;



#Create Database Query to Insert into courses
$query = $db->prepare("INSERT INTO reg_courses ( crs_ID )
        VALUES
        ( :crs_id );");
$query->execute(array(
    ":crs_id" => $crs_id
));
//header('Location:.../student_driver/registered_Courses');
//header('Location:../student_driver/registered_Courses?crs_ID='.$crs_id);
exit();
