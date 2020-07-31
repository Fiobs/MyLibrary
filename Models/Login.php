<?php


namespace Models;


use System\View;


class Login extends Datas
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clean = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clean)];
        }
        return $code;
    }

    public function login()
    {
        session_start();
        if (isset($_POST['submit'])) {
            $login = trim(htmlspecialchars($_POST['login']));
            $pass = md5(md5(trim($_POST['pass'])));

            // Получаем данные с базы и нормализируем их
            $sth = $this->dbUsers->prepare("SELECT user_hash, user_id, user_password FROM novices WHERE user_login = :login");
            $sth->execute([':login' => $login]);
            $data1 = $sth->fetchAll(\PDO::FETCH_ASSOC);


            // Нормализируем данные
            if ($data1) {
                $user_id = $data1[0]['user_id'];
                $user_password = $data1[0]['user_password'];
                // Проверка на ввод пароля
                if ($user_password == $pass) {
                    $hash = md5($this->generateCode(10));

                    setcookie("id", $user_id, time() + 3600, "/");
                    setcookie("login", $login, time() + 3600, "/");
                    setcookie("hash", $hash, time() + 3600, "/");

                    $this->dbUsers->exec(
                        "UPDATE novices 
                              SET user_hash = '$hash' 
                              WHERE user_id = '$user_id'");

                    header("Location: http://library/login/check");
                } else {
                    $error[] = "Не верный пароль!!";
                    View::render('Authorization/login', $error);
                }
            } else {
                $error[] = "Пользователь не найден!";
                View::render('Authorization/login', $error);
            }
        }
    }

    public function check()
    {
        if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
            $id = $_COOKIE['id'];

            $sth = $this->dbUsers->prepare("SELECT * FROM novices WHERE user_id = :user_id");
            $sth->execute([':user_id' => $id]);
            $user_data = $sth->fetch(\PDO::FETCH_ASSOC);
            var_dump($user_data);
            var_dump($_COOKIE);


            if (($user_data['user_hash'] !== $_COOKIE['hash']) or ($user_data['user_id'] !== $_COOKIE['id'])) {
                setcookie("id" . "" . time() - 3600, "/");
                setcookie("hash" . "" . time() - 3600, "/", null, null, true);
                echo "Что то пошло не так";
            } else {
                header("Location: http://library/home");
                echo "Привет, " . $user_data['user_login'] . ". Всё работает!";
            }
        } else {
            echo "Включите куки!";
        }
    }

    public function logout()
    {
        setcookie("id", " ", time() - 3600, "/");
        setcookie("login", " ", time() - 3600, "/");
        setcookie("hash", " ", time() - 3600, "/");
        header("Location: http://library/login");
    }
}