<?php
session_start();
require_once '../includes/config.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST["username"]), ENT_QUOTES, 'UTF-8');
    $password = trim($_POST["password"]);
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin'] = $row['username'];
                header("Location: dashboard.php?success=login");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CityConnect</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.8) 0%, rgba(25, 135, 84, 0.8) 100%), url('../assets/images/city-banner.jpg') center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

    <div class="container px-4">
        <div class="login-card mx-auto animate-fade-in">
            <div class="bg-primary text-white text-center p-4">
                <i class="fa-solid fa-shield-halved fa-3x mb-2"></i>
                <h3 class="fw-bold m-0">Admin Access</h3>
                <p class="mb-0 small text-white-50">CityConnect Portal Management</p>
            </div>
            
            <div class="p-4 p-md-5">
                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger p-2 mb-4 fs-6">
                        <i class="fa-solid fa-circle-exclamation me-2"></i><?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form action="login.php" method="POST">
                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold text-muted">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0 bg-light" id="username" name="username" required>
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="form-label fw-semibold text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0 ps-0 bg-light" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">
                        Login to Dashboard <i class="fa-solid fa-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="../home.php" class="text-decoration-none text-muted small"><i class="fa-solid fa-arrow-left me-1"></i> Back to Public Portal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
