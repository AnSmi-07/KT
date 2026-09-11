<h1 class="text-center my-5">Корзина</h1>

<?php if (empty($cartItems)): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <p class="mb-3">Корзина пуста</p>
            <a href="katalog.php" class="btn accent">Перейти в каталог</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table secondary-color">
                <tr>
                    <th>ID</th>
                    <th>Картинка</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Стоимость</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td>
                        <?php if (!empty($item['image'])): ?>
                            <img src="img/<?= htmlspecialchars($item['image']) ?>" alt="" style="max-width: 80px;">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price'], 0, '', ' ') ?> ₽</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="cart.php?action=dec&product_id=<?= $item['id'] ?>" class="btn accent btn-sm">−</a>
                            <span class="px-3 fw-bold"><?= $item['quantity'] ?></span>
                            <a href="cart.php?action=inc&product_id=<?= $item['id'] ?>" class="btn accent btn-sm">+</a>
                        </div>
                    </td>
                    <td><?= number_format($item['subtotal'], 0, '', ' ') ?> ₽</td>
                    <td>
                        <a href="cart.php?action=remove&product_id=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h4 class="mb-0">Итого: <?= number_format($cartTotal, 0, '', ' ') ?> ₽</h4>
                <div>
                    <a href="cart.php?action=clear" class="btn btn-secondary">Очистить</a>
                    <a href="create_order.php" class="btn accent">Оформить заказ</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>