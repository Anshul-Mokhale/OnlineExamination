<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";
    if (isset($_GET['id'], $_GET['sec'])) {
        $id = $_GET['id'];
        $sec = $_GET['sec'];
    } else {
        header("location: exam.php");
    }
} else {
    $msg = "";
    if (isset($_GET['id'], $_GET['sec'])) {
        $id = $_GET['id'];
        $sec = $_GET['sec'];
    } else {
        // $id = "";
        header("location: exam.php");
    }
}

?>
<style>
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .pupup {
        display: none;
        /* Initially hide the popup */
        position: fixed;
        /* Position the popup relative to the viewport */
        top: 50%;
        /* Position the top edge of the popup at 50% from the top of the viewport */
        left: 50%;
        /* Position the left edge of the popup at 50% from the left of the viewport */
        transform: translate(-50%, -50%);
        /* Center the popup both horizontally and vertically */
        background-color: white;
        /* Set the background color of the popup */
        padding: 20px;
        /* Add padding to the popup content */
        border: 1px solid #ccc;
        /* Add a border around the popup */
        border-radius: 5px;
        /* Add rounded corners to the popup */
        z-index: 2999;
        /* Set a higher z-index to ensure the popup appears above other elements */
        width: 90%;
        /* Set the width of the popup to 90% of the viewport width */
        max-width: 500px;
        /* Set a maximum width for the popup to prevent it from becoming overly wide */
        max-height: 80%;
        /* Set a maximum height for the popup */
        overflow-y: auto;
        /* Allow vertical scrolling when the content exceeds the maximum height */
        opacity: 0;
        /* Initially set the opacity to 0 */
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Add transition effects for opacity and transform */
        transform-origin: center;
        /* Set the transform origin to the center of the popup */
    }


    .overlay.active,
    .pupup.active {
        display: block;
        opacity: 1;
    }

    .pupup.active {
        transform: translate(-50%, -50%) scale(1);
    }

    .table-responsive {
        overflow-x: auto !important;
    }

    .selected-values {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        flex-wrap: wrap;
    }

    .selected-value {
        margin: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
    }

    .remove-icon {
        margin-left: 5px;
        cursor: pointer;
    }

    .selected-values {
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: flex;
        flex-wrap: wrap;
    }

    .selected-value {
        margin: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border-radius: 20px;
        display: flex;
        align-items: center;
    }

    .remove-icon {
        margin-left: 5px;
        cursor: pointer;
    }

    .scroll-top-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        /* Initially hide the button */
        z-index: 9999;
        /* Set a high z-index to ensure it appears above other elements */
    }
