<?php


namespace Models;


class Authors extends  Datas
{
    protected $authors = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAuthors()
    {
        $sth1 = $this->dbTest->prepare("SELECT * FROM authors");
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

    public function editAuthors($id)
    {
        $author = $this->getAuthors()[$id]; // Получаем конкретного автора
        $author += ['authors_id' => $id]; // Добавляем в массив id автора
        return $author;
    }

    public function changeAuthors()
    {
        $name = $_POST['Authorname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $author_id = $_POST['AuthorId'];

        $sth = $this->dbTest->prepare(
            "UPDATE authors 
                      SET author_name = '$name', email = '$email', phone = '$phone' 
                      WHERE id = '$author_id'"
        );
        $sth->execute();
    }

    public function addAuthor()
    {
        $name = $_POST['Authorname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $this->dbTest->exec(
            "INSERT INTO authors (author_name, email, phone) 
                     VALUES ('$name','$email','$phone')");
    }

    public function deleteAuthor($id)
    {
        $sth = $this->dbTest->prepare("SELECT book_id FROM authors_books WHERE author_id = '$id'");
        $sth->execute();
        $book_id = $sth->fetchAll(\PDO::FETCH_COLUMN); // Проверяем есть ли книги у этого автора

        if ($book_id) {
            // Если есть, удаляем автора и связь
            $this->dbTest->exec("DELETE FROM authors_books WHERE author_id = '$id'");
            $this->dbTest->exec("DELETE FROM authors WHERE id = '$id'");

            // Проверяем есть ли у этой книги другой автор
            foreach ($book_id as $id1){
                $sth = $this->dbTest->prepare("SELECT author_id FROM authors_books WHERE book_id = '$id1'");
                $sth->execute();
                $author_id = $sth->fetch(\PDO::FETCH_COLUMN);
                if  (!$author_id){
                    // Если нету, удаляем книгу
                    $this->dbTest->exec("DELETE FROM books WHERE id = '$id1'");
                }
            }
        } else {
            // Если нету, удаляем автора
            $this->dbTest->exec("DELETE FROM authors WHERE id = '$id'");
        }
    }

    public function deleteAuthors()
    {
        // Получаем id авторов, которые отмечены
        $id_arr = explode(',',$_GET['arr']);

        foreach ($id_arr as $item){
            // Проверяем есть ли книги у этого автора
            $sth = $this->dbTest->prepare("SELECT book_id FROM authors_books WHERE author_id = '$item'");
            $sth->execute();
            $book_id = $sth->fetchAll(\PDO::FETCH_COLUMN); // Проверяем есть ли книги у этого автора

            if ($book_id) {
                // Если есть, удаляем автора и связь
                $this->dbTest->exec("DELETE FROM authors_books WHERE author_id = '$item'");
                $this->dbTest->exec("DELETE FROM authors WHERE id = '$item'");

                // Проверяем есть ли у этой книги другой автор
                foreach ($book_id as $id1){
                    $sth = $this->dbTest->prepare("SELECT author_id FROM authors_books WHERE book_id = '$id1'");
                    $sth->execute();
                    $author_id = $sth->fetch(\PDO::FETCH_COLUMN);
                    if  (!$author_id){
                        // Если нету, удаляем книгу
                        $this->dbTest->exec("DELETE FROM books WHERE id = '$id1'");
                    }
                }
            } else {
                // Если нету, удаляем автора
                $this->dbTest->exec("DELETE FROM authors WHERE id = '$item'");
            }
        }
    }
}