<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg primary-color">
    <div class="container">
        <a class="navbar-brand" href="index.php">ВЯЗГРУШИНКИ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="katalog.php">Каталог</a></li>
                <li class="nav-item"><a class="nav-link" href="zakazs.php">Личный кабинет</a></li>
                <?php if ($auth_user && $auth_user['role'] == 1): ?>
                    <li class="nav-item"><a class="nav-link" href="administration.php">Админ-панель</a></li>
                <?php endif; ?>
                <?php if ($auth_user): ?>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Выйти (<?php echo htmlspecialchars($auth_user['login']); ?>)</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">
    <?php require_once "html/$content.php"; ?>
</main>

<footer class="secondary-color text-center py-3 mt-5">
    <p class="mb-0">©️ Все права защищены</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>