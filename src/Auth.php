<?php
// Проверяем, авторизован ли пользователь
$auth_user = null;
if (isset($_SESSION['user_id'])) {
    $auth_user = $db->getRowById('users', $_SESSION['user_id']);
}
?>