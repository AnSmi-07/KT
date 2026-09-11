<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}
if ($auth_user['role'] != 1) {
    redirect('403.php');
}

$title = 'Админ-панель';
$content = 'administration';

if (isset($request->update_status) && isset($request->order_id) && isset($request->status)) {
    $db->updateOrderStatus((int)$request->order_id, $request->status);
    redirect('administration.php');
}

$orders = $db->getAllOrders();
require_once 'html/main.php';
?>