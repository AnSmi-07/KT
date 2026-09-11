<?php
require_once 'src/Base.php';

$title = 'Вход';
$content = 'login';
$error = '';

if ($auth_user) {
    redirect('index.php');
}

if (isset($request->submit)) {
    $login = trim($request->login);
    $password = $request->password;
    
    if (!$login || !$password) {
        $error = 'Введите логин и пароль';
    } else {
        $hashed = md5($password . SECRET);
        $user = $db->getRowByWhere('users', '`login` = ? AND `password` = ?', array($login, $hashed));
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            redirect('index.php');
        } else {
            $error = 'Неверный логин или пароль';
        }
    }
}
require_once 'html/main.php';
?>