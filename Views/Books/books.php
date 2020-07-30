<?php require_once 'Views/header.php';

//foreach ($data as $item){
//    $arr[] = $item['book_name'];
//}
//var_dump($data);
?>

<body>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-7 p-lg-7 mx-auto my-7">
        <div class="d-flex justify-content-end">
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="/books/addBook" data-toggle="tooltip" title="Добавить" class="btn btn-primary"
                   data-original-title="Добавить">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"/>
                        <path fill-rule="evenodd"
                              d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"/>
                    </svg>
                </a>
                <!--/books/deleteBooks-->
                <a href="#" data-toggle="tooltip" title="Удалить" class="btn btn-danger"
                   onclick="deleteCheckedBooks()" data-original-title="Удалить">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!--                        ТАБЛИЦА                     -->
        <table class="table" id="myTable">
            <thead>
            <tr>
                <th style="width: 1px;" class="text-center">
                    <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);">
                </th>
                <th class="text-center" onclick="sortTable(1)">Название книги</th>
                <th class="text-center" onclick="sortTable(2)">Автор</th>
                <td class="text-center">Цена</td>
                <td class="text-center">Количество</td>
                <td class="text-center">Отредачить</td>
                <td class="text-center">Удалить</td>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td class="text-center"><input type="checkbox" name="selected" id="<?= $item['book_id']; ?>"></td>
                    <td class="text-center"><a
                                href="/books/bookPage/?id=<?= $item['book_id']; ?>"><?= $item['book_name']; ?></a></td>
                    <td class="text-center"><?= $item['author_name']; ?></td>

                    <td class="text-center">
                            <span <?php if (isset($item['sale'])): ?> style="text-decoration: line-through;" <?php endif; ?>>
                                <?= $item['price']; ?> руб.
                            </span><br>
                        <?php if (isset($item['sale'])): ?>
                            <div class="text-danger"><?= $item['sale'] ?>руб.</div>
                        <?php endif; ?>
                    </td>
                    <td class="text-center"><span class="label label-success"><?= $item['count']; ?></span></td>
                    <td class="text-center">
                        <a href="/books/editBooks/?id=<?= $item['book_id']; ?>" data-toggle="tooltip" title="Отредачить"
                           class="btn btn-primary" data-original-title="Редактировать">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                <path fill-rule="evenodd"
                                      d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                            </svg>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/books/deleteBook/?b=<?= $item['book_id']; ?>&a=<?= $item['author_id']; ?>"
                           data-toggle="tooltip" title="Удалить" class="btn btn-secondary"
                           data-original-title="Удалить">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <!--        <small id="emailHelp" class="form-text text-muted">Выберите автора для книги.</small>-->

    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>
</body>