<?php
require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/helpers.php';
$products = getAllProducts();
$pageTitle = 'Danh sách sản phẩm';
require __DIR__ . '/view/header.php';
?>
<section>
    <h2>Danh sách sản phẩm</h2>
    <p><a href="product_add.php">+ Thêm sản phẩm</a></p>
    <?php if (isset($_GET['message']) && in_array($_GET['message'], ['added', 'updated', 'deleted'], true)): ?>
        <?php $messages = ['added' => 'Đã thêm sản phẩm.', 'updated' => 'Đã cập nhật sản phẩm.', 'deleted' => 'Đã xóa sản phẩm.']; ?>
        <p class="notice success"><?= e($messages[$_GET['message']]) ?></p>
    <?php endif; ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Chức năng</th></tr></thead>
        <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= (int)$product['id'] ?></td>
                <td><?= e($product['name']) ?></td>
                <td><?= rtrim(rtrim(number_format((float)$product['price'], 2, ',', '.'), '0'), ',') ?></td>
                <td><?= (int)$product['quantity'] ?></td>
                <td><a href="product_edit.php?id=<?= (int)$product['id'] ?>">Sửa</a> | <a href="product_delete.php?id=<?= (int)$product['id'] ?>">Xóa</a></td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$products): ?><tr><td colspan="5">Chưa có sản phẩm nào.</td></tr><?php endif; ?>
        </tbody>
    </table>
</section>
<?php require __DIR__ . '/view/footer.php'; ?>
