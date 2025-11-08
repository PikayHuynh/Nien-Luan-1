<?php
require_once __DIR__ . '/../../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['ID_KHACH_HANG'] ?? null;
    $tenkh = $_POST['TENKH'] ?? '';
    $diachi = $_POST['DIACHI'] ?? '';
    $sdt = $_POST['SODIENTHOAI'] ?? '';
    $hinhanh = $_POST['HINHANH'] ?? null;
    $sob = $_POST['SOB'] ?? null;

    if (!$id) {
        die("Thiếu ID khách hàng để cập nhật!");
    }

    try {
        $sql = "UPDATE KHACH_HANG
                SET TEN_KH = :tenkh, DIACHI = :diachi, SODIENTHOAI = :sdt, HINHANH = :hinhanh, SOB = :sob
                WHERE ID_KHACH_HANG = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':tenkh' => $tenkh,
            ':diachi' => $diachi,
            ':sdt' => $sdt,
            ':hinhanh' => $hinhanh,
            ':sob' => $sob,
            ':id' => $id
        ]);

        header("Location: ../../view/admin/khach_hang/index.php?status=updated");
        exit;
    } catch (PDOException $e) {
        die("Lỗi khi cập nhật khách hàng: " . $e->getMessage());
    }
}
