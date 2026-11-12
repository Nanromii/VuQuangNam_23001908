<?php
header('Content-Type: application/json; charset=utf-8');

function respond(bool $success, int $status = 200, array $extra = []): void
{
    http_response_code($status);
    echo json_encode(array_merge(['success' => $success], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

function readProduct(): array
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        respond(false, 400, ['message' => 'Dữ liệu JSON không hợp lệ.']);
    }

    $name = $input['name'] ?? null;
    $price = $input['price'] ?? null;
    $stock = $input['stock'] ?? null;

    if (!is_string($name)) {
        respond(false, 400, ['message' => 'Tên sản phẩm không hợp lệ.']);
    }
    $name = trim($name);
    $length = preg_match_all('/./us', $name);
    if ($length < 1 || $length > 100) {
        respond(false, 400, ['message' => 'Tên sản phẩm phải có từ 1 đến 100 ký tự.']);
    }
    if (!is_int($price) || $price <= 0) {
        respond(false, 400, ['message' => 'Đơn giá phải là số nguyên lớn hơn 0.']);
    }
    if (!is_int($stock) || $stock < 0) {
        respond(false, 400, ['message' => 'Số lượng tồn phải là số nguyên không âm.']);
    }

    return [$name, $price, $stock];
}

function getId(): int
{
    $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);
    if ($id === false) {
        respond(false, 400, ['message' => 'Mã sản phẩm không hợp lệ.']);
    }
    return $id;
}

try {
    // Sửa tài khoản/mật khẩu ở đây nếu MySQL không dùng cấu hình mặc định của XAMPP.
    $pdo = new PDO('mysql:host=localhost;dbname=thuchanh8;charset=utf8mb4', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET') {
        $rows = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id')->fetchAll();
        respond(true, 200, ['data' => $rows]);
    }

    if ($method === 'POST') {
        [$name, $price, $stock] = readProduct();
        $stmt = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (?, ?, ?)');
        $stmt->execute([$name, $price, $stock]);
        respond(true, 201, ['message' => 'Thêm sản phẩm thành công.']);
    }

    if ($method === 'PUT') {
        $id = getId();
        [$name, $price, $stock] = readProduct();
        $check = $pdo->prepare('SELECT id FROM products WHERE id = ?');
        $check->execute([$id]);
        if (!$check->fetch()) {
            respond(false, 404, ['message' => 'Sản phẩm không tồn tại.']);
        }
        $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ? WHERE id = ?');
        $stmt->execute([$name, $price, $stock, $id]);
        respond(true, 200, ['message' => 'Cập nhật thành công.']);
    }

    if ($method === 'DELETE') {
        $id = getId();
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 0) {
            respond(false, 404, ['message' => 'Sản phẩm không tồn tại.']);
        }
        respond(true, 200, ['message' => 'Xóa sản phẩm thành công.']);
    }

    respond(false, 405, ['message' => 'Phương thức không được hỗ trợ.']);
} catch (PDOException $e) {
    respond(false, 500, ['message' => 'Lỗi kết nối hoặc truy vấn cơ sở dữ liệu.']);
}
