<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath (Jenn)
 * Date: 2/21/2017
 * Time: 10:40 PM
 */

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
//print_r($department);


//Get All From Departments
#Select all from departments and store in departments array (For use of Name and ID together in ForEach
$queryAllDepartments = $db->prepare("SELECT * 
                        FROM department");
$queryAllDepartments->execute();
$departments = $queryAllDepartments->fetchall();
$queryAllDepartments->closecursor();
//print_r($departments);


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
    <h1>Courses List</h1>
    <aside>
        <!-- Display a list of Departments -->
        <h2>Departments</h2>
        <nav>
            <ul>    <!-- Loop through fetchall of Departments and list each by ID and Name -->
                <?php foreach ($departments as $department) : ?>
                    <li>
                        <a href="?departmentID=<?php echo $department['departmentID']; ?>">
                            <?php echo $department['departmentName']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </aside>

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
                           <!-- <input type="hidden" name="departmentID" value="<?// $departmentID ?>"> -->

                            <button type="submit">Register</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br/>

        <a href="../student_driver/registered_Courses.php">See Registered Courses</a>

    </section>
</main>

<footer>
    <!-- Empty footer -->

</footer>
</body>
</html>