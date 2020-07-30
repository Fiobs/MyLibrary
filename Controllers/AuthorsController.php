<?php


namespace Controllers;


use System\View;
use Models\Authors;


class AuthorsController
{
    private $model;
    private $authors;

    public function __construct()
    {
        $this->model = new Authors();
        $this->authors = $this->model->getAuthors();
    }

    // Authors page
    public function indexAction()
    {
        // Отображение главной страницы
        View::render('authors', $this->authors);
    }

    public function editAuthorsAction()
    {
        if (!empty($_GET)) {
            $id = $_GET['id'];
            $arr = $this->model->editAuthors($id);     // Получаем конкретного автора

            View::render('editorauthor', $arr);      // Форма редактирование автора
        } else {
            $this->model->changeAuthors(); // Редактирование автора

            header("Location: http://library/authors");
        }
    }

    public function addAuthorAction()
    {
        if (!empty($_POST['Authorname']) && !empty($_POST['email']) && !empty($_POST['phone'])) {
            $this->model->addAuthor();
            header("Location: http://library/authors");
        }
        View::render('editorauthor');
    }

    public function deleteAuthorAction()
    {
        $id = $_GET['id'];
        $this->model->deleteAuthor($id);

        header("Location: http://library/authors");
    }

    public function deleteAuthorsAction()
    {
        $this->model->deleteAuthors();

        header("Location: http://library/authors");
    }
}