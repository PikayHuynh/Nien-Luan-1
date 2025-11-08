<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "quanly_banhang";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
];

$conn = new PDO(
    "mysql:host=$servername;dbname=$database;charset=utf8mb4",
    $username, 
    $password, 
    $opt
);

// Danh sách phân loại KHÔNG có chữ "đồ chơi"
$phanloai = [
    "Xếp hình" => 
        "Các bộ xếp hình đa dạng về chủ đề, giúp phát triển tư duy không gian và khả năng quan sát.",

    "Điều khiển từ xa" => 
        "Gồm xe, máy bay, tàu, robot điều khiển từ xa, tăng khả năng phối hợp tay – mắt.",

    "Giáo dục" => 
        "Nhóm sản phẩm hỗ trợ học chữ cái, số, hình khối và tư duy logic cơ bản.",

    "Lắp ráp" => 
        "Bộ mô hình lắp ghép chi tiết, giúp trẻ rèn kỹ năng tay và tư duy kỹ thuật.",

    "Mô hình" => 
        "Mô hình nhân vật, robot, xe và tiểu cảnh, kích thích trí tưởng tượng.",

    "Trẻ sơ sinh" => 
        "Sản phẩm an toàn cho trẻ 0–12 tháng, hỗ trợ phát triển giác quan.",

    "Trí tuệ" => 
        "Câu đố, rubik, trò chơi logic giúp rèn tư duy phân tích và ghi nhớ.",

    "Âm nhạc" => 
        "Nhạc cụ mini như đàn, trống, lục lạc giúp bé cảm thụ âm nhạc.",

    "Thể thao trẻ em" => 
        "Bóng, vợt, bowling mini… hỗ trợ vận động và phát triển thể lực."
];

// Chuẩn bị câu lệnh SQL
$sql = "INSERT INTO phan_loai (TENPHANLOAI, MOTA) VALUES (:ten, :mota)";
$stmt = $conn->prepare($sql);

// Thêm dữ liệu
foreach ($phanloai as $ten => $mota) {
    $stmt->bindValue(":ten", $ten);
    $stmt->bindValue(":mota", $mota);
    $stmt->execute();

    echo "✅ Đã thêm: $ten<br>";
}

echo "<br>🎉 Đã thêm 9 phân loại thành công!";
?>
