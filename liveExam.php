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
                                if ($result2 && $result2->num_rows > 0) {
                                    while ($rows = $result2->fetch_assoc()) {
                                        if ($rows['mode'] == "Live") {
                                            echo "<div class='col-md-4'>
                                    <div class='card'>
                                        <div class='card-body'>
                                            <h1 class='card-title'>" . $rows['exam_name'] . "</h1>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Exam Time Limit:" . $rows['time_limit'] . "</h6>
                                            <h6 class='card-subtitle mb-2 text-body-secondary'>Number of Questions:" . $rows['number_of_questions'] . "</h6>";
                                            $si = $_SESSION['id'];
                                            $ei = $rows['id'];
                                            $getSub = "SELECT * FROM submissions WHERE student_id = '$si' AND exam_id = '$ei'";
                                            $reu = $mysql_connection->query($getSub);
                                            if ($reu->num_rows > 0) {
                                                echo "<a onclick=\"alert('You have already given the exam')\" class='btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn'>Take Test</a>";
                                            } else {
                                                echo "<a href='giveExam.php?id=" . $_SESSION['id'] . "&examId=" . $rows['id'] . "' class='btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn' id='Give'>Take Test</a>";
                                            }

                                            echo "</div>
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


                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php'); ?>