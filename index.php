<?php
// Include the database connection file
include 'db.php';

// Fetch all tasks from the database
$sql = "SELECT * FROM todolist";
$stmt = $pdo->query($sql);
$todolist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <!-- Include Bootstrap for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">To Do List</h2>
        <p class="text-center">Catat semua hal yang akan kamu kerjakan disini.</p>

        <!-- Add Task Form -->
        <form class="row g-3 mb-4" action="add_task.php" method="POST">
            <div class="col-md-4">
                <input type="text" name="isi" class="form-control" placeholder="Kegiatan" required>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggalAwal" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggalAkhir" class="form-control" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <!-- Display Task List -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kegiatan</th>
                    <th>Awal</th>
                    <th>Akhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todolist as $index => $task): ?>
                    <tr id="task-row-<?= $task['id'] ?>">
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($task['isi']) ?></td>
                        <td><?= htmlspecialchars($task['tgl_awal']) ?></td>
                        <td><?= htmlspecialchars($task['tgl_akhir']) ?></td>
                        <td id="status-<?= $task['id'] ?>">
                            <?php if ($task['status'] == 0): ?>
                                <span class="badge badge-danger">Belum</span>
                            <?php else: ?>
                                <span class="badge badge-success">Sudah</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button onclick="toggleStatus(<?= $task['id'] ?>)" class="btn btn-info btn-sm">Ubah</button>
                            <button onclick="deleteTask(<?= $task['id'] ?>)" class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- AJAX Script to Delete Task -->
    <script>
        function toggleStatus(id) {
            $.ajax({
                url: 'toggle_status.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    $('#status-' + id).html(response);
                },
                error: function() {
                    alert('Gagal mengubah status.');
                }
            });
        }

        function deleteTask(id) {
            if (confirm('Yakin ingin menghapus?')) {
                $.ajax({
                    url: 'delete_task.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response === 'success') {
                            $('#task-row-' + id).remove(); // Remove the row from the DOM
                        } else {
                            alert('Gagal menghapus tugas.');
                        }
                    },
                    error: function() {
                        alert('Gagal menghapus tugas.');
                    }
                });
            }
        }
    </script>
</body>

</html>