<?php

use Controller\Programs;
use Controller\Students;

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

    elseif ($module === "class") :
        $class = new Classes($config["database"]["mysql"]);

        switch (key($_GET)):
            case 'department':
                $result = $class->fetchByDepartment($_GET["department"]);
                $feed = Validator::SendResult($result, $result, "Class not found!");
                die(json_encode($feed));

            case 'class':
                $result = $class->fetchByCode($_GET["class"]);
                $feed = Validator::SendResult($result, $result, "Class not found!");
                die(json_encode($feed));

            default:
        endswitch;


    elseif ($module === "student") :
        $student = new Students($config["database"]["mysql"]);

        switch (key($_GET)):
            case 'department':
                $result = $student->fetchByDepartment($_GET["department"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            case 'student':
                $result = $student->fetchByIndexNumber($_GET["student"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));



            default:
        endswitch;

    // elseif ($module ===  'lecturer') :

    elseif ($module ===  'program') :
        $program = new Programs($config["database"]["mysql"]);

        switch (key($_GET)):
            case 'department':
                $result = $program->fetchByDepartment($_GET["department"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));

            case 'program':
                $result = $program->fetchByCode($_GET["program"]);
                $feed = Validator::SendResult($result, $result, "Staff details not found!");
                die(json_encode($feed));



            default:
        endswitch;


    elseif ($module ===  'course') :
        $course = new Courses($config["database"]["mysql"]);
        // $result = $course->fetchByDepartment(1);
        // if (!empty($result)) die(array("success" => true, "data" => json_encode($result)));
        // die(array("success" => false, "data" => "No result found!"));

        switch (key($_GET)):
            case 'course':
                $result = $course->fetchByCode($_GET["course"]);
                $feed = Validator::SendResult($result, $result, "Course details not found!");
                die(json_encode($feed));



            default:
        endswitch;

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

                    // Accessing user data
                    $mname = $_SESSION["user"]["middle_name"];
                    $lname = $_SESSION["user"]["last_name"];
                    $fname = $_SESSION["user"]["first_name"];

                    // $email = $_SESSION["user"]["email"];
                    $role = $_SESSION["user"]["role"];
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
        $lecturer = new Lecturers($config["database"]["mysql"]);

        switch ($action):

            case 'add':
                $result = $lecturer->add($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, "New staff added!", "Failed to add staff!");
                // die(json_encode($feed));

            case 'edit':
                $result = $lecturer->edit($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to edit staff information!");
                // die(json_encode($feed));

            case 'archive':
                $result = $lecturer->archive($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to archive staff information!");
                // die(json_encode($feed));

            case 'delete':
                $result = $lecturer->remove($_POST);
                $feed = Validator::SendResult($result, $result, "Failed to remove staff information!");
                die(json_encode($feed));

            default:
                # code...
                break;
        endswitch;

    elseif ($module === 'student') :
        $student = new Students($config["database"]["mysql"]);

        switch ($action):

            case 'add':
                $result = $student->add($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, "New staff added!", "Failed to add staff!");
                // die(json_encode($feed));

            case 'edit':
                $result = $student->edit($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to edit staff information!");
                // die(json_encode($feed));

            case 'archive':
                $result = $student->archive($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to archive staff information!");
                // die(json_encode($feed));

            case 'delete':
                $result = $student->remove($_POST);
                $feed = Validator::SendResult($result, $result, "Failed to remove staff information!");
                die(json_encode($feed));

            default:
                # code...
                break;
        endswitch;


    elseif ($module === 'class') :
        $classes = new Classes($config["database"]["mysql"]);

        switch ($action):

            case 'add':
                $result = $classes->add($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, "New staff added!", "Failed to add staff!");
                // die(json_encode($feed));

            case 'edit':
                $result = $classes->edit($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to edit staff information!");
                // die(json_encode($feed));

            case 'archive':
                $result = $classes->archive($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to archive staff information!");
                // die(json_encode($feed));

            case 'delete':
                $result = $classes->remove($_POST);
                $feed = Validator::SendResult($result, $result, "Failed to remove staff information!");
                die(json_encode($feed));

            default:
                # code...
                break;
        endswitch;




    elseif ($module === 'program') :
        $programs = new Programs($config["database"]["mysql"]);

        switch ($action):

            case 'add':
                $result = $programs->add($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, "New staff added!", "Failed to add staff!");
                // die(json_encode($feed));

            case 'edit':
                $result = $programs->edit($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to edit staff information!");
                // die(json_encode($feed));

            case 'archive':
                $result = $programs->archive($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to archive staff information!");
                // die(json_encode($feed));

            case 'delete':
                $result = $programs->remove($_POST);
                $feed = Validator::SendResult($result, $result, "Failed to remove staff information!");
                die(json_encode($feed));

            default:
                # code...
                break;
        endswitch;




    elseif ($module === 'course') :
        $course = new Courses($config["database"]["mysql"]);

        switch ($action):

            case 'add':
                $result = $course->add($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, "New staff added!", "Failed to add staff!");
                // die(json_encode($feed));

            case 'edit':
                $result = $course->edit($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to edit staff information!");
                // die(json_encode($feed));

            case 'archive':
                $result = $course->archive($_POST);
                die(json_encode($result));
                // $feed = Validator::SendResult($result, $result, "Failed to archive staff information!");
                // die(json_encode($feed));

            case 'delete':
                $result = $course->remove($_POST);
                $feed = Validator::SendResult($result, $result, "Failed to remove staff information!");
                die(json_encode($feed));

            default:
                # code...
                break;
        endswitch;

    elseif ($module === 'class') :

    endif;

endif;
