<?php

require_once('./connection.php');

if ( isset($_POST['action']) && $_POST['action'] == 'delete' ) {

    $id = $_POST['id'];

    $stmt = $pdo->prepare('DELETE FROM books WHERE id = :id');
    $stmt->execute(['id' => $id]);

    header('Location: ./index.php');
}

