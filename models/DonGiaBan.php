<?php

/**
 * Model quản lý bảng ĐƠN GIÁ BÁN (DON_GIA_BAN)
 * Dùng để lưu giá bán áp dụng theo từng thời điểm cho từng hàng hóa
 */
class DonGiaBan
{

    private $conn;
    private $table = "DON_GIA_BAN";

    /**
     * Nhận kết nối CSDL khi khởi tạo model
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy toàn bộ đơn giá bán
     * JOIN với bảng HANG_HOA để hiển thị tên sản phẩm
     */
    public function getAll()
    {

        $sql = "SELECT d.*, h.TENHANGHOA
                FROM $this->table d
                LEFT JOIN HANG_HOA h ON d.ID_HANGHOA = h.ID_HANGHOA
                ORDER BY d.NGAYBATDAU DESC";

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách đơn giá bán theo phân trang
     */
    public function getPaging($limit, $offset)
    {

        $sql = "SELECT d.*, h.TENHANGHOA
                FROM $this->table d
                LEFT JOIN HANG_HOA h ON d.ID_HANGHOA = h.ID_HANGHOA
                ORDER BY d.NGAYBATDAU DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số dòng của bảng
     */
    public function countAll()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    /**
     * Tìm kiếm đơn giá theo tên hàng hóa với phân trang
     */
    public function searchPaging($limit, $offset, $searchQuery = '')
    {

        $sql = "SELECT d.*, h.TENHANGHOA
                FROM $this->table d
                LEFT JOIN HANG_HOA h ON d.ID_HANGHOA = h.ID_HANGHOA
                WHERE h.TENHANGHOA LIKE :search
                ORDER BY d.NGAYBATDAU DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm số dòng khi tìm kiếm
     */
    public function countSearch($searchQuery = '')
    {

        $sql = "SELECT COUNT(*) FROM $this->table d
                LEFT JOIN HANG_HOA h ON d.ID_HANGHOA = h.ID_HANGHOA
                WHERE h.TENHANGHOA LIKE :search";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':search', '%' . $searchQuery . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * Lấy đơn giá theo ID
     */
    public function getById($id)
    {

        $sql = "SELECT * FROM $this->table WHERE ID_DONGIA = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo mới một dòng đơn giá bán
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (GIATRI, NGAYBATDAU, APDUNG, ID_HANGHOA)
                VALUES 
                (:giatri, :ngaybatdau, :apdung, :idhanghoa)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':giatri'      => $data['GIATRI'],
            ':ngaybatdau'  => $data['NGAYBATDAU'],
            ':apdung'      => $data['APDUNG'] ?? 1,  // mặc định áp dụng
            ':idhanghoa'   => $data['ID_HANGHOA']
        ]);
    }

    /**
     * Cập nhật đơn giá bán
     */
    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET GIATRI = :giatri,
                    NGAYBATDAU = :ngaybatdau,
                    APDUNG = :apdung,
                    ID_HANGHOA = :idhanghoa
                WHERE ID_DONGIA = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':giatri'     => $data['GIATRI'],
            ':ngaybatdau' => $data['NGAYBATDAU'],
            ':apdung'     => $data['APDUNG'] ?? 1,
            ':idhanghoa'  => $data['ID_HANGHOA'],
            ':id'         => $id
        ]);
    }

    /**
     * Xóa đơn giá bán theo ID
     */
    public function delete($id)
    {

        $sql = "DELETE FROM $this->table WHERE ID_DONGIA = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }
}
