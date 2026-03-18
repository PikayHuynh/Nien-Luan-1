<?php

/**
 * Model quản lý bảng KHACH_HANG
 * Bao gồm: CRUD, phân trang, kiểm tra quyền admin, xoá cascading.
 */
class KhachHang
{

    private $conn;
    private $table = "KHACH_HANG";

    /**
     * Nhận kết nối database khi khởi tạo
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ============================================================
    // ========================= GET DATA ==========================
    // ============================================================

    /**
     * Lấy toàn bộ khách hàng
     */
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy dữ liệu phân trang
     */
    public function getAllPaging($offset, $limit)
    {

        $sql = "SELECT * FROM $this->table 
                ORDER BY ID_KHACH_HANG DESC 
                LIMIT :offset, :limit";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số khách hàng
     */
    public function countAll()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'] ?? 0;
    }

    /**
     * Tìm kiếm khách hàng theo tên và phân trang kết quả.
     *
     * @param int    $offset Vị trí bắt đầu.
     * @param int    $limit  Số lượng kết quả.
     * @param string $q      Từ khóa tìm kiếm.
     * @return array         Mảng các khách hàng tìm thấy.
     */
    public function searchAndPaginateByName($offset, $limit, $q)
    {
        $searchTerm = "%$q%";
        $sql = "SELECT * FROM $this->table
                WHERE TEN_KH LIKE :q
                ORDER BY ID_KHACH_HANG DESC
                LIMIT :offset, :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':q', $searchTerm, PDO::PARAM_STR);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số kết quả khi tìm kiếm khách hàng theo tên.
     *
     * @param string $q Từ khóa tìm kiếm.
     * @return int     Tổng số khách hàng khớp.
     */
    public function countSearchResults($q)
    {
        $searchTerm = "%$q%";
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM $this->table WHERE TEN_KH LIKE :q");
        $stmt->execute([':q' => $searchTerm]);
        return $stmt->fetchColumn();
    }

