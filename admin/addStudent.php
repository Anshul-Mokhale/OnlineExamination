<?php
include_once('components/includes/connection.php');
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
<style>
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
                <div class="page-header">
                    <h3 class="page-title">
                        <a href="students.php" class="txt-primary" style="font-size: 30px !important;"><i
                                class="mdi mdi-arrow-left"></i></a>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <!-- <li class="breadcrumb-item active" aria-current="page">
                                <a href="#" class="page-title-icon bg-gradient-primary text-white me-2 mark">Add Course
                                    <i class="mdi mdi-library-plus"></i></a>
                            </li> -->
                        </ul>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Student</h4>
                                <!-- <p class="card-description"> Basic form elements </p> -->
                                <form class="forms-sample" id="AddStudent">
                                    <div class="form-group">
                                        <label for="exampleInputName1">Name of Student</label>
                                        <input type="text" class="form-control" id="exampleInputName1"
                                            placeholder="Enter Student Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail3"
                                            placeholder="Enter Email Address Here">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputMobile">Phone Number</label>
                                        <input type="tel" class="form-control" id="exampleInputMobile" maxlength="10"
                                            placeholder="Enter Phone Number Here" pattern="[0-9]{10}"
                                            title="Please enter a valid 10-digit phone number">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword4">Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword4"
                                            placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Gender</label>
                                        <select class="form-control" id="exampleSelectGender">
                                            <option selected disabled>Select one</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="ceheck">
                                        <label>Select Courses</label>
                                        <div class="course-grid">
                                            <?php
                                            $sql = "SELECT * FROM course";
                                            $result = $mysql_connection->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $id = $row['id'];
                                                    $courseName = htmlspecialchars($row['Name']);
                                                    echo '<div class="form-check">
                                                            <label class="form-check-label">
                                                            <input type="checkbox" value="' . $id . '" class="form-check-input">' . $courseName . ' 
                                                            </label>
                                                            </div>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputBirth">Enter Birth Date</label>
                                        <input type="date" class="form-control" id="exampleInputBirth" name="birthDate"
                                            placeholder="Select birth date">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputCity1">Address</label>
                                        <input type="text" class="form-control" id="exampleInputCity1"
                                            placeholder="Location">
                                    </div>
                                    <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    var out = $('#message');
                    $(document).ready(function () {
                        var form = $('#AddStudent');
                        $("#AddStudent").submit(function (event) {
                            // Prevent the default form submission
                            event.preventDefault();

                            // Collect form data
                            var formData = {
                                name: $("#exampleInputName1").val(),
                                email: $("#exampleInputEmail3").val(),
                                phoneNumber: $("#exampleInputMobile").val(),
                                password: $("#exampleInputPassword4").val(),
                                gender: $("#exampleSelectGender").val(),
                                courses: $("input[type='checkbox']:checked").map(function () {
                                    return $(this).val();
                                }).get(),
                                birthDate: $("#exampleInputBirth").val(),
                                address: $("#exampleInputCity1").val()
                            };

                            // console.log(JSON.stringify(formData))
                            // Send the data to backend.php using AJAX
                            $.ajax({
                                type: "POST",
                                url: "BackendAPI/AddStudent.php",
                                data: { data: JSON.stringify(formData) },

                                success: function (response) {
                                    var jsonResponse = JSON.parse(response);

                                    if (jsonResponse.status === "success") {
                                        out.html("<div class='alert alert-success alert-dismissible'>" +
                                            "<strong>" + jsonResponse.message + "</strong></div>");

                                    } else {
                                        out.html("<div class='alert alert-danger alert-dismissible'>" +
                                            "<strong>" + jsonResponse.message + "</strong></div>");
                                    }
                                    setTimeout(function () {
                                        form.trigger('reset');
                                        out.html(''); // Clear the output after resetting
                                    }, 2000);
                                },
                                error: function (error) {
                                    console.log("Error:", error);
                                }
                            });
                        });
                    });
                </script>

                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php');