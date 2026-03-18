<?php

class Kho
{
    private $conn;
    private $table = "kho";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * @param int $id_hanghoa
     * @param int|null $id_ctmua
     * @param int|null $id_ctban
     * @param int $soluong (Số lượng thay đổi, dương cho nhập, âm cho xuất)
     * @param string $loai_chung_tu ('MUA' hoặc 'BAN')
     * @return bool
     */
    public function create($id_hanghoa, $id_ctmua, $id_ctban, $soluong, $loai_chung_tu)
    {
        $sql = "INSERT INTO $this->table (ID_HANGHOA, ID_CTMUA, ID_CTBAN, SOLUONG, LOAI_CHUNG_TU) 
                VALUES (:id_hanghoa, :id_ctmua, :id_ctban, :soluong, :loai_chung_tu)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':id_hanghoa' => $id_hanghoa,
            ':id_ctmua' => $id_ctmua,
            ':id_ctban' => $id_ctban,
            ':soluong' => $soluong,
            ':loai_chung_tu' => $loai_chung_tu
        ]);
    }

    public function deleteByCtMua($id_ctmua)
    {
        $sql = "DELETE FROM $this->table WHERE ID_CTMUA = :id_ctmua AND LOAI_CHUNG_TU = 'MUA'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_ctmua' => $id_ctmua]);
    }

    public function deleteByCtBan($id_ctban)
    {
        $sql = "DELETE FROM $this->table WHERE ID_CTBAN = :id_ctban AND LOAI_CHUNG_TU = 'BAN'";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id_ctban' => $id_ctban]);
    }

    public function countAll()
    {
        return $this->conn->query("SELECT COUNT(*) FROM $this->table")->fetchColumn();
    }

    public function getPaging($limit, $offset)
    {
        $sql = "
            SELECT k.*, h.TENHANGHOA
            FROM $this->table k
            LEFT JOIN hang_hoa h ON k.ID_HANGHOA = h.ID_HANGHOA
            ORDER BY k.NGAY_TAO DESC
            LIMIT :limit OFFSET :offset
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
