<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center">Вход</h1>
                <?php if ($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Логин</label>
                        <input class="form-control" type="text" name="login" placeholder="Логин" required>
                    </div>
                    <div class="mb-3">
                        <label>Пароль</label>
                        <input class="form-control" type="password" name="password" placeholder="Пароль" required>
                    </div>
                    <button type="submit" name="submit" class="btn accent w-100">Войти</button>
                </form>
                <p class="mt-3 text-center">Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
            </div>
        </div>
    </div>
</div>