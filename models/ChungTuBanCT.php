<?php
class ChungTuBanCT {
    private $conn;
    private $table = "CHUNG_TU_BAN_CT";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY ID_CTBAN DESC, ID_CT ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getByChungTu($idCtb) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_CTBAN=?");
        $stmt->execute([$idCtb]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteByChungTu($idCtb) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_CTBAN=?");
        $stmt->execute([$idCtb]);
    }
}
