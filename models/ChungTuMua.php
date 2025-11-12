<?php
class ChungTuMua {
    private $conn;
    private $table = 'chung_tu_mua';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY NGAYPHATSINH DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_CTMUA = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (MASOCT, NGAYPHATSINH, ID_KHACHHANG, TONGTIENHANG, THUE) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['MASOCT'],
            $data['NGAYPHATSINH'],
            $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'],
            $data['THUE']
        ]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET MASOCT=?, NGAYPHATSINH=?, ID_KHACHHANG=?, TONGTIENHANG=?, THUE=? WHERE ID_CTMUA=?");
        $stmt->execute([
            $data['MASOCT'],
            $data['NGAYPHATSINH'],
            $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'],
            $data['THUE'],
            $id
        ]);
    }

    public function delete($id) {
        // Xóa chi tiết trước
        require_once 'ChungTuMuaCT.php';
        $ctCT = new ChungTuMuaCT($this->conn);
        $ctCT->deleteByChungTu($id);

        // Xóa chứng từ
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_CTMUA = ?");
        $stmt->execute([$id]);
    }
}
