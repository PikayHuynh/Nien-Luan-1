<?php
class HangHoa {
    private $conn;
    private $table = "HANG_HOA";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPagingClient($limit, $offset, $id_phanloai = null) {
    $sql = "
        SELECT 
            h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH,
            p.TENPHANLOAI,
            d.GIATRI AS DONGIA
        FROM " . $this->table . " h
        LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
        LEFT JOIN DON_GIA_BAN d 
            ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
    ";

    // Thêm điều kiện lọc
    if ($id_phanloai !== null) {
        $sql .= " WHERE h.ID_PHANLOAI = :id_phanloai";
    }

    $sql .= " 
        ORDER BY h.ID_HANGHOA DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    if ($id_phanloai !== null) {
        $stmt->bindValue(':id_phanloai', (int)$id_phanloai, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function countAllClient($id_phanloai = null) {
    $sql = "SELECT COUNT(*) FROM " . $this->table;

    if ($id_phanloai !== null) {
        $sql .= " WHERE ID_PHANLOAI = :id_phanloai";
    }

    $stmt = $this->conn->prepare($sql);

    if ($id_phanloai !== null) {
        $stmt->bindValue(':id_phanloai', (int)$id_phanloai, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchColumn();
}

    public function getAllClient() {
        // $stmt = $this->conn->prepare("
        //     SELECT 
        //         h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH,
        //         h.ID_PHANLOAI, p.TENPHANLOAI,
        //         d.GIATRI AS DONGIA
        //     FROM $this->table h
        //     LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
        //     LEFT JOIN DON_GIA_BAN d 
        //         ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
        //     ORDER BY h.ID_HANGHOA DESC
        // ");
        // $stmt->execute();
        // return $stmt->fetchAll(PDO::FETCH_ASSOC);

        
    }

    public function getPaging($limit, $offset) {
        $stmt = $this->conn->prepare("
            SELECT 
                h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH,
                p.TENPHANLOAI,
                d.GIATRI AS DONGIA
            FROM $this->table h
            LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
            LEFT JOIN DON_GIA_BAN d 
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
            ORDER BY h.ID_HANGHOA DESC
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM $this->table");
        return $stmt->fetchColumn();
    }

    // Lấy chi tiết 1 sản phẩm
    public function getByIdClient($id) {
        $stmt = $this->conn->prepare("
            SELECT
                h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH,
                h.ID_PHANLOAI, p.TENPHANLOAI,
                d.GIATRI AS DONGIA
            FROM $this->table h
            LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
            LEFT JOIN DON_GIA_BAN d
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
            WHERE h.ID_HANGHOA = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_HANGHOA = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (TENHANGHOA, MOTA, DONVITINH, HINHANH, ID_PHANLOAI)
                                      VALUES (:ten, :mota, :dvt, :hinhanh, :id_phanloai)");
        return $stmt->execute([
            ':ten' => $data['TENHANGHOA'],
            ':mota' => $data['MOTA'],
            ':dvt' => $data['DONVITINH'],
            ':hinhanh' => $data['HINHANH'],
            ':id_phanloai' => $data['ID_PHANLOAI']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET TENHANGHOA=:ten, MOTA=:mota, DONVITINH=:dvt,
                                      HINHANH=:hinhanh, ID_PHANLOAI=:id_phanloai WHERE ID_HANGHOA=:id");
        return $stmt->execute([
            ':ten' => $data['TENHANGHOA'],
            ':mota' => $data['MOTA'],
            ':dvt' => $data['DONVITINH'],
            ':hinhanh' => $data['HINHANH'],
            ':id_phanloai' => $data['ID_PHANLOAI'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        // TODO: Xóa các bảng liên quan nếu có FK
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_HANGHOA=:id");
        return $stmt->execute([':id'=>$id]);
    }
}
