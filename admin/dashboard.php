<?php
session_start();
require_once '../includes/config.php';

// Check authentication
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch statistics
$stats = [
    'total_complaints' => 0,
    'pending_complaints' => 0,
    'resolved_complaints' => 0,
    'total_announcements' => 0
];

// Total Complaints
$res = $conn->query("SELECT COUNT(*) as count FROM complaints");
if($row = $res->fetch(PDO::FETCH_ASSOC)) $stats['total_complaints'] = $row['count'];

// Pending Complaints
$res = $conn->query("SELECT COUNT(*) as count FROM complaints WHERE status = 'Pending'");
if($row = $res->fetch(PDO::FETCH_ASSOC)) $stats['pending_complaints'] = $row['count'];

// Resolved Complaints
$res = $conn->query("SELECT COUNT(*) as count FROM complaints WHERE status = 'Resolved'");
if($row = $res->fetch(PDO::FETCH_ASSOC)) $stats['resolved_complaints'] = $row['count'];

// Total Announcements
$res = $conn->query("SELECT COUNT(*) as count FROM announcements");
if($row = $res->fetch(PDO::FETCH_ASSOC)) $stats['total_announcements'] = $row['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CityConnect</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="dashboard.php">
                <i class="fa-solid fa-shield-halved me-2"></i>Admin Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item me-3">
                        <span class="text-light"><i class="fa-regular fa-circle-user me-1"></i> Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light btn-sm rounded-pill px-3" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block admin-sidebar py-4 px-0">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="fa-solid fa-chart-pie w-20px me-2 text-center"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="complaints.php">
                                <i class="fa-solid fa-clipboard-list w-20px me-2 text-center"></i> Manage Complaints
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="announcements.php">
                                <i class="fa-solid fa-bullhorn w-20px me-2 text-center"></i> Manage Announcements
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-muted" href="../home.php" target="_blank">
                                <i class="fa-solid fa-arrow-up-right-from-square w-20px me-2 text-center"></i> View Public Site
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                    <h1 class="h2 fw-bold text-dark m-0">Dashboard Overview</h1>
                </div>

                <!-- Stats Row -->
                <div class="row g-4 mb-5">
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted fw-semibold mb-2">Total Complaints</h6>
                                    <h2 class="fw-bold m-0"><?php echo $stats['total_complaints']; ?></h2>
                                </div>
                                <div class="icon-box bg-primary bg-opacity-10 text-primary m-0" style="width:60px; height:60px;">
                                    <i class="fa-solid fa-folder-open"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted fw-semibold mb-2">Pending</h6>
                                    <h2 class="fw-bold m-0 text-warning"><?php echo $stats['pending_complaints']; ?></h2>
                                </div>
                                <div class="icon-box bg-warning bg-opacity-10 text-warning m-0" style="width:60px; height:60px;">
                                    <i class="fa-solid fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted fw-semibold mb-2">Resolved</h6>
                                    <h2 class="fw-bold m-0 text-success"><?php echo $stats['resolved_complaints']; ?></h2>
                                </div>
                                <div class="icon-box bg-success bg-opacity-10 text-success m-0" style="width:60px; height:60px;">
                                    <i class="fa-solid fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-muted fw-semibold mb-2">Announcements</h6>
                                    <h2 class="fw-bold m-0 text-info"><?php echo $stats['total_announcements']; ?></h2>
                                </div>
                                <div class="icon-box bg-info bg-opacity-10 text-info m-0" style="width:60px; height:60px;">
                                    <i class="fa-solid fa-newspaper"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                                <h5 class="fw-bold m-0">Recent Pending Complaints</h5>
                                <a href="complaints.php" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">ID</th>
                                                <th>Category</th>
                                                <th>Area</th>
                                                <th>Date</th>
                                                <th class="pe-4">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $recent = $conn->query("SELECT * FROM complaints WHERE status='Pending' ORDER BY date DESC LIMIT 5");
                                            $rows = $recent->fetchAll(PDO::FETCH_ASSOC);
                                            if(count($rows) > 0) {
                                                foreach($rows as $r) {
                                                    echo "<tr>";
                                                    echo "<td class='ps-4'>#".$r['id']."</td>";
                                                    echo "<td><span class='badge bg-secondary bg-opacity-10 text-dark border'>".$r['category']."</span></td>";
                                                    echo "<td>".htmlspecialchars($r['area'])."</td>";
                                                    echo "<td>".date('M d, Y', strtotime($r['date']))."</td>";
                                                    echo "<td class='pe-4'><a href='complaints.php' class='btn btn-sm btn-primary'>Update</a></td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center py-4 text-muted'>No pending complaints.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === 'login') {
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Welcome back to the dashboard.',
                timer: 2000,
                showConfirmButton: false
            });
            // Clean URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>
