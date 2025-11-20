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

    public function getPagingClient(
        $limit, $offset,
        $id_phanloai = null,
        $feature = null,
        $minPrice = null,
        $maxPrice = null,
        $q = null,
        $sortPrice = null
    ) {
        $params = [];

        $sql = "
            SELECT 
                h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH,
                p.TENPHANLOAI,
                d.GIATRI AS DONGIA
            FROM HANG_HOA h
            LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
            LEFT JOIN DON_GIA_BAN d 
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
        ";

        // WHERE
        $where = [];

        if ($id_phanloai !== null) {
            $where[] = "h.ID_PHANLOAI = :id_phanloai";
            $params[':id_phanloai'] = $id_phanloai;
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $where[] = "d.GIATRI BETWEEN :minPrice AND :maxPrice";
            $params[':minPrice'] = $minPrice;
            $params[':maxPrice'] = $maxPrice;
        }

        if (!empty($q)) {
            $where[] = "(h.TENHANGHOA LIKE :q OR h.MOTA LIKE :q)";
            $params[':q'] = '%' . $q . '%';
        }

        if ($where) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        // ORDER
        if ($sortPrice === 'price_asc') {
            $order = "d.GIATRI ASC";
        } elseif ($sortPrice === 'price_desc') {
            $order = "d.GIATRI DESC";
        } elseif ($feature === 'promo') {
            $order = "d.GIATRI ASC";
        } else {
            $order = "h.ID_HANGHOA DESC";
        }

        $sql .= " ORDER BY $order LIMIT :limit OFFSET :offset";

        // BIND
        $stmt = $this->conn->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, ($k === ':q') ? PDO::PARAM_STR : PDO::PARAM_INT);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function countAllClient($id_phanloai = null, $minPrice = null, $maxPrice = null, $q = null) {
        $params = [];
        $sql = "SELECT COUNT(*) FROM " . $this->table . " h
                LEFT JOIN DON_GIA_BAN d ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1";

        $where = [];
        if ($id_phanloai !== null) {
            $where[] = "h.ID_PHANLOAI = :id_phanloai";
            $params[':id_phanloai'] = (int)$id_phanloai;
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $where[] = "d.GIATRI BETWEEN :minPrice AND :maxPrice";
            $params[':minPrice'] = (int)$minPrice;
            $params[':maxPrice'] = (int)$maxPrice;
        }

        if (!empty($q)) {
            $where[] = "(h.TENHANGHOA LIKE :q OR h.MOTA LIKE :q)";
            $params[':q'] = '%' . $q . '%';
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(' AND ', $where);
        }

        $stmt = $this->conn->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, ($k === ':q') ? PDO::PARAM_STR : PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
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
