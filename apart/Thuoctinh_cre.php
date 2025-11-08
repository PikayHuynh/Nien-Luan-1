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


// =====================================================
// BỘ THUỘC TÍNH CHUẨN THEO TỪNG PHÂN LOẠI
// =====================================================

$attr = [

    1 => [ // Xếp hình
        ["Chất liệu", "Gỗ cao su"],
        ["Chất liệu", "Nhựa ABS"],
        ["Số mảnh", "100 mảnh"],
        ["Số mảnh", "200 mảnh"],
        ["Màu chủ đạo", "Nhiều màu"]
    ],

    2 => [ // Điều khiển từ xa
        ["Pin", "Pin AA"],
        ["Pin", "Pin 3.7V sạc"],
        ["Tầm điều khiển", "30 mét"],
        ["Tầm điều khiển", "50 mét"],
        ["Tốc độ", "20 km/h"]
    ],

    3 => [ // Giáo dục
        ["Mức khó", "Cơ bản"],
        ["Mức khó", "Trung bình"],
        ["Chất liệu", "Gỗ ép"],
        ["Độ tuổi", "3-5 tuổi"],
        ["Độ tuổi", "5-7 tuổi"]
    ],

    4 => [ // Lắp ráp
        ["Số chi tiết", "150 chi tiết"],
        ["Số chi tiết", "300 chi tiết"],
        ["Cấp độ", "Level 1"],
        ["Cấp độ", "Level 2"],
        ["Chất liệu", "Nhựa ABS"]
    ],

    5 => [ // Mô hình
        ["Tỉ lệ", "1:32"],
        ["Tỉ lệ", "1:24"],
        ["Chất liệu", "Hợp kim"],
        ["Chất liệu", "Nhựa cứng"],
        ["Màu sơn", "Đỏ"]
    ],

    6 => [ // Trẻ sơ sinh
        ["Chất liệu", "Vải cotton"],
        ["Chất liệu", "Silicon mềm"],
        ["Độ mềm", "Cao"],
        ["Màu sắc", "Hồng"],
        ["Màu sắc", "Xanh"]
    ],

    7 => [ // Trí tuệ
        ["Mức IQ", "Basic"],
        ["Mức IQ", "Advance"],
        ["Chất liệu", "Nhựa cao cấp"],
        ["Độ khó", "Trung bình"],
        ["Độ khó", "Khó"]
    ],

    8 => [ // Âm nhạc
        ["Âm lượng", "Vừa"],
        ["Âm lượng", "To"],
        ["Chất liệu", "Nhựa ABS"],
        ["Loại âm", "Nhạc thiếu nhi"],
        ["Pin", "Pin AA"]
    ],

    9 => [ // Thể thao trẻ em
        ["Kích thước", "Cỡ M"],
        ["Kích thước", "Cỡ L"],
        ["Chất liệu", "Nhựa dẻo"],
        ["Khối lượng", "Nhẹ"],
        ["Màu sắc", "Đỏ"]
    ]

];


// =====================================================
// LẤY DANH SÁCH 500 HÀNG HÓA
// =====================================================

$getHH = $conn->query("SELECT ID_HANGHOA, ID_PHANLOAI FROM HANG_HOA ORDER BY ID_HANGHOA ASC");
$hanghoa = $getHH->fetchAll();


// =====================================================
// INSERT THUỘC TÍNH
// =====================================================

$sql = "INSERT INTO THUOC_TINH (TEN, GIATRI, HINHANH, ID_HANGHOA)
        VALUES (:ten, :giatri, :hinh, :idhh)";

$stmt = $conn->prepare($sql);

$totalInsert = 0;

foreach ($hanghoa as $hh) {

    $pl = $hh["ID_PHANLOAI"];
    $idhh = $hh["ID_HANGHOA"];

    if (!isset($attr[$pl])) continue;

    // số thuộc tính 3 đến 5
    $soTT = rand(3, 5);

    // random không trùng
    $list = $attr[$pl];
    shuffle($list);
    $pick = array_slice($list, 0, $soTT);

    foreach ($pick as $tt) {
        $stmt->execute([
            ":ten"   => $tt[0],
            ":giatri" => $tt[1],
            ":hinh"   => "",
            ":idhh"   => $idhh
        ]);
        $totalInsert++;
    }
}

echo "<h3>✅ Đã tạo xong $totalInsert THUỘC TÍNH SẢN PHẨM cho 500 mặt hàng!</h3>";
