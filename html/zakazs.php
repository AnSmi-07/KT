<h1 class="text-center my-5">Личный кабинет</h1>

<div class="card mb-4">
    <div class="card-header primary-color">
        Профиль
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-2">
                <strong>Логин:</strong> <?= htmlspecialchars($auth_user['login']) ?>
            </div>
            <div class="col-md-3 mb-2">
                <strong>ФИО:</strong> <?= htmlspecialchars($auth_user['fio']) ?>
            </div>
            <div class="col-md-3 mb-2">
                <strong>Email:</strong> <?= htmlspecialchars($auth_user['email']) ?>
            </div>
            <div class="col-md-3 mb-2">
                <strong>Телефон:</strong> <?= htmlspecialchars($auth_user['phone']) ?>
            </div>
            <div class="col-md-3 mb-2">
                <strong>Дата регистрации:</strong>
                <?= !empty($auth_user['created_at']) ? date('d.m.Y', strtotime($auth_user['created_at'])) : '—' ?>
            </div>
        </div>
    </div>
</div>

<h2 class="mb-3">Мои заказы</h2>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Заказ оформлен!</div>
<?php endif; ?>
<?php if (empty($orders)): ?>
    <p>У вас пока нет заказов. <a href="katalog.php">Перейти в каталог</a></p>
<?php else: ?>
    <?php foreach ($orders as $order): ?>
        <div class="card mb-3">
            <div class="card-header primary-color">
                Заказ №<?= $order['id'] ?> от <?= date('d.m.Y', strtotime($order['created_at'])) ?>
                <span class="badge secondary-color float-end">
                    <?php
                        $statusMap = ['new'=>'Новый', 'in_progress'=>'В процессе', 'completed'=>'Завершён'];
                        echo $statusMap[$order['status']];
                    ?>
                </span>
            </div>
            <div class="card-body">
            <?php foreach ($order['items'] as $it): ?>
                <div class="d-flex align-items-center mb-2">
                    <div style="width: 50px; flex-shrink: 0;">
                        <img src="img/<?= htmlspecialchars($it['image']) ?>" class="img-fluid" alt="">
                    </div>
                    <div class="ms-3">
                        <?= htmlspecialchars($it['product_name']) ?> × <?= $it['quantity'] ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <p class="mt-3"><strong>Дата получения:</strong> <?= date('d.m.Y', strtotime($order['order_date'])) ?></p>

            <?php if (!empty($order['review'])): ?>
                            <div class="alert alert-secondary">
                                <strong>Ваш отзыв:</strong> <?= nl2br(htmlspecialchars($order['review'])) ?>
                            </div>
                        <?php elseif ($order['status'] == 'completed'): ?>
                            <form method="post" class="mt-3">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <div class="mb-2">
                                    <label class="form-label">Оставить отзыв</label>
                                    <textarea name="review_text" rows="2" class="form-control" required placeholder="Поделитесь впечатлениями..."></textarea>
                                </div>
                                <button type="submit" name="submit_review" class="btn accent btn-sm">Отправить отзыв</button>
                            </form>
                            <?php elseif ($order['status'] !== 'cancelled'): ?>
                                <p class="text-muted small">Отзыв можно оставить после завершения заказа.</p>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>