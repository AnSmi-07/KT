<h1 class="text-center my-5">Оформление заказа</h1>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-header primary-color">Товары в заказе</div>
            <div class="card-body">
                <?php foreach ($items as $item): ?>
                    <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                        <div style="width: 60px; flex-shrink: 0;">
                            <img src="img/<?= htmlspecialchars($item['image']) ?>" class="img-fluid" alt="">
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <div><strong><?= htmlspecialchars($item['name']) ?></strong></div>
                            <div class="text-muted small"><?= $item['quantity'] ?> × <?= number_format($item['price'], 0, '', ' ') ?> ₽</div>
                        </div>
                        <div class="text-end"><?= number_format($item['subtotal'], 0, '', ' ') ?> ₽</div>
                    </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between">
                    <strong>Итого:</strong>
                    <strong><?= number_format($total, 0, '', ' ') ?> ₽</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header primary-color">Дата получения</div>
            <div class="card-body">
                <?= $message ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="order_date" class="form-label">Дата получения</label>
                        <input type="date" class="form-control" id="order_date" name="order_date"
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                    <button type="submit" name="submit_order" class="btn accent w-100 text">Подтвердить заказ</button>
                    <a href="cart.php" class="btn secondary-color w-100 mt-2 text">Вернуться в корзину</a>
                </form>
            </div>
        </div>
    </div>
</div>