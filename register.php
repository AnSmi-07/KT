<?php
require_once 'src/Base.php';

$title = 'Регистрация';
$content = 'register';
$error = '';
$success = '';

if ($auth_user) {
    redirect('index.php');
}

if (isset($request->submit)) {
    $login = trim($request->login);
    $password = $request->password;
    $confirm = $request->confirm;
    $email = trim($request->email);
    
    if (!$login || !$password || !$confirm || !$email) {
        $error = 'Заполните все поля';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают';
    } elseif (strlen($password) < 4) {
        $error = 'Пароль должен быть не менее 4 символов';
    } else {
        $existing = $db->getRowByWhere('users', '`login` = ?', array($login));
        if ($existing) {
            $error = 'Логин уже занят';
        } else {
            $hashed = md5($password . SECRET);
            $data = array(
                'login' => $login,
                'password' => $hashed,
                'email' => $email,
                'role' => 0,
                'created_at' => date('Y-m-d')
            );
            $db->insert('users', $data);
            $success = 'Регистрация успешна! Теперь вы можете <a href="login.php">войти</a>.';
        }
    }
}
require_once 'html/main.php';
?>