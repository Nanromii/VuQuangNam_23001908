<?php
require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts()
{
    global $conn;
    $result = $conn->query('SELECT id, name, price, quantity FROM products ORDER BY id ASC');
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductById($id)
{
    global $conn;
    $stmt = $conn->prepare('SELECT id, name, price, quantity FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addProduct($name, $price, $quantity)
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)');
    $stmt->bind_param('sdi', $name, $price, $quantity);
    return $stmt->execute();
}

function updateProduct($id, $name, $price, $quantity)
{
    global $conn;
    $stmt = $conn->prepare('UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?');
    $stmt->bind_param('sdii', $name, $price, $quantity, $id);
    return $stmt->execute();
}

function deleteProduct($id)
{
    global $conn;
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}
