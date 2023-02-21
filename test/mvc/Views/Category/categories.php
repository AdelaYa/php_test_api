<?php
/** @var string $name
 * @var int $userId
 * @var CategoryModel $model
 */

use Models\CategoryModel;

?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <p>Добро пожаловать, <?= $name ?></p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-11">
        <button type="button" class="btn btn-primary" id="btn-add-category">Добавить категорию</button>
    </div>
    <div class="col-md-1">
        <form method="post" action="/auth/logout">
            <button type="submit" class="btn btn-secondary">Выйти</button>
        </form>
    </div>
</div>
<hr>


<div class="col-sm-10">
    <?php foreach ($model->getCategories() as $category): ?>
        <?php if ($userId == $category['client_id']): ?>
            <div class="row row-cols-auto">
                <div class="col">
                    <a href="/product/product?id=<?= $category['id']; ?>"
                       class="list-group-item list-group-item-action ">
                        <?= $category['name']; ?>
                    </a>
                </div>
                <div class="col">

                    <button type="button" class="btn btn-success"
                            id="btn-change-category-<?= $category['id']; ?>">
                        Изменить категорию
                    </button>
                </div>
                <div class="col">

                    <button type="button" class="btn btn-danger"
                            id="btn-delete-category-<?= $category['id']; ?>">
                        Удалить категорию
                    </button>
                </div>

            </div>
        <?php endif; ?>
    <?php endforeach; ?>


</div>


<div id="newCategoryModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Создать категорию</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <form method="get" class="create_form">
                    <label for="categoryName" class="col-form-label">Название:</label>
                    <input type="text" class="form-control" name="categoryName" id="categoryName">
                    <input type="hidden" class="form-control" name="UserId" id="UserId"
                           value="<?= $userId; ?>">
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary js-close" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary js-add-category">Сохранить изменения</button>
            </div>
        </div>
    </div>
</div>


<?php foreach ($model->getCategories() as $category): ?>
    <div id="changeModal-<?= $category['id']; ?>" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменить категорию <?= $category['name']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form method="post" class="edit_form-<?= $category['id']; ?>">
                    <div class="modal-body">

                        <label for="newCategoryName" class="col-form-label">Новое название:</label>
                        <input type="text" class="form-control" name="newCategoryName"
                               id="newCategoryName"
                        >
                        <input type="hidden" class="form-control" name="UserId" id="UserId"
                               value="<?= $userId; ?>">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary js-close" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary js-change-category" name="addProduct">Сохранить
                            изменения
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($model->getCategories() as $category): ?>
    <div id="deleteModal-<?= $category['id']; ?>" class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Удалить категорию <?= $category['name']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">
                    <p>Вы уверены, что хотите удалить категорию?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary js-close" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-danger js-delete-category">Удалить</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {

        $('#btn-add-category').on('click', function () {
            $("#newCategoryModal").modal("show");


            $('.js-add-category').on('click', function () {
                $.ajax({
                    type: "POST",
                    url: "/category/category",
                    data: $('.create_form').serialize(),
                    success: function () {
                        $("#newCategoryModal").modal("hide");
                        window.location.href = "/category/category/";
                    }
                });
            });
            $('.js-close').on('click', function () {
                $('.create_form')[0].reset();
                location.reload();
            });
        });

        <?php foreach ($model->getCategories() as $category): ?>

        $('#btn-change-category-<?= $category['id']; ?>').on('click', function () {
            $("#changeModal-<?= $category['id']; ?>").modal("show");
            console.log($('.edit_form-<?= $category['id']; ?>').serialize())
            $('.edit_form-<?= $category['id']; ?>').on('submit', function () {
                console.log($('.edit_form-<?= $category['id']; ?>').serialize())

                $.ajax({
                    type: "POST",
                    url: "/category/category",
                    data: $('.edit_form-<?= $category['id']; ?>').serialize() + "&categoryID=" + <?= $category['id']; ?>,
                    success: function () {
                        $("#changeModal-<?= $category['id']; ?>").modal("hide");
                        window.location.href = "/category/category/";

                    }
                });

            });
        });

        <?php endforeach; ?>

        <?php foreach ($model->getCategories() as $category): ?>
        $('#btn-delete-category-<?= $category['id']; ?>').on('click', function () {
            $("#deleteModal-<?= $category['id']; ?>").modal("show");

            console.log(<?= $category['id']; ?>);

            $('.js-delete-category').on('click', function () {

                $.ajax({
                    type: "POST",
                    url: "/category/category",
                    data: {"categoryID": <?= $category['id']; ?>, "name": "<?= $category['name']; ?>"},
                    success: function () {
                        $("#deleteModal-<?= $category['id']; ?>").modal("hide");
                        window.location.href = "/category/category";

                    }
                });
            });

        })
        <?php endforeach; ?>

    });


</script>