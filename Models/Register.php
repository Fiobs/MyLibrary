<?php


namespace Models;


use System\View;


class Register extends Datas
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registration()
    {
        session_start();
        $login = trim(htmlspecialchars($_POST['login']));
        $pass = md5(md5(trim($_POST['pass'])));
        $pass2 = md5(md5(trim($_POST['pass2'])));

        if (isset($_POST['submit'])) {
            $error = [];

            //Проверяем логин
            if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
            {
                $error[] = "Логин может состоять только из букв английского алфавита и цифр!!!";
            }

            if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
            {
                $error[] = "Логин должен быть не меньше 3-х символов и не больше 30!!!";
            }

            $sth = $this->dbUsers->prepare("SELECT user_id FROM novices WHERE user_login = '$login'");
            $sth->execute();
            $check = $sth->fetch(\PDO::FETCH_COLUMN);

            // Проверям есть ли в базе такой логин
            if ($check){
                $error[] = "Пользователь с таким логином уже существует!";
            }

            if ($pass != $pass2){
                $error[] = "Пароли не совпадают!!";
            }

            // Если нету ошибок - добавить пользователя
            if (count($error) == 0){
                $sth = $this->dbUsers->prepare('INSERT INTO novices(user_login,user_password) VALUES (:login, :pass)');
                $sth->execute([':login' => $login, ':pass' => $pass]);
                header("Location: http://library/login");
            } else {
                View::render('Authorization/register', $error);
            }
        }
    }
}
