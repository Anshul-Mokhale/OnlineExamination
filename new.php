<!DOCTYPE html>
<html>

<head>
    <title>New.php</title>
</head>

<body>
    <h1>Submitted Form Values:</h1>
    <ul>
        <?php
        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Loop through each submitted answer
            foreach ($_POST['answers'] as $sectionAnswers) {
                foreach ($sectionAnswers as $questionAnswer) {
                    // Print the answer
                    echo "<li>$questionAnswer</li>";
                }
            }
        } else {
            echo "<li>No form data submitted</li>";
        }
        ?>
    </ul>
</body>

</html>