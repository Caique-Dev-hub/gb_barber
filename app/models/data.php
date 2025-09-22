<?php

class Data extends Database
{

    // GET
    public function getHorarios(int $data)
    {
        $sql = "SELECT * FROM tbl_data_horario
        INNER JOIN tbl_data ON tbl_data_horario.id_data = tbl_data.id_data
        INNER JOIN tbl_horario ON tbl_data_horario.id_horario = tbl_horario.id_horario
        WHERE tbl_data_horario.id_data = :id_data AND status_data_horario = 'Disponivel'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_data' => $data
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDatas()
    {
        $sql = "SELECT * FROM tbl_data WHERE status_data = 'Disponivel'";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDataHorarioDetalhe(int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_data_horario
        INNER JOIN tbl_horario ON tbl_data_horario.id_horario = tbl_horario.id_horario
        WHERE tbl_data_horario.id_data_horario = :data_horario";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':data_horario' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getHorarioDetalhe(int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_horario WHERE id_horario = :horario";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':horario' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
