<?php
require_once __DIR__ . '/../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tenkh = $_POST['TENKH'] ?? '';
    $diachi = $_POST['DIACHI'] ?? '';
    $sdt = $_POST['SODIENTHOAI'] ?? '';
    $hinhanh = $_POST['HINHANH'] ?? null;
    $sob = $_POST['SOB'] ?? null;

    try {
        $sql = "INSERT INTO KHACH_HANG (TEN_KH, DIACHI, SODIENTHOAI, HINHANH, SOB)
                VALUES (:tenkh, :diachi, :sdt, :hinhanh, :sob)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tenkh' => $tenkh,
            ':diachi' => $diachi,
            ':sdt' => $sdt,
            ':hinhanh' => $hinhanh,
            ':sob' => $sob
        ]);

        header("Location: ../../view/admin/khach_hang/index.php?status=added");
        exit;
    } catch (PDOException $e) {
        die("Lỗi khi thêm khách hàng: " . $e->getMessage());
    }
}
