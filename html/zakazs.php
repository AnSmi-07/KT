<h1 class="text-center">Мои заказы</h1>
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
                <div class="row">
                    <div class="col-md-2">
                        <img src="img/<?= $order['image'] ?>" class="img-fluid" alt="<?= $order['product_name'] ?>">
                    </div>
                    <div class="col-md-10">
                        <p><strong>Товар:</strong> <?= htmlspecialchars($order['product_name']) ?></p>
                        <p><strong>Дата получения:</strong> <?= date('d.m.Y', strtotime($order['order_date'])) ?></p>
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
                                <button type="submit" name="submit_review" class="btn btn-primary btn-sm">Отправить отзыв</button>
                            </form>
                        <?php else: ?>
                            <p class="text-muted small">Отзыв можно оставить после завершения заказа.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>