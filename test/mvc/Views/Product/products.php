<?php
/** @var int $userId
 * @var ProductModel $model
 * @var  array $_GET
 */

use Models\ProductModel;
$count = 1;

?>
<div class="row">
    <div class="col-sm-5 ">
        <button type="button" class="btn btn-primary" id="btn-add-product">Добавить продукт</button>

    </div>
    <div class="col-sm-5">
        <form method="post" action="/category/category/">
            <button type="submit" class="btn btn-secondary">Вернуться в категории</button>
        </form>
    </div>
    <div class="col-sm-1">
        <form method="post" action="/auth/logout">
            <button type="submit" class="btn btn-secondary">Выйти</button>
        </form>
    </div>
</div>
<br>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Наименование</th>
        <th scope="col">Описание</th>
        <th scope="col">Стоимость</th>
        <th scope="col">Изменить</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
    <?php foreach ($model->getProductDescription() as $product): ?>
        <?php if ($_GET['id'] == $product['id_categories']): ?>
            <tr>
                <th scope="row"><?= $count; ?></th>
                <td><?= $product['name']; ?></td>
                <td><?= $product['description']; ?></td>
                <td><?= $product['price']; ?></td>
                <td>
                    <button type="button" class="btn btn-success" id="btn-change-product-<?= $product['ID']; ?>">
                        Изменить
                        продукт
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" id="btn-delete-product-<?= $product['ID']; ?>">
                        Удалить
                        продукт
                    </button>
                </td>
            </tr>
            <?php $count++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>


<div id="newProductModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создать продукт</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <form method="get" class="create_form">
                    <label for="productName" class="col-form-label">Название:</label>
                    <input type="text" class="form-control productName" name="productName" id="productName">
                    <label for="productDescription" class="col-form-label">Описание:</label>
                    <input type="text" class="form-control productDescription" name="productDescription"
                           id="productDescription">
                    <input type="hidden" class="form-control productCategory" name="productCategory"
                           id="productCategory" value="<?=$_GET['id'] ?>">
                    <label for="productPrice" class="col-form-label">Стоимость:</label>
                    <input type="text" class="form-control productPrice" name="productPrice" id="productPrice">
                    <span class="error">Стоимость должна содержать <strong>только цифры</span>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary js-close" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary js-add-product">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>


<?php foreach ($model->getProductDescription() as $product): ?>
    <div id="changeModal-<?= $product['ID']; ?>" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменить продукт <?= $product['name']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form method="post" class="edit_form-<?= $product['ID']; ?>">

                    <div class="modal-body">
                        <label for="newProductName" class="col-form-label">Новое название:</label>
                        <input type="text" class="form-control productName" name="newProductName" id="newProductName"
                               placeholder="<?= $product['name']; ?>">
                        <label for="newProductDescription" class="col-form-label">Новое описание:</label>
                        <input type="text" class="form-control newProductDescription" name="newProductDescription"
                               id="newProductDescription" placeholder="<?= $product['description'] ?>">
                        <input type="hidden" class="form-control newProductCategory" name="newProductCategory"
                               id="newProductCategory">
                        <label for="newProductPrice" class="col-form-label">Новая стоимость:</label>
                        <input type="text" class="form-control productPrice" name="newProductPrice" id="newProductPrice"
                               placeholder="<?= $product['price']; ?>">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary js-close" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary js-change-product" name="addProduct">Сохранить
                            изменения
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($model->getProductDescription() as $product): ?>
    <div id="deleteModal-<?= $product['ID']; ?>" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить продукт <?= $product['name']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <p>Вы уверены, что хотите удалить продукт?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-danger js-delete-product">Удалить</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {

        $('#btn-add-product').on('click', function () {
            $("#newProductModal").modal("show");


            $('.js-add-product').on('click', function () {

                $.ajax({
                    type: "POST",
                    url: "/product/product",
                    data: $('.create_form').serialize(),
                    success: function () {
                        $("#newProductModal").modal("hide");
                        window.location.href = "/product/product?id=<?= $_GET['id']; ?>";
                    }
                });
            });
            $('.js-close').on('click', function () {
                $('.create_form')[0].reset();
                location.reload();
            });
        });

        <?php foreach ($model->getProducts() as $product): ?>

        $('#btn-change-product-<?= $product['ID']; ?>').on('click', function () {
            $("#changeModal-<?= $product['ID']; ?>").modal("show");
            console.log(<?= $product['ID']; ?>)
            console.log(<?= $_GET['id']; ?>)

            $('.edit_form-<?= $product['ID']; ?>').on('submit', function () {

                $.ajax({
                    type: "POST",
                    url: "/product/product",
                    data: $('.edit_form-<?= $product['ID']; ?>').serialize() + "&productID=" + <?= $product['ID']; ?>,
                    success: function () {
                        $("#changeModal-<?= $product['ID']; ?>").modal("hide");
                        window.location.href = "/product/product?id=<?=$_GET['id']; ?>";
                    }
                });
            });
        });

        <?php endforeach; ?>

        <?php foreach ($model->getProducts() as $product): ?>
        $('#btn-delete-product-<?= $product['ID']; ?>').on('click', function () {
            $("#deleteModal-<?= $product['ID']; ?>").modal("show");


            $('.js-delete-product').on('click', function () {
                console.log(<?=$_GET['id']; ?>);
                $.ajax({
                    type: "POST",
                    url: "/product/product",
                    data: {"productID": <?= $product['ID']; ?>},
                    success: function () {
                        $("#deleteModal-<?= $product['ID']; ?>").modal("hide");
                        window.location.href = "/product/product?id=<?=$_GET['id']; ?>";

                    }
                });
            });
        })
        <?php endforeach; ?>
    })
    ;


</script>
