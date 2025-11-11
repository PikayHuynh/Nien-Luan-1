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
// Hằng số và Tỷ lệ Thuế Cố định
// ==============================================
const NUM_ORDERS_TO_GENERATE = 1000; // Số lượng chứng từ bán
const THUE_VAT_PERCENT = 10.00; // Đã cố định 10%

// ==============================================
// 1. LẤY DANH SÁCH ID VÀ GIÁ BÁN HIỆN TẠI
// ==============================================

// Lấy ID Khách Hàng 
$customer_ids_result = $conn->query("SELECT ID_KHACH_HANG FROM KHACH_HANG");
$customer_ids = $customer_ids_result->fetchAll(PDO::FETCH_COLUMN);

// Lấy ID Hàng Hóa và Giá bán đang áp dụng (APDUNG=1)
$prices_result = $conn->query("
    SELECT hh.ID_HANGHOA, dgb.GIATRI AS GIABAN
    FROM HANG_HOA hh
    JOIN DON_GIA_BAN dgb ON hh.ID_HANGHOA = dgb.ID_HANGHOA
    WHERE dgb.APDUNG = 1
");

// Lưu trữ giá bán dưới dạng mảng key-value (ID_HANGHOA => GIABAN)
$product_prices = [];
foreach ($prices_result->fetchAll() as $row) {
    $product_prices[$row['ID_HANGHOA']] = $row['GIABAN'];
}
$product_ids = array_keys($product_prices);

if (empty($customer_ids) || empty($product_ids)) {
    die("Lỗi: Cần dữ liệu trong KHACH_HANG, HANG_HOA và DON_GIA_BAN (với APDUNG=1).");
}

// ==============================================
// 2. CHUẨN BỊ CÂU LỆNH INSERT
// ==============================================

// *** ĐÃ SỬA LỖI MASOCT TRONG CÂU LỆNH SQL ***
$sql_insert_ban = "INSERT INTO CHUNG_TU_BAN 
    (MASOCT, NGAYDATHANG, ID_KHACHHANG, TONGTIENHANG, THUE, TRANGTHAI, GHICHU)
    VALUES (:masoct, :ngaydathang, :idkh, :tth, :thue, :trangthai, :ghichu)";
$stmt_ban = $conn->prepare($sql_insert_ban);

$sql_insert_ctban = "INSERT INTO CHUNG_TU_BAN_CT 
    (ID_HANGHOA, GIABAN, SOLUONG, ID_CTBAN)
    VALUES (:idhh, :giaban, :sl, :idctban)";
$stmt_ctban = $conn->prepare($sql_insert_ctban);

// ==============================================
// 3. TẠO VÀ CHÈN CHỨNG TỪ BÁN (1000 CHỨNG TỪ)
// ==============================================

$conn->beginTransaction();
$total_ban_inserted = 0;
$total_ct_ban_inserted = 0;

$trang_thai_options = ['Hoàn thành', 'Đã giao hàng', 'Đang xử lý', 'Đã hủy'];

for ($i = 1; $i <= NUM_ORDERS_TO_GENERATE; $i++) {
    
    // 3.1. Dữ liệu chung cho Chứng từ Bán
    $id_khachhang = $customer_ids[array_rand($customer_ids)];
    $ngay_dat_hang = date('Y-m-d', strtotime('-' . rand(1, 365) . ' days'));
    
    // MASOCT: MB + yy + STT (3 chữ số)
    $masoct = "MB" . date('y', strtotime($ngay_dat_hang)) . str_pad($i, 3, '0', STR_PAD_LEFT);
    
    // Trạng thái ngẫu nhiên
    $trang_thai = $trang_thai_options[array_rand($trang_thai_options)];

    // Tạo 2 đến 5 dòng Chi tiết Bán ngẫu nhiên
    $num_details = rand(2, 5);
    $current_tong_tien_hang = 0;
    $details = [];

    $selected_product_ids = array_rand(array_flip($product_ids), $num_details);
    if (!is_array($selected_product_ids)) { $selected_product_ids = [$selected_product_ids]; }

    // 3.2. Tạo Chi tiết Bán và tính TONGTIENHANG
    foreach ($selected_product_ids as $id_hh) {
        $so_luong = rand(1, 10); 
        $gia_ban = $product_prices[$id_hh]; 
        $thanh_tien = $gia_ban * $so_luong; 
        
        $details[] = [
            'id_hanghoa' => $id_hh,
            'giaban' => $gia_ban,
            'soluong' => $so_luong,
        ];
        $current_tong_tien_hang += $thanh_tien;
    }

    // 3.3. Chèn vào CHUNG_TU_BAN
    // *** ĐÃ SỬA LỖI MASOCT TRONG MẢNG THAM SỐ (Nếu có) ***
    $stmt_ban->execute([
        ":masoct" => $masoct, 
        ":ngaydathang" => $ngay_dat_hang,
        ":idkh" => $id_khachhang,
        ":tth" => $current_tong_tien_hang,
        ":thue" => THUE_VAT_PERCENT, // Cố định 10.00
        ":trangthai" => $trang_thai,
        ":ghichu" => "Chứng từ bán mẫu số $i"
    ]);

    $id_ctban_moi = $conn->lastInsertId();
    $total_ban_inserted++;

    // 3.4. Chèn vào CHUNG_TU_BAN_CT
    foreach ($details as $detail) {
        $stmt_ctban->execute([
            ":idhh" => $detail['id_hanghoa'],
            ":giaban" => $detail['giaban'],
            ":sl" => $detail['soluong'],
            ":idctban" => $id_ctban_moi
        ]);
        $total_ct_ban_inserted++;
    }
}

$conn->commit();

echo "<h3>🎉 Hoàn tất chèn dữ liệu BÁN!</h3>";
echo "<ul>";
echo "<li>Đã chèn **$total_ban_inserted** Chứng từ Bán.</li>";
echo "<li>Đã chèn **$total_ct_ban_inserted** Chi tiết Bán.</li>";
echo "</ul>";
?>