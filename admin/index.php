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
$active_user = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `students` WHERE `status` = 1");
$Course = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `course`");
$exams = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `exams`");
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
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-normal mb-1">Total Students <i
                    class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                </h5>
                <h2 class="mb-1">
                  <?= $active_user[0]['cnt'] ?>

                </h2>
                <h6 class="card-text">Total Students</h6>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-normal mb-1">Total Courses <i
                    class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                </h5>
                <h2 class="mb-1">
                  <?= $Course[0]['cnt'] ?>
                </h2>
                <h6 class="card-text">Total Course</h6>
              </div>
            </div>
          </div>
          <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-primary card-img-holder text-white">
              <div class="card-body index-card">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-normal mb-1">Total Exams <i
                    class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                </h5>
                <h2 class="mb-1">
                  <?= $exams[0]['cnt'] ?>
                </h2>
                <h6 class="card-text">Total Exams</h6>
              </div>
            </div>
          </div>

        </div>
        <!-- <?php $otp = executeSelect('otp', array(), array(), 'date_added DESC LIMIT 3');
        if (count($otp) > 0) {
          ?>
          <div class="row ">
            <div class="col-12 col-lg-12 col-sm-12 grid-margin">
              <div class="card pad-9">
                <div class="card-body index-card">
                  <h4 class="card-title">Recent Otp Generated</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Email Id </th>
                          <th class="text-center"> OTP </th>
                          <th class="text-center"> Status </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($otp as $key => $row) {
                          $expiry_date_time = isset($row['date_added']) ? date('Y-m-d H:i:s', strtotime($row['date_added'] . " + 5 minutes")) : 0;
                          $current_date_time = date('Y-m-d H:i:s');
                          if (strtotime($current_date_time) <= strtotime($expiry_date_time)) {
                            $status = '<div class="btn btn-gradient-success text-white"> Active</div>';
                          } else {
                            $status = '<div class="btn btn-gradient-danger text-white"> Expired</div>';
                          }
                          ?>
                          <tr>
                            <td>
                              <?= $key + 1 ?>
                            </td>
                            <td>
                              <?= isset($row['email']) ? $row['email'] : 'Unknown' ?>
                            </td>
                            <td class="text-center"> <button type="button" class="btn btn-gradient-light"
                                data-toggle="tooltip" title="Click To Copy" data-placement="top"
                                onclick="click_to_copy_html_text(this);">
                                <?= isset($row['otp']) ? $row['otp'] : 0 ?>
                              </button></td>
                            <td class="text-center">
                              <?= $status ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }
        $appointment_detail = getResultAsArray("SELECT * FROM `appointment_detail` ORDER BY id DESC LIMIT 3");
        if (count($appointment_detail) > 0) {
          ?>
          <div class="row ">
            <div class="col-12 col-lg-12 col-sm-12 grid-margin">
              <div class="card">
                <div class="card-body index-card">
                  <h4 class="card-title">Recently Added Appointments</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Name </th>
                          <th> Email </th>
                          <th> Phone No. </th>
                          <th> Gender </th>
                          <th> Reach Type </th>
                          <th> Date </th>
                          <th> Time </th>
                          <th> Address </th>
                          <th> Reason </th>
                          <th> User Mail Status </th>
                          <th> Admin Mail Status </th>
                          <th> Date Added </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($appointment_detail as $key => $row) {
                          if (isset($row['user_mail']) && !empty($row['user_mail']) && $row['user_mail'] == '1') {
                            $user_status = '<div class="btn btn-gradient-success text-white">Sent</div>';
                          } else {
                            $user_status = '<div class="btn btn-gradient-danger text-white">Not Sent</div>';
                          }
                          if (isset($row['admin_mail']) && !empty($row['admin_mail']) && $row['admin_mail'] == '1') {
                            $admin_status = '<div class="btn btn-gradient-success text-white">Sent</div>';
                          } else {
                            $admin_status = '<div class="btn btn-gradient-danger text-white">Not Sent</div>';
                          }
                          ?>
                          <tr>
                            <td>
                              <?= $key + 1 ?>
                            </td>
                            <td>
                              <?= isset($row['name']) ? $row['name'] : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['email']) ? '<a href="mailto:' . $row['email'] . '">' . $row['email'] . '</a>' : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['phone']) ? '<a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a>' : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['gender']) ? $row['gender'] : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['reach_type']) ? $row['reach_type'] : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['app_date']) ? date('d-m-Y', strtotime($row['app_date'])) : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['app_time']) ? date('H:i:s', strtotime($row['app_time'])) : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['address']) && !empty($row['address']) ? '<textarea class="form-control textarea_manage"   required rows="4" cols="50" disabled >' . $row['address'] . '</textarea>' : '-' ?>
                            </td>
                            <td>
                              <?= isset($row['reason']) && !empty($row['reason']) ? '<textarea class="form-control textarea_manage"   required rows="4" cols="50" disabled >' . $row['reason'] . '</textarea>' : '-' ?>
                            </td>
                            <td>
                              <?= isset($user_status) ? $user_status : '0' ?>
                            </td>
                            <td>
                              <?= isset($admin_status) ? $admin_status : '0' ?>
                            </td>
                            <td>
                              <?= isset($row['date_added']) ? date('d-m-Y', strtotime($row['date_added'])) : 'Unknown' ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }
        $query = getResultAsArray("SELECT * FROM `query` ORDER BY id DESC LIMIT 5");
        if (count($query) > 0) {
          ?>
          <div class="row ">
            <div class="col-12 col-lg-12 col-sm-12 grid-margin">
              <div class="card">
                <div class="card-body index-card">
                  <h4 class="card-title">Recently Added Query</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Name </th>
                          <th> Email </th>
                          <th> Phone No. </th>
                          <th> Message </th>
                          <th> Mail Status </th>
                          <th> Date Added </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($query as $key => $row) {
                          if (isset($row['mail_sent']) && !empty($row['mail_sent']) && $row['mail_sent'] == '1') {
                            $status = '<div class="btn btn-gradient-success text-white">Sent</div>';
                          } else {
                            $status = '<div class="btn btn-gradient-danger text-white">Not Sent</div>';
                          }
                          ?>
                          <tr>
                            <td>
                              <?= $key + 1 ?>
                            </td>
                            <td>
                              <?= isset($row['name']) ? $row['name'] : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['email']) ? '<a href="mailto:' . $row['email'] . '">' . $row['email'] . '</a>' : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['phone']) ? '<a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a>' : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['message']) && !empty($row['message']) ? '<textarea class="form-control textarea_manage"   required rows="4" cols="50" disabled >' . $row['message'] . '</textarea>' : '-' ?>
                            </td>
                            <td>
                              <?= isset($status) ? $status : '0' ?>
                            </td>
                            <td>
                              <?= isset($row['date_added']) ? date('d-m-Y', strtotime($row['date_added'])) : 'Unknown' ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php }
        $home_query = getResultAsArray("SELECT * FROM `home_query` ORDER BY id DESC LIMIT 5");
        if (count($home_query) > 0) {
          ?>
          <div class="row ">
            <div class="col-12 col-lg-12 col-sm-12 grid-margin">
              <div class="card">
                <div class="card-body index-card">
                  <h4 class="card-title">Recently User Connected</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Name </th>
                          <th> Email </th>
                          <th> Phone No. </th>
                          <th> Mail Status </th>
                          <th> Date Added </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($home_query as $key => $row) {
                          if (isset($row['mail_sent']) && !empty($row['mail_sent']) && $row['mail_sent'] == '1') {
                            $status = '<div class="btn btn-gradient-success text-white">Sent</div>';
                          } else {
                            $status = '<div class="btn btn-gradient-danger text-white">Not Sent</div>';
                          }
                          ?>
                          <tr>
                            <td>
                              <?= $key + 1 ?>
                            </td>
                            <td>
                              <?= isset($row['name']) ? $row['name'] : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['email']) ? '<a href="mailto:' . $row['email'] . '">' . $row['email'] . '</a>' : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($row['phone']) ? '<a href="tel:' . $row['phone'] . '">' . $row['phone'] . '</a>' : 'Unknown' ?>
                            </td>
                            <td>
                              <?= isset($status) ? $status : '0' ?>
                            </td>
                            <td>
                              <?= isset($row['date_added']) ? date('d-m-Y', strtotime($row['date_added'])) : 'Unknown' ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?> -->
      </div>
      <!-- content-wrapper ends -->
      <?php include_once('components/footer.php'); ?>