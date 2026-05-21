<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $id = intval($_POST['id']);
    $status = htmlspecialchars(trim($_POST['status']), ENT_QUOTES, 'UTF-8');
    
    $stmt = $conn->prepare("UPDATE complaints SET status=? WHERE id=?");
    if($stmt->execute([$status, $id])) {
        header("Location: complaints.php?success=1");
    } else {
        header("Location: complaints.php?error=1");
    }
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM complaints WHERE id=?");
    if($stmt->execute([$id])) {
        header("Location: complaints.php?deleted=1");
    }
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">

    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="dashboard.php"><i class="fa-solid fa-shield-halved me-2"></i>Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3"><span class="text-light"><i class="fa-regular fa-circle-user me-1"></i> <?php echo htmlspecialchars($_SESSION['admin']); ?></span></li>
                    <li class="nav-item"><a class="btn btn-outline-light btn-sm rounded-pill px-3" href="logout.php">Logout</a></li>
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
                        <li class="nav-item"><a class="nav-link" href="dashboard.php"><i class="fa-solid fa-chart-pie w-20px me-2 text-center"></i> Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link active" href="complaints.php"><i class="fa-solid fa-clipboard-list w-20px me-2 text-center"></i> Manage Complaints</a></li>
                        <li class="nav-item"><a class="nav-link" href="announcements.php"><i class="fa-solid fa-bullhorn w-20px me-2 text-center"></i> Manage Announcements</a></li>
                        <li class="nav-item mt-5"><a class="nav-link text-muted" href="../home.php" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square w-20px me-2 text-center"></i> View Public Site</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                    <h1 class="h2 fw-bold text-dark m-0">Manage Complaints</h1>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Reporter</th>
                                        <th>Category & Area</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="pe-4 text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $res = $conn->query("SELECT * FROM complaints ORDER BY date DESC");
                                    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
                                    if(count($rows) > 0) {
                                        foreach($rows as $r) {
                                            $badgeClass = 'bg-warning text-dark';
                                            if($r['status'] == 'In Progress') $badgeClass = 'bg-primary';
                                            if($r['status'] == 'Resolved') $badgeClass = 'bg-success';
                                            
                                            echo "<tr>";
                                            echo "<td class='ps-4'>#".$r['id']."</td>";
                                            echo "<td><strong>".htmlspecialchars($r['name'])."</strong><br><small class='text-muted'><i class='fa-solid fa-phone me-1'></i>".htmlspecialchars($r['contact'])."</small></td>";
                                            echo "<td><span class='badge bg-secondary bg-opacity-10 text-dark border mb-1'>".$r['category']."</span><br><small class='text-muted'>".htmlspecialchars($r['area'])."</small></td>";
                                            echo "<td><div style='max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;' title='".htmlspecialchars($r['description'])."'>".htmlspecialchars($r['description'])."</div><small class='text-muted'>".date('M d, Y', strtotime($r['date']))."</small></td>";
                                            echo "<td><span class='badge $badgeClass rounded-pill'>".$r['status']."</span></td>";
                                            echo "<td class='pe-4 text-end'>";
                                            echo "<button class='btn btn-sm btn-outline-primary me-2' data-bs-toggle='modal' data-bs-target='#updateModal".$r['id']."'><i class='fa-solid fa-pen'></i></button>";
                                            echo "<a href='complaints.php?delete=".$r['id']."' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this complaint?\");'><i class='fa-solid fa-trash'></i></a>";
                                            echo "</td>";
                                            echo "</tr>";
                                            
                                            // Modal for each row
                                            ?>
                                            <div class="modal fade" id="updateModal<?php echo $r['id']; ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST" action="complaints.php">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Status #<?php echo $r['id']; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?php echo $r['id']; ?>">
                                                                <input type="hidden" name="update_status" value="1">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Status</label>
                                                                    <select name="status" class="form-select">
                                                                        <option value="Pending" <?php if($r['status']=='Pending') echo 'selected'; ?>>Pending</option>
                                                                        <option value="In Progress" <?php if($r['status']=='In Progress') echo 'selected'; ?>>In Progress</option>
                                                                        <option value="Resolved" <?php if($r['status']=='Resolved') echo 'selected'; ?>>Resolved</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center py-5 text-muted'>No complaints found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success')) {
            Swal.fire({ icon: 'success', title: 'Status Updated', showConfirmButton: false, timer: 1500 });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        if (urlParams.has('deleted')) {
            Swal.fire({ icon: 'success', title: 'Complaint Deleted', showConfirmButton: false, timer: 1500 });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>
