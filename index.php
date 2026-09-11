<?php
require_once 'src/Base.php';
if (!$auth_user) {
    redirect('login.php');
}
$title = 'Канцтоварики - Главная';
$content = 'index';
require_once 'html/main.php';
?>