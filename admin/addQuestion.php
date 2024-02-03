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
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white me-2">
                                <i class="mdi mdi-home"></i>
                            </span> Exam Section
                        </h3>
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

                    </div>
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                    <!-- content-wrapper ends -->
                    <?php require_once 'components/footer.php'; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>