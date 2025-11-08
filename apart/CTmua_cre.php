<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "quanly_banhang";

$conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4",
                $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);

// Lấy khách hàng
$khachhang = $conn->query("SELECT ID_KHACH_HANG FROM KHACH_HANG")->fetchAll();
if(!$khachhang) die("Chưa có khách hàng");

// Lấy hàng hóa
$hanghoa = $conn->query("SELECT ID_HANGHOA FROM HANG_HOA")->fetchAll();
if(!$hanghoa) die("Chưa có hàng hóa");

// HÀM TÍNH THUẾ
function tinhThue($tong) {
    if ($tong > 3500000) return 5;
    if ($tong >= 2000000) return 7;
    return 10;
}

// TẠO 137 PHIẾU
for($p = 1; $p <= 137; $p++) {

    $mascot = "PN" . str_pad($p, 3, "0", STR_PAD_LEFT);
    $id_kh  = $khachhang[array_rand($khachhang)]->ID_KHACH_HANG;
    $ngay   = date('Y-m-d', strtotime("-" . rand(0, 365) . " days"));

    // 1) Tạo phiếu nhập
    $stmt = $conn->prepare("
        INSERT INTO CHUNG_TU_MUA (MASCOT, NGAYPHATSINH, ID_KHACHHANG, TONGTIENHANG, THUE, TIENTHUE, TONGCONG)
        VALUES (:mascot, :ngay, :kh, 0, 0, 0, 0)
    ");
    $stmt->execute([
        ":mascot" => $mascot,
        ":ngay"   => $ngay,
        ":kh"     => $id_kh
    ]);

    $id_ctmua = $conn->lastInsertId();
    $tongtienhang = 0;

    // Số sản phẩm trong phiếu
    $num_products = rand(1, 5);

    $selected = [];
    while(count($selected) < $num_products){
        $hh = $hanghoa[array_rand($hanghoa)]->ID_HANGHOA;
        if(!in_array($hh, $selected)) $selected[] = $hh;
    }

    // 2) Tạo chi tiết phiếu
    foreach($selected as $idhh){

        $price = $conn->query("
            SELECT GIATRI FROM DON_GIA_BAN 
            WHERE ID_HANGHOA = $idhh 
            ORDER BY NGAYBATDAU DESC 
            LIMIT 1
        ")->fetch();

        $giamua = $price ? $price->GIATRI : rand(500000, 1500000);

        $soluong = rand(1, 20);
        $thanhtien = $giamua * $soluong;

        $tongtienhang += $thanhtien;

        $stmt2 = $conn->prepare("
            INSERT INTO CHUNG_TU_MUA_CT (ID_HANGHOA, GIAMUA, SOLUONG, THANHTIEN, ID_CTMUA)
            VALUES (:idhh, :giamua, :soluong, :thanhtien, :id_ctmua)
        ");
        $stmt2->execute([
            ":idhh" => $idhh,
            ":giamua" => $giamua,
            ":soluong" => $soluong,
            ":thanhtien" => $thanhtien,
            ":id_ctmua" => $id_ctmua
        ]);
    }

    // 3) Tính thuế
    $thue = tinhThue($tongtienhang);
    $tienthue = round($tongtienhang * $thue / 100);
    $tongcong = $tongtienhang + $tienthue;

    // 4) Cập nhật phiếu nhập
    $stmt3 = $conn->prepare("
        UPDATE CHUNG_TU_MUA 
        SET TONGTIENHANG = :tong, THUE = :thue, TIENTHUE = :tienthue, TONGCONG = :tongcong
        WHERE ID_CTMUA = :id
    ");
    $stmt3->execute([
        ":tong" => $tongtienhang,
        ":thue" => $thue,
        ":tienthue" => $tienthue,
        ":tongcong" => $tongcong,
        ":id" => $id_ctmua
    ]);
}

echo "<h2 style='text-align:center;color:#0f0;background:#222;padding:15px'>
✅ ĐÃ TẠO 137 PHIẾU NHẬP CHUẨN THEO DATABASE
</h2>";
?>
