<?php

// List all books
$app->get('/api/books', function () {

    require_once("dbconnect.php");

    $query = "select * from books";

    $result = $mysqli->query($query);

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    if (isset($data)) {
        header('Content-Type: x-www-form-uelencoded');
        echo json_encode($data);
    }
});

// DISPLAY a single book by id
$app->get('/api/books/{id}', function($request, $response, $args) {
    require_once("dbconnect.php");
    $id = $args['id'];
    $query = "select * from books where id=$id";
    $result = $mysqli->query($query);

    if($result){
        $data[] = $result->fetch_assoc();
        header('Content-Type: x-www-form-uelencoded');
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
});

// POST data and create a new record
$app->post('/api/books', function($request, $response, $args) {
    require_once("dbconnect.php");
    $query = "INSERT INTO `books` (`book_title`, `author`, `amazon_url`) VALUES (?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $book_title, $author, $amazon_url);

    $book_title = $request->getParsedBody()['book_title'];
    $author = $request->getParsedBody()['author'];
    $amazon_url = $request->getParsedBody()['amazon_url'];

    $stmt->execute();
    echo("done");
    
});



// POST data and create a new record
$app->put('/api/books/{id}', function($request, $response, $args) {
    require_once("dbconnect.php");
    $id = $args['id'];
    $query = "UPDATE `books` SET `book_title` = ?, `author` = ?, `amazon_url` = ? WHERE `books`.`id` = $id";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $book_title, $author, $amazon_url);

    $book_title = $request->getParsedBody()['book_title'];
    $author = $request->getParsedBody()['author'];
    $amazon_url = $request->getParsedBody()['amazon_url'];

    $stmt->execute();
    echo("done");
    
});

// POST data and create a new record
$app->delete('/api/books/{id}', function($request, $response, $args) {
    require_once("dbconnect.php");
    $id = $args['id'];
    $query = "delete from `books` WHERE `books`.`id` = $id";
    $mysqli->query($query);
    
    echo("done");
    
});