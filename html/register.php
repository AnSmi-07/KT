<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center caveat">Регистрация</h1>
                <?php if ($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
                <?php if ($success) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Логин</label>
                        <input class="form-control" type="text" name="login" placeholder="Логин (латиница и цифры, от 6 символов)"
                               pattern="[A-Za-z0-9]{6,}" required>
                    </div>
                    <div class="mb-3">
                        <label>ФИО</label>
                        <input class="form-control" type="text" name="fio" placeholder="Иванов Иван Иванович" required>
                    </div>
                    <div class="mb-3">
                        <label>Телефон</label>
                        <input class="form-control" type="text" name="phone" placeholder="8(999)123-45-67"
                               pattern="8\(\d{3}\)\d{3}-\d{2}-\d{2}" required>
                    </div>
                    <div class="mb-3">
                        <label>Пароль</label>
                        <input class="form-control" type="password" name="password" placeholder="Пароль (от 8 символов)"
                               minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label>Повторите пароль</label>
                        <input class="form-control" type="password" name="confirm" placeholder="Повторите пароль"
                               minlength="8" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                    </div>
                    <button type="submit" name="submit" class="btn accent w-100 text">Зарегистрироваться</button>
                </form>
                <p class="mt-3 text-center">Уже есть аккаунт? <a href="login.php">Войти</a></p>
            </div>
        </div>
    </div>
</div>