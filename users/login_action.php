<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 3/31/2017
 * Time: 12:01 PM
 */

#Start Session
session_start();

#Require The Database
require_once('../db_error/database.php');

#Get user's username and password from login.php form
$username = $_POST['username'];
$password = $_POST['pass'];

//Users Table Query
#Select all users from users table that have the same username and password as the login
$usersSelectQuery = $db->prepare("SELECT * FROM users
                                          WHERE userName = :username AND password = :password");
$usersSelectQuery->execute(array(
    ":username" => $username,
    ":password" => $password
));
$userSelect = $usersSelectQuery->fetch();
//$usersSelectQuery->closeCursor();

#Now we have an array of Users that the Select Query Matched...
#If the array is > 0, or in other words the Select Query found a match we set the $_SESSIONS

if ($userSelect > 0) {
# We are adding Session variables for the userName, role, and ID
    $_SESSION['userName'] = $userSelect['userName'];
    $_SESSION['userRole'] = $userSelect['role'];
    $_SESSION['userID'] = $userSelect['userID'];

# Now we need an if statement to check role and determine which homepage to send them to
    if($userSelect['role'] == 'manager'){
        header("Location:../manager_driver/index.php");
    } elseif($userSelect['role'] == 'student'){
        header("Location:../student_driver/student_home.php");
    }else{
        header("Location:../login.php");
        $errorResponse = "User has unrecognized role.";
    }
} else {

    $errorResponse = "Username and Password were not found.";
}

#In above IF statement two different types of error messages can be set.