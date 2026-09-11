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
        $user = $db->getRowByWhere('users', '`login` = ?', array($login));
        $ok = false;

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $ok = true;
            } elseif (defined('SECRET') && $user['password'] === md5($password . SECRET)) {
                // старый md5-хеш — пускаем и обновляем на новый
                $ok = true;
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $db->update('users', array('password'), array($newHash), '`id` = ?', array($user['id']));
            }
        }

        if ($ok) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            redirect('index.php');
        } else {
            $error = 'Неверный логин или пароль';
        }
    }
}
require_once 'html/main.php';
?>