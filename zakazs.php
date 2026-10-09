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

// Пользователь видит только заказы, которые уже приняты админом в работу
// (in_progress, completed). Отменённые и новые (на подтверждении) — скрыты.
$orders = array_values(array_filter($orders, function($o) {
    return in_array($o['status'], ['in_progress', 'completed']);
}));

require_once 'html/main.php';
?>