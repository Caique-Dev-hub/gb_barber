<?php

class Agendamento extends Database
{
    // ADD
    public function addAgendamento(array $campos, int $id_cliente): int|bool
    {
        extract($campos);

        if (isset($servico)) {
            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_servico, id_data_horario)
            SELECT id_cliente, :servico, :data_horario FROM tbl_cliente WHERE id_cliente = :cliente";
        } else{
            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_combo, id_data_horario)
            SELECT id_cliente, :combo, :data_horario FROM tbl_cliente WHERE id_cliente = :cliente";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->bindValue(':data_horario', $data_horario, PDO::PARAM_STR);
        if(isset($servico)){
            $stmt->bindValue(':servico', (int)$servico, PDO::PARAM_INT);
        } else{
            $stmt->bindValue(':combo', (int)$combo, PDO::PARAM_INT);
        }
        $stmt->execute();

        $id = $this->db->lastInsertId();
        return (int)$id;
    }


    // GET
    public function getAgendamentoDetalhes(int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_agendamento WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // UPDATE 
    public function updateAgendamentoHorario(int $id_data, string $tempoMinino, string $tempoMaximo): bool
    {
        $sql = "UPDATE tbl_data_horario INNER JOIN tbl_horario ON tbl_horario.id_horario = tbl_data_horario.id_horario
        SET status_data_horario = 'Indisponivel' 
        WHERE tbl_horario.hora_inicio BETWEEN :tempoMinimo AND :tempoMaximo 
        AND id_data = :data_agendamento AND status_data_horario = 'Disponivel'";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':data_agendamento' => $id_data,
            ':tempoMinimo' => $tempoMinino,
            ':tempoMaximo' => $tempoMaximo
        ]);
    }
}
