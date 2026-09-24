<?php

declare(strict_types=1);

require_once __DIR__ . '/ShoppingCart.php';

function printOutput(string $content = ''): void
{
    if (PHP_SAPI === 'cli') {
        echo $content . PHP_EOL;
        return;
    }

    echo nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '<br>';
}

function formatCurrency(float $amount): string
{
    return number_format($amount, 0, ',', '.') . ' VNĐ';
}

printOutput('=== BÀI 1: QUẢN LÝ GIỎ HÀNG ===');

$cart = new ShoppingCart();

try {
    // 1. Tạo ít nhất 04 sản phẩm hợp lệ.
    $products = [
        new CartItem('Laptop', 15000000, 1),
        new CartItem('Chuột không dây', 350000, 2),
        new CartItem('Bàn phím cơ', 1200000, 1),
        new CartItem('Tai nghe', 850000, 2),
    ];

    // 2. Thêm sản phẩm vào giỏ hàng bằng addItem().
    foreach ($products as $product) {
        $cart->addItem($product);
    }

    // 3. Hiển thị giỏ hàng.
    printOutput("\n1. Giỏ hàng ban đầu:");
    printOutput($cart->displayCart());

    // 4. Tính và hiển thị tổng tiền.
    printOutput('2. Tổng tiền giỏ hàng: ' . formatCurrency($cart->calculateTotal()));

    // 5. Xóa một sản phẩm theo tên.
    $productToRemove = 'Bàn phím cơ';
    if ($cart->removeItem($productToRemove)) {
        printOutput("3. Đã xóa sản phẩm: {$productToRemove}");
    } else {
        printOutput("3. Không tìm thấy sản phẩm: {$productToRemove}");
    }

    // 6. Hiển thị lại giỏ hàng sau khi xóa.
    printOutput("\n4. Giỏ hàng sau khi xóa:");
    printOutput($cart->displayCart());
} catch (InvalidArgumentException $exception) {
    printOutput('Lỗi dữ liệu: ' . $exception->getMessage());
}

// ------------------------------------------------------------
// Kiểm tra các trường hợp không hợp lệ bắt buộc của đề bài.
// ------------------------------------------------------------
printOutput("\n=== KIỂM TRA TRƯỜNG HỢP NGOẠI LỆ ===");

$invalidProducts = [
    ['Sản phẩm giá 0', 0, 1],
    ['Sản phẩm giá âm', -10000, 1],
    ['Sản phẩm số lượng 0', 10000, 0],
    ['Sản phẩm số lượng âm', 10000, -2],
];

foreach ($invalidProducts as [$name, $price, $quantity]) {
    try {
        $cart->addItem(new CartItem($name, $price, $quantity));
    } catch (InvalidArgumentException $exception) {
        printOutput("- Không thể thêm sản phẩm: {$exception->getMessage()}");
    }
}

$missingProduct = 'Sản phẩm không tồn tại';
if (!$cart->removeItem($missingProduct)) {
    printOutput("- Không thể xóa '{$missingProduct}': không tìm thấy sản phẩm trong giỏ hàng.");
}

$emptyCart = new ShoppingCart();
printOutput('- Tổng tiền của giỏ hàng rỗng: ' . formatCurrency($emptyCart->calculateTotal()));
printOutput($emptyCart->displayCart());
