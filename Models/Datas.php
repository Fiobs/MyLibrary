<?php


namespace Models;


class Datas
{
    protected $dbTest;
    protected $dbUsers;

    public function __construct()
    {
        $this->dbTest = new \PDO('mysql:host=localhost;port=3308;dbname=test_db', 'root');
        $this->dbTest->exec('SET NAMES utf8');
        $this->dbUsers = new \PDO('mysql:host=localhost;port=3308;dbname=users', 'root');
    }
}