<?php
require_once __DIR__ . '/../../config/db_connect.php';

try {
    $records_per_page = 5;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;

    // Tổng số bản ghi
    $stmt_total = $pdo->query("SELECT COUNT(*) FROM KHACH_HANG");
    $total_records = $stmt_total->fetchColumn();
    $total_pages = ceil($total_records / $records_per_page);

    // Lấy dữ liệu khách hàng
    $stmt = $pdo->prepare("SELECT * FROM KHACH_HANG ORDER BY ID_KHACH_HANG DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $khach_hang = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- Xác định cửa sổ hiển thị 5 nút ---
    $max_buttons = 5;
    $start_page = max(1, $page - floor($max_buttons / 2));
    $end_page = min($total_pages, $start_page + $max_buttons - 1);

    // Điều chỉnh lại start_page nếu end_page chạm cuối
    $start_page = max(1, $end_page - $max_buttons + 1);

} catch (PDOException $e) {
    die("Lỗi khi lấy danh sách khách hàng: " . $e->getMessage());
}
