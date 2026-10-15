<?php
require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername($username)
{
    global $conn;
    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function addUser($username, $passwordHash)
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    $stmt->bind_param('ss', $username, $passwordHash);
    return $stmt->execute();
}