    public function searchByName($q)
    {
        $q = "%$q%";

        $stmt = $this->conn->prepare("
            SELECT * FROM KHACH_HANG
            WHERE TEN_KH LIKE :q
            ORDER BY ID_KHACH_HANG DESC
        ");

        $stmt->execute(['q' => $q]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSortedByName(): array
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM KHACH_HANG ORDER BY TEN_KH ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    /**
     * Lấy khách hàng theo ID
     */
    public function getById($id)
    {

        $stmt = $this->conn->prepare("
            SELECT * FROM $this->table 
            WHERE ID_KHACH_HANG = :id
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy khách hàng theo Username
     */
    public function getByName($tenKH)
    {

        $stmt = $this->conn->prepare("
            SELECT * FROM KHACH_HANG 
            WHERE TEN_KH = :tenKH
        ");

        $stmt->execute(['tenKH' => $tenKH]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // ========================= CREATE ============================
    // ============================================================

    /**
     * Tạo khách hàng mới
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (TEN_KH, PASSWORD, DIACHI, SODIENTHOAI, HINHANH, SOB)
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

    // ============================================================
    // ========================= UPDATE ============================
    // ============================================================

    /**
     * Cập nhật khách hàng (admin dùng)
     */
    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET TEN_KH = :TEN_KH,
                    DIACHI = :DIACHI,
                    SODIENTHOAI = :SODIENTHOAI,
                    HINHANH = :HINHANH,
                    SOB = :SOB
                WHERE ID_KHACH_HANG = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'TEN_KH' => $data['TEN_KH'],
            'DIACHI' => $data['DIACHI'],
            'SODIENTHOAI' => $data['SODIENTHOAI'],
            'HINHANH' => $data['HINHANH'] ?? null,
            'SOB' => $data['SOB'],
            'id' => $id
        ]);
    }

    /**
     * Cập nhật hồ sơ người dùng (client)
     */
    public function updateProfile($id, $data)
    {

        $sql = "UPDATE $this->table
                SET TEN_KH = :TEN_KH,
                    DIACHI = :DIACHI,
                    SODIENTHOAI = :SODIENTHOAI
                WHERE ID_KHACH_HANG = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'TEN_KH' => $data['TEN_KH'],
            'DIACHI' => $data['DIACHI'],
            'SODIENTHOAI' => $data['SODIENTHOAI'],
            'id' => $id
        ]);
    }

    // ============================================================
    // ========================== DELETE ===========================
    // ============================================================

    /**
     * Xoá khách hàng + toàn bộ chứng từ liên quan
     */
    public function delete($id)
    {

        // Không cho phép xoá admin từ model
        if ($this->isAdmin($id)) {
            throw new Exception("Không thể xóa tài khoản quản trị (admin).");
        }

        try {
            $this->conn->beginTransaction();

            // 1️⃣ Xóa chi tiết chứng từ mua
            $sql = "DELETE FROM CHUNG_TU_MUA_CT
                    WHERE ID_CTMUA IN (
                        SELECT ID_CTMUA FROM CHUNG_TU_MUA WHERE ID_KHACHHANG = :id
                    )";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            // 2️⃣ Xóa chứng từ mua
            $stmt = $this->conn->prepare("
                DELETE FROM CHUNG_TU_MUA WHERE ID_KHACHHANG = :id
            ");
            $stmt->execute([':id' => $id]);

            // 3️⃣ Xóa chi tiết chứng từ bán
            $stmt = $this->conn->prepare("
                DELETE FROM CHUNG_TU_BAN_CT
                WHERE ID_CTBAN IN (
                    SELECT ID_CTBAN FROM CHUNG_TU_BAN WHERE ID_KHACHHANG = :id
                )
            ");
            $stmt->execute([':id' => $id]);

            // 4️⃣ Xóa chứng từ bán
            $stmt = $this->conn->prepare("
                DELETE FROM CHUNG_TU_BAN WHERE ID_KHACHHANG = :id
            ");
            $stmt->execute([':id' => $id]);

            // 5️⃣ Xóa khách hàng
            $stmt = $this->conn->prepare("
                DELETE FROM KHACH_HANG WHERE ID_KHACH_HANG = :id
            ");
            $stmt->execute([':id' => $id]);

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            throw new Exception("Xóa khách hàng thất bại: " . $e->getMessage());
        }
    }

    // ============================================================
    // ======================== CHECK ADMIN ========================
    // ============================================================

    /**
     * Kiểm tra khách hàng có phải admin không
     */
    public function isAdmin($idKH)
    {

        $stmt = $this->conn->prepare("
            SELECT TEN_KH, SOB 
            FROM KHACH_HANG 
            WHERE ID_KHACH_HANG = :id
        ");

        $stmt->execute(['id' => $idKH]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row)
            return false;

        // admin nếu SOB='admin' hoặc username = 'admin'
        return (
            (isset($row['SOB']) && strtolower($row['SOB']) === 'admin')
            ||
            (isset($row['TEN_KH']) && strtolower($row['TEN_KH']) === 'admin')
        );
    }

    /**
     * Kiểm tra khách hàng có đạt chuẩn VIP không
     * Điều kiện: Tổng tiền mua hàng > 30 triệu trong 30 ngày gần nhất
     */
    public function checkVip($idKH, $limit = 30000000, $days = 30)
    {
        $sql = "SELECT SUM(TONGCONG) as total_spent 
                FROM CHUNG_TU_BAN 
                WHERE ID_KHACHHANG = :id 
                AND TRANGTHAI = 'Đã Giao Hàng'
                AND NGAYDATHANG >= DATE_SUB(NOW(), INTERVAL :days DAY)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $idKH, PDO::PARAM_INT);
        $stmt->bindParam(':days', $days, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalSpent = $row['total_spent'] ?? 0;

        return $totalSpent > $limit;
    }
}
