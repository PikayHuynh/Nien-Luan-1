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

// ==============================================
// 1. ĐỊNH NGHĨA GIÁ TRỊ CƠ SỞ THEO PHÂN LOẠI
// ==============================================
// Giá trị cơ sở (BASE_PRICE) cho mỗi ID_PHANLOAI.
// Dựa vào giá này để tạo giá bán ngẫu nhiên phù hợp.

$base_prices = [
    1 => 50000,   // Xếp hình
    2 => 450000,  // Điều khiển từ xa (giá cao hơn)
    3 => 150000,  // Giáo dục
    4 => 300000,  // Lắp ráp
    5 => 80000,   // Mô hình
    6 => 120000,  // Trẻ sơ sinh
    7 => 200000,  // Trí tuệ
    8 => 250000,  // Âm nhạc
    9 => 180000   // Thể thao trẻ em
];

// ==============================================
// 2. LẤY DỮ LIỆU HÀNG HÓA
// ==============================================
// Lấy ID và ID_PHANLOAI của tất cả hàng hóa để tạo giá.
$sql_select = "SELECT ID_HANGHOA, ID_PHANLOAI FROM HANG_HOA";
$stmt_select = $conn->query($sql_select);
$hang_hoa_list = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

if (empty($hang_hoa_list)) {
    die("Lỗi: Không tìm thấy Hàng Hóa. Vui lòng chạy mã chèn HÀNG HÓA trước.");
}

// ==============================================
// 3. INSERT STATEMENT
// ==============================================
$sql_insert = "INSERT INTO DON_GIA_BAN (GIATRI, NGAYBATDAU, APDUNG, ID_HANGHOA)
               VALUES (:gia, :ngaybd, :apdung, :idhhoa)";
$stmt_insert = $conn->prepare($sql_insert);

// ==============================================
// 4. LỌC VÀ CHÈN DỮ LIỆU ĐƠN GIÁ BÁN
// ==============================================

$total_prices_inserted = 0;

foreach ($hang_hoa_list as $hang_hoa) {
    $id_hanghoa = $hang_hoa['ID_HANGHOA'];
    $id_phanloai = $hang_hoa['ID_PHANLOAI'];

    // Lấy giá trị cơ sở, nếu không tìm thấy, dùng 100000
    $base_price = $base_prices[$id_phanloai] ?? 100000;
    
    // Tạo số lượng mức giá ngẫu nhiên (2 hoặc 3 mức giá)
    $num_prices = rand(2, 3);
    $dates = [];
    $prices = [];

    // Tạo các ngày bắt đầu khác nhau
    for ($k = 0; $k < $num_prices; $k++) {
        // Tạo ngày ngẫu nhiên trong khoảng 1 năm trở lại
        $timestamp = strtotime('-' . rand(0, 365) . ' days');
        $dates[] = date('Y-m-d', $timestamp);
    }
    // Sắp xếp các ngày để đảm bảo NGAYBATDAU là thứ tự thời gian
    sort($dates);
    
    // Tạo các mức giá dựa trên giá cơ sở (dao động ±20%)
    for ($k = 0; $k < $num_prices; $k++) {
        // Giá trị sẽ nằm trong khoảng 80% đến 120% của giá cơ sở
        $min_price = $base_price * 0.8;
        $max_price = $base_price * 1.2;
        
        // Mức giá ngẫu nhiên (làm tròn đến hàng nghìn)
        $prices[] = round(rand($min_price, $max_price) / 1000) * 1000;
    }
    
    // Chèn các mức giá
    for ($k = 0; $k < $num_prices; $k++) {
        
        // Chỉ mức giá mới nhất (ngay bat dau lớn nhất) là được áp dụng (APDUNG = 1)
        $apdung = ($k === $num_prices - 1) ? 1 : 0; 
        
        $stmt_insert->bindValue(":gia", $prices[$k]);
        $stmt_insert->bindValue(":ngaybd", $dates[$k]);
        $stmt_insert->bindValue(":apdung", $apdung);
        $stmt_insert->bindValue(":idhhoa", $id_hanghoa);
        
        $stmt_insert->execute();
        $total_prices_inserted++;
    }
    // echo "✅ Đã thêm $num_prices mức giá cho ID Hàng Hóa: $id_hanghoa. <br>";
}

echo "<h3>🎉 Hoàn tất! Đã chèn thành công $total_prices_inserted mức giá vào bảng DON_GIA_BAN.</h3>";
?>