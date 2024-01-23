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


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handles all GET requests
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    // student data after successfull login
    if ($_GET["url"] == "studentLoginSet") {

        if (!isset($_POST["studentIndexNumber"]) || empty($_POST["studentIndexNumber"]))
            die(json_encode(array("success" => false, "message" => "Invalid request!")));
    }

    // student data
    else if ($_GET["url"] == "studentData") {

        if (!isset($_POST["studentIndexNumber"]) || empty($_POST["studentIndexNumber"]))
            die(json_encode(array("success" => false, "message" => "Invalid request!")));
    }

    // student courses for the semester
    else if ($_GET["url"] == "semesterCourses") {

        if (!isset($_POST["studentIndexNumber"]) || empty($_POST["studentIndexNumber"]))
            die(json_encode(array("success" => false, "message" => "Invalid request!")));
    }
}

// Handles all POST requests
else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Admin handler

    if (isset($_GET["url"]) && !empty($_GET["url"]) && !empty($_POST)) {

        switch ($module) {
            case 'courseFetch':
                $config = require Base::build_path("config/database.php");
                die($config);
                $course = new Courses($config["database"]["mysql"]);
                $result = $course->fetchByDepartment(1);
                if (!empty($result)) die(array("success" => true, "data" => json_encode($result)));
                die(array("success" => false, "data" => "No result found!"));
                break;

            case 'class':
                switch ($action) {
                    case 'add':
                        die(array("success"));
                        break;
                }
                break;

            case 'program':
                switch ($action) {
                    case 'add':
                        die(array("success"));
                        break;
                }
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
} else {
    http_response_code(405);
}
