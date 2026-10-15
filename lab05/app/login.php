<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/common/helpers.php';

if (isset($_SESSION['user_id'])) {
    header('Location: product_list.php');
    exit;
}

$username = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/model/user.php';
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || trim($password) === '') {
        $error = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
    } else {
        $user = getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        }
        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}

$pageTitle = 'Đăng nhập';
require __DIR__ . '/view/header.php';
?>
<h2>Đăng nhập</h2>
<?php if (isset($_GET['registered']) && $_GET['registered'] === '1'): ?>
    <p>Đăng ký thành công. Vui lòng đăng nhập.</p>
<?php endif; ?>
<?php if ($error !== ''): ?><p><?= e($error) ?></p><?php endif; ?>
<form method="post" action="login.php">
    <p><label for="username">Tên đăng nhập:</label> <input id="username" name="username" type="text" maxlength="50" required value="<?= e($username) ?>"></p>
    <p><label for="password">Mật khẩu:</label> <input id="password" name="password" type="password" required></p>
    <p><button type="submit">Đăng nhập</button></p>
</form>
<p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
<?php require __DIR__ . '/view/footer.php'; ?>
