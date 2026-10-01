-- =========================================================
-- BAI 1
-- =========================================================
CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

DROP TABLE IF EXISTS cart_items;

CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

-- 1. Thêm 5 sản phẩm vào bảng
INSERT INTO cart_items (name, price, quantity) VALUES
('Bàn phím cơ', 750000, 2),
('Chuột không dây', 350000, 6),
('Tai nghe Bluetooth', 1200000, 3),
('Cáp sạc USB-C', 90000, 10),
('Đế tản nhiệt laptop', 280000, 7);

-- 2. Hiển thị toàn bộ sản phẩm
SELECT * FROM cart_items;

-- 3. Hiển thị sản phẩm có giá lớn hơn 100000
SELECT *
FROM cart_items
WHERE price > 100000;

-- 4. Hiển thị sản phẩm có số lượng lớn hơn 5
SELECT *
FROM cart_items
WHERE quantity > 5;

-- 5. Sắp xếp sản phẩm theo giá giảm dần
SELECT *
FROM cart_items
ORDER BY price DESC;

-- 6. Cập nhật giá của một sản phẩm
UPDATE cart_items
SET price = 800000
WHERE id = 1;

-- Kiểm tra kết quả sau khi cập nhật giá
SELECT *
FROM cart_items
WHERE id = 1;

-- 7. Cập nhật số lượng của một sản phẩm
UPDATE cart_items
SET quantity = 8
WHERE id = 3;

-- Kiểm tra kết quả sau khi cập nhật số lượng
SELECT *
FROM cart_items
WHERE id = 3;

-- 8. Xóa một sản phẩm
DELETE FROM cart_items
WHERE id = 4;

-- Kiểm tra danh sách sau khi xóa
SELECT * FROM cart_items;

-- 9. Hiển thị tên sản phẩm, giá, số lượng và thành tiền
SELECT
    name,
    price,
    quantity,
    price * quantity AS thanh_tien
FROM cart_items;

-- 10. Tính tổng tiền của toàn bộ giỏ hàng
SELECT SUM(price * quantity) AS tong_tien_gio_hang
FROM cart_items;


-- =========================================================
-- BAI 2
-- =========================================================
CREATE DATABASE IF NOT EXISTS movie_ticket;
USE movie_ticket;

DROP TABLE IF EXISTS movies;

CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

-- 1. Thêm 5 bộ phim
INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Avengers: Endgame', 120000, 150, 40),
('Interstellar', 90000, 120, 55),
('Spider-Man: No Way Home', 110000, 180, 60),
('Dune: Part Two', 130000, 200, 80),
('Inside Out 2', 85000, 100, 70);

-- 2. Hiển thị toàn bộ danh sách phim
SELECT * FROM movies;

-- 3. Hiển thị phim có giá vé lớn hơn 100000
SELECT *
FROM movies
WHERE price > 100000;

-- 4. Hiển thị phim còn nhiều hơn 50 ghế
SELECT *
FROM movies
WHERE available_seats > 50;

-- 5. Sắp xếp phim theo giá vé giảm dần
SELECT *
FROM movies
ORDER BY price DESC;

-- 6. Cập nhật số ghế còn lại của một phim
UPDATE movies
SET available_seats = 35
WHERE id = 1;

-- Kiểm tra kết quả sau khi cập nhật
SELECT *
FROM movies
WHERE id = 1;

-- 7. Xóa một phim
DELETE FROM movies
WHERE id = 5;

-- Kiểm tra danh sách sau khi xóa
SELECT * FROM movies;

-- 8. Hiển thị số vé đã bán của từng phim
SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS so_ve_da_ban
FROM movies;

-- 9. Tính doanh thu của từng phim
SELECT
    title,
    price,
    total_seats - available_seats AS so_ve_da_ban,
    (total_seats - available_seats) * price AS doanh_thu
FROM movies;

-- 10. Tính tổng doanh thu của tất cả các phim
SELECT SUM((total_seats - available_seats) * price) AS tong_doanh_thu
FROM movies;

-- 11. Tìm phim có số vé bán ra nhiều nhất
SELECT
    title,
    total_seats - available_seats AS so_ve_da_ban
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);
