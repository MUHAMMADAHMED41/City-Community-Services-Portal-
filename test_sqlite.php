<?php
try {
    $db = new PDO('sqlite:city_portal.db');
    echo "Success PDO SQLite";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
