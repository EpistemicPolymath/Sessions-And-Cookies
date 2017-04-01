<?php

#Initiatie the Session
session_start();

#Require the database so that we can use the $db variable to reach the database
#This is setup in database.php
require_once("../db_error/database.php");

#Grabbing Necessary Components from Database

// Get Department ID for displaying particular department information
$departmentID = filter_input(INPUT_GET, 'departmentID', FILTER_VALIDATE_INT);
#If departmentID is null or false set it to the default value 1 which is Engineering
if ($departmentID == NULL || $departmentID == FALSE) {
    $departmentID = 1;
}

// Get name for currently selected Department
#Query calls for all elements from department table that match the current departmentID from GET
$queryDepartments = "SELECT * FROM department
                      WHERE departmentID = :departmentID";
$queryDepartmentName = $db->prepare($queryDepartments);
$queryDepartmentName->execute(array(
    'departmentID' => $departmentID
));
#Fetches from the query and places in arry department
$department = $queryDepartmentName->fetch();
#Takes the current DepartmentName from the Query and stores as an isolated variable
$department_name = $department['departmentName'];
$queryDepartmentName->closeCursor();


////Get All From Departments
//#Select all from departments and store in departments array (For use of Name and ID together in ForEach
//$queryAllDepartments = $db->prepare("SELECT *
//                        FROM department");
//$queryAllDepartments->execute();
//$departments = $queryAllDepartments->fetchall();
//$queryAllDepartments->closecursor();
////print_r($departments);
//
//
//// Select all Courses Depending on departmentID or selected department
//$queryAllCourses = $db->prepare("SELECT *
//                                FROM courses
//                                WHERE dep_id = :departmentID
//                                ORDER BY crs_ID");
//# I use arrays within excute staments instead of bindParam
//$queryAllCourses->execute(array(
//    ':departmentID' => $departmentID
//));
//#Create an array of all of the courses for use (By using a fetchAll)
//$courses = $queryAllCourses->fetchAll();
//$queryAllCourses->closeCursor();


////Select Courses From Reg_Courses that correspond to crs_id
//#Get crs_id
//
//$crs_id = filter_input(INPUT_GET, 'crs_id', FILTER_VALIDATE_INT);

#Check if Sessions userID isset
if (isset($_SESSION['userID'])) {

    $userID = $_SESSION['userID'];

}

#Check Sessions Department ID

if(isset($_SESSION['deptID'])){

    $deptID = $_SESSION['deptID'];

}


#Initiate Database Query for Student's Registered Courses
$queryStudentCourses = $db->prepare("SELECT DISTINCT c.crs_ID, c.crs_code, c.crs_title, c.crs_credits, c.crs_description, c.dep_id
                                              FROM courses c INNER JOIN reg_courses r ON (c.crs_ID = r.crs_ID)
                                                             INNER JOIN users u ON (r.userID = u.userID)
                                              WHERE r.userID = :userID");

$queryStudentCourses->execute(array(
    ":userID" => $userID
));
$studentCourses = $queryStudentCourses->fetchAll();

?>

<html>
<link rel="stylesheet" type="text/css" href="../css/styles.css"/>

<h1>My Courses</h1>
<hr/>


<table>
    <tr>
        <th>Code</th>
        <th>Title</th>
        <th>Credits</th>
        <th>Description</th>
        <!--Drop-->
        <th></th>
    </tr>

    <?php foreach ($studentCourses as $course) : ?>
        <tr>
            <td><?php echo $course['crs_code']; ?></td>
            <td><?php echo $course['crs_title']; ?></td>
            <td><?php echo $course['crs_credits']; ?></td>
            <td><?php echo $course['crs_description']; ?></td>

            <td>
                <!-- Allows Student to Unregister From Course -->
                <form action="../reg_course/reg_course_Delete.php" method="post">
                    <input type="hidden" name="crs_id" value="<?= $course['crs_ID'] ?>">

                    <button type="submit">Drop</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br/>


<a href="../student_driver/student_home.php?departmentID=<?= $deptID ?>">Back To Registration</a>

</html>
