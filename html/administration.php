<h1 class="text-center my-5 caveat">Админ-панель</h1>

<h2 class="mt-5 caveat" id="orders">Заказы</h2>

<!-- Панель фильтров -->
<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Статус</label>
                <select id="filterStatus" class="form-select">
                    <option value="">Все статусы</option>
                    <option value="new">Новый</option>
                    <option value="in_progress">В процессе</option>
                    <option value="completed">Завершён</option>
                    <option value="cancelled">Отменён</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Сортировка</label>
                <select id="filterDate" class="form-select">
                    <option value="desc">Сначала новые</option>
                    <option value="asc">Сначала старые</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Поиск по ID / логину</label>
                <input type="text" id="filterSearch" class="form-control" placeholder="Введите ID или логин">
            </div>
            <div class="col-md-3">
                <button id="resetFilters" class="btn btn-secondary w-100 text">Сбросить фильтры</button>
            </div>
        </div>
    </div>
</div>

<?php if (empty($orders)): ?>
    <p>Нет заказов</p>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered" id="ordersTable">
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
            <tbody id="ordersBody">
            <?php foreach ($orders as $ord): ?>
                <?php
                    $statusMap = ['new'=>'Новый', 'in_progress'=>'В процессе', 'completed'=>'Завершён', 'cancelled'=>'Отменён'];
                ?>
                <tr class="order-row"
                    data-id="<?= $ord['id'] ?>"
                    data-login="<?= htmlspecialchars(mb_strtolower($ord['login'])) ?>"
                    data-status="<?= htmlspecialchars($ord['status']) ?>">
                    <td><?= $ord['id'] ?></td>
                    <td><?= htmlspecialchars($ord['login']) ?></td>
                    <td>
                        <?php foreach ($ord['items'] as $it): ?>
                            <div><?= htmlspecialchars($it['product_name']) ?> × <?= $it['quantity'] ?></div>
                        <?php endforeach; ?>
                    </td>
                    <td><?= date('d.m.Y', strtotime($ord['order_date'])) ?></td>
                    <td><?= $statusMap[$ord['status']] ?></td>
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
                                <button type="submit" name="update_status" class="btn bg-successg btn-sm mt-1 text">Обновить</button>
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

    <!-- Пагинация -->
    <nav>
        <ul class="pagination justify-content-center" id="ordersPagination"></ul>
    </nav>
    <p class="text-center text-muted" id="paginationInfo"></p>
<?php endif; ?>

<hr class="my-5">

<h2 class="mb-3 caveat" id="products">Работа с товарами</h2>

<div class="card mb-4" id="edit-form">
    <div class="card-header secondary-color">
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
                <button type="submit" name="update_product" class="btn bg-successg text">Сохранить изменения</button>
                <a href="administration.php#products" class="btn btn-secondary">Отмена</a>
            <?php else: ?>
                <button type="submit" name="add_product" class="btn accent text">Добавить товар</button>
            <?php endif; ?>
        </form>
    </div>
</div>

<h2 class="mt-5 caveat" id="products-list">Список товаров</h2>
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
                        <a href="administration.php?edit_id=<?= $p['id'] ?>#edit-form" class="btn bg-successg btn-sm text">Редактировать</a>
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


<script>
(function () {
    const PER_PAGE = 5;
    const tbody = document.getElementById('ordersBody');
    if (!tbody) return;

    const allRows = Array.from(tbody.querySelectorAll('.order-row'));
    const filterStatus  = document.getElementById('filterStatus');
    const filterDate    = document.getElementById('filterDate');
    const filterSearch  = document.getElementById('filterSearch');
    const resetBtn      = document.getElementById('resetFilters');
    const paginationEl  = document.getElementById('ordersPagination');
    const paginationInfo = document.getElementById('paginationInfo');

    if (!filterStatus || !filterDate || !filterSearch || !resetBtn ||
        !paginationEl || !paginationInfo) return;

    let currentPage = 1;
    let filteredRows = allRows.slice();

    function applyFilters() {
        const status = filterStatus.value;
        const search = filterSearch.value.trim().toLowerCase();

        filteredRows = allRows.filter(row => {
            const rowStatus = row.dataset.status;
            const rowLogin  = row.dataset.login;
            const rowId     = row.dataset.id;

            if (status && rowStatus !== status) return false;
            if (search && !(rowId.includes(search) || rowLogin.includes(search))) return false;
            return true;
        });

        // Сортировка по ID заказа:
        //   asc  → сначала старые (1, 2, 3, ...)
        //   desc → сначала новые  (13, 12, 11, ...)
        const sortDir = filterDate.value;
        filteredRows.sort((a, b) => {
            const idA = parseInt(a.dataset.id, 10);
            const idB = parseInt(b.dataset.id, 10);
            return sortDir === 'asc' ? idA - idB : idB - idA;
        });

        currentPage = 1;
        render();
    }

    function render() {
        // Скрываем все
        allRows.forEach(r => r.style.display = 'none');

        const total = filteredRows.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (currentPage > totalPages) currentPage = totalPages;

        const start = (currentPage - 1) * PER_PAGE;
        const end = start + PER_PAGE;
        const pageRows = filteredRows.slice(start, end);

        // Показываем строки текущей страницы
        pageRows.forEach(r => r.style.display = '');

        // ★ Переставляем строки в DOM в нужном порядке
        pageRows.forEach(r => tbody.appendChild(r));

        renderPagination(totalPages);
        paginationInfo.textContent = total === 0
            ? 'Ничего не найдено'
            : `Найдено ${total}`;
    }

    function renderPagination(totalPages) {
        paginationEl.innerHTML = '';

        const makeLi = (label, page, disabled = false, active = false) => {
            const li = document.createElement('li');
            li.className = 'page-item' + (disabled ? ' disabled' : '') + (active ? ' active' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#orders';
            a.textContent = label;
            a.addEventListener('click', (e) => {
                e.preventDefault();
                if (disabled || active) return;
                currentPage = page;
                render();
            });
            li.appendChild(a);
            return li;
        };

        paginationEl.appendChild(makeLi('«', currentPage - 1, currentPage === 1));

        for (let i = 1; i <= totalPages; i++) {
            if (totalPages > 7 && i !== 1 && i !== totalPages && Math.abs(i - currentPage) > 2) {
                if (i === 2 || i === totalPages - 1) {
                    const li = document.createElement('li');
                    li.className = 'page-item disabled';
                    li.innerHTML = '<span class="page-link">…</span>';
                    paginationEl.appendChild(li);
                }
                continue;
            }
            paginationEl.appendChild(makeLi(i, i, false, i === currentPage));
        }

        paginationEl.appendChild(makeLi('»', currentPage + 1, currentPage === totalPages));
    }

    filterStatus.addEventListener('change', applyFilters);
    filterDate.addEventListener('change', applyFilters);
    filterSearch.addEventListener('input', applyFilters);
    resetBtn.addEventListener('click', () => {
        filterStatus.value = '';
        filterDate.value = 'desc';
        filterSearch.value = '';
        applyFilters();
    });

    applyFilters();
})();
</script>
