<?php require_once 'Views/header.php';
//var_dump($data);
?>

    <div class="container my-4">
        <div class="row no-gutters shadow-sm position-relative">
            <div class="col-md-5 col-sm-12 ">
                <img src="/<?php echo $data['book']['cover'] ?>" alt="Книга" width="400">
            </div>
            <div class="col-md-7 col-sm-12">
                <p class="text-info">Название книги: <label
                            class="text-body"> <?php echo $data['book']['book_name'] ?></label></p>
                <p class="text-info">Автор книги: <label
                            class="text-body"><?php echo $data['book']['author_name'] ?></label></p>
                <p class="text-info">Цена книги: <label
                            class="text-body"><?php echo isset($data['book']['sale']) ? $data['book']['sale'] : $data['book']['price'] ?></label>
                </p>
                <p class="text-info">Количество на складе: <label
                            class="text-body"><?php echo $data['book']['count'] ?></label></p>
                <p class="text-info">email автора: <label class="text-body"><?php echo $data['book']['email'] ?></label>
                </p>
                <p class="text-info">Связь с автором: <label
                            class="text-body">+<?php echo $data['book']['phone'] ?></label></p>
                <p class="text-info">Описание: </p>
                <?php echo $data['book']['description'] ?>
            </div>
        </div>
    </div>

<?php if (isset($_COOKIE['login'])) : ?>
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
        <form name="comment" action="/comment" method="post">
            <label class="text-body">Вы зашли под логином: <label class="text-success"><?= $_COOKIE['login'] ?></label></label>
            <p>
                <label>Оставить комментарий: </label><br>
                <textarea name="description" cols="120" rows="10"></textarea>
            </p>
            <p>
                <input type="hidden" name="page_id"
                       value="http://library/books/bookPage/?id=<?= $data['book']['book_id']; ?>">
                <input type="hidden" name="login" value="<?= $_COOKIE['login']; ?>">
                <input type="submit" value="отправить"/>
            </p>
        </form>
    </div>
<?php endif; ?>

<?php if (!empty($data['comments'])) : ?>
    <div class="col-md-4 mx-auto">
        <div class="text-center">
            <div class="card" style="width: 30rem;">
                <ul class="list-group list-group-flush">
                    <?php foreach ($data['comments'] as $item) : ?>
                        <?php if ($item['page_id'] == "http://library/books/bookPage/?id=" . $data['book']['book_id']) : ?>
                            <div class="card">
                                <label class="text-primary"><?= $item['login'] ?> :</label>
                                <p>
                                    <?= $item['text_comment'] ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>