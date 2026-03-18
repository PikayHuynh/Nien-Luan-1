<?php

/**
 * Model quản lý bảng CHUNG_TU_BAN_CT (chi tiết chứng từ bán)
 */
class ChungTuBanCT
{

    private $conn;
    private $table = "CHUNG_TU_BAN_CT";

    /**
     * Nhận kết nối database khi khởi tạo
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy toàn bộ chi tiết chứng từ bán
     * Sắp xếp theo ID_CTBAN (giảm dần), sau đó ID_CT (tăng dần)
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table 
                ORDER BY ID_CTBAN DESC, ID_CT ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách chi tiết theo ID chứng từ bán
     */
    public function getByChungTu($idCtb)
    {

        $sql = "SELECT * FROM $this->table WHERE ID_CTBAN = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCtb]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo mới 1 dòng chi tiết:
     * - KHÔNG insert THANHTIEN vì đây là cột sinh tự động (GIABAN * SOLUONG)
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (ID_CTBAN, ID_HANGHOA, GIABAN, SOLUONG)
                VALUES 
                (:ID_CTBAN, :ID_HANGHOA, :GIABAN, :SOLUONG)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'ID_CTBAN'   => $data['ID_CTBAN'],
            'ID_HANGHOA' => $data['ID_HANGHOA'],
            'GIABAN'     => $data['GIABAN'],
            'SOLUONG'    => $data['SOLUONG']
        ]);
    }

    /**
     * Xóa toàn bộ chi tiết thuộc 1 chứng từ bán
     * (Dung khi xóa hoặc cập nhật lại đơn hàng)
     */
    public function deleteByChungTu($idCtb)
    {

        $sql = "DELETE FROM $this->table WHERE ID_CTBAN = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCtb]);
    }
}
