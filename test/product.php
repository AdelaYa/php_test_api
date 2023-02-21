<?php
include 'database.php';


$database = new Database();
$count = 1
?>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Products</title>
</head>
<body>

<button type="button" class="btn btn-primary" id="btn-add-product">Добавить продукт</button>

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
    <?php foreach ($database->getProductDescription() as $product): ?>
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
                    <button type="button" class="btn btn-danger" id="btn-delete-product-<?= $product['ID']; ?>">Удалить
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
                           id="productCategory" value="<?= $_GET['id'] ?>">
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


<?php foreach ($database->getProductDescription() as $product): ?>
    <div id="changeModal-<?= $product['ID']; ?>" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменить продукт <?= $product['ID']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <form method="get" class="edit_form-<?= $product['ID']; ?>">
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
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary js-close" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary js-change-product" name="addProduct">Сохранить
                        изменения
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($database->getProductDescription() as $product): ?>
    <div id="deleteModal-<?= $product['ID']; ?>" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить продукт <?= $product['ID']; ?></h5>
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
                    url: "validate.php",
                    data: $('.create_form').serialize(),
                    success: function () {
                        $("#newProductModal").modal("hide");
                        window.location.href = "product.php?id=<?= $_GET['id']; ?>";
                    }
                });
            });
            $('.js-close').on('click', function () {
                $('.create_form')[0].reset();
                location.reload();
            });
        });

        <?php foreach ($database->getProducts() as $product): ?>

        $('#btn-change-product-<?= $product['ID']; ?>').on('click', function () {
            $("#changeModal-<?= $product['ID']; ?>").modal("show");
            console.log(<?= $product['ID']; ?>)

            $('.js-change-product').on('click', function () {

                $.ajax({
                    type: "POST",
                    url: "validate.php",
                    data: $('.edit_form-<?= $product['ID']; ?>').serialize() + "&productID=" + <?= $product['ID']; ?>,
                    success: function () {
                        $("#changeModal-<?= $product['ID']; ?>").modal("hide");
                        window.location.href = "product.php?id=<?= $_GET['id']; ?>";
                    }
                });
            });
        });

        <?php endforeach; ?>

        <?php foreach ($database->getProducts() as $product): ?>
        $('#btn-delete-product-<?= $product['ID']; ?>').on('click', function () {
            $("#deleteModal-<?= $product['ID']; ?>").modal("show");


            $('.js-delete-product').on('click', function () {
                console.log(<?= $_GET['id']; ?>);
                $.ajax({
                    type: "POST",
                    url: "validate.php",
                    data: {"productID": <?= $product['ID']; ?>},
                    success: function () {
                        $("#deleteModal-<?= $product['ID']; ?>").modal("hide");
                        window.location.href = "product.php?id=<?= $_GET['id']; ?>";

                    }
                });
            });
        })
        <?php endforeach; ?>
    })
    ;


</script>
</body>
</html>