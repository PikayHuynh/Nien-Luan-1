<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "quanly_banhang";

$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
);

$conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password, $opt);

// Danh sách họ và tên mẫu
$ho  = ["Nguyễn", "Trần", "Lê", "Phạm", "Hoàng", "Võ", "Đặng", "Bùi", "Đỗ", "Hồ"];
$dem = ["Văn", "Thị", "Hữu", "Ngọc", "Minh", "Thanh", "Tuấn", "Quốc", "Anh", "Mai"];
$ten = ["Hào", "An", "Bình", "Chi", "Dung", "Hùng", "Lan", "Linh", "Nam", "Phương", "Tú", "Vy"];

// Tên đường
$ten_duong = [
    "Nguyễn Trãi", "Lý Tự Trọng", "Nguyễn Văn Cừ", "Trường Chinh",
    "Hùng Vương", "Phạm Ngũ Lão", "3 Tháng 2", "CMT8",
    "Hoàng Hoa Thám", "Điện Biên Phủ", "Ngô Quyền"
];

// Phường/Xã
$phuong = [
    "P.1", "P.2", "P.3", "P.4", "P.5", "P.6",
    "P. Bình Thủy", "P. An Hòa", "P. Tân Lập",
    "X. Mỹ Khánh", "X. Tân Phú"
];

// Quận/Huyện
$quan_huyen = [
    "Quận 1", "Quận 3", "Quận Ninh Kiều", "Quận Bình Thủy",
    "Huyện Châu Thành", "Huyện Tân Hiệp", "Quận Cái Răng",
    "TP. Thủ Dầu Một", "TP. Biên Hòa"
];

// Tỉnh/TP
$tinh_tp = [
    "TP Hồ Chí Minh", "Hà Nội", "Đà Nẵng", "Cần Thơ",
    "Bình Dương", "Đồng Nai", "Kiên Giang", "An Giang",
    "Cà Mau", "Sóc Trăng", "Vĩnh Long"
];

// Query INSERT
$sql = "INSERT INTO khach_hang (TEN_KH, DIACHI, SODIENTHOAI, HINHANH, SOB)
        VALUES (:tenkh, :diachi, :sdt, :hinhanh, :sob)";

$stmt = $conn->prepare($sql);

for ($i = 1; $i <= 100; $i++) {

    // Random tên
    $tenKH = $ho[array_rand($ho)] . " " .
             $dem[array_rand($dem)] . " " .
             $ten[array_rand($ten)];

    // Random địa chỉ
    $so_nha = rand(1, 500);
    $duong  = $ten_duong[array_rand($ten_duong)];
    $p      = $phuong[array_rand($phuong)];
    $qh     = $quan_huyen[array_rand($quan_huyen)];
    $tp     = $tinh_tp[array_rand($tinh_tp)];

    $diachi = "$so_nha $duong, $p, $qh, $tp";

    // Random số điện thoại
    $sdt = "09" . rand(10000000, 99999999);

    // ✅ hình ảnh đúng
    $hinhAnh = "khach_" . $i . ".jpg";

    // Random số lần mua
    $sob = rand(0, 20);

    // Bind
    $stmt->bindValue(":tenkh", $tenKH);
    $stmt->bindValue(":diachi", $diachi);
    $stmt->bindValue(":sdt", $sdt);
    $stmt->bindValue(":hinhanh", $hinhAnh);
    $stmt->bindValue(":sob", $sob);

    $stmt->execute();

    echo "✅ Đã thêm $i: $tenKH — $diachi — $sdt — $hinhAnh <br>";
}

echo "<br>🎉 Hoàn tất thêm 100 khách hàng!";
?>
