<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $isi = $_POST['isi'];
    $tanggalAwal = $_POST['tanggalAwal'];
    $tanggalAkhir = $_POST['tanggalAkhir'];
    $status = $_POST['status'];

    $sql = "UPDATE todolist SET isi = ?, tgl_awal = ?, tgl_akhir = ?, status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$isi, $tanggalAwal, $tanggalAkhir, $status, $id]);

    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM todolist WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!-- Form for editing the task, pre-populate with data from the database -->