<?php


namespace Models;


class Datas
{
    protected $dbh;
    protected $authors = [];
    protected $books = [];
    protected $authors_books = [];

    public function __construct()
    {
        // Подключаем базу
        $this->dbh = new \PDO('mysql:host=localhost;port=3308;dbname=test_db', 'root');
        $this->dbh->exec('SET NAMES utf8');
    }

    public function getAuthors(){
        $sth1 = $this->dbh->prepare("SELECT * FROM authors");
        $sth1->execute();
        $arr = $sth1->fetchAll(\PDO::FETCH_ASSOC);

        // Присваивание ключам айдишники
        foreach($arr as $tag){
            $this->authors[$tag['id']] = [
                'author_name' => $tag['author_name'],
                'email' => $tag['email'],
                'phone' => $tag['phone'],
                'data_author' => $tag['data_created']
            ];
        }
        return $this->authors;
    }

    public function getBooks()
    {
        $sth = $this->dbh->prepare("SELECT * FROM books");
        $sth->execute();
        $arr = $sth->fetchAll(\PDO::FETCH_ASSOC);

        // Присваивание ключам айдишники
        foreach($arr as $tag){
            $this->books[$tag['id']] = [
                'book_name' => $tag['book_name'],
                'price' => $tag['price'],
                'count' => $tag['count'],
                'sale' => $tag['sale'],
                'description' => $tag['description'],
                'cover' => $tag['cover'],
                'data' => $tag['data']
            ];
        }
        return $this->books;
    }

    public function getAu_b()
    {
        $sth = $this->dbh->prepare('SELECT *
                FROM `books` AS b
                LEFT JOIN `authors_books` as ab ON b.id=ab.book_id
                LEFT JOIN `authors` as a ON ab.author_id = a.id');
        $sth->execute();
        $this->authors_books = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $this->authors_books;
    }
}