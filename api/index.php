<?php
session_start();
/*
* Designed and programmed by
* @Author: Francis A. Anlimah
*/


require "../bootstrap.php";

use Controller\Classes;
use Core\Base;
use Core\Validator;
use Controller\Courses;
use Controller\Lecturers;
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

$module = $separatePath[0];

$config = require Base::build_path("config/database.php");

// Handles all GET requests
if ($_SERVER['REQUEST_METHOD'] === "GET") :

    if ($module === "lecturer") :
        $staff = new Lecturers($config["database"]["mysql"]);

        switch (key($_GET)):
            case 'department':
                $result = $staff->fetchByDepartment($_GET["department"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            case 'staff':
                $result = $staff->fetchByStaffNumber($_GET["staff"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            default:
        endswitch;

    elseif ($module ===  'class') :
        $classObj = new Classes($config["database"]["mysql"]);

        switch (key($_GET)):
            case 'department':
                $result = $classObj->fetchByDepartment($_GET["department"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            case 'program':
                $result = $classObj->fetchByProgram($_GET["program"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            case 'code':
                $result = $classObj->fetchByCode($_GET["code"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            default:
        endswitch;

    elseif ($module ===  'lecturer') :

    elseif ($module ===  'program') :

    elseif ($module ===  'course') :
        $course = new Courses($config["database"]["mysql"]);
        $result = $course->fetchByDepartment(1);
        if (!empty($result)) die(array("success" => true, "data" => json_encode($result)));
        die(array("success" => false, "data" => "No result found!"));

    elseif ($module ===  'class') :

    endif;

// Handles all POST requests
elseif ($_SERVER['REQUEST_METHOD'] === "POST") :
    $action = $separatePath[1];

    if ($module === 'staff') :
        $staff = new Staff($config["database"]["mysql"]);

        switch ($action):

            case 'login':
                $result = $staff->login($_POST["email"], $_POST["password"]);
                $feed = Validator::SendResult($result, "Login successful!", "Account not found!");

                if ($feed["success"]) :
                    $_SESSION["isLoggedIn"] = true;
                    unset($result["password"]);
                    $_SESSION["user"] = $result;
                endif;

                die(json_encode($feed));

            case 'assign':
                $result = $staff->assignCourse($_POST);
                $feed = Validator::SendResult($result, $result, "Account not found!");
                die(json_encode($feed));

            default:
                # code...
                break;
        endswitch;


    elseif ($module === 'lecturer') :


    elseif ($module === 'program') :


    elseif ($module === 'course') :
        $course = new Courses($config["database"]["mysql"]);
        $result = $course->fetchByDepartment(1);
        if (!empty($result)) die(array("success" => true, "data" => json_encode($result)));
        die(array("success" => false, "data" => "No result found!"));

    elseif ($module === 'class') :

    endif;

endif;

// student login
/*if ($_GET["url"] == "studentLogin") {
    if (!isset($_SESSION["_start"]) || !isset($_POST["_logToken"]) || empty($_SESSION["_start"]) || empty($_POST["_logToken"]))
        die(json_encode(array("success" => false, "message" => "Missing required parameters!")));
    if ($_POST["_logToken"] !== $_SESSION["_start"]) die(json_encode(array("success" => false, "message" => "Invalid request!")));
    if (!isset($_POST["index_number"])) die(json_encode(array("success" => false, "message" => "Missing input: Index number is required!")));
    if (!isset($_POST["password"])) die(json_encode(array("success" => false, "message" => "Missing input: Password is required!")));

    $index_number = Validator::IndexNumber($_POST["index_number"]);
    $password = Validator::Password($_POST["password"]);
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
}*/
