CREATE DATABASE rental_management;

USE rental_management;

CREATE TABLE equipment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255),
    price_per_day DECIMAL(10, 2) NOT NULL,
    availability BOOLEAN DEFAULT 1
);

INSERT INTO equipment (name, type, price_per_day, availability)
VALUES 
    ('Tractor', 'Heavy Machinery', 100.00, 1),
    ('Plough', 'Tool', 25.00, 1),
    ('Harvester', 'Heavy Machinery', 150.00, 1),
    ('Seeder', 'Tool', 30.00, 1),
    ('Sprayer', 'Tool', 20.00, 1),
    ('Cultivator', 'Heavy Machinery', 75.00, 1),
    ('Baler', 'Heavy Machinery', 200.00, 1);
