CREATE DATABASE IF NOT EXISTS shopping_cart
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Bàn phím cơ', 850000.00, 12),
('Chuột không dây', 320000.00, 25),
('Tai nghe Bluetooth', 690000.00, 15),
('Màn hình 24 inch', 3200000.00, 8),
('Ổ cứng SSD 512GB', 1250000.00, 20);
