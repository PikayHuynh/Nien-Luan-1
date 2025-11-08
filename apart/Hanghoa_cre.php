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
// DANH SÁCH SẢN PHẨM THEO PHÂN LOẠI 1-9
// ==============================================

$products_by_category = [

    // 1 → Đồ chơi xếp hình
    1 => [
        "Bộ xếp hình 3D", "Puzzle nghệ thuật", "Xếp hình hoạt hình",
        "Puzzle phong cảnh", "Lego thành phố", "Puzzle động vật",
        "Xếp hình lâu đài", "Puzzle khủng long", "Lego kỹ thuật",
        "Xếp hình kim tự tháp", "Puzzle bản đồ thế giới"
    ],

    // 2 → Điều khiển từ xa
    2 => [
        "Xe địa hình điều khiển", "Drone mini 2 cánh", "Máy bay RC",
        "Thuyền điều khiển", "Robot RC chiến đấu", "Xe drift điều khiển",
        "Drone camera HD", "Xe tank điều khiển", "Robot AI mini",
        "Thuyền cao tốc RC", "Máy bay phản lực mô phỏng"
    ],

    // 3 → Đồ chơi giáo dục
    3 => [
        "Flashcard học chữ", "Bộ học toán Montessori", "Bảng số thông minh",
        "Bộ học tiếng Anh", "Khối gỗ nhận biết hình", "Bộ học màu sắc",
        "Bộ học nhận biết trái cây", "Trò chơi chữ cái nam châm",
        "Bảng phép tính nhanh", "Câu đố lắp ghép thông minh",
        "Sách vải giáo dục"
    ],

    // 4 → Lắp ráp
    4 => [
        "Lắp ráp xe công trình", "Robot lắp ráp 200 khối", "Lắp ráp cơ khí",
        "Lắp ráp xe cứu hỏa", "Lắp ráp tàu vũ trụ", "Lắp ráp xe đua",
        "Lắp ráp xe chuyên dụng", "Robot vũ trụ lắp ráp",
        "Bộ lắp thép kỹ thuật", "Xe công trình mini", "Cỗ máy lắp ráp đa năng"
    ],

    // 5 → Mô hình
    5 => [
        "Mô hình xe tăng", "Mô hình ô tô kim loại", "Mô hình máy bay",
        "Mô hình khủng long", "Mô hình xe cổ", "Mô hình robot",
        "Mô hình tàu thủy", "Mô hình nhà cổ", "Mô hình chiến binh",
        "Mô hình động vật rừng", "Mô hình kiến trúc Tokyo"
    ],

    // 6 → Trẻ sơ sinh
    6 => [
        "Lục lạc mềm", "Đồ chơi gặm nướu", "Thảm chơi sơ sinh",
        "Chuông gió treo nôi", "Thú bông phát nhạc", "Vòng xúc xắc",
        "Gối ôm thú bông", "Bộ gặm nướu silicon", "Kệ chữ A phát nhạc",
        "Xe tập đi mềm", "Bộ xúc xắc đa giác"
    ],

    // 7 → Trí tuệ
    7 => [
        "Khối rubik 3x3", "Trò chơi logic IQ", "Mê cung mini",
        "Khối gỗ tư duy", "Ghép hình IQ", "Trò chơi tìm đường",
        "Rubik 4x4", "Trò chơi chiến thuật mini", "Boardgame trí tuệ",
        "Khối tư duy kim loại", "Puzzle IQ thử thách"
    ],

    // 8 → Âm nhạc
    8 => [
        "Đàn piano mini", "Đàn organ bé", "Trống trẻ em",
        "Guitar đồ chơi", "Đàn gỗ gõ nhịp", "Bộ trống mini",
        "Đàn ukulele nhựa", "Đàn harmonica bé", "Micro karaoke trẻ em",
        "Đàn kèn trumpet đồ chơi", "Đàn sáo mini"
    ],

    // 9 → Thể thao trẻ em
    9 => [
        "Bóng rổ mini", "Bộ bowling trẻ em", "Vợt cầu lông bé",
        "Bóng đá mềm", "Gậy golf nhựa", "Bộ dụng cụ thể thao",
        "Bộ đá cầu mềm", "Bộ ném vòng trẻ em", "Bộ bóng chuyền mini",
        "Ván trượt trẻ em", "Bộ nhảy lò cò tiêu chuẩn"
    ]
];



// ==============================================
// ĐƠN VỊ TÍNH + THƯƠNG HIỆU NỔI TIẾNG
// ==============================================

$donvitinh = ["Cái", "Hộp", "Bộ", "Set", "Chiếc", "Gói", "Túi"];

$brands = [
    "Lego", "Hasbro", "Barbie", "Hot Wheels", "Fisher Price",
    "Mattel", "Takara Tomy", "Playmobil", "Bandai", "Xiaomi",
    "Vtech", "Kidzone", "Huanger", "KidzLabs", "Mechlab"
];


// ==============================================
// INSERT STATEMENT
// ==============================================
$sql = "INSERT INTO HANG_HOA (TENHANGHOA, MOTA, DONVITINH, HINHANH, ID_PHANLOAI)
        VALUES (:ten, :mota, :dvt, :hinh, :pl)";

$stmt = $conn->prepare($sql);


// ==============================================
// TẠO 500 SẢN PHẨM ĐA DẠNG – ĐÚNG PHÂN LOẠI – CÓ THƯƠNG HIỆU
// ==============================================

$count = 0;

foreach ($products_by_category as $pl => $items) {

    foreach ($items as $baseName) {

        if ($count >= 500) break;

        for ($i = 1; $i <= 10; $i++) {

            if ($count >= 500) break;

            // Model + Thương hiệu
            $brand = $brands[array_rand($brands)];
            $ten = $baseName . " Model " . rand(100, 999) . " - " . $brand;

            // Mô tả chi tiết
            $mota = "Sản phẩm '$ten' thuộc phân loại $pl, chất lượng cao, thương hiệu $brand, an toàn cho trẻ.";

            // Đơn vị tính
            $dvt = $donvitinh[array_rand($donvitinh)];

            // INSERT
            $stmt->bindValue(":ten", $ten);
            $stmt->bindValue(":mota", $mota);
            $stmt->bindValue(":dvt", $dvt);
            $stmt->bindValue(":hinh", "");
            $stmt->bindValue(":pl", $pl);

            $stmt->execute();
            $count++;
        }
    }
}

echo "<h3>✅ Đã tạo $count mặt hàng với thương hiệu nổi tiếng — KHÔNG TRÙNG — RẤT ĐA DẠNG!</h3>";

?>
