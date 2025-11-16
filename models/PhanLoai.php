<?php
class PhanLoai {
    private $conn;
    private $table = "PHAN_LOAI";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaging($limit, $offset) {
        $stmt = $this->conn->prepare("
            SELECT * FROM $this->table
            ORDER BY ID_PHANLOAI DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    public function getAllWithCount() {
        $stmt = $this->conn->query("
            SELECT p.*, COUNT(h.ID_HANGHOA) AS total_products
            FROM PHAN_LOAI p
            LEFT JOIN HANG_HOA h ON p.ID_PHANLOAI = h.ID_PHANLOAI
            GROUP BY p.ID_PHANLOAI
            ORDER BY p.ID_PHANLOAI DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_PHANLOAI = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (TENPHANLOAI, MOTA, HINHANH) 
                                      VALUES (:ten, :mota, :hinhanh)");
        return $stmt->execute([
            ':ten' => $data['TENPHANLOAI'],
            ':mota' => $data['MOTA'],
            ':hinhanh' => $data['HINHANH'] ?? null
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table 
                                      SET TENPHANLOAI=:ten, MOTA=:mota, HINHANH=:hinhanh 
                                      WHERE ID_PHANLOAI=:id");
        return $stmt->execute([
            ':ten' => $data['TENPHANLOAI'],
            ':mota' => $data['MOTA'],
            ':hinhanh' => $data['HINHANH'] ?? null,
            ':id' => $id
        ]);
    }

    public function delete($id) {
        // Nếu có HANG_HOA FK với PHAN_LOAI, nên xóa hoặc chuyển sang null
        // Tạm thời thử xóa trực tiếp
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_PHANLOAI=:id");
        return $stmt->execute([':id'=>$id]);
    }
}
