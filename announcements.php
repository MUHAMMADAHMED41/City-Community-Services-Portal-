<?php
require_once 'includes/config.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch all announcements
$announcements = [];
$query = "SELECT * FROM announcements ORDER BY date DESC";
if($result = mysqli_query($conn, $query)) {
    while($row = mysqli_fetch_assoc($result)) {
        $announcements[] = $row;
    }
}
?>

<main class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center animate-fade-in">
                <h1 class="fw-bold text-primary mb-3">City Announcements</h1>
                <p class="lead text-muted">Stay up to date with the latest news, notices, and important information from your municipal council.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Search Box -->
                <div class="glass-panel p-4 mb-5 animate-fade-in" style="animation-delay: 0.1s;">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0 text-primary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" id="searchServices" class="form-control border-start-0 ps-0" placeholder="Search announcements...">
                    </div>
                </div>

                <!-- Announcements List -->
                <div class="row g-4" id="announcementsList">
                    <?php if(empty($announcements)): ?>
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="fa-regular fa-folder-open fa-3x mb-3"></i>
                                <h4>No announcements available right now.</h4>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($announcements as $index => $ann): ?>
                            <div class="col-12 animate-fade-in" style="animation-delay: <?php echo 0.2 + ($index * 0.1); ?>s;">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden service-card">
                                    <?php
                                    // Highlight emergency notices if the title contains 'emergency' or 'urgent'
                                    $is_emergency = (stripos($ann['title'], 'emergency') !== false || stripos($ann['title'], 'urgent') !== false || stripos($ann['title'], 'break') !== false);
                                    if($is_emergency): ?>
                                        <div class="bg-danger text-white px-4 py-2 fw-bold d-flex align-items-center">
                                            <i class="fa-solid fa-triangle-exclamation me-2"></i> URGENT NOTICE
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body p-4 p-md-5">
                                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                                            <h3 class="card-title fw-bold m-0 text-dark mb-2 mb-md-0"><?php echo htmlspecialchars($ann['title']); ?></h3>
                                            <span class="badge bg-light text-primary border px-3 py-2 fs-6 rounded-pill">
                                                <i class="fa-regular fa-calendar me-1"></i> <?php echo date('F d, Y - h:i A', strtotime($ann['date'])); ?>
                                            </span>
                                        </div>
                                        <p class="card-text text-muted fs-5 lh-base"><?php echo nl2br(htmlspecialchars($ann['body'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-12 text-center py-5" id="noResults" style="display: none;">
                            <div class="text-muted">
                                <i class="fa-solid fa-magnifying-glass fa-2x mb-3"></i>
                                <h5>No matching announcements found.</h5>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="assets/js/search-services.js"></script>
<?php include 'includes/footer.php'; ?>
