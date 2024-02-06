<?php
include "../components/includes/connection.php";

// Set content type to JSON
header('Content-Type: application/json');

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve JSON data
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true); // true to get an associative array

    // Check if all required fields are present
    if (!isset($data['course'], $data['examName'], $data['instructions'], $data['mode'], $data['dateTime'], $data['timeLimit'], $data['numberOfQuestions'])) {
        $response['status'] = "error";
        $response['message'] = "Please provide all required fields";
    } else {
        // Retrieve form data
        $course = mysqli_real_escape_string($mysql_connection, $data['course']);
        $examName = mysqli_real_escape_string($mysql_connection, $data['examName']);
        $instructions = mysqli_real_escape_string($mysql_connection, $data['instructions']);
        $mode = mysqli_real_escape_string($mysql_connection, $data['mode']);
        $dateTime = mysqli_real_escape_string($mysql_connection, $data['dateTime']);
        $timeLimit = mysqli_real_escape_string($mysql_connection, $data['timeLimit']);
        $numberOfQuestions = mysqli_real_escape_string($mysql_connection, $data['numberOfQuestions']);

        // Perform validation if needed

        // Save data to the database
        $insertSql = "INSERT INTO exams (course_name, exam_name, instructions, mode, date_time, time_limit, number_of_questions)
                      VALUES ('$course', '$examName', '$instructions', '$mode', '$dateTime', '$timeLimit', '$numberOfQuestions')";

        if ($mysql_connection->query($insertSql) === TRUE) {
            $response['status'] = "success";
            $response['message'] = "Exam data saved successfully!";
        } else {
            $response['status'] = "error";
            $response['message'] = "Error saving exam data: " . $mysql_connection->error;
        }
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid request method";
}

// Encode the response as JSON and output
echo json_encode($response);
?>