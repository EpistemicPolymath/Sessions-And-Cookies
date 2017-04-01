<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath (Jenn)
 * Date: 2/21/2017
 * Time: 10:40 PM
 */

#Start the session
session_start();

#Make sure page is only accessed by students
if (isset($_SESSION['userRole'])) {
    if ($_SESSION['userRole'] != 'student') {
        header("Location:../login.php");
        $errorResponse = "You do not have the valid permissions to view that page.";
    }
} else {
    header("Location:../login.php");
    $errorResponse = "User has unrecognized role.";
}

#Error Message for being sent back to login.php
if (isset($errorResponse)) {

    #If it is set we create the Session variable
    $_SESSION['errorResponse'] = $errorResponse;
    header("Location:../login.php");
}


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

//Get Departments that apply to specific user

#Check Sessions Department ID

if (isset($_SESSION['deptID'])) {

    $deptID = $_SESSION['deptID'];

}

$querySelectDepartments = $db->prepare("SELECT * 
                        FROM department
                        WHERE departmentID = :deptID");
$querySelectDepartments->execute(array(
    ":deptID" => $deptID
));
$department = $querySelectDepartments->fetchAll();
$querySelectDepartments->closeCursor();


// Select all Courses Depending on departmentID or selected department
$queryAllCourses = $db->prepare("SELECT *
                                FROM courses
                                WHERE dep_id = :departmentID
                                ORDER BY crs_ID");
# I use arrays within excute staments instead of bindParam
$queryAllCourses->execute(array(
    ':departmentID' => $departmentID
));
#Create an array of all of the courses for use (By using a fetchAll)
$courses = $queryAllCourses->fetchAll();
$queryAllCourses->closeCursor();


#Check if courses are already registered by specific user

#Check if isset
if (isset($_SESSION['userID'])) {

    $userID = $_SESSION['userID'];
}

$checkCoursesRegistered = $db->prepare("SELECT crs_ID FROM reg_courses
                                                WHERE userID = :userID");

$checkCoursesRegistered->execute(array(
    ":userID" => $userID
));
$checkCourses = $checkCoursesRegistered->fetchAll();


#Check if firstName isset

if (isset($_SESSION['firstName'])) {

    $firstname = $_SESSION['firstName'];
}

?>

<!DOCTYPE html>
<html>
<!-- the header section -->
<head>
    <title>My University Schema</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
</head>

<!-- the body section -->
<body>
<main>
    <h1 class="title">University Courses Manager</h1>
    <hr/>
    <h1>Welcome back, <?= $firstname ?> </h1> <br/>
    <section>
        <!-- Department Name -->

        <h2><?php echo $department_name; ?></h2>
        <!-- Display Table of Courses for each Department -->

        <table>
            <!-- Row Headings -->
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Credits</th>
                <th>Description</th>
                <!--Register-->
                <th></th>
            </tr>
            <!-- Row Data -->
            <?php foreach ($courses as $course) : ?>
                <tr>
                    <td><?php echo $course['crs_code']; ?></td>
                    <td><?php echo $course['crs_title']; ?></td>
                    <td><?php echo $course['crs_credits']; ?></td>
                    <td><?php echo $course['crs_description']; ?></td>
                    <!-- Allows Student to Register for Specific Course -->
                    <td>
                        <form action="../reg_course/reg_course_Insert.php" method="post">

                            <input type="hidden" name="crs_id" value="<?= $course['crs_ID'] ?>">
                            <!-- <input type="hidden" name="departmentID" value="<? // $departmentID ?>"> -->
                            <?php foreach ($checkCourses as $check) : ?>
                                <?php if ($check['crs_ID'] == $course['crs_ID']) : ?>
                                    <?php $checked = true; ?>
                                    <?php break; ?>
                                <?php else : ?>
                                    <?php $checked = false; ?>
                                    <?php continue; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- Determine which Register Button to Place down -->
                            <?php if ($checked == true) : ?>
                                <button type="submit" disabled>Register</button>
                            <?php else : ?>
                                <button type="submit">Register</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br/>

        <a href="../student_driver/registered_Courses.php">See Registered Courses</a><br/> <br/>
        <a href="../users/user_logout.php">Log Out</a>

    </section>
</main>

<footer>
    <!-- Empty footer -->

</footer>
</body>
</html>