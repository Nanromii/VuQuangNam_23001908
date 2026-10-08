<?php
require_once __DIR__ . '/model/product.php';
require_once __DIR__ . '/common/helpers.php';
$id = productIdFromGet();
$product = $id === null ? null : getProductById($id);
if (!$product) {
    http_response_code(404);
    $pageTitle = 'Không tìm thấy sản phẩm';
    require __DIR__ . '/view/header.php';
    echo '<section><p >Sản phẩm không tồn tại hoặc ID không hợp lệ.</p><a href="product_list.php">Quay lại danh sách</a></section>';
    require __DIR__ . '/view/footer.php';
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteProduct($id);
    header('Location: product_list.php?message=deleted');
    exit;
}
$pageTitle = 'Xác nhận xóa sản phẩm';
require __DIR__ . '/view/header.php';
?>
<section>
    <h2>Xác nhận xóa sản phẩm</h2>
    <p>Bạn có chắc muốn xóa <strong><?= e($product['name']) ?></strong> (ID: <?= (int)$id ?>)?</p>
    <form method="post" action="product_delete.php?id=<?= (int)$id ?>">
        <p><button type="submit">Xác nhận xóa</button> &nbsp; <a href="product_list.php">Hủy</a></p>
    </form>
</section>
<?php require __DIR__ . '/view/footer.php'; ?>
