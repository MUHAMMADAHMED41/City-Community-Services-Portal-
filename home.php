<?php
require_once 'includes/config.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch latest announcements
$announcements = [];
$query = "SELECT * FROM announcements ORDER BY date DESC LIMIT 3";
$stmt = $conn->query($query);
if ($stmt) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $announcements[] = $row;
    }
}
?>

<!-- Notice Ticker -->
<?php if(count($announcements) > 0): ?>
<div class="notice-ticker">
    <div class="container notice-content">
        <p>
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <?php foreach($announcements as $index => $ann): ?>
                <strong><?php echo htmlspecialchars($ann['title']); ?>:</strong> <?php echo htmlspecialchars($ann['body']); ?> 
                <?php if($index < count($announcements) - 1) echo "&nbsp;&nbsp;|&nbsp;&nbsp;"; ?>
            <?php endforeach; ?>
        </p>
    </div>
</div>
<?php endif; ?>

<!-- Hero Section -->
<section class="hero-section text-center">
    <div class="container">
        <h1 class="hero-title mb-4 animate-fade-in">Welcome to SmartCity Services</h1>
        <p class="lead mb-5 animate-fade-in" style="animation-delay: 0.2s;">Your central hub for community engagement, civic services, and transparent municipal management.</p>
        <div class="animate-fade-in" style="animation-delay: 0.4s;">
            <a href="complaint.php" class="btn btn-light btn-lg text-primary fw-bold px-5 py-3 rounded-pill me-sm-3 mb-3 mb-sm-0 shadow-sm">
                <i class="fa-solid fa-bullhorn me-2"></i>Report an Issue
            </a>
            <a href="services.php" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm">
                <i class="fa-solid fa-address-book me-2"></i>Find Services
            </a>
        </div>
    </div>
</section>

<!-- Main Content -->
<main class="py-5">
    <div class="container">
        
        <!-- City Overview / Quick Access Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <a href="complaint.php" class="text-decoration-none text-dark">
                    <div class="card hover-card h-100 text-center p-4 border-0">
                        <div class="card-body">
                            <div class="icon-box mx-auto">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <h4 class="card-title fw-bold">Report Issues</h4>
                            <p class="card-text text-muted">Help us keep the city clean and safe. Report potholes, broken lights, and more easily.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="announcements.php" class="text-decoration-none text-dark">
                    <div class="card hover-card h-100 text-center p-4 border-0">
                        <div class="card-body">
                            <div class="icon-box mx-auto">
                                <i class="fa-solid fa-newspaper"></i>
                            </div>
                            <h4 class="card-title fw-bold">City Updates</h4>
                            <p class="card-text text-muted">Stay informed with the latest news, events, and important notices from the municipal council.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="services.php" class="text-decoration-none text-dark">
                    <div class="card hover-card h-100 text-center p-4 border-0">
                        <div class="card-body">
                            <div class="icon-box mx-auto">
                                <i class="fa-solid fa-building-user"></i>
                            </div>
                            <h4 class="card-title fw-bold">Public Services</h4>
                            <p class="card-text text-muted">Access a comprehensive directory of emergency contacts, utilities, and civic departments.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Latest Announcements Section -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold m-0"><i class="fa-solid fa-bullhorn text-primary me-2"></i>Latest Announcements</h2>
                    <a href="announcements.php" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                
                <?php if(empty($announcements)): ?>
                    <div class="alert alert-info border-0 shadow-sm rounded-3">
                        <i class="fa-solid fa-circle-info me-2"></i> No announcements available right now.
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach($announcements as $ann): ?>
                            <div class="col-12">
                                <div class="card border-0 shadow-sm rounded-3">
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title fw-bold m-0"><?php echo htmlspecialchars($ann['title']); ?></h5>
                                            <span class="badge bg-light text-primary border"><i class="fa-regular fa-clock me-1"></i> <?php echo date('M d, Y', strtotime($ann['date'])); ?></span>
                                        </div>
                                        <p class="card-text text-muted mb-0"><?php echo nl2br(htmlspecialchars(substr($ann['body'], 0, 150) . (strlen($ann['body']) > 150 ? '...' : ''))); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Emergency Contacts Sidebar -->
            <div class="col-lg-4">
                <div class="glass-panel p-4 h-100 bg-white">
                    <h3 class="fw-bold mb-4 text-danger"><i class="fa-solid fa-phone-volume me-2"></i>Emergency</h3>
                    <ul class="list-group list-group-flush rounded-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 bg-light mb-2 rounded">
                            <div><i class="fa-solid fa-shield-halved text-primary me-2"></i>Police</div>
                            <span class="badge bg-primary rounded-pill fs-6 px-3">911</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 bg-light mb-2 rounded">
                            <div><i class="fa-solid fa-fire-flame-curved text-danger me-2"></i>Fire Dept</div>
                            <span class="badge bg-danger rounded-pill fs-6 px-3">911</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 bg-light mb-2 rounded">
                            <div><i class="fa-solid fa-truck-medical text-success me-2"></i>Ambulance</div>
                            <span class="badge bg-success rounded-pill fs-6 px-3">911</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0 bg-light rounded">
                            <div><i class="fa-solid fa-droplet text-info me-2"></i>Water Emergency</div>
                            <span class="badge bg-info text-dark rounded-pill fs-6 px-3">555-0200</span>
                        </li>
                    </ul>
                    <div class="mt-4 text-center">
                        <a href="services.php" class="text-decoration-none text-muted small">View full directory <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
