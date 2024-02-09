<?php include_once('components/includes/connection.php');
include_once('components/includes/function.php');
include_once('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";

} else {
    $msg = "";
}
// $active_user = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `admin` WHERE `status` = 1");

?>

<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <style>
            .card-body {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .row {
                margin-top: 2em !important;
            }
        </style>
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
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-home"></i>
                        </span> Live Exam
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <span></span>Overview <i
                                    class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                            </li>
                        </ul>
                    </nav>
                </div>
                <?php
                // Assuming $_SESSION['course'] contains a JSON string representation of the array like '["1","7"]'
                $coursesJson = $_SESSION['course'];

                // Convert the JSON string to an array
                $courses = json_decode($coursesJson, true);

                // Print the array
                // echo "<pre>";
                // print_r($courses);
                // echo "</pre>";
                
                // Define an empty array to store course details
                $courseDetails = array();

                // Check if $courses is an array
                if (is_array($courses)) {
                    // Iterate over each course ID
                    foreach ($courses as $courseId) {
                        // Execute SQL query for the current course ID
                        $sql = "SELECT * FROM course WHERE id = '$courseId'";
                        $result = $mysql_connection->query($sql);

                        // Check if query was successful
                        if ($result) {
                            // Fetch the row from the result set
                            while ($row = $result->fetch_assoc()) {
                                $cname = $row['Name'];
                                echo '<div class="row">
                                        <h1>' . $cname . '</h1>';
                                $sql1 = "SELECT * FROM exams WHERE course_name = '$cname'";
                                $result2 = $mysql_connection->query($sql1);
                                while ($rows = $result2->fetch_assoc()) {
                                    echo "<div class='col-md-4'>
                                    <div class='card'>
                                        <div class='card-body'>
                                            <h1 class='card-title'>" . $rows['exam_name'] . "</h1>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Exam Time Limit:" . $rows['time_limit'] . "</h6>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Number of Questions:" . $rows['number_of_questions'] . "</h6>
                                            <a href='#' class='btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn'>Take Test</a>
                                        </div>
                                    </div>
                                    </div>";
                                }
                                echo '</div>';

                            }

                            // // Add fetched course details to the $courseDetails array
                            // if ($row) {
                            //     $courseDetails[] = $row;
                            // }
                        } else {
                            // Handle query error
                            echo "Error executing query: " . $mysql_connection->error;
                        }
                    }
                } else {
                    // Handle invalid input in $_SESSION['course']
                    echo "Invalid input for course data.";
                }


                ?>


                <!-- <div class="row">
                    <h1>COurse Name</h1>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Exam Nmae</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Exam Time Limit</h6>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="#" class="card-link">Take Test</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Exam Nmae</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Exam Time Limit</h6>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="#" class="card-link">Take Test</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h1>COurse Name</h1>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Exam Nmae</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">Exam Time Limit</h6>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk of the card's content.</p>
                                <a href="#" class="card-link">Take Test</a>
                            </div>
                        </div>
                    </div>

                </div> -->

                <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function () {
                        // Make an AJAX GET request to getExam.php with id=1
                        $.ajax({
                            url: 'BackendAPI/getExam.php?id=<?= $_SESSION['id'] ?>',
                            type: 'GET',
                            // data: {
                            //     id: 1
                            // },
                            // dataType: 'json',
                            success: function (response) {
                                // Handle the successful response
                                console.log('Response:', response);

                                // Example: Update HTML content with response data
                                $('#result').html('<p>ID: ' + response.id + '</p><p>Message: ' + response.message + '</p>');
                            },
                            error: function (xhr, status, error) {
                                // Handle errors
                                console.error('Error:', error);

                                // Example: Display error message
                                $('#result').text('Error occurred: ' + error);
                            }
                        });
                    });

                </script> -->

                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php'); ?>