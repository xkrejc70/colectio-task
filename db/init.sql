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
    ('Bob', 'Bob Minion with Robot Arms', 50.00, 'EUR');
