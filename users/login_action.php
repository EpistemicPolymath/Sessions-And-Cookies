<?php
/**
 * Created by PhpStorm.
 * User: EpistemicPolymath
 * Date: 3/31/2017
 * Time: 12:01 PM
 */
session_start();

require_once('../db_error/database.php');


$username = $_POST['uname'];
$password = $_POST['psw'];

print_r($_POST);