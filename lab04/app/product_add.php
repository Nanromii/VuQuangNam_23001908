<?php
require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/helpers.php';
$name = '';
$price = '';
$quantity = '0';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string)($_POST['name'] ?? ''));
    $price = trim((string)($_POST['price'] ?? ''));
    $quantity = trim((string)($_POST['quantity'] ?? ''));

    if (preg_match('/^[0-9]+$/', $quantity)) {
        $quantity = (string)(int)$quantity;
    }

    $errors = validProductInput($name, $price, $quantity);

    if (!$errors) {
        addProduct($name, (float)$price, (int)$quantity);
        header('Location: product_list.php?message=added');
        exit;
    }
}
$pageTitle = 'Thêm sản phẩm';
require __DIR__ . '/view/header.php';
?>
<section>
    <h2>Thêm sản phẩm</h2>
    <?php if ($errors): ?><div>
            <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
        </div><?php endif; ?>
    <form method="post" action="product_add.php">
        <p><label for="name">Tên sản phẩm:</label> <input id="name" name="name" type="text" maxlength="100" required value="<?= e($name) ?>"></p>
        <p><label for="price">Giá:</label> <input id="price" name="price" type="number" min="0.01" step="0.01" required value="<?= e($price) ?>"></p>
        <p><label for="quantity">Số lượng:</label> <input id="quantity" name="quantity" type="number" min="0" step="1" required value="<?= e($quantity) ?>"></p>
        <p><button type="submit">Lưu sản phẩm</button> &nbsp; <a href="product_list.php">Hủy</a></p>
    </form>
</section>
<?php require __DIR__ . '/view/footer.php'; ?>