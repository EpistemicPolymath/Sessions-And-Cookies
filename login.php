<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 3/29/2017
 * Time: 5:00 PM
 */


session_start();

#Check if the Session error response was set and display it on page.
if (isset($_SESSION['errorResponse'])) {
    $errorResponse = $_SESSION['errorResponse'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>My University Schema-Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css"/>
</head>

<body>

<h2>Login Form</h2>

<div class="errorMessageContainer container">

    <?php

    if(isset($errorResponse)){

        echo "$errorResponse";
        unset($_SESSION['errorResponse']);
    }

    ?>
</div>

<form action="users/login_action.php" method="post">
    <div class="imgcontainer">
        <img src="img/unc-charlotte-logo.gif" alt="UNCC Logo">
    </div>

    <div class="container">
        <label><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>

        <label><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="pass" required>

        <button type="submit">Login</button>
        <input type="checkbox" name="checkbox" checked="checked"> Remember me
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" class="cancelbtn">Cancel</button>
        <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
    </div>
</form>

</body>
</html>

