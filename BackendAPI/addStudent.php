<?php

include "../components/includes/connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jsonData = json_decode($_POST['data'], true);

    // Now you can access the data using $jsonData['key']
    $name = $jsonData['name'];
    $email = $jsonData['email'];
    $phone = $jsonData['phoneNumber'];
    $password = $jsonData['password'];
    $gender = $jsonData['gender'];
    $courses = json_encode($jsonData['courses']); // Serialize the array to JSON
    $birthDate = $jsonData['birthDate'];
    $address = $jsonData['address'];

    // Perform your processing and storage logic here

    // Example: Inserting into the 'students' table
    $insertQuery = "INSERT INTO students (name, email, phone, password, gender, birth_date, address, courses, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $mysql_connection->prepare($insertQuery);

    if ($stmt) {
        $stmt->bind_param("ssssssss", $name, $email, $phone, $password, $gender, $birthDate, $address, $courses);
        $stmt->execute();
        $stmt->close();

        $mysql_connection->close();

        // Send a response back to the client (for example, a success message)
        echo json_encode(['status' => 'success', 'message' => 'Student Register Successfully']);
    } else {
        // Handle the error
        echo json_encode(['status' => 'error', 'message' => 'Error in prepared statement']);
    }

} else {
    // Handle other request methods or invalid requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>