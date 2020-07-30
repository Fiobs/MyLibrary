<?php

$dbh = new \PDO('mysql:host=localhost;port=3308;dbname=test_db', 'root');
//$sth = $dbh->prepare("SELECT book_id FROM authors_books WHERE author_id = 20");
//$sth->execute();
//$id = $sth->fetch(\PDO::FETCH_COLUMN);
////var_dump($id);die();
//echo $id ? "notempty" : "empty";

$bookId = $dbh->prepare("SELECT id FROM books WHERE book_name = 'BIBLIA'");
$bookId->execute();
$bookId = $bookId->fetch(\PDO::FETCH_COLUMN);
var_dump($bookId);die();