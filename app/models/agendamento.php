<?php

class Agendamento extends Database
{
    // ADD
    public function addAgendamento(array $campos, int $id): int|bool
    {
        extract($campos);

        if(isset($combo)){
            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_combo, id_data_horario)
            SELECT id_cliente, :combo, :data_horario FROM tbl_cliente 
            WHERE id_cliente = :id AND status_cliente = 'Ativo'";
        } else{
            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_servico, id_data_horario)
            SELECT id_cliente, :servico, :data_horario FROM tbl_cliente 
            WHERE id_cliente = :id AND status_cliente = 'Ativo'";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':combo' => $combo ?? NULL,
            ':servico' => $servico ?? NULL,
            ':data_horario' => $data_horario,
            ':id' => $id
        ]);
        return (int)$this->db->lastInsertId();
    }


    // GET
    public function getDataId(int $id_horario, int $id_data): array|bool
    {
        $sql = "SELECT * FROM tbl_data_horario
        INNER JOIN tbl_horario ON tbl_data_horario.id_data_horario = tbl_horario.id_horario
        INNER JOIN tbl_data ON tbl_data_horario.id_data = tbl_data.id_data
        WHERE tbl_data_horario.id_horario = :horario AND tbl_data_horario.id_data = :data";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':horario' => $id_horario,
            ':data' => $id_data
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAgendamentoId(int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_agendamento 
        INNER JOIN tbl_data_horario ON tbl_agendamento.id_data_horario = tbl_data_horario.id_data_horario
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}