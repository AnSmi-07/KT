<h1 class="text-center my-5">Админ-панель</h1>

<h2 class="mt-5" id="orders">Заказы</h2>

<?php if (empty($orders)): ?>
    <p>Нет заказов</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table secondary-color">
                <tr>
                    <th>ID</th>
                    <th>Пользователь</th>
                    <th>Товар</th>
                    <th>Дата получения</th>
                    <th>Статус</th>
                    <th>Отзыв</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $ord): ?>
                <tr>
                    <td><?= $ord['id'] ?></td>
                    <td><?= htmlspecialchars($ord['login']) ?></td>
                    <td>
                        <?php foreach ($ord['items'] as $it): ?>
                            <div><?= htmlspecialchars($it['product_name']) ?> × <?= $it['quantity'] ?></div>
                        <?php endforeach; ?>
                    </td>                    
                    <td><?= date('d.m.Y', strtotime($ord['order_date'])) ?></td>
                    <td>
                        <?php
                            $statusMap = ['new'=>'Новый', 'in_progress'=>'В процессе', 'completed'=>'Завершён', 'cancelled'=>'Отменён'];
                            echo $statusMap[$ord['status']];
                        ?>
                    </td>
                    <td><?= !empty($ord['review']) ? nl2br(htmlspecialchars($ord['review'])) : '—' ?></td>
                    <td>
                        <?php if ($ord['status'] === 'cancelled'): ?>
                            <span class="text-muted">Отменён</span>
                        <?php else: ?>
                            <form method="post" class="mb-1">
                                <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">
                                <select name="status" class="form-select form-select-sm">
                                    <option value="new" <?= $ord['status']=='new' ? 'selected' : '' ?>>Новый</option>
                                    <option value="in_progress" <?= $ord['status']=='in_progress' ? 'selected' : '' ?>>В процессе</option>
                                    <option value="completed" <?= $ord['status']=='completed' ? 'selected' : '' ?>>Завершён</option>
                                </select>
                                <button type="submit" name="update_status" class="btn bg-success btn-sm mt-1 text">Обновить</button>
                            </form>
                            <form method="post" onsubmit="return confirm('Отменить заказ №<?= $ord['id'] ?>?');">
                                <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">
                                <button type="submit" name="cancel_order" class="btn btn-danger btn-sm text">Отменить</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<hr class="my-5">

<h2 class="mb-3" id="products">Товары</h2>

<div class="card mb-4" id="edit-form">
    <div class="card-header primary-color">
        <?= $editProduct ? 'Редактирование товара №' . $editProduct['id'] : 'Добавить товар' ?>
    </div>
    <div class="card-body">
        <form method="post">
            <?php if ($editProduct): ?>
                <input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Название</label>
                    <input type="text" name="name" class="form-control" required
                           value="<?= $editProduct ? htmlspecialchars($editProduct['name']) : '' ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Цена</label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" required
                           value="<?= $editProduct ? htmlspecialchars($editProduct['price']) : '' ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Картинка (имя файла)</label>
                    <input type="text" name="image" class="form-control"
                           placeholder="img1.jpg"
                           value="<?= $editProduct ? htmlspecialchars($editProduct['image']) : '' ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Описание</label>
                <textarea name="description" rows="3" class="form-control"><?= $editProduct ? htmlspecialchars($editProduct['description']) : '' ?></textarea>
            </div>

            <?php if ($editProduct): ?>
                <button type="submit" name="update_product" class="btn bg-success text ">Сохранить изменения</button>
                <a href="administration.php#products" class="btn btn-secondary text ">Отмена</a>
            <?php else: ?>
                <button type="submit" name="add_product" class="btn accent text">Добавить товар</button>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if (empty($products)): ?>
    <p>Нет товаров</p>
<?php else: ?>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table secondary-color">
            <tr>
                <th>ID</th>
                <th>Картинка</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td>
                    <?php if (!empty($p['image'])): ?>
                        <img src="img/<?= htmlspecialchars($p['image']) ?>" alt="" style="max-width: 80px;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= htmlspecialchars($p['description']) ?></td>
                <td><?= number_format($p['price'], 0, '', ' ') ?> ₽</td>
                <td>
                    <a href="administration.php?edit_id=<?= $p['id'] ?>#edit-form" class="btn bg-success btn-sm text">Редактировать</a>
                    <form method="post" class="d-inline"
                          onsubmit="return confirm('Удалить товар «<?= htmlspecialchars($p['name']) ?>»?');">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button type="submit" name="delete_product" class="btn btn-danger btn-sm text">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>