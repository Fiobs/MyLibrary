<?php


namespace Controllers;


use Models\Authors;
use Models\Comments;
use System\View;
use Models\Books;


class BooksController
{
    private $model;
    private $data;

    public function __construct()
    {
        $this->model = new Books();
        //Получаем список авторов
        $this->data = $this->model->getBooks();
    }

    public function indexAction()
    {
        $books = $this->model->getAu_b();
        // Отображение главной страницы
        View::render('Books/books', $books);
    }

    // Редактирование книг
    public function editBooksAction()
    {
        if (!empty($_GET)) {
            // Переход на форму
            $id = $_GET['id'];
            $arr = $this->model->editBooks($id);

            View::render('Books/editorbook', $arr);
        } else {
            $this->model->changeBooks();
            header("Location: http://library/books");
        }
    }

    // Добавение книг
    public function addBookAction()
    {
        // Добавляем книгу
        if (!empty($_POST['Bookname']) && !empty($_POST['Price']) && !empty($_POST['Count'])) {
            $this->model->addBook();
            header("Location: http://library/books");
        }
        // получаем авторов
        $au = new Authors();
        $arr = $au->getAuthors();

        // приводим к общей форме отображения
        $arr2 = ['authors' => []];
        foreach ($arr as $id => $value) {
            $arr2['authors'] += [$id => $value['author_name']];
        }

        //Выводим форму
        View::render('Books/editorbook', $arr2);


    }

    //Удаление книг
    public function deleteBookAction()
    {
        $this->model->deleteBook();

        header("Location: http://library/books");
    }

    //Просмотр страницы книги
    public function bookPageAction()
    {
        // Находим конкретну книгу
        $id = $_GET['id'];
        $book = $this->model->bookPage($id);

        // Выбираем с базы данных комментарии к КОНКРЕТНОЙ книге
        $m = new Comments();
        $page_id = "http://library" . $_SERVER['REQUEST_URI'];     // Получаем страницу
        $comments = $m->getComments($page_id);

        $data = ['book' => $book, 'comments' => $comments];

        View::render("Books/bookPage", $data);
    }

    // DELETE ARRAY
    public function deleteBooksAction()
    {
        $this->model->deleteBooks();
        header("Location: http://library/books");
    }

}