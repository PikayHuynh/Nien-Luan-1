<?php

/**
 * Model quản lý bảng HANG_HOA (sản phẩm)
 */
class HangHoa
{

    private $conn;
    private $table = "HANG_HOA";

    /**
     * Nhận kết nối database khi khởi tạo model
     */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // =====================================================
    // =============== 1. PHẦN ADMIN – GET ALL ==============
    // =====================================================

    /**
     * Lấy toàn bộ sản phẩm (admin)
     */
    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM $this->table");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy danh sách sản phẩm theo phân trang (admin)
     * Kèm thông tin phân loại + giá áp dụng
     */
    public function getPaging($limit, $offset)
    {

        $sql = "
            SELECT 
                h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH, h.NGAYTAO, h.GIAGOC, h.SOLUONG,
                p.TENPHANLOAI,
                d.GIATRI AS DONGIA,
                (SELECT SUM(ct.SOLUONG) 
                 FROM CHUNG_TU_BAN_CT ct 
                 JOIN CHUNG_TU_BAN b ON ct.ID_CTBAN = b.ID_CTBAN 
                 WHERE ct.ID_HANGHOA = h.ID_HANGHOA 
                 AND b.NGAYDATHANG >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                ) as SOLD_COUNT
            FROM $this->table h
            LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
            LEFT JOIN DON_GIA_BAN d 
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
            ORDER BY h.ID_HANGHOA DESC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm tổng số sản phẩm
     */
    public function countAll()
    {
        return $this->conn->query("SELECT COUNT(*) FROM $this->table")->fetchColumn();
    }

    // =====================================================
    // ========== 2. PHẦN CLIENT – GET LIST FILTER ==========
    // =====================================================

    /**
     * Lấy danh sách sản phẩm cho client với:
     * - lọc phân loại
     * - lọc giá
     * - tìm kiếm
     * - sắp xếp giá
     * - phân trang
     */
    public function getPagingClient(
        $limit,
        $offset,
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
                h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH, h.NGAYTAO, h.GIAGOC, h.SOLUONG,
                p.TENPHANLOAI,
                d.GIATRI AS DONGIA,
                (SELECT SUM(ct.SOLUONG) 
                 FROM CHUNG_TU_BAN_CT ct 
                 JOIN CHUNG_TU_BAN b ON ct.ID_CTBAN = b.ID_CTBAN 
                 WHERE ct.ID_HANGHOA = h.ID_HANGHOA 
                 AND b.NGAYDATHANG >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                ) as SOLD_COUNT
            FROM HANG_HOA h
            LEFT JOIN PHAN_LOAI p 
                ON h.ID_PHANLOAI = p.ID_PHANLOAI
            LEFT JOIN DON_GIA_BAN d 
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
        ";

        // ------------------ WHERE ------------------
        $where = [];

        if ($id_phanloai !== null) {
            $where[] = "h.ID_PHANLOAI = :id_phanloai";
            $params[':id_phanloai'] = (int) $id_phanloai;
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $where[] = "d.GIATRI BETWEEN :minPrice AND :maxPrice";
            $params[':minPrice'] = (int) $minPrice;
            $params[':maxPrice'] = (int) $maxPrice;
        }

        if (!empty($q)) {
            $where[] = "(h.TENHANGHOA LIKE :q OR h.MOTA LIKE :q)";
            $params[':q'] = "%$q%";
        }

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        // ------------------ ORDER ------------------
        if ($sortPrice === 'price_asc') {
            $order = "d.GIATRI ASC";
        } elseif ($sortPrice === 'price_desc') {
            $order = "d.GIATRI DESC";
        } elseif ($feature === 'promo') {
            $order = "d.GIATRI ASC";
        } else {
            $order = "h.ID_HANGHOA DESC"; // mặc định lấy mới nhất
        }

        $sql .= " ORDER BY $order LIMIT :limit OFFSET :offset";

        // ------------------ EXECUTE ------------------
        $stmt = $this->conn->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, ($k === ':q') ? PDO::PARAM_STR : PDO::PARAM_INT);
        }

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Đếm số sản phẩm (client) sau khi lọc
     */
    public function countAllClient($id_phanloai = null, $minPrice = null, $maxPrice = null, $q = null)
    {

        $params = [];

        $sql = "
            SELECT COUNT(*) 
            FROM HANG_HOA h
            LEFT JOIN DON_GIA_BAN d 
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
        ";

        $where = [];

        if ($id_phanloai !== null) {
            $where[] = "h.ID_PHANLOAI = :id_phanloai";
            $params[':id_phanloai'] = (int) $id_phanloai;
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $where[] = "d.GIATRI BETWEEN :minPrice AND :maxPrice";
            $params[':minPrice'] = (int) $minPrice;
            $params[':maxPrice'] = (int) $maxPrice;
        }

        if (!empty($q)) {
            $where[] = "(h.TENHANGHOA LIKE :q OR h.MOTA LIKE :q)";
            $params[':q'] = "%$q%";
        }

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, ($k === ':q' ? PDO::PARAM_STR : PDO::PARAM_INT));
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //
    // 3. PHẦN CLIENT – DETAIL
    //

