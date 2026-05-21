<?php
require_once 'includes/config.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Fetch all services
$services = [];
$query = "SELECT * FROM services ORDER BY name ASC";
$stmt = $conn->query($query);
if ($stmt) {
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $services[] = $row;
    }
}
?>

<main class="py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center animate-fade-in">
                <div class="icon-box mx-auto bg-white shadow-sm mb-3 text-primary" style="width: 80px; height: 80px; font-size: 2rem;">
                    <i class="fa-solid fa-address-book"></i>
                </div>
                <h1 class="fw-bold text-primary mb-3">Public Services Directory</h1>
                <p class="lead text-muted">Find contact information and addresses for essential municipal and emergency services.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Search Box -->
                <div class="glass-panel p-4 mb-5 animate-fade-in" style="animation-delay: 0.1s;">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0 text-primary"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" id="searchServices" class="form-control border-start-0 ps-0" placeholder="Search for hospitals, police, water department...">
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="row g-4" id="servicesList">
                    <?php if(empty($services)): ?>
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="fa-regular fa-folder-open fa-3x mb-3"></i>
                                <h4>No services listed yet.</h4>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($services as $index => $srv): ?>
                            <div class="col-md-6 animate-fade-in" style="animation-delay: <?php echo 0.2 + ($index * 0.1); ?>s;">
                                <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">
                                    <div class="card-body p-4 service-card">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-box bg-light text-primary me-3 mb-0" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                <?php
                                                // Dynamic icon based on name
                                                $name = strtolower($srv['name']);
                                                $icon = "fa-building-user";
                                                if (strpos($name, 'hospital') !== false || strpos($name, 'health') !== false) $icon = "fa-truck-medical text-danger";
                                                elseif (strpos($name, 'police') !== false) $icon = "fa-shield-halved text-primary";
                                                elseif (strpos($name, 'fire') !== false) $icon = "fa-fire-flame-curved text-danger";
                                                elseif (strpos($name, 'water') !== false) $icon = "fa-droplet text-info";
                                                elseif (strpos($name, 'electric') !== false || strpos($name, 'power') !== false) $icon = "fa-bolt text-warning";
                                                elseif (strpos($name, 'bus') !== false || strpos($name, 'transit') !== false) $icon = "fa-bus text-success";
                                                ?>
                                                <i class="fa-solid <?php echo $icon; ?>"></i>
                                            </div>
                                            <h4 class="card-title fw-bold m-0 text-dark"><?php echo htmlspecialchars($srv['name']); ?></h4>
                                        </div>
                                        <ul class="list-unstyled text-muted mb-0">
                                            <li class="mb-2"><i class="fa-solid fa-location-dot me-2 text-secondary w-20px"></i> <?php echo htmlspecialchars($srv['address']); ?></li>
                                            <li class="mb-2"><i class="fa-solid fa-phone me-2 text-secondary w-20px"></i> <span class="fw-bold text-dark"><?php echo htmlspecialchars($srv['phone']); ?></span></li>
                                            <li><i class="fa-regular fa-clock me-2 text-secondary w-20px"></i> <?php echo htmlspecialchars($srv['hours']); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="col-12 text-center py-5" id="noResults" style="display: none;">
                            <div class="text-muted">
                                <i class="fa-solid fa-magnifying-glass fa-2x mb-3"></i>
                                <h5>No matching services found.</h5>
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
