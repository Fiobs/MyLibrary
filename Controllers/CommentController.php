<?php


namespace Controllers;


use System\View;
use Models\Comments;


class CommentController
{
    private $model;

    public function __construct()
    {
        $this->model = new Comments();
    }

    public function indexAction()
    {
        $this->model->addComment();
    }
}