<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 2/21/2017
 * Time: 10:41 PM
 */

#Get variables from the form POST

$departmentName = $_POST['department_name'];
$department_id = $_POST['department_id'];

?>

<!DOCTYPE html>
<html>
<!-- the header section -->
<head>
    <title>University Courses Manager</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css"/>
</head>

<!-- the body section -->
<body>
<main>
    <h1 class="title">University Courses Manager</h1>
    <hr/>
    <h1>Update Department</h1>
    <form action="../department/department_Update.php" method="post">
        <label>Department Name:<input type="text" name="departmentName" value="<?= $departmentName ?>"></label>
        <input type="hidden" name="department_id" value="<?= $department_id ?>"> <br /> <br />
        <button type="submit">Update Department</button>
    </form> <br /> <br />
    <a href="../manager_driver/department_list.php">View Department List</a><br /> <br />
</main>
</body>
</html>

