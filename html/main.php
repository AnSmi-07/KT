<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.6.0/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg primary-color">
    <div class="container">
        <a class="navbar-brand" href="index.php">ВЯЗГРУШка</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-2"><a class="nav-link" href="index.php"><i class="fa-solid fa-house" title="Главная"></i></a></li>
                <li class="nav-item mx-2"><a class="nav-link" href="katalog.php"><i class="fa-solid fa-book" title="Каталог"></i></a></li>
                <?php
                    $cart_count = 0;
                    if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $q) $cart_count += $q;
                    }
                ?>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping" title="Корзина"></i><?= $cart_count > 0 ? ' (' . $cart_count . ')' : '' ?></a>
                </li>
                <li class="nav-item mx-2"><a class="nav-link" href="zakazs.php"><i class="fa-solid fa-user" title="Личный кабинет"></i></a></li>
                <?php if ($auth_user && $auth_user['role'] == 1): ?>
                    <li class="nav-item mx-2"><a class="nav-link" href="administration.php"><i class="fa-brands fa-web-awesome" title="Панель-администратора"></i></a></li>
                <?php endif; ?>
                <?php if ($auth_user): ?>
                    <li class="nav-item ml-2"><a class="nav-link text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" title="Выход"></i> (<?php echo htmlspecialchars($auth_user['login']); ?>)</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <?php require_once "html/$content.php"; ?>
</main>

<footer class="primary-color text-center py-3 mt-5">
    <p class="mb-0">©️ Все права защищены</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>