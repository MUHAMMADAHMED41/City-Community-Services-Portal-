<?php
// Determine the current page for active nav link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="home.php">
            <i class="fa-solid fa-city me-2"></i>CityConnect
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'home.php' || $current_page == 'index.php') ? 'active fw-semibold' : ''; ?>" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'announcements.php') ? 'active fw-semibold' : ''; ?>" href="announcements.php">Announcements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'services.php') ? 'active fw-semibold' : ''; ?>" href="services.php">Services Directory</a>
                </li>
                <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                    <a class="btn btn-light text-primary fw-bold" href="complaint.php">
                        <i class="fa-solid fa-bullhorn me-1"></i> Report Issue
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
