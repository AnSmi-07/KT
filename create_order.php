<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}

$title = 'Оформление заказа';
$content = 'create_order';

if (empty($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    redirect('cart.php');
}

// Собираем позиции
$items = array();
$total = 0;
foreach ($_SESSION['cart'] as $pid => $qty) {
    $product = $db->getProductById($pid);
    if ($product) {
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
        $items[] = array(
            'product_id' => $pid,
            'quantity'   => $qty,
            'price'      => $product['price'],
            'name'       => $product['name'],
            'image'      => $product['image'],
            'subtotal'   => $subtotal
        );
    }
}

if (empty($items)) {
    redirect('cart.php');
}

$message = '';

if (isset($request->submit_order)) {
    $order_date = $request->order_date;

    if (empty($order_date)) {
        $message = '<p class="text-danger">Выберите дату получения.</p>';
    } else {
        if ($db->createOrderWithItems($auth_user['id'], $order_date, $items)) {
            $_SESSION['cart'] = array();
            redirect('zakazs.php?success=1');
        } else {
            $message = '<p class="text-danger">Ошибка при создании заказа. Попробуйте снова.</p>';
        }
    }
}

require_once 'html/main.php';
?>