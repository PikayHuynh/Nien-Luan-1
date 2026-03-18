<?php

/**
 * Model quản lý bảng CHUNG_TU_MUA_CT (chi tiết chứng từ mua)
 */
class ChungTuMuaCT
{

    private $conn;
    private $table = 'CHUNG_TU_MUA_CT';

    /**
     * Nhận kết nối database khi khởi tạo
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Lấy toàn bộ chi tiết chứng từ mua
     * Sắp xếp theo ID_CTMUA giảm dần, sau đó ID_CT tăng dần
     */
    public function getAll()
    {
        $sql = "SELECT * FROM $this->table 
                ORDER BY ID_CTMUA DESC, ID_CT ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy chi tiết theo ID chứng từ mua
     */
    public function getByChungTu($idCTMua)
    {

        $sql = "SELECT * FROM $this->table 
                WHERE ID_CTMUA = ? 
                ORDER BY ID_CT ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCTMua]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Tạo mới chi tiết chứng từ mua
     * GIAMUA * SOLUONG → THANHTIEN (do DB tự sinh)
     */
    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (ID_CTMUA, ID_HANGHOA, GIAMUA, SOLUONG)
                VALUES 
                (:ID_CTMUA, :ID_HANGHOA, :GIAMUA, :SOLUONG)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'ID_CTMUA'   => $data['ID_CTMUA'],
            'ID_HANGHOA' => $data['ID_HANGHOA'],
            'GIAMUA'     => $data['GIAMUA'],
            'SOLUONG'    => $data['SOLUONG']
        ]);
    }

    /**
     * Cập nhật 1 dòng chi tiết
     */
    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET ID_HANGHOA=?, SOLUONG=?, DONGIA=? 
                WHERE ID_CT=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $data['ID_HANGHOA'],
            $data['SOLUONG'],
            $data['DONGIA'],
            $id
        ]);
    }

    /**
     * Xóa 1 dòng chi tiết
     */
    public function delete($id)
    {

        $sql = "DELETE FROM $this->table WHERE ID_CT=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }

    /**
     * Xóa toàn bộ chi tiết của 1 chứng từ mua
     * → dùng khi xóa chứng từ hoặc reset chi tiết
     */
    public function deleteByChungTu($idCTMua)
    {

        $sql = "DELETE FROM $this->table WHERE ID_CTMUA = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idCTMua]);
    }
}
