<?php


namespace Models;


class Books extends Datas
{
    protected $books = [];
    protected $authors_books = [];

    public function __construct()
    {
        // Подключаем базу
        parent::__construct();
    }

    public function getBooks()
    {
        $sth = $this->dbTest->prepare("SELECT * FROM books");
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
        $sth = $this->dbTest->prepare('SELECT *
                FROM `books` AS b
                LEFT JOIN `authors_books` as ab ON b.id=ab.book_id
                LEFT JOIN `authors` as a ON ab.author_id = a.id');
        $sth->execute();
        $this->authors_books = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $this->authors_books;
    }

    public function editBooks($id)
    {
        $books['books'] = $this->getBooks()[$id]; //Получаем конкретную книгу
        $books['books'] += ['book_id' => $id];
        $au = new Authors();
        $authors = $au->getAuthors();

        foreach ($authors as $id => $tag) {
            $authors_name[$id] = $tag['author_name'];
        }
        $books['authors'] = $authors_name; // Добавляем массив имен авторов
        return $books;
    }

    public function changeBooks()
    {
        // Полуаем данные о редактируемой книге
        $book = trim(htmlspecialchars($_POST['Bookname']));
        $author_id = $_POST['Authors'];
        $price = $_POST['Price'] ? $_POST['Price'] : 00;
        $count = $_POST['Count'] ? $_POST['Count'] : 00;
        $bookId = $_POST['book_id'];
        $description = $_POST['description'] ? $_POST['description'] : "Описание отсутствует :)";

        if (!empty($book)){
            if (!empty($_FILES['cover']['tmp_name'])){
                $path_img ='upload/'.time().$_FILES['cover']['name'];
                move_uploaded_file($_FILES['cover']['tmp_name'],$path_img);
                // Обновляем данные о книге
                $this->dbTest->exec(
                    "UPDATE books 
                      SET book_name = '$book', price = '$price', count = '$count', description = '$description', cover = '$path_img'
                      WHERE id = '$bookId'");
            } else {
                // Обновляем данные о книге
                $this->dbTest->exec(
                    "UPDATE books 
                      SET book_name = '$book', price = '$price', count = '$count', description = '$description'
                      WHERE id = '$bookId'");
            }

            // Проверяем есть ли в базе данных связь книги с таким автором (изменился ли автор)
            $sth = $this->dbTest->prepare("SELECT book_id FROM authors_books WHERE author_id = '$author_id'");
            $sth->execute();
            $id = $sth->fetch(\PDO::FETCH_COLUMN);

            // Если нету(автор изменился), добавляем в базу новую связь и удаляем старую
            if (!$id) {
                // Удаляем старую связь
                $this->dbTest->exec("DELETE FROM authors_books WHERE book_id = '$bookId' AND author_id = '$author_id'");

                // Создаем новую связь
                $this->dbTest->exec("INSERT INTO authors_books SET author_id = '$author_id' AND book_id = '$bookId'");
            }
        }
    }

    public function addBook()
    {
        $book = trim(htmlspecialchars($_POST['Bookname']));
        $author_id = $_POST['Authors'];
        $price = $_POST['Price'] ? $_POST['Price'] : 00;
        $count = $_POST['Count'] ? $_POST['Count'] : 00;
        $description = $_POST['description'] ? $_POST['description'] : "Описание отсутствует :)";

        if (!empty($book)){
            if (!empty($_FILES['cover']['tmp_name'])){
                // Если есть картинка, добавить картинку
                $path_img ='upload/'.time().$_FILES['cover']['name'];
            } else {
                // Если нету картинки, обавить дефолтное значение
                $path_img = 'upload/noImageAvailable';
            }

            move_uploaded_file($_FILES['cover']['tmp_name'],$path_img);

            // Добавить книгу
            $this->dbTest->exec(
                "INSERT INTO books (`book_name`, `price`, `count`, `description`,`cover`) 
                     VALUES ('$book','$price','$count','$description','$path_img')");

            // Получаем id книги
            $bookId = $this->dbTest->prepare("SELECT id FROM books WHERE book_name = '$book'");
            $bookId->execute();
            $bookId = $bookId->fetch(\PDO::FETCH_COLUMN);

            // Создаем связь
            $this->dbTest->exec(
                "INSERT INTO authors_books (`author_id`, `book_id`) 
                     VALUES ('$author_id','$bookId')");
        }
    }

    public function deleteBook()
    {
        $b_id = $_GET['b'];
        $a_id = $_GET['a'];

//        $img = "upload/1596183180Manyrin.jpg";
//        if(file_exists($img)) ;


        $this->dbTest->exec("DELETE FROM authors_books WHERE author_id = '$a_id' AND book_id = '$b_id'"); // Удаляем связь книги\автора

        $books_id = $this->dbTest->prepare("SELECT book_id FROM authors_books WHERE book_id = '$b_id'"); // Проверка наличия книги в базе
        $books_id->execute();
        $books_id = $books_id->fetch(\PDO::FETCH_COLUMN);


        if (!$books_id) {
            $img = $this->dbTest->prepare("SELECT cover FROM books WHERE id = :id");
            $img->execute([':id' => $b_id]);
            $img = $img->fetch(\PDO::FETCH_COLUMN);
            if ($img != "upload/noImageAvailable"){
                unlink($img);
            }
            $this->dbTest->exec("DELETE FROM books  WHERE id = '$b_id'");
        }
    }

    public function bookPage($id)
    {
        $arr = $this->getAu_b();
        foreach ($arr as $item) {
            $item['book_id'] == $id ? $arr2 = $item : false;
        }

       return $arr2;
    }

    public function deleteBooks()
    {
        $id_arr = explode(',',$_GET['arr']); // Получаем id книг, которые отмечены

        // Присваиваем id книгам - id авторов
        foreach ($id_arr as $book_id){
            $author_id = $this->dbTest->prepare("SELECT author_id FROM authors_books WHERE book_id = '$book_id'");
            $author_id->execute();
            $author_id = $author_id->fetch(\PDO::FETCH_COLUMN);
            $arr[$book_id] = $author_id;
        }
        foreach ($arr as $b_id => $a_id){
            // Удаление связи с автором
            $this->dbTest->exec("DELETE FROM authors_books WHERE author_id = '$a_id' AND book_id = '$b_id'");

            // Проверка наличия связи с книгой
            $books_id = $this->dbTest->prepare("SELECT book_id FROM authors_books WHERE book_id = '$b_id'");
            $books_id->execute();
            $books_id = $books_id->fetch(\PDO::FETCH_COLUMN);

            // Если связей нету, то удаляем книгу
            if (!$books_id) {
                $img = $this->dbTest->prepare("SELECT cover FROM books WHERE id = :id");
                $img->execute([':id' => $b_id]);
                $img = $img->fetch(\PDO::FETCH_COLUMN);
                if ($img != "upload/noImageAvailable"){
                    unlink($img);
                }
                $this->dbTest->exec("DELETE FROM books  WHERE id = '$b_id'");
            }
        }
    }
}