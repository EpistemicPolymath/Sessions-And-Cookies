<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/21/2017
 * Time: 10:40 PM
 */

#Require the database
require_once("../db_error/database.php");

//Get All From Departments
#Select all from departments and store in departments array (For use of Name and ID together in ForEach
$queryAllDepartments = $db->prepare("SELECT * 
                        FROM department");
$queryAllDepartments->execute();
$departments = $queryAllDepartments->fetchall();
$queryAllDepartments->closecursor();


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
    <h1 class="title">Department Manager</h1>
    <hr/>
    <h1>Department List</h1>

    <table>
        <tr>
            <th>Name</th>
            <!--Delete/Update-->
            <th></th>
        </tr>

        <?php foreach ($departments as $department) : ?>
            <tr>
                <td><?php echo $department['departmentName']; ?></td>
                <td>
                    <form action="../department/department_Delete.php" method="post">
                        <input type="hidden" name="department_id" value="<?= $department['departmentID'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="../manager_driver/department_update_from.php" method="post">
                        <input type="hidden" name="department_name" value="<?= $department['departmentName'] ?>">
                        <input type="hidden" name="department_id" value="<?= $department['departmentID'] ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
    <br/>

    <form action="../department/department_Insert.php" method="post">
        <h1>Add Department</h1>
        <label>Name: <input name='newDepartmentName' type='text'></label>
        <input type='submit' value='Add'/><br/><br/>

    </form><br />

    <a href="../manager_driver/index.php">List Courses</a> <br /> <br />


</main>
</body>
</html>