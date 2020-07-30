<?php require_once 'header.php' ?>

<form method="post" action="<?php echo !empty($data) ? '/authors/editAuthors' : '/authors/addAuthor' ?>">
    <div class="bg-warning text-dark">
        <div class="col-md-4 p-lg-5 mx-auto my-5">
            <div class="form-group required">
                <input type="hidden" name="AuthorId" value="<?php echo !empty($data) ? $data['authors_id'] : ''; ?>">
                <p>Автор:
                <div class="col-sm-10">
                    <input type="text" value="<?php echo !empty($data) ? $data['author_name'] : ''; ?>"
                           placeholder="Название товара" name="Authorname" class="form-control" autocomplete="off">
                </div>
                </p>
                <p>e-mail:
                <div class="col-sm-10">
                    <input type="text" value="<?php echo !empty($data) ? $data['email'] : ''; ?>"
                           placeholder="Название товара" name="email" class="form-control" autocomplete="off">
                </div>
                </p>
                <p>Телефон:
                <div class="col-sm-10">
                    <input type="text" value="<?php echo !empty($data) ? $data['phone'] : ''; ?>" maxlength="11"
                           placeholder="Название товара" name="phone" class="form-control" autocomplete="off">
                </div>
                </p>
                <br/><br/>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <input type="submit" value="<?php echo !empty($data) ? 'Отредачить автора' : 'Добавить автора'; ?>"
                           class="btn btn-secondary">
                </div>
            </div>
        </div>
    </div>
</form>
