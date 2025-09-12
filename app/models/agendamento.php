<?php

class Agendamento extends Database
{
    // ADD
    public function addAgendamento(array $campos, int $id_cliente): bool
    {
        extract($campos);

        $sql = "INSERT INTO tbl_agendamento (id_cliente, id_servico, id_combo, id_data_horario)
        SELECT id_cliente, :servico, :combo, :data_horario FROM tbl_cliente WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => $id_cliente,
            ':servico' => (int)$servico ?? NULL,
            ':combo' => (int)$combo ?? NULL,
            ':data_horario' => (int)$data_horario
        ]);
    }


    // GET



    // UPDATE 
    public function updateHorarioAgendamento(array $campos): bool
    {
        $sql = "UPDATE tbl_data_horario INNER JOIN tbl_horario ON tbl_data_horario.id_horario = tbl_horario.id_horario"
    }
    
}