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
$department_id = filter_input(INPUT_GET, 'department_id', FILTER_VALIDATE_INT);
#If departmentID is null or false set it to the default value 1 which is Engineering
if ($department_id == NULL || $department_id == FALSE) {
    $department_id = 1;
}

// Get name for currently selected Department
#Query calls for all elements from department table that match the current department_id from GET
$queryDepartments = "SELECT * FROM department
                      WHERE departmentID = :department_id";
$queryDepartmentName = $db->prepare($queryDepartments);
$queryDepartmentName->execute(array(
    'department_id' => $department_id
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


// Select all Courses Depending on department_id or selected department
$queryAllCourses = $db->prepare("SELECT *
                                FROM courses
                                WHERE dep_id = :department_id
                                ORDER BY crs_ID");
# I use arrays within excute staments instead of bindParam
$queryAllCourses->execute(array(
    ':department_id' => $department_id
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
                        <a href="?department_id=<?php echo $department['departmentID']; ?>">
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
            <tr>
                <th>Code</th>
                <th>Title</th>
                <th>Credits</th>
                <th>Description</th>
                <!--Delete-->
                <th></th>
                <!--Update-->
                <th></th>
            </tr>

            <?php foreach ($courses as $course) : ?>
                <tr>
                    <td><?php echo $course['crs_code']; ?></td>
                    <td><?php echo $course['crs_title']; ?></td>
                    <td><?php echo $course['crs_credits']; ?></td>
                    <td><?php echo $course['crs_description']; ?></td>

                    <td>
                        <form action="../course/course_Delete.php" method="post">
                            <input type="hidden" name="crs_id" value="<?= $course['crs_ID'] ?>">
                            <input type="hidden" name="department_id" value="<?= $department_id ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>

                    <td>
                        <form action="../manager_driver/course_update_from.php" method="post">
                            <input type="hidden" name="crs_id" value="<?= $course['crs_ID'] ?>">
                            <input type="hidden" name="crs_code" value="<?= $course['crs_code'] ?>">
                            <input type="hidden" name="crs_title" value="<?= $course['crs_title'] ?>">
                            <input type="hidden" name="crs_credits" value="<?= $course['crs_credits'] ?>">
                            <input type="hidden" name="crs_description" value="<?= $course['crs_description'] ?>">
                            <input type="hidden" name="department_id" value="<?= $department_id ?>">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br/>

        <a href="../manager_driver/course_Insert_Form.php?department_id=<?= $department_id ?>">Add Course</a> <br/>
        <br/>
        <a href="../manager_driver/department_list.php">List Departments</a><br /> <br />
        <a href="../users/user_logout.php">Log Out</a>

    </section>
</main>

<footer>
    <!-- Empty footer -->

</footer>
</body>
</html>