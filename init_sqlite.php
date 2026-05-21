<?php
try {
    $db = new PDO('sqlite:city_portal.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
    CREATE TABLE IF NOT EXISTS complaints (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        contact TEXT NOT NULL,
        category TEXT NOT NULL,
        description TEXT NOT NULL,
        area TEXT NOT NULL,
        status TEXT DEFAULT 'Pending',
        date DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS announcements (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        body TEXT NOT NULL,
        date DATETIME DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT EXISTS services (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        address TEXT NOT NULL,
        phone TEXT NOT NULL,
        hours TEXT NOT NULL
    );

    CREATE TABLE IF NOT EXISTS admin (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL
    );
    ";
    
    $db->exec($sql);

    // Insert Default admin if not exists
    $stmt = $db->query("SELECT COUNT(*) FROM admin");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO admin (username, password) VALUES ('admin', '$2y$10\$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm')");
    }

    // Insert sample services if empty
    $stmt = $db->query("SELECT COUNT(*) FROM services");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("
        INSERT INTO services (name, address, phone, hours) VALUES 
        ('City General Hospital', '123 Main St, Health District', '555-0100', '24/7'),
        ('Water Department', '45 Waterway Ave, Utilities Park', '555-0200', 'Mon-Fri 8AM-5PM'),
        ('Electricity Office', '88 Power Blvd, Central', '555-0300', 'Mon-Fri 8AM-5PM'),
        ('Central Bus Terminal', '200 Transit Way', '555-0400', '24/7'),
        ('City Police Department', '1 Police Plaza', '911', '24/7'),
        ('City Fire Department', '1 Firehouse Lane', '911', '24/7');
        ");
    }

    // Insert sample announcements if empty
    $stmt = $db->query("SELECT COUNT(*) FROM announcements");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("
        INSERT INTO announcements (title, body) VALUES
        ('Water Main Break on 5th Ave', 'Please be advised that emergency repairs are underway on 5th Avenue. Expect low water pressure in the surrounding areas.'),
        ('City Park Renovation Started', 'The central park will be closed for the next two weeks for scheduled renovations and tree planting.');
        ");
    }

    echo "Database initialized successfully.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
