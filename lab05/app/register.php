<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/common/helpers.php';

if (isset($_SESSION['user_id'])) {
    header('Location: product_list.php');
    exit;
}

$username = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/model/user.php';
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username === '') {
        $errors[] = 'Tên đăng nhập không được để trống.';
    } elseif (characterLength($username) > 50) {
        $errors[] = 'Tên đăng nhập không được vượt quá 50 ký tự.';
    }
    if (trim($password) === '') {
        $errors[] = 'Mật khẩu không được để trống.';
    }
    if (!$errors && getUserByUsername($username)) {
        $errors[] = 'Tên đăng nhập đã tồn tại.';
    }

    if (!$errors) {
        try {
            addUser($username, password_hash($password, PASSWORD_DEFAULT));
            header('Location: login.php?registered=1');
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $errors[] = 'Tên đăng nhập đã tồn tại.';
            } else {
                throw $e;
            }
        }
    }
}

$pageTitle = 'Đăng ký';
require __DIR__ . '/view/header.php';
?>
<h2>Đăng ký</h2>
<?php if ($errors): ?>
    <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
<?php endif; ?>
<form method="post" action="register.php">
    <p><label for="username">Tên đăng nhập:</label> <input id="username" name="username" type="text" maxlength="50" required value="<?= e($username) ?>"></p>
    <p><label for="password">Mật khẩu:</label> <input id="password" name="password" type="password" required></p>
    <p><button type="submit">Đăng ký</button></p>
</form>
<p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
<?php require __DIR__ . '/view/footer.php'; ?>
