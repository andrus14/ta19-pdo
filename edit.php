<?php

require_once('./connection.php');

$id = $_POST['id'];
$stmt = $pdo->prepare('SELECT b.id AS book_id, title, release_date, cover_path, language, summary, price, stock_saldo, pages, type, first_name, last_name FROM books b LEFT JOIN book_authors ba ON ba.book_id=b.id LEFT JOIN authors a ON ba.author_id=a.id WHERE b.id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT count(*) FROM orders WHERE book_id = :id');
$stmt->execute(['id' => $id]);
$ordersCount = $stmt->fetchColumn();

$typeInEstonian = [
    'ebook' => 'E-raamat',
    'new' => 'Uus',
    'used' => 'Kasutatud',
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $book['title']; ?></title>
</head>
<body>

    <div id="container">

        <form action="./edit.php" method="post">
                <input type="hidden" name="id" value="<?php echo $book['book_id']; ?>">
                <button type="submit" name="action" value="save">Salvesta</button>
            </form>

        <div>
            <span class="label">Pealkiri:</span><?php echo $book['title']; ?>
        </div>
        <br>
        
        <div>
            <span class="label">Autor:</span> <input type="text" value="<?php echo $book['first_name']; ?>">
            <span class="label">Autor:</span> <input type="text" value="<?php echo $book['last_name']; ?>">
        </div>
        <br>

        <div>
            <img src="<?php echo $book['cover_path']; ?>">
        </div>
        <br>

        <div>
            <span class="label">Aasta:</span><?php echo $book['release_date']; ?>
        </div>
        <br>

        <div>
            <span class="label">Keel:</span><?php echo $book['language']; ?>
        </div>
        <br>

        <div>
            <span class="label">Sisukokkuvõte:</span><?php echo $book['summary']; ?>
        </div>
        <br>

        <div>
            <span class="label">Hind:</span><?php echo str_replace('.', ',', round($book['price'], 2)); ?> €
        </div>
        <br>

        <div>
            <span class="label">Leheküljed:</span><?php echo $book['pages']; ?>
        </div>
        <br>

        <div>
            <span class="label">Laoseis:</span><?php echo $book['stock_saldo']; ?>
        </div>
        <br>

        <div>
            <span class="label">Tüüp:</span><?php echo $typeInEstonian[$book['type']]; ?>
        </div>
        <br>

    </div>

</body>
</html>

