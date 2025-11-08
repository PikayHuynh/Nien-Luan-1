<?php
// --- Kết nối CSDL bằng PDO ---
// Cấu hình thông tin kết nối
$host = 'localhost';
$dbname = 'quanly_banhang';
$username = 'root';
$password = ''; // nếu bạn dùng Laragon hoặc XAMPP thì để trống

try {
    // Tạo kết nối PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Thiết lập chế độ lỗi để PDO báo Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Tùy chọn: tự động trả kết quả dưới dạng associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // echo "✅ Kết nối CSDL thành công!";
} catch (PDOException $e) {
    // Báo lỗi nếu không kết nối được
    die("❌ Lỗi kết nối CSDL: " . $e->getMessage());
}
?>
