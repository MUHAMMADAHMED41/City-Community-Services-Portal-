<?php
include 'includes/header.php';
include 'includes/navbar.php';
?>

<main class="py-5" style="background: linear-gradient(135deg, var(--bg-light) 0%, #e9ecef 100%); min-height: calc(100vh - 76px);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="text-center mb-5 animate-fade-in">
                    <div class="icon-box mx-auto bg-white shadow-sm mb-3 text-primary" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h1 class="fw-bold">Report an Issue</h1>
                    <p class="text-muted lead">Help us improve your community by reporting issues directly to the municipal council.</p>
                </div>

                <div class="glass-panel p-4 p-md-5 animate-fade-in" style="animation-delay: 0.2s;">
                    <form id="complaintForm" action="submit_complaint.php" method="POST">
                        <div class="row g-4">
                            
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-regular fa-user text-muted"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="contact" class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-phone text-muted"></i></span>
                                    <input type="tel" class="form-control" id="contact" name="contact" placeholder="03001234567" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold">Issue Category <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-list text-muted"></i></span>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="" selected disabled>Select Category...</option>
                                        <option value="Road Maintenance">Road Maintenance / Potholes</option>
                                        <option value="Street Lighting">Street Lighting</option>
                                        <option value="Water & Sanitation">Water & Sanitation</option>
                                        <option value="Garbage Collection">Garbage Collection</option>
                                        <option value="Public Parks">Public Parks</option>
                                        <option value="Noise Pollution">Noise Pollution</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="area" class="form-label fw-semibold">Area / Street <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fa-solid fa-location-dot text-muted"></i></span>
                                    <input type="text" class="form-control" id="area" name="area" placeholder="e.g., Block 4, Clifton" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Detailed Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Please provide specific details about the issue to help us locate and resolve it efficiently." required></textarea>
                                <div class="form-text">Minimum 10 characters required.</div>
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm w-100 w-md-auto">
                                    <i class="fa-regular fa-paper-plane me-2"></i> Submit Complaint
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="assets/js/complaint-validation.js"></script>
<?php include 'includes/footer.php'; ?>
