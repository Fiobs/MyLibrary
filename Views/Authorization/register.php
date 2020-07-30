<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
</head>
<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
    <div class="col-md-5 p-lg-5 mx-auto my-5">
        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-left bg-light">
            <form method="post" action="/register/register">
                <p class="text-primary">
                    Логин: <input type="text" name="login" placeholder="Введите логин" autocomplete="off" required><br/><br/>
                    Пароль: <input type="password" name="pass" placeholder="Введите пароль" autocomplete="off" required><br/><br/>
                    Подтвердите пароль: <input type="password" name="pass2" placeholder="Подтвердите пароль" autocomplete="off" required><br/><br/>
                </p>
                <input name="submit" type="submit" value="Зарегестрироваться">
                <p>
                    Уже зарегестрировались? - <a href="/login">Войти</a>
                </p>
                <br/>
                <p class="text-danger">
                <?php
                if (!empty($data)) {
                    foreach ($data as $value){
                        echo $value;
                    }
                }
                ?>
                </p>
            </form>
        </div>
    </div>
    <div class="product-device shadow-sm d-none d-md-block"></div>
    <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
</div>