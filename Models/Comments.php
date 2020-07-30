<?php


namespace Models;


class Comments
{
    private $model;
    private $dbh;

    public function __construct()
    {
        $this->model = new Datas();
        $this->dbh = new \PDO('mysql:host=localhost;port=3308;dbname=users', 'root');
        $this->dbh->exec('SET NAMES utf8');
    }

    public function getComments($page_id)
    {
        $sth = $this->dbh->prepare("SELECT * 
                                             FROM comments 
                                             WHERE page_id = '$page_id' 
                                             ORDER BY id DESC");
        $sth->execute();
        $sth = $sth->fetchAll(\PDO::FETCH_ASSOC);

//        $arr = empty($arr);

        foreach ($sth as $key => $item){
            $arr[$item['id']] = [
                    'page_id' => $item['page_id'],
                    'login' => $item['name'],
                    'text_comment' => $item['text_comment']
                ];
        }

        if (empty($arr)){
            return null;
        } else {
            return $arr;
        }
    }

    public function addComment()
    {
        if (isset($_POST['description'])) {

            $login = $_POST['login'];
            $text = htmlspecialchars($_POST['description']);
            $page_id = $_POST['page_id'];

            $this->dbh->exec(
                "INSERT INTO comments(`name`,`page_id`,`text_comment`) 
                          VALUES ('$login','$page_id','$text')");

            header("Location: " . $_SERVER["HTTP_REFERER"]);
        } else {
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
    }
}