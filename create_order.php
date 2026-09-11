<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}

$title = 'Оформление заказа';
$content = 'create_order';

$product_id = isset($request->id) ? (int)$request->id : 0;
$product = $db->getProductById($product_id);

if (!$product) {
    redirect('katalog.php');
}

$message = '';

if (isset($request->submit_order)) {
    $order_date = $request->order_date;

    if (empty($order_date)) {
        $message = '<p class="error-message">Выберите дату получения.</p>';
    } else {
        if ($db->createOrder($auth_user['id'], $product_id, $order_date)) {
            redirect('zakazs.php?success=1');
        } else {
            $message = '<p class="error-message">Ошибка при создании заказа. Попробуйте снова.</p>';
        }
    }
}

require_once 'html/main.php';
?>