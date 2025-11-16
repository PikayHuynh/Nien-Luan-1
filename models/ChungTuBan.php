<?php
require_once __DIR__ . '/ChungTuBanCT.php';

class ChungTuBan {
    private $conn;
    private $table = "CHUNG_TU_BAN";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY NGAYDATHANG DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getPaging($limit, $offset) {
        $sql = "SELECT * FROM $this->table 
                ORDER BY NGAYDATHANG DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_CTBAN=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (MASOCT, NGAYDATHANG, ID_KHACHHANG, TONGTIENHANG, THUE, TRANGTHAI, GHICHU)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['MASOCT'], $data['NGAYDATHANG'], $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'], $data['THUE'], $data['TRANGTHAI'], $data['GHICHU']
        ]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET MASOCT=?, NGAYDATHANG=?, ID_KHACHHANG=?, TONGTIENHANG=?, THUE=?, TRANGTHAI=?, GHICHU=? WHERE ID_CTBAN=?");
        $stmt->execute([
            $data['MASOCT'], $data['NGAYDATHANG'], $data['ID_KHACHHANG'],
            $data['TONGTIENHANG'], $data['THUE'], $data['TRANGTHAI'], $data['GHICHU'], $id
        ]);
    }

    public function delete($id) {
        $ctbct = new ChungTuBanCT($this->conn);
        $ctbct->deleteByChungTu($id);

        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_CTBAN=?");
        $stmt->execute([$id]);
    }
}