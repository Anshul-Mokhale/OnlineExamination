<?php
include "../components/includes/connection.php";

// Retrieve the raw POST data
$data = file_get_contents("php://input");

// Decode the JSON data into a PHP array
$formData = json_decode($data, true);

// Extract form data
$examName = $formData['examName'];
$paragraph = $formData['paragraph'];
$question = $formData['question'];
$choiceA = $formData['choiceA'];
$choiceB = $formData['choiceB'];
$choiceC = $formData['choiceC'];
$choiceD = $formData['choiceD'];
$correctAnswer = $formData['correctAnswer'];

$response = array();

try {
    // Check if table exists for the provided examName
    $tableName = "question_" . $examName;
    $checkTableExistsQuery = "SHOW TABLES LIKE '$tableName'";
    $result = $mysql_connection->query($checkTableExistsQuery);

    if ($result->num_rows == 0) {
        // Table does not exist, create it dynamically
        $createTableQuery = "CREATE TABLE $tableName (
            qid INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            paragraph TEXT,
            question VARCHAR(255),
            choiceA VARCHAR(255),
            choiceB VARCHAR(255),
            choiceC VARCHAR(255),
            choiceD VARCHAR(255),
            correctAnswer VARCHAR(255)
        )";
        $mysql_connection->query($createTableQuery);
    }

    // Insert data into the table
    $insertQuery = "INSERT INTO $tableName (paragraph, question, choiceA, choiceB, choiceC, choiceD, correctAnswer) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysql_connection->prepare($insertQuery);
    $stmt->bind_param("sssssss", $paragraph, $question, $choiceA, $choiceB, $choiceC, $choiceD, $correctAnswer);
    $stmt->execute();

    // Construct response
    $response['success'] = true;
    $response['message'] = "Question Added successfully!";
} catch (Exception $e) {
    // Construct error response
    $response['success'] = false;
    $response['message'] = "Insertion failed: " . $e->getMessage();
}

// Set content type to application/json
header('Content-Type: application/json');

// Encode response array to JSON and echo it
echo json_encode($response);
?>