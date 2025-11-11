<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "quanly_banhang";

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4",
                $username, $password, $opt);

// ==============================================
// Hằng số và Tỷ lệ Thuế Ngẫu nhiên
// ==============================================
const NUM_ORDERS_TO_GENERATE = 1000; // Số lượng chứng từ mua

// Tỷ lệ thuế phổ biến trên thị trường (dạng %: 5.00, 8.00, 10.00)
$thue_options = [5.00, 8.00, 10.00]; 

// ==============================================
// 1. LẤY DANH SÁCH ID VÀ GIÁ BÁN HIỆN TẠI
// ==============================================

// Lấy ID Khách Hàng (dùng làm Nhà Cung Cấp)
$customer_ids_result = $conn->query("SELECT ID_KHACH_HANG FROM KHACH_HANG");
$customer_ids = $customer_ids_result->fetchAll(PDO::FETCH_COLUMN);

// Lấy ID Hàng Hóa và Giá bán đang áp dụng (APDUNG=1) để làm giá cơ sở
$prices_result = $conn->query("
    SELECT hh.ID_HANGHOA, dgb.GIATRI AS GIABAN
    FROM HANG_HOA hh
    JOIN DON_GIA_BAN dgb ON hh.ID_HANGHOA = dgb.ID_HANGHOA
    WHERE dgb.APDUNG = 1
");

$product_prices = [];
foreach ($prices_result->fetchAll() as $row) {
    $product_prices[$row['ID_HANGHOA']] = $row['GIABAN'];
}
$product_ids = array_keys($product_prices);

if (empty($customer_ids) || empty($product_ids)) {
    die("Lỗi: Cần dữ liệu trong KHACH_HANG, HANG_HOA và DON_GIA_BAN.");
}

// ==============================================
// 2. CHUẨN BỊ CÂU LỆNH INSERT
// ==============================================

$sql_insert_mua = "INSERT INTO CHUNG_TU_MUA 
    (MASOCT, NGAYPHATSINH, ID_KHACHHANG, TONGTIENHANG, THUE)
    VALUES (:masoct, :ngayps, :idkh, :tth, :thue)";
$stmt_mua = $conn->prepare($sql_insert_mua);

$sql_insert_ctmua = "INSERT INTO CHUNG_TU_MUA_CT 
    (ID_HANGHOA, GIAMUA, SOLUONG, ID_CTMUA)
    VALUES (:idhh, :giamua, :sl, :idctmua)";
$stmt_ctmua = $conn->prepare($sql_insert_ctmua);

// ==============================================
// 3. TẠO VÀ CHÈN CHỨNG TỪ MUA (1000 CHỨNG TỪ)
// ==============================================

$conn->beginTransaction();
$total_mua_inserted = 0;
$total_ct_mua_inserted = 0;

for ($i = 1; $i <= NUM_ORDERS_TO_GENERATE; $i++) {
    
    // 3.1. Dữ liệu chung cho Chứng từ Mua
    $id_khachhang = $customer_ids[array_rand($customer_ids)];
    $ngay_ps = date('Y-m-d', strtotime('-' . rand(1, 365) . ' days'));
    
    // *** ĐÃ SỬA: MASOCT mới theo định dạng MHyySTT ***
    // (yy = 2 chữ số năm, STT = 3 chữ số)
    $masoct = "MH" . date('y', strtotime($ngay_ps)) . str_pad($i, 3, '0', STR_PAD_LEFT);
    
    // Lấy tỷ lệ thuế ngẫu nhiên cho chứng từ này
    $thue_ngau_nhien = $thue_options[array_rand($thue_options)]; 
    
    // Tạo 2 đến 5 dòng Chi tiết Mua ngẫu nhiên
    $num_details = rand(2, 5);
    $current_tong_tien_hang = 0;
    $details = [];

    $selected_product_ids = array_rand(array_flip($product_ids), $num_details);
    if (!is_array($selected_product_ids)) { $selected_product_ids = [$selected_product_ids]; }

    // 3.2. Tạo Chi tiết Mua và tính TONGTIENHANG
    foreach ($selected_product_ids as $id_hh) {
        $so_luong = rand(10, 100); 
        
        // Tính toán Giá Mua (70% - 85% Giá Bán hiện tại)
        $base_giaban = $product_prices[$id_hh];
        $random_ratio = rand(700, 850) / 1000; // 0.70 đến 0.85
        $gia_mua = round(($base_giaban * $random_ratio) / 1000) * 1000;
        
        $thanh_tien = $gia_mua * $so_luong; 
        
        $details[] = [
            'id_hanghoa' => $id_hh,
            'giamua' => $gia_mua,
            'soluong' => $so_luong,
        ];
        $current_tong_tien_hang += $thanh_tien;
    }

    // 3.3. Chèn vào CHUNG_TU_MUA
    $stmt_mua->execute([
        ":masoct" => $masoct, // Giá trị đã được cập nhật: MH25001
        ":ngayps" => $ngay_ps,
        ":idkh" => $id_khachhang,
        ":tth" => $current_tong_tien_hang,
        ":thue" => $thue_ngau_nhien 
    ]);

    $id_ctmua_moi = $conn->lastInsertId();
    $total_mua_inserted++;

    // 3.4. Chèn vào CHUNG_TU_MUA_CT
    foreach ($details as $detail) {
        $stmt_ctmua->execute([
            ":idhh" => $detail['id_hanghoa'],
            ":giamua" => $detail['giamua'],
            ":sl" => $detail['soluong'],
            ":idctmua" => $id_ctmua_moi
        ]);
        $total_ct_mua_inserted++;
    }
}

$conn->commit();

echo "<h3>🎉 Hoàn tất chèn dữ liệu MUA!</h3>";
echo "<ul>";
echo "<li>Đã chèn **$total_mua_inserted** Chứng từ Mua.</li>";
echo "<li>Đã chèn **$total_ct_mua_inserted** Chi tiết Mua.</li>";
echo "</ul>";
?>