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
                    <a href="create_order.php?id=<?= $product['id'] ?>" class="btn accent">Купить</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>