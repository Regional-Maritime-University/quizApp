<?php

include("dataconn.php"); // Include your database configuration or connection file

session_start();

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming JSON data is sent
    $postData = json_decode(file_get_contents("php://input"), true);
    $action = $postData['action'] ?? '';

    if ($action === 'addQuiz') {
        handleAddQuizRequest($postData);
    }
    // Add more conditions as needed for other POST actions
}

// Functions related to POST requests
function handleAddQuizRequest()
{
    global $pdo;

    $quizData = array(
        'quizTitle' => filter_var($_POST['quizTitle'], FILTER_SANITIZE_STRING),
        'quizDescription' => filter_var($_POST['quizDescription'], FILTER_SANITIZE_STRING),
        'courseDropdown' => filter_var($_POST['courseDropdown'], FILTER_SANITIZE_STRING),
        'quizDate' => $_POST['quizDate'],
        'quizTime' => $_POST['quizTime'],
        'quizDuration' => $_POST['quizDuration'] ,
        'fk_course' => $_POST['fk_course'],
        'fk_staff' => $_POST['fk_staff']

    );

    $result = addQuizToDatabase($quizData, $pdo);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}
// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';

    if ($action === 'getQuizzes') {
        handleGetQuizzesRequest();
    }
    // Add more conditions as needed for other GET actions
}

// Close the database connection
$pdo = null;



// Functions related to GET requests
function handleGetQuizzesRequest()
{
    global $pdo;

    $quizzes = fetchQuizzesFromDatabase($pdo);

    header('Content-Type: application/json');
    echo json_encode($quizzes);
    exit();
}

function addQuizToDatabase($quizData, $pdo)
{
    try {
        $stmt = $pdo->prepare("INSERT INTO quizz (title, instruction, fk_course, start_date,start_time, duration,fk_staff,fk_semester)
                               VALUES (:quizTitle, :quizDescription, :course, :quizDate, :quizTime, :quizDuration,:fk_staff, :fk_semester)");

        $stmt->bindParam(':quizTitle', $quizData['quizTitle']);
        $stmt->bindParam(':quizDescription', $quizData['quizDescription']);
        $stmt->bindParam(':course', $quizData['courseDropdown']);
        $stmt->bindParam(':quizDate', $quizData['quizDate']);
        $stmt->bindParam(':quizTime', $quizData['quizTime']);
        $stmt->bindParam(':quizDuration', $quizData['quizDuration']); 
        $stmt->bindParam(':fk_staff', $quizData['fk_staff']);
        $stmt->bindParam(':fk_semester', $quizData['fk_semester']);


        $stmt->execute();

        return array("success" => true, "message" => "Quiz added successfully!");
    } catch (PDOException $e) {
        return array("success" => false, "message" => "Failed to add quiz: " . $e->getMessage());
    }
}

function fetchQuizzesFromDatabase($pdo)
{
    // Implement your logic to fetch quizzes from the database
    // This is a placeholder, replace it with your actual logic

    $quizzes = array(
        array("quiz_id" => 1, "quiz_title" => "Quiz 1", "course" => "Course A", "status" => "assigned"),
        array("quiz_id" => 2, "quiz_title" => "Quiz 2", "course" => "Course B", "status" => "completed"),
        // Add more quiz data as needed
    );

    return $quizzes;
}

?>
