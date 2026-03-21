<?php

/**
 * Model quản lý bảng CHUNG_TU_MUA (chứng từ mua hàng)
 */
class ChungTuMua
{

    private $conn;
    private $table = 'CHUNG_TU_MUA';

    /**
     * Khởi tạo model và nhận kết nối DB
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy toàn bộ chứng từ mua (sắp xếp mới nhất)
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table 
                ORDER BY NGAYPHATSINH DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách chứng từ mua có phân trang
     */
    public function getPaging($limit, $offset)
    {

        $sql = "SELECT * FROM $this->table 
                ORDER BY NGAYPHATSINH DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit',  (int)$limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số bản ghi
     */
    public function countAll()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    /**
     * Lấy 1 chứng từ theo ID
     */
    public function getById($id)
    {

        $sql = "SELECT * FROM $this->table WHERE ID_CTMUA = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo chứng từ mua mới
     * Trả về ID vừa được tạo
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (MASOCT, NGAYPHATSINH, ID_KHACHHANG, TONGTIENHANG, THUE)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['MASOCT'],
            $data['NGAYPHATSINH'],
            $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'],
            $data['THUE']
        ]);

        return $this->conn->lastInsertId();
    }

    /**
     * Cập nhật chứng từ mua
     */
    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET MASOCT=?, NGAYPHATSINH=?, ID_KHACHHANG=?, 
                    TONGTIENHANG=?, THUE=?
                WHERE ID_CTMUA=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['MASOCT'],
            $data['NGAYPHATSINH'],
            $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'],
            $data['THUE'],
            $id
        ]);
    }

    /**
     * Xóa chứng từ mua:
     * - Xóa chi tiết trước
     * - Sau đó xóa chứng từ
     */
    public function delete($id)
    {

        // Xóa chi tiết trước
        require_once 'ChungTuMuaCT.php';

        $ctCT = new ChungTuMuaCT($this->conn);
        $ctCT->deleteByChungTu($id);

        // Xóa chứng từ
        $sql = "DELETE FROM $this->table WHERE ID_CTMUA = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }

    /**
     * Lấy danh sách chứng từ mua theo ID Khách hàng (sắp xếp mới nhất)
     */
    public function getByCustomerId($customerId)
    {
        // Truy vấn SQL: Lấy tất cả bản ghi từ bảng CHUNG_TU_MUA 
        // có ID_KHACHHANG trùng với $customerId, sắp xếp theo ngày phát sinh mới nhất.
        $sql = "SELECT * FROM $this->table 
                WHERE ID_KHACHHANG = ? 
                ORDER BY NGAYPHATSINH DESC";

        $stmt = $this->conn->prepare($sql);
        // Thực thi truy vấn với ID khách hàng
        $stmt->execute([$customerId]);

        // Trả về tất cả các bản ghi tìm được dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCustomerIdPaging($limit, $offset, $customerId)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE ID_KHACHHANG = :customerId 
                ORDER BY NGAYPHATSINH DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':customerId', (int) $customerId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countByCustomerId($customerId)
    {
        $sql = "SELECT COUNT(*) FROM $this->table WHERE ID_KHACHHANG = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$customerId]);
        return $stmt->fetchColumn();
    }
}
