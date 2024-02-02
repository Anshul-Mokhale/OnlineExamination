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

?>
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
                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-home"></i>
                        </span> Student
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">
                                <a href="addStudent.php"
                                    class="page-title-icon bg-gradient-primary text-white me-2 mark">Add Students
                                    <i class="mdi mdi-account-plus"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Bordered table</h4>
                                <table class="table table-bordered" id="courseTable">
                                    <thead>
                                        <tr>
                                            <th> Sr </th>
                                            <th> Student Name </th>
                                            <th> Email </th>
                                            <th> Phone </th>
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
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function () {
                        var out = $('#message');

                        // Function to populate the table with user details
                        function populateTable(data) {
                            var tableBody = $("#userTable tbody");
                            tableBody.empty(); // Clear existing rows
                            var i = 1;

                            if (data.length === 0) {
                                // If no data is present, display a message
                                tableBody.append("<tr><td colspan='10' class='text-center'>No data available</td></tr>");
                            } else {
                                // Iterate through the data and append rows to the table
                                $.each(data, function (index, item) {
                                    var row = "<tr>" +
                                        "<td>" + item['id'] + "</td>" +
                                        "<td>" + item['name'] + "</td>" +
                                        "<td>" + item['email'] + "</td>" +
                                        "<td>" + item['phone'] + "</td>" +
                                        "<td>" + item['password'] + "</td>" +
                                        "<td>" + item['gender'] + "</td>" +
                                        "<td>" + item['birth_date'] + "</td>" +
                                        "<td>" + item['address'] + "</td>" +
                                        "<td>" + item['courses'] + "</td>" +
                                        "<td>" + item['created_at'] + "</td>" +
                                        "</tr>";
                                    i++;
                                    tableBody.append(row);
                                });
                            }
                        }

                        // Make an AJAX request to fetch user data
                        $.ajax({
                            type: "GET",
                            url: "BackendAPI/getStudents.php", // Replace with the actual path to your PHP file
                            dataType: "json",
                            success: function (data) {
                                // Populate the table with user details
                                populateTable(data);
                            },
                            error: function (error) {
                                console.log("Error fetching data:", error);
                            }
                        });
                    });
                </script>



                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php'); ?>