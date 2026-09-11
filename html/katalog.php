<?php if (!empty($_GET['added'])): ?>
    <div class="alert alert-success">Товар добавлен в корзину</div>
<?php endif; ?>
<h1 class="text-center my-5">Каталог вязгрушинок</h1>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-4 mb-3">
            <div class="card">
                <img src="img/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong><?= number_format($product['price'], 0, '', ' ') ?> ₽</strong></p>
                    <form method="post" action="cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" name="add_to_cart" class="btn accent w-100">Добавить в корзину</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>