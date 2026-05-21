<?php
try {
    $conn = new PDO('sqlite:' . __DIR__ . '/../city_portal.db');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Add dummy mysqli functions for compatibility with some scripts that might still use them accidentally
    // but we will update the main ones.
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}
?>
