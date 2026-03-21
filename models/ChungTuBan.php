<?php
require_once __DIR__ . '/ChungTuBanCT.php';

/**
 * Model quản lý bảng CHUNG_TU_BAN (đơn hàng bán)
 */
class ChungTuBan
{

    private $conn;
    private $table = "CHUNG_TU_BAN";

    /**
     * Nhận kết nối database khi khởi tạo
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Trả về connection cho các model khác sử dụng
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Lấy toàn bộ chứng từ bán (sắp xếp mới nhất)
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table ORDER BY NGAYDATHANG DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách có phân trang
     */
    public function getPaging($limit, $offset)
    {

        $sql = "SELECT * FROM $this->table 
                ORDER BY NGAYDATHANG DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm toàn bộ record
     */
    public function countAll()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    /**
     * Lấy 1 chứng từ bán theo ID
     */
    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE ID_CTBAN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tất cả đơn hàng của 1 user (client)
     */
    public function getByUserId($userId)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE ID_KHACHHANG = ? 
                ORDER BY NGAYDATHANG DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserIdPaging($limit, $offset, $userId)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE ID_KHACHHANG = :userId 
                ORDER BY NGAYDATHANG DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':userId', (int) $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByUserId($userId)
    {
        $sql = "SELECT COUNT(*) FROM $this->table WHERE ID_KHACHHANG = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    /**
     * Tạo chứng từ bán mới
     * Trả về ID vừa tạo
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (MASOCT, NGAYDATHANG, ID_KHACHHANG, TONGTIENHANG, THUE, TRANGTHAI)
                VALUES 
                (:MASOCT, :NGAYDATHANG, :ID_KHACHHANG, :TONGTIENHANG, :THUE, :TRANGTHAI)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            'MASOCT' => $data['MASOCT'],
            'NGAYDATHANG' => $data['NGAYDATHANG'],
            'ID_KHACHHANG' => $data['ID_KHACHHANG'],
            'TONGTIENHANG' => $data['TONGTIENHANG'],
            'THUE' => $data['THUE'],
            'TRANGTHAI' => $data['TRANGTHAI'] ?? 'Đang xử lý' // mặc định
        ]);

        return $this->conn->lastInsertId();
    }

    /**
     * Cập nhật chứng từ bán
     */
    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET MASOCT=?, NGAYDATHANG=?, ID_KHACHHANG=?, 
                    TONGTIENHANG=?, THUE=?, TRANGTHAI=?, GHICHU=?
                WHERE ID_CTBAN=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['MASOCT'],
            $data['NGAYDATHANG'],
            $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'],
            $data['THUE'],
            $data['TRANGTHAI'],
            $data['GHICHU'],
            $id
        ]);
    }

    /**
     * Xóa chứng từ bán
     * - Xóa chi tiết bán trước
     * - Sau đó xóa chứng từ
     */
    public function delete($id)
    {

        // Xóa chi tiết trước
        $ctbct = new ChungTuBanCT($this->conn);
        $ctbct->deleteByChungTu($id);

        // Xóa chứng từ
        $sql = "DELETE FROM $this->table WHERE ID_CTBAN=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }

    public function getAllWithCustomerSortedByName()
    {
        $sql = "SELECT ctb.*, kh.TEN_KH
                FROM CHUNG_TU_BAN ctb
                JOIN KHACH_HANG kh ON kh.ID_KHACH_HANG = ctb.ID_KHACHHANG
                ORDER BY kh.TEN_KH ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchByName($q)
    {
        $q = "%$q%";

        $sql = "SELECT ctb.*, kh.TEN_KH
                FROM CHUNG_TU_BAN ctb
                JOIN KHACH_HANG kh ON kh.ID_KHACH_HANG = ctb.ID_KHACHHANG
                WHERE kh.TEN_KH LIKE :q
                ORDER BY kh.TEN_KH ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['q' => $q]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy doanh thu theo ngày trong tháng (cho biểu đồ)
     */
    public function getRevenueByDay($month, $year)
    {
        $sql = "SELECT DAY(NGAYDATHANG) as day, SUM(TONGCONG) as revenue
                FROM $this->table
                WHERE MONTH(NGAYDATHANG) = :month 
                  AND YEAR(NGAYDATHANG) = :year
                  AND (TRANGTHAI = 'Đã Giao Hàng' OR TRANGTHAI = 'Đang xử lý')
                GROUP BY DAY(NGAYDATHANG)
                ORDER BY day ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
