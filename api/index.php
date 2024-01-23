<?php
session_start();
/*
* Designed and programmed by
* @Author: Francis A. Anlimah
*/


require "../bootstrap.php";

use Core\Base;
use Core\Validator;
use Controller\Courses;
use Controller\Staff;


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$fullUrl = $_SERVER["REQUEST_URI"];
$urlParse = parse_url($fullUrl, PHP_URL_PATH);
$urlPath = str_replace("/quizApp/api/", "", $urlParse);
$separatePath = explode("/", $urlPath);
$resourceRequested = count($separatePath);

if ($resourceRequested !== 2) Base::abort();

$module = $separatePath[0];
$action = $separatePath[1];

// Handles all GET requests
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    //Staff
    if (!isset($_GET["staffID"]) || empty($_GET["staffID"]))
        die(json_encode(array("success" => false, "message" => "Invalid request!")));
}

// Handles all POST requests
else if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $config = require Base::build_path("config/database.php");

    switch ($module) {

        case 'staff':

            switch ($action) {
                case 'login':
                    $staff = new Staff($config["database"]["mysql"]);
                    $result = $staff->login($_POST["email"], $_POST["password"]);

                    if (!$result) die(json_encode(array("success" => false, "message" => "Account not found!")));

                    $_SESSION["isLoggedIn"] = true;
                    unset($result["password"]);
                    $_SESSION["user"] = $result;

                    die(json_encode(array("success" => true, "message" => "Login successful!", "data" => $result["role"])));
                    break;

                default:
                    # code...
                    break;
            }

            break;

        case 'lecturer':

            break;

        case 'program':

            break;

        case 'course':
            $course = new Courses($config["database"]["mysql"]);
            $result = $course->fetchByDepartment(1);
            if (!empty($result)) die(array("success" => true, "data" => json_encode($result)));
            die(array("success" => false, "data" => "No result found!"));
            break;

        case 'class':

            break;
    }
}

// student login
if ($_GET["url"] == "studentLogin") {
    if (!isset($_SESSION["_start"]) || !isset($_POST["_logToken"]) || empty($_SESSION["_start"]) || empty($_POST["_logToken"]))
        die(json_encode(array("success" => false, "message" => "Missing required parameters!")));
    if ($_POST["_logToken"] !== $_SESSION["_start"]) die(json_encode(array("success" => false, "message" => "Invalid request!")));
    if (!isset($_POST["index_number"])) die(json_encode(array("success" => false, "message" => "Missing input: Index number is required!")));
    if (!isset($_POST["password"])) die(json_encode(array("success" => false, "message" => "Missing input: Password is required!")));

    $index_number = Validator::validateIndexNumber($_POST["index_number"]);
    $password = Validator::validatePassword($_POST["password"]);
    $result = $user->loginStudent($index_number, $password);

    if (!$result) {
        $_SESSION['isLoggedIn'] = true;
        die(json_encode(array("success" => false, "message" => "Incorrect index number or password! ")));
    }

    $_SESSION['studentIndexNumber'] = $result["index_number"];
    $_SESSION['isLoggedIn'] = true;

    die(json_encode(array("success" => true, "message" => "Login successfull!")));
}

// Register courses
else if ($_GET["url"] == "registerCourses") {
}
