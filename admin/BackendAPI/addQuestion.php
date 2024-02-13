<?php
include "../components/includes/connection.php";
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON data sent from the form
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract data from the JSON object
    // Extract data from the JSON object
    $examName = mysqli_real_escape_string($mysql_connection, $data['examName']);
    $section = mysqli_real_escape_string($mysql_connection, $data['section']);
    $description = mysqli_real_escape_string($mysql_connection, $data['paragraph']);
    $question = mysqli_real_escape_string($mysql_connection, $data['question']);
    $choices = mysqli_real_escape_string($mysql_connection, json_encode($data['choices'])); // Convert choices array to JSON string
    $correctAnswer = mysqli_real_escape_string($mysql_connection, $data['correctAnswer']);
    $explanation = mysqli_real_escape_string($mysql_connection, $data['explanation']);


    // Check if the question table exists
    $checkTableQuery = "SHOW TABLES LIKE 'question_$examName'";
    $tableResult = $mysql_connection->query($checkTableQuery);

    // If the question table does not exist, create it
    if ($tableResult->num_rows == 0) {
        $createTableQuery = "CREATE TABLE question_$examName (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            exam_id INT(6) UNSIGNED,
            description TEXT,
            question TEXT,
            choices TEXT,
            correct_answer VARCHAR(255),
            explanation TEXT,
            section INT(11)
        )";

        if ($mysql_connection->query($createTableQuery) === TRUE) {
            echo json_encode(["message" => "Table question_$examName created successfully"]);
        } else {
            echo json_encode(["error" => "Error creating table: " . $mysql_connection->error]);
        }
    }

    // Insert data into the question table
    $insertQuery = "INSERT INTO question_$examName (exam_id, description, question, choices, correct_answer, explanation, section)
                    VALUES ('$examName', '$description', '$question', '$choices', '$correctAnswer', '$explanation', '$section')";

    if ($mysql_connection->query($insertQuery) === TRUE) {
        echo json_encode(["status" => "success", "message" => "New record created successfully"]);
    } else {
        echo json_encode(["status" => "failed", "error" => "Error: " . $insertQuery . "<br>" . $mysql_connection->error]);
    }

    $mysql_connection->close();
}
?>