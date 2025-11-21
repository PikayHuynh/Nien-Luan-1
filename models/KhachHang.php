<?php
class KhachHang {
    private $conn;
    private $table = "KHACH_HANG";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getAll() {
    //     $stmt = $this->conn->query("SELECT * FROM $this->table ORDER BY ID_KHACH_HANG DESC");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

     // Lấy dữ liệu phân trang
    public function getAllPaging($offset, $limit) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY ID_KHACH_HANG DESC LIMIT :offset, :limit");
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM $this->table");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_KHACH_HANG = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO $this->table (TEN_KH, PASSWORD, DIACHI, SODIENTHOAI, HINHANH, SOB)
                VALUES (:TEN_KH, :PASSWORD, :DIACHI, :SODIENTHOAI, :HINHANH, :SOB)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'TEN_KH' => $data['TEN_KH'],
            'PASSWORD' => $data['PASSWORD'],
            'DIACHI' => $data['DIACHI'],
            'SODIENTHOAI' => $data['SODIENTHOAI'],
            'HINHANH' => $data['HINHANH'] ?? null,
            'SOB' => $data['SOB']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE $this->table SET TEN_KH=:TEN_KH, DIACHI=:DIACHI, 
                SODIENTHOAI=:SODIENTHOAI, HINHANH=:HINHANH, SOB=:SOB WHERE ID_KHACH_HANG=:id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        return $stmt->execute([
            'TEN_KH' => $data['TEN_KH'],
            'DIACHI' => $data['DIACHI'],
            'SODIENTHOAI' => $data['SODIENTHOAI'],
            'HINHANH' => $data['HINHANH'] ?? null,
            'SOB' => $data['SOB'],
            'id' => $id
        ]);
    }

    public function updateProfile($id, $data) {
        $sql = "UPDATE $this->table 
                SET TEN_KH = :TEN_KH, DIACHI = :DIACHI, SODIENTHOAI = :SODIENTHOAI
                WHERE ID_KHACH_HANG = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'TEN_KH' => $data['TEN_KH'],
            'DIACHI' => $data['DIACHI'],
            'SODIENTHOAI' => $data['SODIENTHOAI'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        // Prevent deleting admin accounts at model level as well
        if ($this->isAdmin($id)) {
            throw new Exception("Không thể xóa tài khoản quản trị (admin).");
        }

        try {
            $this->conn->beginTransaction();

            // 1️⃣ Xóa chi tiết chứng từ mua liên quan
            $stmt = $this->conn->prepare("DELETE FROM CHUNG_TU_MUA_CT 
                                        WHERE ID_CTMUA IN (SELECT ID_CTMUA FROM CHUNG_TU_MUA WHERE ID_KHACHHANG = :id)");
            $stmt->execute([':id' => $id]);

            // 2️⃣ Xóa chứng từ mua
            $stmt = $this->conn->prepare("DELETE FROM CHUNG_TU_MUA WHERE ID_KHACHHANG = :id");
            $stmt->execute([':id' => $id]);

            // 3️⃣ Xóa chi tiết chứng từ bán liên quan
            $stmt = $this->conn->prepare("DELETE FROM CHUNG_TU_BAN_CT 
                                        WHERE ID_CTBAN IN (SELECT ID_CTBAN FROM CHUNG_TU_BAN WHERE ID_KHACHHANG = :id)");
            $stmt->execute([':id' => $id]);

            // 4️⃣ Xóa chứng từ bán
            $stmt = $this->conn->prepare("DELETE FROM CHUNG_TU_BAN WHERE ID_KHACHHANG = :id");
            $stmt->execute([':id' => $id]);

            // 5️⃣ Xóa khách hàng
            $stmt = $this->conn->prepare("DELETE FROM KHACH_HANG WHERE ID_KHACH_HANG = :id");
            $stmt->execute([':id' => $id]);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("Xóa khách hàng thất bại: " . $e->getMessage());
        }
    }

    public function getByName($tenKH) {
        $stmt = $this->conn->prepare("SELECT * FROM KHACH_HANG WHERE TEN_KH = :tenKH");
        $stmt->execute(['tenKH' => $tenKH]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kiểm tra admin
    public function isAdmin($idKH) {
        $stmt = $this->conn->prepare("SELECT TEN_KH, SOB FROM KHACH_HANG WHERE ID_KHACH_HANG = :id");
        $stmt->execute(['id' => $idKH]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return false;
        // Consider user admin if explicit role SOB='admin' or username is 'admin'
        return (isset($row['SOB']) && strtolower($row['SOB']) === 'admin') || (isset($row['TEN_KH']) && strtolower($row['TEN_KH']) === 'admin');
    }

}