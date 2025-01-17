CREATE DATABASE IF NOT EXISTS app_db;
USE app_db;

-- to store conversion rates between all currencies extra table needed (currency pairs with rates)
CREATE TABLE IF NOT EXISTS `currencies` (
    code CHAR(3) PRIMARY KEY,
    name VARCHAR(64) NOT NULL,
    rate DECIMAL(15, 6) NOT NULL
);

CREATE TABLE IF NOT EXISTS `items` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price DECIMAL(10, 2) NOT NULL,
    currencyCode CHAR(3) NOT NULL,
    FOREIGN KEY (currencyCode) REFERENCES `currencies` (code)
);

CREATE INDEX idx_currency_code ON `items` (currencyCode);

INSERT INTO `currencies` (code, name, rate) VALUES
    ('USD', 'US Dollar', 24.52),
    ('EUR', 'Euro', 25.27),
    ('CZK', 'Czech koruna', 1.00);

INSERT INTO `items` (name, description, price, currencyCode) VALUES
    ('Lego', 'A rare Lego set from 2008.', 100.00, 'USD'),
    ('Bob', 'Bob Minion with Robot Arms', 50.00, 'EUR'),
    ('Smartphone', 'Latest model with 128GB storage', 500.00, 'USD'),
    ('Laptop', '15-inch laptop with 16GB RAM and 512GB SSD', 1200.00, 'USD'),
    ('Headphones', 'Noise-canceling wireless headphones', 150.00, 'USD'),
    ('TV', '55-inch 4K UHD Smart TV', 800.00, 'USD'),
    ('Smartwatch', 'Fitness tracker with heart rate monitor', 200.00, 'EUR'),
    ('Camera', 'DSLR camera with 18-55mm lens', 600.00, 'EUR'),
    ('Shoes', 'Running shoes, size 42', 80.00, 'USD'),
    ('Backpack', 'Waterproof hiking backpack', 45.00, 'EUR'),
    ('Watch', 'Elegant wristwatch with leather strap', 150.00, 'EUR'),
    ('Blender', 'High-speed kitchen blender', 120.00, 'USD'),
    ('Microwave', 'Compact microwave oven', 100.00, 'USD'),
    ('Book', 'Bestseller novel by popular author', 25.00, 'EUR'),
    ('Table', 'Wooden dining table, 6 seats', 300.00, 'USD'),
    ('Couch', 'Comfortable 3-seater couch', 700.00, 'USD'),
    ('Jacket', 'Leather jacket, size M', 150.00, 'EUR');
