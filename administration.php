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

// Обновление статуса заказа
if (isset($request->update_status) && isset($request->order_id) && isset($request->status)) {
    $db->updateOrderStatus((int)$request->order_id, $request->status);
    redirect('administration.php#orders');
}

// Отмена заказа
if (isset($request->cancel_order) && isset($request->order_id)) {
    $db->updateOrderStatus((int)$request->order_id, 'cancelled');
    redirect('administration.php#orders');
}

// Добавление товара
if (isset($request->add_product)) {
    $name = trim($request->name);
    $description = trim($request->description);
    $price = (float)$request->price;
    $image = trim($request->image);

    if ($name !== '' && $price > 0) {
        $db->addProduct($name, $description, $price, $image);
    }
    redirect('administration.php#products');
}

// Редактирование товара
if (isset($request->update_product)) {
    $id = (int)$request->product_id;
    $name = trim($request->name);
    $description = trim($request->description);
    $price = (float)$request->price;
    $image = trim($request->image);

    if ($id > 0 && $name !== '' && $price > 0) {
        $db->updateProduct($id, $name, $description, $price, $image);
    }
    redirect('administration.php#products');
}

// Удаление товара
if (isset($request->delete_product)) {
    $id = (int)$request->product_id;
    if ($id > 0) {
        $db->deleteProduct($id);
    }
    redirect('administration.php#products');
}

$orders = $db->getAllOrders();
foreach ($orders as &$o) {
    $o['items'] = $db->getOrderItems($o['id']);
}
unset($o);
$products = $db->getRows('products', '', array(), 'name');

$editProduct = null;
if ($request->edit_id) {
    $editProduct = $db->getProductById((int)$request->edit_id);
    if (empty($editProduct)) {
        $editProduct = null;
    }
}

require_once 'html/main.php';
?>