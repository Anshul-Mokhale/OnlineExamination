<?php
include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['ab'])) {
    $msg = $_GET['ab'];
} else {
    $msg = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Exam</title>
    <link rel="stylesheet" href="exam.css">
</head>

<body>
    <nav class="NavBar">
        <img src="assets/images/IMAGELOGO.svg" alt=""> Test Exam 1
        <a class="nav-link" style="color:white;">
            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
    </nav>
    <div class="row" style="height: 88vh; text-align:justify;">
        <div class="col-9">
            <div class="navi">
                <li class="first">
                    <p>Section</p>
                    <h6>Time Limit:</h6>
                </li>
                <li class="first" style="border-top:1px solid black; border-bottom:1px solid black;">
                    <div class="acr">
                        <a href="#"><i class="fa-solid fa-caret-left"></i></a>
                        <h6 id="section" style="padding:5px; background-color: #4973bd; color:white; margin:0;">
                        </h6>
                    </div>
                    <div class="last">
                        <a href="#"><i class="fa-solid fa-caret-right"></i></a>
                    </div>
                </li>
                <li class="first">
                    <p>question type: MCQs</p>
                </li>
                <li class="NavBar" id="qno">

                </li>
            </div>
            <div class="bodde">
                <form id="questionForm">

                    <div id="sections-container">
                        <!-- Divs will be dynamically added here -->
                    </div>
                </form>
            </div>
            <div class="botom">
                <div class="lefto">
                    <button>Mark as Review & next</button>
                    <button>Clear response</button>
                </div>
                <div class="rightto">
                    <button id="nexxt">save & next</button>
                </div>
            </div>
        </div>
        <div class="col-3 user">
            <div class="top1">
                <div class="cc">
                    <img src="admin/uploads/65c2361510ef6/Screenshot (2).png" alt="">
                </div>
                <div class="value">
                    <h3>Anshul Mokhale</h3>
                    <p>87668655732</p>
                </div>
            </div>
            <div id="sidebar" class="pp"></div>

        </div>
    </div>

    <script>


        document.addEventListener('DOMContentLoaded', function () {
            var fullscreenButton = document.getElementById('fullscreen-button');
            var sectionContainer = document.getElementById('sections-container');
            var saveAndNextButton = document.getElementById('nexxt');
            var secHead = document.getElementById('section');
            var showNum = document.getElementById('qno');
            var sections;

            function fetchSectionsData() {
                var url = 'BackendAPI/getQuesti.php'; // Modify the URL with your endpoint
                var params = {
                    method: 'POST',
                    body: JSON.stringify({ examId: 10 })
                };

                fetch(url, params)
                    .then(response => response.json())
                    .then(data => {
                        // Parse choices property from JSON to array for each question
                        data.forEach(section => {
                            section.questions.forEach(question => {
                                question.choices = JSON.parse(question.choices);
                            });
                        });

                        // Assign fetched sections data to the sections variable
                        sections = data;

                        // Show the first section and its first question when the data is fetched
                        showCurrentSection();
                        updateSidebar(currentSectionIndex);
                    })
                    .catch(error => {
                        console.error('Error fetching sections data:', error);
                        // Handle errors if needed
                    });
            }

            fetchSectionsData();

            var currentSectionIndex = 0;
            var currentQuestionIndex = 0;
            var answers = []; // Array to store user answers

            // Function to show the current section and its questions
            function showCurrentSection() {
                sectionContainer.innerHTML = ""; // Clear previous content

                var currentSection = sections[currentSectionIndex];

                // Update section heading
                secHead.textContent = currentSection.name;

                var currentQuestion = currentSection.questions[currentQuestionIndex];

                // Display description if present
                if (currentQuestion.description) {
                    var descriptionDiv = document.createElement('div');
                    descriptionDiv.classList.add('description');
                    descriptionDiv.innerHTML = "<strong>Description:</strong> " + currentQuestion.description;
                    sectionContainer.appendChild(descriptionDiv);
                }

                // Update question number
                var questionNumber = currentQuestionIndex + 1;
                // Update question number display
                showNum.innerHTML = "<strong>Question No: </strong>" + questionNumber;

                // Create elements for question and choices
                var questionDiv = document.createElement('div');
                questionDiv.classList.add('question');
                questionDiv.innerHTML = currentQuestion.question;

                // Append question to section container
                sectionContainer.appendChild(questionDiv);

                // Create radio buttons for choices
                if (currentQuestion.choices.length > 0) {
                    var choicesContainer = document.createElement('div');
                    choicesContainer.classList.add('choice');

                    currentQuestion.choices.forEach(function (choice, index) {
                        var choiceInput = document.createElement('input');
                        choiceInput.setAttribute('type', 'radio');
                        choiceInput.setAttribute('name', 'choice');
                        choiceInput.setAttribute('value', choice);
                        choiceInput.setAttribute('id', 'choice' + index);

                        // Check if the choice is the previously selected one
                        if (answers[currentSectionIndex] && answers[currentSectionIndex][currentQuestionIndex] === choice) {
                            choiceInput.setAttribute('checked', 'checked');
                        }

                        var choiceLabel = document.createElement('label');
                        choiceLabel.setAttribute('for', 'choice' + index);
                        choiceLabel.textContent = choice;

                        // Append choice input and label to choicesContainer div
                        choicesContainer.appendChild(choiceInput);
                        choicesContainer.appendChild(choiceLabel);

                        // Add a line break after each choice
                        choicesContainer.appendChild(document.createElement('br'));
                    });

                    // Append choicesContainer div to section container
                    sectionContainer.appendChild(choicesContainer);
                }

                // Update sidebar with current section's questions
                updateSidebar(currentSectionIndex);
            }

            function saveAnswer() {
                // Find the selected choice
                var selectedChoice = document.querySelector('input[name="choice"]:checked');
                var answer = selectedChoice ? selectedChoice.value : '';

                // Store the answer for the current question in the answers array
                answers[currentSectionIndex] = answers[currentSectionIndex] || [];
                answers[currentSectionIndex][currentQuestionIndex] = answer;
            }

            // Event listener for the "Save and Next" button
            saveAndNextButton.addEventListener('click', function () {
                saveAnswer(); // Save the answer before moving to the next question

                // Move to the next question or section if reached the end
                if (currentQuestionIndex < sections[currentSectionIndex].questions.length - 1) {
                    currentQuestionIndex++;
                } else {
                    // Check if it's the last section and last question
                    if (currentSectionIndex === sections.length - 1 && currentQuestionIndex === sections[currentSectionIndex].questions.length - 1) {
                        // Change the button name to "Submit"
                        saveAndNextButton.textContent = "Submit";
                        // Handle submission via AJAX
                        submitAnswers();
                        return;
                    } else {
                        // Check if the section is changing
                        var previousSectionIndex = currentSectionIndex;
                        currentQuestionIndex = 0;
                        currentSectionIndex++;
                        if (currentSectionIndex >= sections.length) {
                            // Submit the form or handle end of questions
                            console.log("End of questions");
                            return;
                        }

                        // Show the next question or move to the next section
                        showCurrentSection();

                        // If section changed, show alert
                        if (previousSectionIndex !== currentSectionIndex) {
                            alert("Section has changed!");
                        }

                        return;
                    }
                }

                // Show the next question or move to the next section
                showCurrentSection();
            });


            function updateSidebar(sectionIndex) {
                var sidebar = document.getElementById('sidebar');
                sidebar.innerHTML = ""; // Clear previous content

                sections[sectionIndex].questions.forEach(function (question, index) {
                    var questionButton = document.createElement('button');
                    questionButton.textContent = index + 1;
                    questionButton.classList.add('question-button');
                    questionButton.classList.add(sectionIndex + '_' + index);

                    // Check if the question has been answered
                    if (answers[sectionIndex] && answers[sectionIndex][index]) {
                        questionButton.classList.add('shape');
                    } else {
                        questionButton.classList.add('shape0');
                    }

                    questionButton.addEventListener('click', function () {
                        if (currentSectionIndex !== sectionIndex) {
                            // Display alert when changing sections
                            alert("Changing section. Do you want to continue?");
                        }
                        currentQuestionIndex = index;
                        showCurrentSection();
                    });

                    sidebar.appendChild(questionButton);
                });

                // Reset classList for previous section's questions
                if (currentSectionIndex !== sectionIndex) {
                    var previousSectionQuestions = sections[currentSectionIndex].questions;
                    previousSectionQuestions.forEach(function (question, index) {
                        var button = document.querySelector('.' + currentSectionIndex + '_' + index);
                        if (button) {
                            // Remove both shape and shape0 classes
                            button.classList.remove('shape');
                            button.classList.remove('shape0');
                        }
                    });
                }

                // Update current section index
                currentSectionIndex = sectionIndex;
            }


            function submitAnswers() {
                // Perform AJAX request to submit answers
                console.log(answers);
                // var xhr = new XMLHttpRequest();
                // xhr.open("POST", "new.php", true);
                // xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                // xhr.onreadystatechange = function () {
                //     if (xhr.readyState === XMLHttpRequest.DONE) {
                //         if (xhr.status === 200) {
                //             // Handle successful submission
                //             console.log("Answers submitted successfully");
                //         } else {
                //             // Handle error
                //             console.error("Error submitting answers:", xhr.status);
                //         }
                //     }
                // };
                // xhr.send(JSON.stringify(answers));
            }

            // Fullscreen functionality
            fullscreenButton.addEventListener('click', function () {
                if (document.fullscreenElement) {
                    exitFullscreen();
                } else {
                    enterFullscreen();
                }
            });

            function enterFullscreen() {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) { /* Firefox */
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) { /* IE/Edge */
                    document.documentElement.msRequestFullscreen();
                }
            }

            function exitFullscreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) { /* Firefox */
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) { /* IE/Edge */
                    document.msExitFullscreen();
                }
            }
        });
    </script>

    <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
</body>

</html>