    /**
     * Lấy chi tiết sản phẩm cho client
     */
    public function getByIdClient($id)
    {

        $sql = "
            SELECT
                h.ID_HANGHOA, h.TENHANGHOA, h.MOTA, h.DONVITINH, h.HINHANH, h.NGAYTAO, h.GIAGOC, h.SOLUONG,
                h.ID_PHANLOAI, p.TENPHANLOAI,
                d.GIATRI AS DONGIA,
                (SELECT SUM(ct.SOLUONG) 
                 FROM CHUNG_TU_BAN_CT ct 
                 JOIN CHUNG_TU_BAN b ON ct.ID_CTBAN = b.ID_CTBAN 
                 WHERE ct.ID_HANGHOA = h.ID_HANGHOA 
                 AND b.NGAYDATHANG >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                ) as SOLD_COUNT
            FROM $this->table h
            LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
            LEFT JOIN DON_GIA_BAN d 
                ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
            WHERE h.ID_HANGHOA = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateQuantity($id_hanghoa, $qty_change) {
        $sql = "UPDATE $this->table SET SOLUONG = SOLUONG + :qty WHERE ID_HANGHOA = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':qty' => $qty_change, ':id' => $id_hanghoa]);
    }

    public function getHotProducts($limit = 8) {
        $sql = "SELECT h.*, p.TENPHANLOAI, d.GIATRI AS DONGIA,
                (SELECT SUM(ct.SOLUONG) FROM CHUNG_TU_BAN_CT ct JOIN CHUNG_TU_BAN b ON ct.ID_CTBAN = b.ID_CTBAN WHERE ct.ID_HANGHOA = h.ID_HANGHOA AND b.NGAYDATHANG >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as SOLD_COUNT
                FROM $this->table h
                LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
                LEFT JOIN DON_GIA_BAN d ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
                HAVING SOLD_COUNT >= 5
                ORDER BY SOLD_COUNT DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewProducts($limit = 8) {
        $sql = "SELECT h.*, p.TENPHANLOAI, d.GIATRI AS DONGIA,
                (SELECT SUM(ct.SOLUONG) FROM CHUNG_TU_BAN_CT ct JOIN CHUNG_TU_BAN b ON ct.ID_CTBAN = b.ID_CTBAN WHERE ct.ID_HANGHOA = h.ID_HANGHOA) as SOLD_COUNT
                FROM $this->table h
                LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
                LEFT JOIN DON_GIA_BAN d ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
                WHERE h.NGAYTAO >= DATE_SUB(NOW(), INTERVAL 14 DAY)
                ORDER BY h.NGAYTAO DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaleProducts($limit = 8) {
        $sql = "SELECT h.*, p.TENPHANLOAI, d.GIATRI AS DONGIA,
                (SELECT SUM(ct.SOLUONG) FROM CHUNG_TU_BAN_CT ct JOIN CHUNG_TU_BAN b ON ct.ID_CTBAN = b.ID_CTBAN WHERE ct.ID_HANGHOA = h.ID_HANGHOA) as SOLD_COUNT
                FROM $this->table h
                LEFT JOIN PHAN_LOAI p ON h.ID_PHANLOAI = p.ID_PHANLOAI
                LEFT JOIN DON_GIA_BAN d ON h.ID_HANGHOA = d.ID_HANGHOA AND d.APDUNG = 1
                WHERE h.GIAGOC > d.GIATRI AND h.GIAGOC > 0
                ORDER BY h.ID_HANGHOA DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // =====================================================
    // =============== 4. CRUD CHO ADMIN ====================
    // =====================================================

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_HANGHOA = :id");
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {

        $sql = "INSERT INTO $this->table 
                (TENHANGHOA, MOTA, DONVITINH, HINHANH, ID_PHANLOAI, GIAGOC, NGAYTAO)
                VALUES (:ten, :mota, :dvt, :hinhanh, :id_phanloai, :giagoc, :ngaytao)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ten' => $data['TENHANGHOA'],
            ':mota' => $data['MOTA'],
            ':dvt' => $data['DONVITINH'],
            ':hinhanh' => $data['HINHANH'],
            ':id_phanloai' => $data['ID_PHANLOAI'],
            ':giagoc' => $data['GIAGOC'] ?? 0,
            ':ngaytao' => $data['NGAYTAO'] ?? date('Y-m-d H:i:s')
        ]);
    }

    public function update($id, $data)
    {

        $sql = "UPDATE $this->table 
                SET TENHANGHOA = :ten,
                    MOTA = :mota,
                    DONVITINH = :dvt,
                    HINHANH = :hinhanh,
                    ID_PHANLOAI = :id_phanloai,
                    GIAGOC = :giagoc,
                    NGAYTAO = :ngaytao
                WHERE ID_HANGHOA = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ten' => $data['TENHANGHOA'],
            ':mota' => $data['MOTA'],
            ':dvt' => $data['DONVITINH'],
            ':hinhanh' => $data['HINHANH'],
            ':id_phanloai' => $data['ID_PHANLOAI'],
            ':giagoc' => $data['GIAGOC'] ?? 0,
            ':ngaytao' => $data['NGAYTAO'] ?? date('Y-m-d H:i:s'),
            ':id' => $id
        ]);
    }

    /**
     * Xóa sản phẩm
     * (Có thể mở rộng để xóa luôn bảng con nếu có FK)
     */
    public function delete($id)
    {
        $this->conn->beginTransaction();
        try {
            // 1. Xóa các bản ghi phụ thuộc (bảng con)
            $tables_to_delete = [
                'CHUNG_TU_BAN_CT',
                'CHUNG_TU_MUA_CT',
                'THUOC_TINH',
                'DON_GIA_BAN'
            ];

            foreach ($tables_to_delete as $table) {
                $sql_child = "DELETE FROM $table WHERE ID_HANGHOA = :id";
                $stmt_child = $this->conn->prepare($sql_child);
                $stmt_child->execute([':id' => $id]);
            }
            // 2. Xóa bản ghi cha (HANG_HOA)
            $sql_parent = "DELETE FROM $this->table WHERE ID_HANGHOA = :id";
            $stmt_parent = $this->conn->prepare($sql_parent);
            $result = $stmt_parent->execute([':id' => $id]);

            $this->conn->commit();
            return $result;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            // Ném lại hoặc ghi log lỗi
            throw $e;
        }
    }
}
