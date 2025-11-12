<?php
class DonGiaBan {
    private $conn;
    private $table = "DON_GIA_BAN";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT d.*, h.TENHANGHOA FROM $this->table d 
                                    LEFT JOIN HANG_HOA h ON d.ID_HANGHOA = h.ID_HANGHOA
                                    ORDER BY d.NGAYBATDAU DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_DONGIA = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (GIATRI, NGAYBATDAU, APDUNG, ID_HANGHOA) 
                                      VALUES (:giatri, :ngaybatdau, :apdung, :idhanghoa)");
        return $stmt->execute([
            ':giatri' => $data['GIATRI'],
            ':ngaybatdau' => $data['NGAYBATDAU'],
            ':apdung' => $data['APDUNG'] ?? 1,
            ':idhanghoa' => $data['ID_HANGHOA']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table 
                                      SET GIATRI=:giatri, NGAYBATDAU=:ngaybatdau, APDUNG=:apdung, ID_HANGHOA=:idhanghoa
                                      WHERE ID_DONGIA=:id");
        return $stmt->execute([
            ':giatri' => $data['GIATRI'],
            ':ngaybatdau' => $data['NGAYBATDAU'],
            ':apdung' => $data['APDUNG'] ?? 1,
            ':idhanghoa' => $data['ID_HANGHOA'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_DONGIA=:id");
        return $stmt->execute([':id' => $id]);
    }
}
