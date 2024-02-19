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
                        </span> Scheduled Exam
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
                $coursesJson = $_SESSION['course'];

                // Convert the JSON string to an array
                $courses = json_decode($coursesJson, true);

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
                                if ($result2 && $result2->num_rows > 0) {
                                    while ($rows = $result2->fetch_assoc()) {
                                        // Get current timestamp
                                        $current_timestamp = time(); // Get current Unix timestamp
                                        $current_datetime = date('Y-m-d H:i:s', $current_timestamp); // Convert Unix timestamp to desired datetime format
                
                                        // Convert date strings to timestamps
                                        $start_timestamp = strtotime($rows['date_time']);
                                        $end_timestamp = strtotime($rows['date_time2']);

                                        // Convert exam timestamps to the same format as the current timestamp
                                        $start_datetime = date('Y-m-d H:i:s', $start_timestamp);
                                        $end_datetime = date('Y-m-d H:i:s', $end_timestamp);

                                        // echo $current_datetime . " " . $start_datetime . " " . $end_datetime;
                                        if ($current_datetime >= $start_datetime && $current_datetime <= $end_datetime) {
                                            $link_class = 'btn-gradient-primary'; // Active link
                                            $link_text = 'Take Test';
                                            $link_url = 'giveExam.php?id=' . $_SESSION['id'] . '&examId=' . $rows['id'];
                                        } else {
                                            $link_class = 'btn-disabled'; // Disabled link
                                            $link_text = 'Exam Not Available';
                                            $link_url = 'javascript:void(0);';
                                        }

                                        if ($rows['mode'] == "Scheduled") {
                                            echo "<div class='col-md-4'>
                                    <div class='card'>
                                        <div class='card-body'>
                                            <h1 class='card-title'>" . $rows['exam_name'] . "</h1>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Exam Time Limit:" . $rows['time_limit'] . "</h6>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Exam Will Active On :" . $start_datetime . "</h6>
                                            <a href='$link_url' class='btn btn-block $link_class btn-lg font-weight-medium auth-form-btn'>$link_text</a>
                                        </div>
                                    </div>
                                </div>";
                                        } else {
                                            echo "Nothing found";
                                        }
                                    }
                                } else {
                                    echo "Nothing found";
                                }
                                echo '</div>';
                            }
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