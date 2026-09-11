<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}

$title = 'Мои заказы';
$content = 'zakazs';

// Обработка отзыва
if (isset($request->submit_review) && isset($request->order_id) && isset($request->review_text)) {
    $orderId = (int)$request->order_id;
    $review = trim($request->review_text);
    if (!empty($review)) {
        $db->addReview($orderId, $review);
        redirect('zakazs.php');
    }
}

$orders = $db->getUserOrders($auth_user['id']);
foreach ($orders as &$o) {
    $o['items'] = $db->getOrderItems($o['id']);
}
unset($o);

$orders = array_values(array_filter($orders, function($o) {
    return $o['status'] !== 'cancelled';
}));
require_once 'html/main.php';
?>