</style>
<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <?php
                if ($msg) {
                    echo "
            <section>                   
              <div class='container-fluid'>
                <div class='row'>
                  " . $msg . "
                </div>
              </div>
            </section>
            ";
                }
                ?>
                <section>
                    <div class='container-fluid'>
                        <div class='row' id="message">

                        </div>
                    </div>
                </section>
                <?php
                $sqee = "SELECT name FROM sections WHERE sr = '$sec' AND id = '$id'";
                $resulutees = $mysql_connection->query($sqee);
                if ($resulutees->num_rows > 0) {
                    $rowses = $resulutees->fetch_assoc();
                    // echo "<h3>" . $rowses['name'] . "</h3>";
                }
                ?>
                <div class="overlay"></div> <!-- Dark overlay -->
                <div class="pupup">
                    <div class="modal-content">
                        <div class="col stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $va = "";
                                    $sqq = "SELECT exam_name FROM exams WHERE id = '$id'";
                                    $resu = $mysql_connection->query($sqq);
                                    if ($resu && $resu->num_rows > 0) {
                                        $rew = $resu->fetch_assoc();
                                        $va = $rew['exam_name'];
                                        echo "<h4 class='card-title'>Add question for " . $rew['exam_name'] . "</h4>";
                                    } else {
                                        echo "<h4 class='card-title'>Exam not found</h4>";
                                    }
                                    ?>

                                    <!-- <p class="card-description"> Basic form elements </p> -->
                                    <form id="myForm" class="forms-sample">
                                        <input type="number" value="<?= $id ?>" id="examName" style="display:none;">
                                        <input type="number" value="<?= $sec ?>" id="section" style="display:none;">
                                        <div class="form-group">
                                            <label for="Paragraph">Description</label>
                                            <textarea class="form-control" id="Paragraph" rows="4"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="Question">Question</label>
                                            <input type="text" class="form-control" id="Question"
                                                placeholder="Enter Question">
                                        </div>
                                        <!-- Choices -->
                                        <div class="choices-container">
                                            <div class="form-group choice-group">
                                                <label for="CHA">Choice A</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input type="checkbox" class="answer-checkbox"
                                                                name="correct-answer" value="A">
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control choice"
                                                        placeholder="Enter Option A">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Add Button for New Choices -->
                                        <div class="form-group">
                                            <button type="button" id="addChoiceBtn" class="btn btn-sm btn-secondary">Add
                                                Choice</button>
                                        </div>
                                        <!-- Correct Answer -->
                                        <div class="form-group">
                                            <label for="Explanation">Explanation</label>
                                            <textarea class="form-control" id="Explanation"
                                                placeholder="Enter Explanation" rows="2"></textarea>
                                        </div>
                                        <button type="submit" id="submitForm"
                                            class="btn btn-gradient-primary me-2">Submit</button>
                                        <!-- Close Button -->
                                        <button type="button" id="closeForm"
                                            class="btn btn-danger cancel-btn">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-header">
                    <h3 class="page-title">
                        <a href="addSection.php?id=<?= $id ?>" class="txt-primary"
                            style="font-size: 30px !important;"><i class="mdi mdi-arrow-left"></i></a>
                    </h3>

                    <h3>
                        <?= $rowses['name'] ?>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="#" class="page-title-icon bg-gradient-primary text-white me-2 mark"
                                    id="addSectionBtn">Add Questions
                                    <i class="mdi mdi-pencil"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <?php
                    $quest = "SELECT * FROM question_$id WHERE exam_id = '$id' AND section = '$sec'";
                    try {
                        $result = $mysql_connection->query($quest);
                        $i = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Extract question details from the row
                                $description = nl2br($row['description']);
                                $question = $row['question'];
                                $choices = json_decode($row['choices'], true);
                                $correct_answer = $row['correct_answer'];
                                $explanation = $row['explanation'];

                                // Output question HTML
                                ?>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="card-title">
                                                    <?= $i ?>. Description:
                                                </h5>
                                                <button class="btn btn-danger btn-sm deleteBtn"
                                                    data-id="<?= $row['id'] ?>">Delete</button>
                                            </div>
                                            <p class="card-text">
                                                <?php echo $description; ?>
                                            </p>
                                            <p class="card-text"><strong>Question:</strong>
                                                <?php echo $question; ?>
                                            </p>
                                            <p class="card-text"><strong>Choices:</strong></p>
                                            <ul>
                                                <?php
                                                foreach ($choices as $choice) {
                                                    if ($choice !== "") {
                                                        echo "<li>$choice</li>";
                                                    }

                                                }
                                                ?>
                                            </ul>
                                            <p class="card-text"><strong>Answer:</strong>
                                                <?php echo $correct_answer; ?>
                                            </p>
                                            <p class="card-text"><strong>Explanation:</strong>
                                                <?php echo $explanation; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                        } else {
                            echo "<div class='col-lg-12'><p>No questions found.</p></div>";
                        }
                    } catch (mysqli_sql_exception $e) {
                        echo "<div class='col-lg-12'><p>Nothing found!</p></div>";
                    }
                    ?>
                </div>
                <button id="scrollTopBtn" class="btn btn-primary scroll-top-btn" title="Go to top"><i
                        class="mdi mdi-arrow-up"></i></button>




                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>

                    $(document).ready(function () {
                        // Function to handle add section button click
                        $('#addSectionBtn').click(function (event) {
                            event.preventDefault();
                            $('.pupup').addClass('active');
                            $('.overlay').addClass('active');
                            // Reset form fields if needed
                            // Example: $('#inputSecton').val('');
                        });

                        // Function to handle edit section button clicks


                        // Function to handle cancel button click
                        $('.cancel-btn').click(function () {
                            $('.pupup').removeClass('active');
                            $('.overlay').removeClass('active');
                        });

                        // Add event listener to the "Add Choice" button
                        $('#addChoiceBtn').click(function () {
                            // Increment the choice counter and get the corresponding letter (A, B, C, etc.)
                            var choiceLabel = String.fromCharCode(65 + $('.choice-group').length);

                            // Create a new choice input field with checkbox
                            var newChoiceInput = $('<div>').addClass('form-group choice-group').html(
                                '<label for="CH' + choiceLabel + '">Choice ' + choiceLabel + '</label>' +
                                '<div class="input-group">' +
                                '<div class="input-group-prepend">' +
                                '<div class="input-group-text">' +
                                '<input type="checkbox" class="answer-checkbox" name="correct-answer" value="' + choiceLabel + '">' +
                                '</div>' +
                                '</div>' +
                                '<input type="text" class="form-control choice" placeholder="Enter Option ' + choiceLabel + '">' +
                                '</div>'
                            );

                            // Append the new choice input field to the choices container
                            $('.choices-container').append(newChoiceInput);
                        });

                        // Handle form submission
                        $('#submitForm').click(function () {
                            event.preventDefault();
                            // Get values from form fields
                            var examName = $('#examName').val();
                            var section = $('#section').val(); // Make sure there is an input field with ID 'section'
                            var paragraph = $('#Paragraph').val();
                            var question = $('#Question').val();
                            var choices = [];
                            var correctAnswer = ''; // Update variable name to match JSON key

                            // Iterate through each choice input
                            var isAtLeastOneChecked = false; // Flag to track if at least one checkbox is checked
                            $('.choice-group').each(function () {
                                var choice = $(this).find('.choice').val();
                                var isChecked = $(this).find('.answer-checkbox').is(':checked');

                                // Add the choice to the array
                                choices.push(choice);

                                // If the checkbox is checked, set the correctAnswer
                                if (isChecked) {
                                    correctAnswer = choice;
                                    isAtLeastOneChecked = true; // Set the flag to true if at least one checkbox is checked
                                }
                            });

                            // Check if at least one checkbox is checked
                            if (!isAtLeastOneChecked) {
                                alert('Please check at least one checkbox.');
                                return; // Abort the submission if no checkbox is checked
                            }

                            var explanation = $('#Explanation').val();

                            // Construct JSON data
                            var jsonData = JSON.stringify({
                                examName: examName,
                                section: section,
                                paragraph: paragraph,
                                question: question,
                                choices: choices,
                                correctAnswer: correctAnswer, // Update key to 'correctAnswer'
                                explanation: explanation
                            });

                            // Send JSON data to backend.php using AJAX
                            $.ajax({
                                url: 'BackendAPI/addQuestion.php',
                                method: 'POST',
                                contentType: 'application/json',
                                data: jsonData,
                                dataType: 'json',
                                success: function (response) {
                                    // Handle the JSON response from backend.php
                                    if (response.status == "success") {
                                        // alert("Added Question!");
                                        location.reload();
                                        $('#myForm')[0].reset();
                                    }
                                    else {
                                        alert("failed");
                                    }
                                },
                                error: function (xhr, status, error) {
                                    // Handle errors
                                    console.error(xhr.responseText);
                                }
                            });
                        });
                        $('.deleteBtn').click(function () {
                            var examId = <?php echo $id; ?>; // Get the exam ID from PHP variable
                            var questionId = $(this).data('id'); // Get the question ID from data attribute

                            // Confirm deletion with the user
                            var confirmDelete = confirm('Are you sure you want to delete this question?');

                            // If user confirms deletion
                            if (confirmDelete) {
                                // Send AJAX request to delete question
                                $.ajax({
                                    url: 'BackendAPI/deleteQuestion.php', // Change to the actual path of your backend script
                                    method: 'POST',
                                    data: { examId: examId, questionId: questionId },
                                    dataType: 'json',
                                    success: function (response) {
                                        // Check if deletion was successful
                                        if (response.status === 'success') {
                                            // Reload the page to reflect changes
                                            location.reload();
                                        } else {
                                            // Show error message if deletion fails
                                            alert('Failed to delete question.');
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // Show error message if AJAX request fails
                                        console.error(xhr.responseText);
                                        alert('An error occurred while processing your request.');
                                    }
                                });
                            }
                        });
                        $(window).scroll(function () {
                            // If user has scrolled more than 20px from the top
                            if ($(this).scrollTop() > 20) {
                                // Show the scroll-to-top button
                                $('#scrollTopBtn').fadeIn();
                            } else {
                                // Otherwise, hide the button
                                $('#scrollTopBtn').fadeOut();
                            }
                        });

                        // Function to handle button click
                        $('#scrollTopBtn').click(function () {
                            // Scroll to the top of the page with animation
                            $('html, body').animate({ scrollTop: 0 }, 800);
                        });
                    });

                </script>


                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php');


