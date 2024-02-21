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
                    <a href="index.php">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span>
                        </h3>
                    </a>
                    <h3 class="page-title">Results</h3>
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
                echo "<div class = 'row'>";
                $id = $_SESSION['id'];
                $vss = "SELECT * FROM submissions WHERE student_id = '$id'";
                $vresu = $mysql_connection->query($vss);
                if ($vresu->num_rows > 0) {
                    while ($row = $vresu->fetch_assoc()) {
                        $eid = $row['exam_id'];
                        $exmadata = "SELECT * FROM exams WHERE id = '$eid'";
                        $examResu = $mysql_connection->query($exmadata);
                        if ($examResu->num_rows > 0) {
                            while ($rew = $examResu->fetch_assoc()) {
                                echo "<div class='col-md-4'>
                                <div class='card'>
                                    <div class='card-body'>
                                        <h1 class='card-title'>Exam Name: " . $rew['exam_name'] . "</h1>
                                        <a href='viewResult.php?id=" . $_SESSION['id'] . "&examId=" . $rew['id'] . "' class='btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn'>View Result</a>
                                    </div>
                                </div>
                            </div>";
                            }
                        }
                    }
                }
                echo "</div>";

                ?>

                <!-- content-wrapper ends -->
                <?php include_once('components/footer.php'); ?>