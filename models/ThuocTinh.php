<?php
class ThuocTinh {
    private $conn;
    private $table = "THUOC_TINH";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT t.*, h.TENHANGHOA
                                    FROM $this->table t
                                    LEFT JOIN HANG_HOA h ON t.ID_HANGHOA = h.ID_HANGHOA
                                    ORDER BY t.ID_THUOCTINH DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaging($limit, $offset) {
        // Corrected SQL query with LIMIT and OFFSET clauses
        $sql = "SELECT t.*, h.TENHANGHOA
                FROM $this->table t
                LEFT JOIN HANG_HOA h ON t.ID_HANGHOA = h.ID_HANGHOA
                ORDER BY t.ID_THUOCTINH DESC
                LIMIT :limit OFFSET :offset"; // <-- ADDED THIS LINE

        $stmt = $this->conn->prepare($sql);
        // Binding the parameters using PDO::PARAM_INT is correct for pagination
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
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_THUOCTINH = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (TEN, GIATRI, HINHANH, ID_HANGHOA) 
                                      VALUES (:ten, :giatri, :hinhanh, :idhanghoa)");
        return $stmt->execute([
            ':ten' => $data['TEN'],
            ':giatri' => $data['GIATRI'],
            ':hinhanh' => $data['HINHANH'] ?? null,
            ':idhanghoa' => $data['ID_HANGHOA']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table 
                                      SET TEN=:ten, GIATRI=:giatri, HINHANH=:hinhanh, ID_HANGHOA=:idhanghoa
                                      WHERE ID_THUOCTINH=:id");
        return $stmt->execute([
            ':ten' => $data['TEN'],
            ':giatri' => $data['GIATRI'],
            ':hinhanh' => $data['HINHANH'] ?? null,
            ':idhanghoa' => $data['ID_HANGHOA'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_THUOCTINH=:id");
        return $stmt->execute([':id' => $id]);
    }
}
