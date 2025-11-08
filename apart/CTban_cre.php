<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "quanly_banhang";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    // Tắt khóa ngoại
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");
    $conn->exec("TRUNCATE TABLE CHUNG_TU_BAN_CT");
    $conn->exec("TRUNCATE TABLE CHUNG_TU_BAN");
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Tạo bảng nếu chưa có
    if ($conn->query("SHOW TABLES LIKE 'CHUNG_TU_BAN'")->rowCount() == 0) {
        $conn->exec("CREATE TABLE CHUNG_TU_BAN (
            ID_CTBAN INT AUTO_INCREMENT PRIMARY KEY,
            MASCOT VARCHAR(50) UNIQUE,
            NGAYDATHANG DATE NOT NULL,
            ID_KHACHHANG INT,
            TONGTIENHANG DECIMAL(18,2),
            THUE DECIMAL(5,2) DEFAULT 10.00,
            TIENTHUE DECIMAL(18,2),
            TONGCONG DECIMAL(18,2),
            TRANGTHAI VARCHAR(50),
            GHICHU TEXT
        )");
    }

    if ($conn->query("SHOW TABLES LIKE 'CHUNG_TU_BAN_CT'")->rowCount() == 0) {
        $conn->exec("CREATE TABLE CHUNG_TU_BAN_CT (
            ID_CT INT AUTO_INCREMENT PRIMARY KEY,
            ID_CTBAN INT,
            ID_HANGHOA INT,
            GIABAN DECIMAL(18,2),
            SOLUONG INT,
            THANHTIEN DECIMAL(18,2)
        )");
    }

    // Lấy dữ liệu
    $kh = $conn->query("SELECT ID_KHACH_HANG FROM KHACH_HANG")->fetchAll();
    $hh = $conn->query("SELECT ID_HANGHOA FROM HANG_HOA")->fetchAll(PDO::FETCH_COLUMN);

    if (empty($kh)) die("LỖI: Không có khách hàng!");
    if (empty($hh)) die("LỖI: Không có hàng hóa!");

    $stmt_hd = $conn->prepare("INSERT INTO CHUNG_TU_BAN 
        (MASCOT, NGAYDATHANG, ID_KHACHHANG, TONGTIENHANG, THUE, TIENTHUE, TONGCONG, TRANGTHAI, GHICHU)
        VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt_ct = $conn->prepare("INSERT INTO CHUNG_TU_BAN_CT 
        (ID_CTBAN, ID_HANGHOA, GIABAN, SOLUONG, THANHTIEN) VALUES (?,?,?,?,?)");

    $dem_hd = 0;
    $dem_ct = 0;

    for ($i = 1; $i <= 120; $i++) {
        $mascot = "HD" . str_pad($i, 4, "0", STR_PAD_LEFT);
        $ngay   = date('Y-m-d', strtotime("-" . rand(0, 180) . " days"));
        $idkh   = $kh[array_rand($kh)]->ID_KHACH_HANG;
        $tong   = 0;
        $items  = [];

        // Chọn 1-5 sản phẩm
        $n = rand(1, 5);
        $chon = [];
        while (count($chon) < $n) {
            $idhh = $hh[array_rand($hh)];
            if (!in_array($idhh, $chon)) $chon[] = $idhh;
        }

        foreach ($chon as $idhh) {
            $gia = $conn->query("SELECT GIATRI FROM DON_GIA_BAN WHERE ID_HANGHOA = $idhh ORDER BY NGAYBATDAU DESC LIMIT 1")->fetchColumn();
            $giaban = $gia ? round($gia * 1.3) : rand(300000, 2000000);
            $sl = rand(1, 10);
            $tt = $giaban * $sl;
            $tong += $tt;
            $items[] = [$idhh, $giaban, $sl, $tt];
        }

        $tienthue = round($tong * 0.1);
        $tongcong = $tong + $tienthue;

        $stmt_hd->execute([
            $mascot, $ngay, $idkh, $tong, 10.00, $tienthue, $tongcong,
            ['Chưa thanh toán','Đã thanh toán','Hủy'][array_rand([0,1,2])],
            ['VIP','Giao nhanh','Giảm 10%','COD',''][array_rand([0,1,2,3,4])]
        ]);
        $id = $conn->lastInsertId();
        $dem_hd++;

        foreach ($items as $it) {
            $stmt_ct->execute([$id, $it[0], $it[1], $it[2], $it[3]]);
            $dem_ct++;
        }
    }

    // HIỂN THỊ KẾT QUẢ RÕ RÀNG
    echo "<pre style='background:#000;color:#0f0;font-family:Courier New;padding:20px;'>";
    echo "HOÀN TẤT! ĐÃ TẠO THÀNH CÔNG!\n";
    echo "─────────────────────────────\n";
    echo "Hóa đơn (CHUNG_TU_BAN): $dem_hd dòng\n";
    echo "Chi tiết (CHUNG_TU_BAN_CT): $dem_ct dòng\n";
    echo "Mở phpMyAdmin → Xem ngay!\n";
    echo "</pre>";

} catch (Exception $e) {
    echo "<pre style='background:#000;color:red;padding:20px;'>";
    echo "LỖI: " . $e->getMessage() . "\n";
    echo "Dòng: " . $e->getLine() . "\n";
    echo "</pre>";
}
?>