<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handle Add
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_announcement'])) {
    $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
    $body = filter_var(trim($_POST['body']), FILTER_SANITIZE_STRING);
    
    if(!empty($title) && !empty($body)) {
        $stmt = $conn->prepare("INSERT INTO announcements(title, body) VALUES (?, ?)");
        if($stmt->execute([$title, $body])) {
            header("Location: announcements.php?success=add");
        } else {
            header("Location: announcements.php?error=add");
        }
    } else {
        header("Location: announcements.php?error=empty");
    }
    exit();
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM announcements WHERE id=?");
    if($stmt->execute([$id])) {
        header("Location: announcements.php?success=delete");
    }
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - Admin</title>
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
                        <li class="nav-item"><a class="nav-link" href="complaints.php"><i class="fa-solid fa-clipboard-list w-20px me-2 text-center"></i> Manage Complaints</a></li>
                        <li class="nav-item"><a class="nav-link active" href="announcements.php"><i class="fa-solid fa-bullhorn w-20px me-2 text-center"></i> Manage Announcements</a></li>
                        <li class="nav-item mt-5"><a class="nav-link text-muted" href="../home.php" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square w-20px me-2 text-center"></i> View Public Site</a></li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                    <h1 class="h2 fw-bold text-dark m-0">Manage Announcements</h1>
                    <button class="btn btn-primary rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa-solid fa-plus me-1"></i> New Announcement
                    </button>
                </div>

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" width="10%">ID</th>
                                        <th width="25%">Title</th>
                                        <th width="40%">Content</th>
                                        <th width="15%">Date</th>
                                        <th class="pe-4 text-end" width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $res = $conn->query("SELECT * FROM announcements ORDER BY date DESC");
                                    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
                                    if(count($rows) > 0) {
                                        foreach($rows as $r) {
                                            echo "<tr>";
                                            echo "<td class='ps-4'>#".$r['id']."</td>";
                                            echo "<td><strong class='text-dark'>".htmlspecialchars($r['title'])."</strong></td>";
                                            echo "<td><div style='max-width: 400px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;' title='".htmlspecialchars($r['body'])."'>".htmlspecialchars($r['body'])."</div></td>";
                                            echo "<td><span class='badge bg-light text-muted border'>".date('M d, Y', strtotime($r['date']))."</span></td>";
                                            echo "<td class='pe-4 text-end'>";
                                            echo "<a href='announcements.php?delete=".$r['id']."' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this announcement?\");'><i class='fa-solid fa-trash'></i></a>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'>No announcements found.</td></tr>";
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

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <form method="POST" action="announcements.php">
                    <div class="modal-header bg-primary text-white border-0">
                        <h5 class="modal-title"><i class="fa-solid fa-bullhorn me-2"></i>Create Announcement</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" name="add_announcement" value="1">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="Enter title (e.g. URGENT: Road Closure)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Announcement Body</label>
                            <textarea name="body" class="form-control" rows="5" required placeholder="Detailed information..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 pe-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Publish Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success')) {
            let msg = urlParams.get('success') === 'add' ? 'Announcement Published' : 'Announcement Deleted';
            Swal.fire({ icon: 'success', title: msg, showConfirmButton: false, timer: 1500 });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        if (urlParams.has('error')) {
            Swal.fire({ icon: 'error', title: 'Error processing request', text: 'Please ensure all fields are filled.', showConfirmButton: true });
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>
