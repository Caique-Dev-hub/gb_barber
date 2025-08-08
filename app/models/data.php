<?php

class Data extends Database{
    public function getHorarios($data){
        $sql = "SELECT * FROM tbl_data_horario
        INNER JOIN tbl_data ON tbl_data_horario.id_data = tbl_data.id_data
        INNER JOIN tbl_horario ON tbl_data_horario.id_horario = tbl_horario.id_horario
        WHERE tbl_data_horario.id_data = :id_data AND status_data_horario = 'Disponivel'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_data' => (int)$data
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDatas(){
        $sql = "SELECT * FROM tbl_data WHERE status_data = 'Disponivel'";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}