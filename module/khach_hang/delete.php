<?php
require_once __DIR__ . '/../../config/db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 1. Bắt đầu transaction để đảm bảo atomic
        $pdo->beginTransaction();

        // 2. Xóa chi tiết chứng từ mua liên quan (CHUNG_TU_MUA_CT)
        $stmt_ct = $pdo->prepare("
            DELETE CT 
            FROM CHUNG_TU_MUA_CT AS CT
            JOIN CHUNG_TU_MUA AS C ON CT.ID_CTMUA = C.ID_CTMUA
            WHERE C.ID_KHACHHANG = :id
        ");
        $stmt_ct->execute([':id' => $id]);

        // 3. Xóa chứng từ mua liên quan (CHUNG_TU_MUA)
        $stmt_c = $pdo->prepare("DELETE FROM CHUNG_TU_MUA WHERE ID_KHACHHANG = :id");
        $stmt_c->execute([':id' => $id]);

        // 4. Xóa khách hàng
        $stmt_kh = $pdo->prepare("DELETE FROM KHACH_HANG WHERE ID_KHACH_HANG = :id");
        $stmt_kh->execute([':id' => $id]);

        // 5. Commit transaction
        $pdo->commit();

        header("Location: ../../view/admin/khach_hang/index.php?status=deleted");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Lỗi khi xóa khách hàng và chứng từ mua: " . $e->getMessage());
    }

} else {
    die("Thiếu ID khách hàng để xóa!");
}
