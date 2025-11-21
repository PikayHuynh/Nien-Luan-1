<?php
class ChungTuMuaCT {
    private $conn;
    private $table = 'chung_tu_mua_ct';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table ORDER BY ID_CTMUA DESC, ID_CT ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCTMua($idCTMua) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE ID_CTMUA = ? ORDER BY ID_CT ASC");
        $stmt->execute([$idCTMua]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        // $stmt = $this->conn->prepare("INSERT INTO $this->table (ID_CTMUA, ID_HANGHOA, SOLUONG, DONGIA) VALUES (?, ?, ?, ?)");
        // $stmt->execute([
        //     $data['ID_CTMUA'],
        //     $data['ID_HANGHOA'],
        //     $data['SOLUONG'],
        //     $data['DONGIA']
        // ]);
        // return $this->conn->lastInsertId();
        $stmt = $this->conn->prepare(
            "INSERT INTO $this->table (ID_CTMUA, ID_HANGHOA, GIAMUA, SOLUONG)
            VALUES (:ID_CTMUA, :ID_HANGHOA, :GIAMUA, :SOLUONG)"
        );

        return $stmt->execute([
            'ID_CTMUA'   => $data['ID_CTMUA'],
            'ID_HANGHOA' => $data['ID_HANGHOA'],
            'GIAMUA'     => $data['GIAMUA'],
            'SOLUONG'    => $data['SOLUONG']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET ID_HANGHOA=?, SOLUONG=?, DONGIA=? WHERE ID_CT=?");
        $stmt->execute([
            $data['ID_HANGHOA'],
            $data['SOLUONG'],
            $data['DONGIA'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_CT = ?");
        $stmt->execute([$id]);
    }

    public function deleteByChungTu($idCTMua) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE ID_CTMUA = ?");
        $stmt->execute([$idCTMua]);
    }
}
