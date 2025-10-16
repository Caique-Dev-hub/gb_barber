<?php

class Reserva extends Database
{

    public function getReservas()
    {
        $sql = "SELECT * FROM tbl_reserva
        INNER JOIN tbl_data_horario ON tbl_data_horario.id_data_horario = tbl_reserva.id_data_horario
        INNER JOIN tbl_data ON tbl_data_horario.id_data = tbl_data.id_data
        INNER JOIN tbl_horario ON tbl_horario.id_horario = tbl_data_horario.id_horario
        ORDER BY tbl_data.nome_data ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountReservas()
    {
        $sql = "SELECT COUNT(*) AS total_reserva FROM tbl_reserva";

        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCombo($campos)
    {
        extract($campos);

        $sql = "INSERT INTO tbl_reserva (nome_reserva, email_reserva, whatsapp_reserva, id_combo, id_data_horario)
        VALUES (:nome, :email, :whatsapp, :combo, :data_horario)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => (string)$nome,
            ':email' => (string)$email,
            ':whatsapp' => (string)$whatsapp,
            ':combo' => (int)$combo,
            ':data_horario' => (int)$data
        ]);
    }

    public function addServico($campos)
    {
        extract($campos);

        $sql = "INSERT INTO tbl_reserva (nome_reserva, email_reserva, whatsapp_reserva, id_servico, id_data_horario)
        VALUES (:nome, :email, :whatsapp, :servico, :data_horario)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => (string)$nome,
            ':email' => (string)$email,
            ':whatsapp' => (string)$whatsapp,
            ':servico' => (int)$servico,
            ':data_horario' => (int)$data
        ]);
    }
}
