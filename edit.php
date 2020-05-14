<?php

require_once('./connection.php');

$bookId = $_POST['book_id'];

// save
if ( isset($_POST['action']) && $_POST['action'] == 'save' ) {
    var_dump($_POST);

    $stmt = $pdo->prepare('UPDATE books SET title = :title WHERE id = :book_id');
    $stmt->execute(['title' => $_POST['title'], 'book_id' => $bookId]);

    $stmt = $pdo->prepare('UPDATE book_authors SET author_id = :author_id WHERE book_id = :book_id');
    $stmt->execute(['author_id' => $_POST['author_id'], 'book_id' => $bookId]);
}

// select
$stmt = $pdo->prepare('SELECT b.id AS book_id, a.id AS author_id, title, release_date, cover_path, language, summary, price, stock_saldo, pages, type, first_name, last_name FROM books b LEFT JOIN book_authors ba ON ba.book_id=b.id LEFT JOIN authors a ON ba.author_id=a.id WHERE b.id = :id');
$stmt->execute(['id' => $bookId]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM authors LIMIT 200');
$stmt->execute();
$authors = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT count(*) FROM orders WHERE book_id = :id');
$stmt->execute(['id' => $bookId]);
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
            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">

            <div id="buttons">
                <div>
                    <a href="./book.php?id=<?php echo $book['book_id']; ?>">Back</a>
                </div>
                <div>
                    <button type="submit" name="action" value="save">Salvesta</button>
                </div>
            </div>

            <div>
                <span class="label">Pealkiri:</span>
                <input type="text" name="title" value="<?php echo $book['title']; ?>">
            </div>
            <br>
            
            <div>
                <span class="label">Autor:</span>
                <select name="author_id">
                    <?php foreach ( $authors as $author ) { ?>
                        <option value="<?php echo $author['id']; ?>" <?php if ( $author['id'] == $book['author_id'] ) { echo "selected"; } ?>><?php echo $author['first_name']; ?> <?php echo $author['last_name']; ?></option>
                    <?php }?>
                </select>
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
        </form>

    </div>

</body>
</html>

