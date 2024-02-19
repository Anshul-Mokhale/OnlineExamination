<?php
require_once 'components/includes/connection.php';
require_once 'components/includes/function.php';
require_once 'components/header.php';

$msg = '';

if (!empty($_GET['msg']) && $_GET['msg'] === "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert'>&times;</button>
              <strong>Login successfully!</strong>
            </div>";
}

?>
<style>
    .table-responsive {
        overflow-x: auto !important;
    }
</style>

<body>
    <div class="container-scroller">
        <?php require_once 'components/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once 'components/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php
                    if ($msg) {
                        echo "
                            <section>                   
                                <div class='container-fluid'>
                                    <div class='row'>
                                        $msg
                                    </div>
                                </div>
                            </section>
                        ";
                    }
                    ?>
                    <section>
                        <div class='container-fluid'>
                            <div class='row' id="message">
                                <!-- Content for #message, if any -->
                            </div>
                        </div>
                    </section>
                    <div class="page-header">
                        <a href="index.php">
                            <h3 class="page-title">
                                <span class="page-title-icon bg-gradient-primary text-white me-2">
                                    <i class="mdi mdi-home"></i>
                                </span>
                            </h3>
                        </a>
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">
                                    <a href="addExam.php"
                                        class="page-title-icon bg-gradient-primary text-white me-2 mark">Add Exam
                                        <i class="mdi mdi-pencil-box-outline"></i></a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <!-- <h4 class="card-title">Bordered table</h4> -->
                                    <table class="table" id="courseTable">
                                        <thead>
                                            <tr>
                                                <th> Sr </th>
                                                <th> Course </th>
                                                <th> Exam Name </th>
                                                <th> Mode </th>
                                                <th> Date And Time </th>
                                                <th> Time Limit (min) </th>
                                                <th> Number of Questions </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Table body will be populated dynamically using AJAX -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                    <script>
                        $(document).ready(function () {
                            var out = $('#message');

                            // Function to populate the table with user details
                            function populateTable(data) {
                                var tableBody = $("#courseTable tbody");
                                tableBody.empty(); // Clear existing rows
                                var i = 1;

                                if (data && data.length > 0) {
                                    // Iterate through the data and append rows to the table
                                    $.each(data, function (index, item) {
                                        var row = "<tr>" +
                                            "<td>" + i + "</td>" +
                                            "<td>" + item['course_name'] + "</td>" +
                                            "<td>" + item['exam_name'] + "</td>" +
                                            "<td>" + item['mode'] + "</td>" +
                                            "<td>" + item['date_time'] + "</td>" +
                                            "<td>" + item['time_limit'] + "</td>" +
                                            "<td>" + item['number_of_questions'] + "</td>" +
                                            "<td><a href='addSection.php?id=" + item['id'] + "' class='btn-gradient-success' style ='padding: 5px; text-decoration: none;'>Add Question</a> <a href='updateExam.php?id=" + item['id'] + "' class='btn-gradient-light' style ='padding: 5px; text-decoration: none;'>Update</a> <button class='btn btn-danger btn-sm deleteBtn' data-id='" + item['id'] + "'>Delete</button></td>"
                                        "</tr>";
                                        i++;
                                        tableBody.append(row);
                                    });

                                    // Bind click event to delete button
                                    $(".deleteBtn").on("click", function () {
                                        var studentId = $(this).data("id");
                                        // Show confirmation dialog
                                        if (confirm("Are you sure you want to delete this exam?")) {
                                            // If user confirms, make an AJAX request to delete the exam
                                            deleteCourse(studentId);
                                        }
                                    });

                                } else {
                                    // If no data is present, display a message
                                    tableBody.append("<tr><td colspan='10' class='text-center'>No data available</td></tr>");
                                }
                            }

                            // Make an AJAX request to fetch exam data
                            $.ajax({
                                type: "GET",
                                url: "BackendAPI/getExam.php",
                                dataType: "json",
                                success: function (data) {
                                    // Populate the table with exam details
                                    populateTable(data);
                                },
                                error: function (error) {
                                    console.log("Error fetching data:", error);
                                }
                            });

                            function deleteCourse(examId) {
                                $.ajax({
                                    type: "POST",
                                    url: "BackendAPI/deleteExam.php",
                                    data: { id: examId },
                                    success: function (response) {
                                        console.log(response);
                                        try {
                                            var jsonResponse = JSON.parse(response);
                                            if (jsonResponse.status === "success") {
                                                // Display success message
                                                out.html("<div class='alert alert-success alert-dismissible'>" +
                                                    "<strong>" + jsonResponse.msg + "</strong></div>");
                                            } else {
                                                // Display error message
                                                out.html("<div class='alert alert-danger alert-dismissible'>" +
                                                    "<strong>Failed!</strong></div>");
                                            }

                                            // Reset form and clear output after a delay
                                            setTimeout(function () {
                                                location.reload();
                                            }, 2000);

                                        } catch (e) {
                                            console.log("Error parsing JSON response:", e);
                                        }
                                    },
                                    error: function (error) {
                                        console.log("Error deleting exam:", error);
                                    }
                                });
                            }
                        });
                    </script>
                    <!-- content-wrapper ends -->
                    <?php require_once 'components/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>