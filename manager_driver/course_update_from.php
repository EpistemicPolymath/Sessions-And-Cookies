<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/21/2017
 * Time: 10:42 PM
 */

include_once("../db_error/database.php");

#Passing These as I may need them
$course_id = $_POST['crs_id'];
$course_code = $_POST['crs_code'];
$course_title = $_POST['crs_title'];
$course_credits = $_POST['crs_credits'];
$course_description = $_POST['crs_description'];
$department_id = $_POST['department_id'];


#Getting all Departments

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
    <h1 class="title">University Courses Manager</h1>
    <hr/>
    <h1>Update Course</h1>

    <form action="../course/course_Update.php" method="post">

        <label>Department: <select name="department">
                <?php foreach ($departments as $department) : ?>{

                    <?php if ($department['departmentID'] == $department_id) : ?>
                        <option selected='selected' value="<?= $department['departmentID'] ?>"><?= $department['departmentName'] ?></option>
                  <?php  else : ?>
                        <option value="<?= $department['departmentID'] ?>"><?= $department['departmentName'] ?></option>

                    }
                <?php endif; endforeach; ?>
            </select></label><br/>
        <label>Code:<input type="text" name="course_code" value="<?= $course_code ?>"></label><br/>
        <label>Title:<input type="text" name="course_title" value="<?= $course_title ?>"></label><br/>
        <label>Credits:<input type="text" name="course_credits" value="<?= $course_credits ?>"></label><br/><br/>
        <label>Description:<textarea name="course_description" rows="10" cols="50">
               <?= $course_description ?>
            </textarea></label><br/> <br/> <br/>
        <input type="hidden" name="crs_id" value="<?= $course_id ?>">

        <button type="submit">Update Course</button>
    </form>
    <br/>

    <a href="../manager_driver/index.php">View Courses List</a> <br/> <br/>

</main>
</body>
</html>
