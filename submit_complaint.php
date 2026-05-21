<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Collect inputs and prepare them for storage
    $name = htmlspecialchars(trim($_POST["name"]), ENT_QUOTES, 'UTF-8');
    $contact = trim($_POST["contact"]);
    $category = htmlspecialchars(trim($_POST["category"]), ENT_QUOTES, 'UTF-8');
    $area = htmlspecialchars(trim($_POST["area"]), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST["description"]), ENT_QUOTES, 'UTF-8');
    
    // Basic backend validation
    if (empty($name) || empty($contact) || empty($category) || empty($area) || empty($description)) {
        header("Location: complaint.php?error=empty");
        exit();
    }
    
    if (!preg_match("/^[0-9]+$/", $contact)) {
        header("Location: complaint.php?error=invalid_contact");
        exit();
    }
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO complaints(name, contact, category, description, area) VALUES (?, ?, ?, ?, ?)");
    
    if ($stmt) {
        if ($stmt->execute([$name, $contact, $category, $description, $area])) {
            // Success
            header("Location: home.php?success=complaint");
            exit();
        } else {
            // Execution failed
            header("Location: complaint.php?error=db");
            exit();
        }
    } else {
        // Preparation failed
        header("Location: complaint.php?error=db");
        exit();
    }
} else {
    // Direct access to this file is not allowed
    header("Location: complaint.php");
    exit();
}
?>
