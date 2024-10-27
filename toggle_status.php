<?php
// Include the database connection file
include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch the current status of the task
    $stmt = $pdo->prepare("SELECT status FROM todolist WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $task = $stmt->fetch();

    if ($task) {
        // Toggle the status: if 0 then set to 1, if 1 then set to 0
        $newStatus = $task['status'] == 0 ? 1 : 0;

        // Update the status in the database
        $updateStmt = $pdo->prepare("UPDATE todolist SET status = :status WHERE id = :id");
        $updateStmt->execute(['status' => $newStatus, 'id' => $id]);

        // Output the new status badge as HTML
        if ($newStatus == 0) {
            echo '<span class="badge badge-danger">Belum</span>';
        } else {
            echo '<span class="badge badge-success">Sudah</span>';
        }
    }
}
