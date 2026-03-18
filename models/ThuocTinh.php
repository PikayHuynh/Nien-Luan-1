<?php

/**
 * Model quản lý bảng THUOC_TINH (thuộc tính của sản phẩm)
 */
class ThuocTinh
{

    private $conn;
    private $table = "THUOC_TINH";

    /**
     * Nhận kết nối CSDL
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ===========================================================
    // ======================= GET DATA ===========================
    // ===========================================================

    /**
     * Lấy toàn bộ thuộc tính + tên hàng hóa
     */
    public function getAll()
    {

        $sql = "
            SELECT t.*, h.TENHANGHOA
            FROM $this->table t
            LEFT JOIN HANG_HOA h 
                    ON t.ID_HANGHOA = h.ID_HANGHOA
            ORDER BY t.ID_THUOCTINH DESC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy dữ liệu phân trang
     */
    public function getPaging($limit, $offset)
    {

        $sql = "
            SELECT t.*, h.TENHANGHOA
            FROM $this->table t
            LEFT JOIN HANG_HOA h 
                    ON t.ID_HANGHOA = h.ID_HANGHOA
            ORDER BY t.ID_THUOCTINH DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit',  (int)$limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số thuộc tính
     */
    public function countAll()
    {
        return $this->conn->query("SELECT COUNT(*) FROM $this->table")->fetchColumn();
    }

    /**
     * Lấy thuộc tính theo ID
     */
    public function getById($id)
    {

        $stmt = $this->conn->prepare("
            SELECT * FROM $this->table 
            WHERE ID_THUOCTINH = :id
        ");

        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===========================================================
    // ======================== CREATE ============================
    // ===========================================================

    /**
     * Tạo mới thuộc tính
     */
    public function create($data)
    {

        $sql = "
            INSERT INTO $this->table
            (TEN, GIATRI, HINHANH, ID_HANGHOA)
            VALUES (:ten, :giatri, :hinhanh, :idhanghoa)
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ten'       => $data['TEN'],
            ':giatri'    => $data['GIATRI'],
            ':hinhanh'   => $data['HINHANH'] ?? null,
            ':idhanghoa' => $data['ID_HANGHOA'],
        ]);
    }

    // ===========================================================
    // ======================== UPDATE ============================
    // ===========================================================

    /**
     * Cập nhật thuộc tính
     */
    public function update($id, $data)
    {

        $sql = "
            UPDATE $this->table
                SET TEN        = :ten,
                    GIATRI     = :giatri,
                    HINHANH    = :hinhanh,
                    ID_HANGHOA = :idhanghoa
            WHERE ID_THUOCTINH = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ten'       => $data['TEN'],
            ':giatri'    => $data['GIATRI'],
            ':hinhanh'   => $data['HINHANH'] ?? null,
            ':idhanghoa' => $data['ID_HANGHOA'],
            ':id'        => $id
        ]);
    }

    // ===========================================================
    // ========================= DELETE ===========================
    // ===========================================================

    /**
     * Xóa thuộc tính
     */
    public function delete($id)
    {

        $stmt = $this->conn->prepare("
            DELETE FROM $this->table 
            WHERE ID_THUOCTINH = :id
        ");

        return $stmt->execute([':id' => $id]);
    }
}
