<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}
$title = 'Каталог товаров';
$content = 'katalog';
$products = $db->getRows('products', '', array(), 'name');
require_once 'html/main.php';
?>