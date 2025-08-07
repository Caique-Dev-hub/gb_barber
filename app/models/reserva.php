<?php

class Reserva extends Database{
    public function getReserva($id){
        $sql = "SELECT * FROM tbl_reserva WHERE id_reserva = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => (int)$id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}