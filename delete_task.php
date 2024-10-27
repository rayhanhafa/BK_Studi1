<?php
// Include the database connection file
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete statement
    $stmt = $pdo->prepare("DELETE FROM todolist WHERE id = :id");
    if ($stmt->execute(['id' => $id])) {
        echo 'success';
    } else {
        echo 'error';
    }
}
