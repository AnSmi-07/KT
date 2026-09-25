<?php if (!empty($_GET['added'])): ?>
    <div class="alert alert-success">Товар добавлен в корзину</div>
<?php endif; ?>
<h1 class="text-center my-5 caveat">Каталог вязгрушинок</h1>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-3 col-md-4 col-sm-2 mb-3">
            <div class="card h-100">
                <img src="img/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body primary-color d-flex flex-column">
                     <h5 class="card-title"><?= $product['name'] ?></h5> 
                    <p class="card-text"><?= $product['description'] ?></p>
                    <div class="card-bottom mt-auto">
                        <p class="card-text price"><strong><?= number_format($product['price'], 0, '', ' ') ?> ₽</strong></p>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <button type="submit" name="add_to_cart" class="btn accent w-100 text comfortaa">Добавить в корзину</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>