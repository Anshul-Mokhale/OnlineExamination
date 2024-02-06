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
      .carousel img {
        padding: 10px !important;
        border-radius: 10px !important;
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
            </span> Dashboard
          </h3>
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
              </li>
            </ul>
          </nav>
        </div>
        <div class="row">
          <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="assets/images/Ban/pexels-pixabay-289737.jpg" class="d-block w-100 rounded-carousel-img"
                  alt="...">
              </div>
              <div class="carousel-item">
                <img src="assets/images/Ban/pexels-pixabay-301920.jpg" class="d-block w-100 rounded-carousel-img"
                  alt="...">
              </div>
              <div class="carousel-item">
                <img src="assets/images/Ban/pexels-pixabay-301926.jpg" class="d-block w-100 rounded-carousel-img"
                  alt="...">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
              data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
              data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>


        <div class="row">

        </div>
        <!-- content-wrapper ends -->
        <?php include_once('components/footer.php'); ?>