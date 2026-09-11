<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}

$title = 'Корзина';
$content = 'cart';

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$product_id = (int)$request->product_id;
$action = $request->action;

// Добавление из каталога — возвращаемся обратно в каталог
if (isset($request->add_to_cart) && $product_id > 0) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    redirect('katalog.php?added=1');
}

// Увеличить
if ($action === 'inc' && $product_id > 0) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    }
    redirect('cart.php');
}

// Уменьшить
if ($action === 'dec' && $product_id > 0) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]--;
        if ($_SESSION['cart'][$product_id] <= 0) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    redirect('cart.php');
}

// Удалить позицию
if ($action === 'remove' && $product_id > 0) {
    unset($_SESSION['cart'][$product_id]);
    redirect('cart.php');
}

// Очистить корзину
if ($action === 'clear') {
    $_SESSION['cart'] = array();
    redirect('cart.php');
}

// Собираем данные для вывода
$cartItems = array();
$cartTotal = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    $product = $db->getProductById($pid);
    if ($product) {
        $product['quantity'] = $qty;
        $product['subtotal'] = $product['price'] * $qty;
        $cartTotal += $product['subtotal'];
        $cartItems[] = $product;
    }
}

require_once 'html/main.php';
?>