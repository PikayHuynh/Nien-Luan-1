<?php

/**
 * Model quản lý bảng THONG_BAO
 */
class ThongBao
{
    private $conn;
    private $table = "THONG_BAO";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /**
     * Tạo thông báo mới
     */
    public function create($data)
    {
        $sql = "INSERT INTO $this->table (NOIDUNG, ID_NGUOINHAN, LOAI, NGAYTAO, IS_READ) 
                VALUES (:noidung, :id_nguoinhan, :loai, :ngaytao, 0)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':noidung' => $data['NOIDUNG'],
            ':id_nguoinhan' => $data['ID_NGUOINHAN'] ?? null, // null nếu gửi cho tất cả hoặc admin
            ':loai' => $data['LOAI'], // 'admin', 'client', 'all'
            ':ngaytao' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Lấy thông báo cho Admin
     */
    public function getForAdmin($limit = 10)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE LOAI = 'admin' 
                ORDER BY NGAYTAO DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông báo CHƯA ĐỌC cho Admin
     */
    public function getUnreadForAdmin($limit = 5)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE LOAI = 'admin' AND IS_READ = 0
                ORDER BY NGAYTAO DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPagingForAdmin($limit, $offset)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE LOAI = 'admin' 
                ORDER BY NGAYTAO DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllForAdmin()
    {
        $sql = "SELECT COUNT(*) FROM $this->table WHERE LOAI = 'admin'";
        return $this->conn->query($sql)->fetchColumn();
    }

    /**
     * Lấy thông báo cho Client cụ thể
     */
    public function getForClient($userId, $limit = 10)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE (LOAI = 'all' OR (LOAI = 'client' AND ID_NGUOINHAN = :userId))
                ORDER BY NGAYTAO DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy thông báo CHƯA ĐỌC cho Client
     */
    public function getUnreadForClient($userId, $limit = 5)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE (LOAI = 'all' OR (LOAI = 'client' AND ID_NGUOINHAN = :userId))
                AND IS_READ = 0
                ORDER BY NGAYTAO DESC LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPagingForClient($limit, $offset, $userId)
    {
        $sql = "SELECT * FROM $this->table 
                WHERE (LOAI = 'all' OR (LOAI = 'client' AND ID_NGUOINHAN = :userId))
                ORDER BY NGAYTAO DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllForClient($userId)
    {
        $sql = "SELECT COUNT(*) FROM $this->table 
                WHERE (LOAI = 'all' OR (LOAI = 'client' AND ID_NGUOINHAN = :userId))";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchColumn();
    }

    /**
     * Đếm thông báo chưa đọc
     */
    public function countUnread($userId = null, $loai = 'client')
    {
        if ($loai === 'admin') {
            $sql = "SELECT COUNT(*) FROM $this->table WHERE LOAI = 'admin' AND IS_READ = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
        } else {
            $sql = "SELECT COUNT(*) FROM $this->table 
                    WHERE (LOAI = 'all' OR (LOAI = 'client' AND ID_NGUOINHAN = :userId)) 
                    AND IS_READ = 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':userId' => $userId]);
        }
        return $stmt->fetchColumn();
    }

    /**
     * Đánh dấu đã đọc
     */
    public function markAsRead($id)
    {
        $sql = "UPDATE $this->table SET IS_READ = 1 WHERE ID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
