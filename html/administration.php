<h1 class="text-center">Админ-панель</h1>

<?php if (empty($orders)): ?>
    <p>Нет заказов</p>
<?php else: ?>
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
                <td><?= htmlspecialchars($ord['product_name']) ?></td>
                <td><?= date('d.m.Y', strtotime($ord['order_date'])) ?></td>
                <td>
                    <?php 
                        $statusMap = ['new'=>'Новый', 'in_progress'=>'В процессе', 'completed'=>'Завершён'];
                        echo $statusMap[$ord['status']];
                    ?>
                </td>
                <td><?= !empty($ord['review']) ? nl2br(htmlspecialchars($ord['review'])) : '—' ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?= $ord['id'] ?>">
                        <select name="status" class="form-select form-select-sm">
                            <option value="new" <?= $ord['status']=='new' ? 'selected' : '' ?>>Новый</option>
                            <option value="in_progress" <?= $ord['status']=='in_progress' ? 'selected' : '' ?>>В процессе</option>
                            <option value="completed" <?= $ord['status']=='completed' ? 'selected' : '' ?>>Завершён</option>
                        </select>
                        <button type="submit" name="update_status" class="btn accent btn-sm mt-1">Обновить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<!-- добавить товар  -->
 <!-- редактирование/удаление карточки товара -->