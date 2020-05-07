<?php

require_once('./connection.php');

$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['title']; ?></title>
</head>
<body>
    
    <div><?php echo $book['title']; ?></div>
    <br>

    <div><?php echo $book['language']; ?></div>
    <br>

    <div><?php echo $book['summary']; ?></div>
    <br>

    <div><?php echo $book['price']; ?></div>
    <br>

    <div><?php echo $book['pages']; ?></div>
    <br>


</body>
</html>