<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center">Регистрация</h1>
                <?php if ($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
                <?php if ($success) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Логин</label>
                        <input class="form-control" type="text" name="login" placeholder="Логин" required>
                    </div>
                    <div class="mb-3">
                        <label>Пароль</label>
                        <input class="form-control" type="password" name="password" placeholder="Пароль" required>
                    </div>
                    <div class="mb-3">
                        <label>Повторите пароль</label>
                        <input class="form-control" type="password" name="confirm" placeholder="Повторите пароль" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" placeholder="Email" required>
                    </div>
                    <button type="submit" name="submit" class="btn accent w-100">Зарегистрироваться</button>
                </form>
                <p class="mt-3 text-center">Уже есть аккаунт? <a href="login.php">Войти</a></p>
            </div>
        </div>
    </div>
</div>