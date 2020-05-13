<?php

require_once('./connection.php');

$title = $_GET['title'];
$year = $_GET['year'];
$stmt = $pdo->prepare('SELECT * FROM books WHERE title LIKE :title AND release_date LIKE :year');
$stmt->execute(['title' => '%' . $title . '%', 'year' => '%' . $year . '%']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Raamatupood</title>
</head>
<body>

    <form action="./index.php" method="get">
        <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Pealkiri">
        <input type="text" name="year" value="<?php echo $year; ?>" placeholder="Aasta">
        <input type="submit" name="search" value="Otsi">
    </form>

    <ul>
<?php

while ($row = $stmt->fetch())
{
    echo '<li><a href="./book.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
}

?>
    </ul>

</body>
</html>