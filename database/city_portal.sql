CREATE DATABASE IF NOT EXISTS city_portal;
USE city_portal;

CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    area VARCHAR(100) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(30) NOT NULL,
    hours VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Default admin user with password 'admin123'
-- Hash generated using password_hash("admin123", PASSWORD_DEFAULT);
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm');

-- Sample data for services
INSERT INTO services (name, address, phone, hours) VALUES 
('City General Hospital', '123 Main St, Health District', '555-0100', '24/7'),
('Water Department', '45 Waterway Ave, Utilities Park', '555-0200', 'Mon-Fri 8AM-5PM'),
('Electricity Office', '88 Power Blvd, Central', '555-0300', 'Mon-Fri 8AM-5PM'),
('Central Bus Terminal', '200 Transit Way', '555-0400', '24/7'),
('City Police Department', '1 Police Plaza', '911', '24/7'),
('City Fire Department', '1 Firehouse Lane', '911', '24/7');

-- Sample data for announcements
INSERT INTO announcements (title, body) VALUES
('Water Main Break on 5th Ave', 'Please be advised that emergency repairs are underway on 5th Avenue. Expect low water pressure in the surrounding areas.'),
('City Park Renovation Started', 'The central park will be closed for the next two weeks for scheduled renovations and tree planting.');
