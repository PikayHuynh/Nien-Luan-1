<?php

/**
 * Cấu hình và khởi tạo kết nối đến cơ sở dữ liệu.
 *
 * Tệp này chứa các thông tin cần thiết để kết nối đến cơ sở dữ liệu MySQL
 * bằng PDO (PHP Data Objects).
 *
 * @Lưu_ý_bảo_mật: Để tăng cường bảo mật, bạn nên lưu trữ các thông tin nhạy cảm
 * (như username, password) trong các biến môi trường (sử dụng tệp .env)
 * thay vì viết trực tiếp trong mã nguồn.
 */

/** @var string Tên máy chủ cơ sở dữ liệu (thường là 'localhost'). */
$host = 'localhost';

/** @var string Tên của cơ sở dữ liệu cần kết nối. */
$dbname = 'quanly_banhang_2';

/** @var string Tên người dùng để truy cập cơ sở dữ liệu. */
$username = 'root';

/** @var string Mật khẩu của người dùng (để trống nếu không có). */
$password = '';

/** @var string Bộ ký tự (charset) để đảm bảo hiển thị tiếng Việt chính xác. */
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // die("Kết nối thất bại: " . $e->getMessage());
    /*
     * Bắt và xử lý lỗi nếu kết nối thất bại.
     * Trong môi trường production, nên ghi lỗi vào log và hiển thị một trang
     * thông báo lỗi thân thiện với người dùng thay vì dùng die().
     * die("Kết nối thất bại: " . $e->getMessage());
    */
}
