<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "quanly_banhang";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
];

$conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4",
                $username, $password, $opt);

// Lấy tất cả hàng hóa
$hanghoa = $conn->query("SELECT ID_HANGHOA FROM HANG_HOA")->fetchAll();

$sql_insert = "INSERT INTO DON_GIA_BAN (GIATRI, NGAYBATDAU, APDUNG, ID_HANGHOA)
               VALUES (:giatri, :ngaybd, :apdung, :idhh)";
$stmt = $conn->prepare($sql_insert);

foreach ($hanghoa as $hh) {
    // Giá gốc cho mặt hàng (random 50.000 -> 2.000.000)
    $giatri_goc = rand(50000, 2000000);

    // Tạo 1-3 mức giá gần nhau (±10%)
    $num_prices = rand(1, 3);

    for ($i = 0; $i < $num_prices; $i++) {
        // +/- 10% so với giá gốc
        $giatri = round($giatri_goc * (1 + (rand(-10,10)/100)), 0);

        // Ngày áp dụng ngẫu nhiên trong vòng 1 năm
        $ngaybd = date('Y-m-d', strtotime("-" . rand(0, 365) . " days"));

        $apdung = "Áp dụng cho khách lẻ";

        $stmt->bindValue(":giatri", $giatri);
        $stmt->bindValue(":ngaybd", $ngaybd);
        $stmt->bindValue(":apdung", $apdung);
        $stmt->bindValue(":idhh", $hh->ID_HANGHOA);

        $stmt->execute();
    }
}

echo "<h3>✅ Đã tạo dữ liệu giả cho DON_GIA_BAN với giá ổn định theo mặt hàng!</h3>";
?>

