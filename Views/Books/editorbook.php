<?php require_once 'Views/header.php';
//var_dump($data);
?>


<?php if (array_key_first($data) == 'books') {
    $isEditPage = true;
} else {
    $isEditPage = false;
}; ?>
<form enctype="multipart/form-data" method="post" action="<?php echo $isEditPage ? '/books/editBooks' : '/books/addBook'; ?>">
    <div class="bg-warning text-dark">
        <div class="col-md-4 p-lg-5 mx-auto my-5">
            <div class="col-sm-10 input-group">
            <p class="text-danger">* - обязательные поля</p>
            </div>
            <div class="form-group required">
                <input type="hidden" value="<?php echo $isEditPage ? $data['books']['book_id'] : ''; ?>"
                       name="book_id">
                <p>Название книги:
                <div class="col-sm-11 input-group">
                    <input type="text" required value="<?php echo $isEditPage ? $data['books']['book_name'] : ''; ?>"
                           placeholder="Название товара" name="Bookname" autocomplete="off" class="form-control">
                <label class="text-danger nav-link">*</label>
                </div>
                </p>
                <p>Выберите автора:
                <div class="col-sm-10">
                    <select name="Authors">
                        <?php foreach ($data['authors'] as $key => $item): ?>
                            <option value="<?= $key; ?>"><?= $item; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </p>
                <p>Загрузите обложку книги :
                <div class="col-sm-10">
                    <?php if ($isEditPage) : ?>
                    <img src="/<?php echo $data['books']['cover'] ?>" alt="Книга" width="100">
                    <?php endif; ?>
                    <input type="file" name="cover">
                </div>
                </p>
                <p>Цена:
                <div class="col-sm-10">
                    <input type="number" min="00" value="<?php echo $isEditPage ? $data['books']['price'] : ''; ?>"
                           placeholder="Цена книги" name="Price" autocomplete="off" class="form-control">
                </div>
                </p>
                <p>Количество:
                <div class="col-sm-10">
                    <input type="number" min="00" value="<?php echo $isEditPage ? $data['books']['count'] : ''; ?>"
                           placeholder="Количество на складе" name="Count" autocomplete="off" class="form-control">
                </div>
                </p>
                <p>Описание:
                <div class="col-sm-10">
                    <textarea name="description" cols="80"
                              rows="10"><?php echo $isEditPage ? $data['books']['description'] : ''; ?></textarea>
                </div>
                <br/><br/>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <input type="submit" class="btn btn-secondary"
                           value="<?php echo $isEditPage ? 'Отредачить книгу' : 'Добавить книгу'; ?>">
                </div>
            </div>
        </div>
    </div>
</form>
