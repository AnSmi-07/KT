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
    $login    = trim($request->login);
    $fio      = trim($request->fio);
    $phone    = trim($request->phone);
    $email    = trim($request->email);
    $password = $request->password;
    $confirm  = $request->confirm;

    if (!$login || !$fio || !$phone || !$email || !$password || !$confirm) {
        $error = 'Заполните все поля';
    } elseif (!preg_match('/^[A-Za-z0-9]{6,}$/', $login)) {
        $error = 'Логин должен содержать только латиницу и цифры, не менее 6 символов';
    } elseif (!preg_match('/^[А-Яа-яЁё\s]+$/u', $fio)) {
        $error = 'ФИО должно содержать только кириллицу и пробелы';
    } elseif (!preg_match('/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $phone)) {
        $error = 'Телефон должен быть в формате 8(XXX)XXX-XX-XX';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Некорректный email';
    } elseif (strlen($password) < 8) {
        $error = 'Пароль должен быть не менее 8 символов';
    } elseif ($password !== $confirm) {
        $error = 'Пароли не совпадают';
    } else {
        $existing = $db->getRowByWhere('users', '`login` = ?', array($login));
        if ($existing) {
            $error = 'Логин уже занят';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $data = array(
                'login'    => $login,
                'fio'      => $fio,
                'phone'    => $phone,
                'password' => $hashed,
                'email'    => $email,
                'role'     => 0,
                'created_at' => date('Y-m-d')
            );
            $db->insert('users', $data);
            $success = 'Регистрация успешна! Теперь вы можете <a href="login.php">войти</a>.';
        }
    }
}
require_once 'html/main.php';
?>