<?php
require_once 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate inputs
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $contact = filter_var(trim($_POST["contact"]), FILTER_SANITIZE_STRING);
    $category = filter_var(trim($_POST["category"]), FILTER_SANITIZE_STRING);
    $area = filter_var(trim($_POST["area"]), FILTER_SANITIZE_STRING);
    $description = filter_var(trim($_POST["description"]), FILTER_SANITIZE_STRING);
    
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
        $stmt->bind_param("sssss", $name, $contact, $category, $description, $area);
        
        if ($stmt->execute()) {
            // Success
            $stmt->close();
            mysqli_close($conn);
            header("Location: home.php?success=complaint");
            exit();
        } else {
            // Execution failed
            $stmt->close();
            mysqli_close($conn);
            header("Location: complaint.php?error=db");
            exit();
        }
    } else {
        // Preparation failed
        mysqli_close($conn);
        header("Location: complaint.php?error=db");
        exit();
    }
} else {
    // Direct access to this file is not allowed
    header("Location: complaint.php");
    exit();
}
?>
