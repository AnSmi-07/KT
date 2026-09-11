<h1 class="text-center">Оформление заказа</h1>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="img/<?= $product['image'] ?>" class="img-fluid" alt="<?= $product['name'] ?>">
                    </div>
                    <div class="col-md-8">
                        <h5><?= htmlspecialchars($product['name']) ?></h5>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <p><strong>Цена:</strong> <?= number_format($product['price'], 0, '', ' ') ?> ₽</p>
                    </div>
                </div>

                <?= $message ?>

                <form method="post">
                    <div class="mb-3">
                        <label for="order_date" class="form-label">Дата получения</label>
                        <input type="date" class="form-control" id="order_date" name="order_date" 
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                    </div>
                    <button type="submit" name="submit_order" class="btn accent">Подтвердить заказ</button>
                    <a href="katalog.php" class="btn btn-secondary">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>