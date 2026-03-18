<?php

/**
 * Model quản lý bảng PHAN_LOAI (danh mục sản phẩm)
 */
class PhanLoai
{

    private $conn;
    private $table = "PHAN_LOAI";

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
     * Lấy tất cả phân loại
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy phân trang phân loại (admin)
     */
    public function getPaging($limit, $offset)
    {

        $sql = "
            SELECT * FROM $this->table
            ORDER BY ID_PHANLOAI DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit',  (int)$limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số phân loại
     */
    public function countAll()
    {
        return $this->conn->query("SELECT COUNT(*) FROM $this->table")->fetchColumn();
    }

    /**
     * Lấy phân loại và số lượng sản phẩm thuộc từng loại
     */
    public function getAllWithCount()
    {

        $sql = "
            SELECT p.*, COUNT(h.ID_HANGHOA) AS total_products
            FROM PHAN_LOAI p
            LEFT JOIN HANG_HOA h ON p.ID_PHANLOAI = h.ID_PHANLOAI
            GROUP BY p.ID_PHANLOAI
            ORDER BY p.ID_PHANLOAI DESC
        ";

        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy phân loại theo ID
     */
    public function getById($id)
    {

        $stmt = $this->conn->prepare("
            SELECT * FROM $this->table 
            WHERE ID_PHANLOAI = :id
        ");

        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===========================================================
    // ======================== CREATE ============================
    // ===========================================================

    /**
     * Tạo mới phân loại
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (TENPHANLOAI, MOTA, HINHANH)
                VALUES (:ten, :mota, :hinhanh)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ten'      => $data['TENPHANLOAI'],
            ':mota'     => $data['MOTA'],
            ':hinhanh'  => $data['HINHANH'] ?? null
        ]);
    }

    // ===========================================================
    // ======================== UPDATE ============================
    // ===========================================================

    /**
     * Cập nhật phân loại
     */
    public function update($id, $data)
    {

        $sql = "
            UPDATE $this->table
            SET TENPHANLOAI = :ten,
                MOTA        = :mota,
                HINHANH     = :hinhanh
            WHERE ID_PHANLOAI = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ten'      => $data['TENPHANLOAI'],
            ':mota'     => $data['MOTA'],
            ':hinhanh'  => $data['HINHANH'] ?? null,
            ':id'       => $id
        ]);
    }

    // ===========================================================
    // ========================= DELETE ===========================
    // ===========================================================

    /**
     * Xóa phân loại
     * ⚠ Lưu ý: Nếu bảng HANG_HOA có FK thì phải xử lý trước
     */
    public function delete($id)
    {

        $sql = "DELETE FROM $this->table WHERE ID_PHANLOAI = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    public function hasHangHoa($id)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*) 
            FROM HANG_HOA 
            WHERE ID_PHANLOAI = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() > 0;
    }
}
