<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isi = $_POST['isi'];
    $tanggalAwal = $_POST['tanggalAwal'];
    $tanggalAkhir = $_POST['tanggalAkhir'];
    $status = 'Belum';

    $sql = "INSERT INTO todolist (isi, tgl_awal, tgl_akhir, status) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$isi, $tanggalAwal, $tanggalAkhir, $status]);

    header("Location: index.php");
    exit;
}
