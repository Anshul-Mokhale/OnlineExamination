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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    body {
        -webkit-user-select: none;
        /* Safari */
        -moz-user-select: none;
        /* Firefox */
        -ms-user-select: none;
        /* IE 10+ */
        user-select: none;
        /* Standard syntax */
    }

    .NavBar {
        padding: 0.5em;
        color: white;
        background-color: #4973bd;
        font-family: 'Roboto', sans-serif !important;
    }

    .box {
        margin: 1em;
        height: 75vh;
        border: 2px solid #959595;
        overflow-y: auto;

    }

    .user {
        display: flex;
        /* justify-content: center; */
        align-items: center;
        flex-direction: column;
    }

    .user img {
        height: 200px;
        width: 150px;
    }

    .shape0 {
        background-color: #dbd9da;
        padding: 15px 20px 15px 20px;
        border-radius: 5px;
        outline: 1px solid black;
        margin-right: 20px;
    }

    .shape {
        width: 80px;
        /* Adjust width as needed */
        height: 80px;
        /* Adjust height as needed */
        background-color: #75bc24;
        /* Blue color */
        clip-path: polygon(30% 0, 70% 0, 100% 42%, 100% 100%, 0 100%, 0 42%);
        padding: 10px 20px 10px 20px;
        outline: 2px solid black;
        color: white;
        margin-right: 20px;
        /* Border style */
    }

    .shape2 {
        width: 80px;
        /* Adjust width as needed */
        height: 80px;
        /* Adjust height as needed */
        background-color: #df3c01;
        /* Blue color */
        clip-path: polygon(0 0, 100% 0, 100% 45%, 70% 100%, 30% 100%, 0 45%);
        padding: 10px 20px 10px 20px;
        outline: 2px solid black;
        /* Border style */
        color: white;
        margin-right: 20px;
    }

    .shape3 {

        color: white;
        background-color: purple;
        padding: 13px 17px 13px 17px;
        border-radius: 50%;
        color: white;
        margin-right: 20px;
    }

    .shape4 {

        color: white;
        background-color: #FFE43E;
        padding: 13px 17px 13px 17px;
        border-radius: 50%;
        color: white;
        margin-right: 20px;
    }

    .tt {
        list-style: none;
    }

    .tt li {
        margin: 40px;

    }

    .redcolor {
        color: red;
        font-style: italic;
    }
</style>

<body>
    <nav class="NavBar">
        <h2>Instruction</h2>
    </nav>
    <div class="row" style="height: 88vh; margin-top:10px;text-align:justify;">
        <div class="col-9" style="border-right: 2px solid #959595;">
            <div class="box">
                <h5>Please Read the following instructions carefully</h5>

                <h6>General instructions:</h6>
                <ol>
                    <li>total of 30 minutes duration will be given to attempt all the questions</li>
                    <li>The clock has been set at the server and the countdown time at the top right of your screen will
                        display the time remaining for you to complete the exam. When the clock runs out the exam ends
                        by default- you are not required to end or submit you exam.</li>
                    <li>The question pallet at the right of the screen shows the following status of each questions:
                        <ul class="tt">
                            <li>
                                <span class="shape0">0</span> You have not visited this question.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape">0</span> You have answered this question.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape2">0</span> You have not answered this question.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape3">0</span> You have not answered this question but marked the
                                question for review.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape4">0</span> You have answered this question but marked the
                                question for review.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                The marked for review status simply act as a reminder that you have set to look the
                                question again. <span class="redcolor">if answered is selected for questions that is
                                    marked for review,
                                    the answered is considerd in the final evaluations.</span>
                            </li>
                        </ul>
                    </li>
                </ol>
            </div>

            <script>
                function openRestrictedWindow(url) {
                    var options = "width=auto,height=auto,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no";
                    var newWindow = window.open(url, '_blank', options);
                    newWindow.focus();
                }
            </script>
            <!-- <a href="#" class="d-block text-center" style="text-decoration:none;"
                onclick="openRestrictedWindow('exam.php?id=1')">Open Restricted Window</a> -->
            <a href="exam.php?id=10" class="d-block text-center">Next</a>
        </div>
        <div class="col-3 user">
            <img src="admin/uploads/65c2361510ef6/Screenshot (2).png" alt="">
            <p>8766865573</p>
        </div>
    </div>

    <script>
        function openFullScreen(event) {
            event.preventDefault();
            var url = event.target.href;
            var newWindow = window.open(url, '_blank');
            if (newWindow) {
                newWindow.moveTo(0, 0);
                newWindow.resizeTo(screen.width, screen.height);
                newWindow.focus();
            } else {
                alert('Your browser blocked opening the new window. Please check your browser settings.');
            }
        }
    </script>
</body>

</html>