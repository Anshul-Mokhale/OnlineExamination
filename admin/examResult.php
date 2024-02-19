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

$sid = $_GET['id'];
$examId = $_GET['examId'];
?>

<div class="container-scroller">
    <?php include_once('components/navbar.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('components/sidebar.php'); ?>
        <style>
            .container-scroller {
                font-family: 'Nunito Sans', sans-serif !important;
            }

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
                <?php if ($msg) { ?>
                    <section>
                        <div class='container-fluid'>
                            <div class='row'>
                                <?= $msg ?>
                            </div>
                        </div>
                    </section>
                <?php } ?>

                <section>
                    <div class='container-fluid'>
                        <div class='row' id="message">

                        </div>
                    </div>
                </section>

                <div class="page-header">
                    <h3 class="page-title">
                        <a href="resultShow.php?id=<?= $sid ?>" class="txt-primary"
                            style="font-size: 30px !important;"><i class="mdi mdi-arrow-left"></i></a>
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

                <div class="row">
                    <div class='col-md-12' style="margin-bottom: 1em;">
                        <div class='card'>
                            <div class='card-body' style="align-items:start">
                                <?php
                                $swq = "SELECT * FROM exams WHERE id = '$examId'";
                                $gg1 = $mysql_connection->query($swq);

                                if ($gg1->num_rows > 0) {
                                    $deta1 = $gg1->fetch_assoc();
                                }

                                $swq2 = "SELECT total FROM submissions WHERE student_id = '$sid' AND exam_id = '$examId'";
                                $gg2 = $mysql_connection->query($swq2);

                                if ($gg2->num_rows > 0) {
                                    $deta2 = $gg2->fetch_assoc();
                                }
                                ?>

                                <h4>Course Name:
                                    <?= $deta1['course_name'] ?>
                                </h4>
                                <h4>Exam Name:
                                    <?= $deta1['exam_name'] ?>
                                </h4>
                                <h4>Correct Answer Marking:
                                    <?= $deta1['posititve'] ?>
                                </h4>
                                <h4>Negative Marking:
                                    <?= $deta1['negaitve'] ?>
                                </h4>
                                <h4>Total Percentage:
                                    <?= number_format($deta2['total'], 2) ?>%
                                </h4>

                            </div>
                        </div>
                    </div>

                    <div class='col-md-12'>
                        <div class='card'>
                            <div class='card-body' style="align-items:start">
                                <?php
                                $answers = array();

                                $getAnswer = "SELECT answers FROM submissions WHERE student_id = '$sid' AND exam_id = '$examId'";
                                $Aanswer = $mysql_connection->query($getAnswer);

                                if ($Aanswer->num_rows > 0) {
                                    $row = $Aanswer->fetch_assoc();
                                    $answers = json_decode($row['answers'], true);
                                }

                                $examId = mysqli_real_escape_string($mysql_connection, $examId);

                                $queee = "SELECT * FROM sections WHERE id = '$examId'";
                                $reu = $mysql_connection->query($queee);
                                $rowses = array();
                                $swooss = array();
                                $sectionName = "";

                                if ($reu->num_rows > 0) {
                                    while ($rowee = $reu->fetch_assoc()) {
                                        $rowses[] = $rowee;
                                        $sectionName = $rowee['name'];
                                    }
                                }

                                foreach ($answers as $sectionKey => $section_answers) {
                                    echo "<h1>Section: $sectionKey </h1>";
                                    foreach ($section_answers as $question => $answer) {
                                        $veddd = "SELECT * FROM question_$examId WHERE question = '$question'";
                                        $restultt = $mysql_connection->query($veddd);

                                        if ($restultt->num_rows > 0) {
                                            while ($swss = $restultt->fetch_assoc()) {
                                                $swooss[] = $swss;
                                                if (isset($swss['description']) && $swss['description'] != "") {
                                                    echo "<h5>Description: " . $swss['description'] . "</h5>";
                                                }
                                                echo "<h5>Question: " . $swss['question'] . "</h5>";
                                                echo '<ul>';
                                                $choices = json_decode($swss['choices'], true);
                                                foreach ($choices as $choice) {
                                                    if ($choice !== "") {
                                                        if ($choice == $swss['correct_answer']) {
                                                            echo "<li style='color:green; font-weight:bold;'>$choice</li>";
                                                        } else {
                                                            echo "<li>$choice</li>";
                                                        }
                                                    }
                                                }
                                                echo '</ul>';

                                                if ($answer == $swss['correct_answer']) {
                                                    echo "<p>Given Anwer: " . $answer . " <i class='fa-solid fa-check'></i></p>";
                                                } else {
                                                    echo "<p>Given Anwer: " . $answer . " <i class='fa-solid fa-xmark'></i></p>";
                                                }

                                                echo "<br>";
                                            }
                                        }
                                    }
                                    echo "<br>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
                <?php include_once('components/footer.php'); ?>