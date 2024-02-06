<!-- partial:partials/_sidebar.html -->
<style>
    .sidebar {
        font-family: 'Nunito Sans', sans-serif !important;
    }
</style>
<nav class="sidebar sidebar-offcanvas " id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link" title="<?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>">
                <div class="nav-profile-image">
                    <img src="assets/images/faces/user.webp" alt="profile">
                    <span class="login-status online" title="online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">
                        <?= isset($_SESSION['name']) ? $_SESSION['name'] : 'User' ?>
                    </span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge" title="online"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Result" aria-expanded="false"
                aria-controls="home_quote">
                <span class="menu-title">Exam</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-shield menu-icon"></i>
            </a>
            <div class="collapse" id="Result">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="#">Live Exam</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">Scheduled Exams</a></li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
<!-- partial -->