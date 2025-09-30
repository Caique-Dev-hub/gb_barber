<?php

class Agendamento extends Database
{
    // ADD
    public function addAgendamento(array $campos): ?int
    {
        try{
            extract($campos);

            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_servico, id_combo, id_data_horario)
            SELECT id_cliente, :servico, :combo, :data_horario FROM tbl_cliente WHERE id_cliente = :cliente";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cliente' => (int)$cliente,
                ':servico' => isset($servico) ? (int)$servico : null,
                ':combo' => isset($combo) ? (int)$combo : null,
                ':data_horario' => (int)$data_horario
            ]);

            $id = $this->db->lastInsertId();

            return $id ?: null;

        } catch(PDOException $e){
            return null;
        }
    }


    // GET
    public function getDataAgendamento(int $id_data, string $horaMaxima): array|bool
    {
        $sql = "SELECT * FROM tbl_agendamento
        INNER JOIN tbl_data_horario ON tbl_agendamento.id_data_horario = tbl_data_horario.id_data_horario
        INNER JOIN tbl_horario ON tbl_data_horario.id_horario = tbl_horario.id_horario
        WHERE :horaMaxima > tbl_horario.hora_inicio AND id_data = :data
        AND tbl_agendamento.status_agendamento = 'Aguardando'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':data' => $id_data,
            ':horaMaxima' => $horaMaxima
        ]);
        return $stmt->fetchAll();
    }

    public function getAgendamentosHorario(string $tempoMinimo, string $tempoMaximo, int $data): ?bool
    {
        try{
            $sql = "SELECT * FROM tbl_agendamento
            INNER JOIN tbl_data_horario ON tbl_agendamento.id_data_horario = tbl_data_horario.id_data_horario
            INNER JOIN tbl_horario ON tbl_data_horario.id_horario = tbl_horario.id_horario
            WHERE tbl_horario.hora_inicio BETWEEN :tempoMinimo AND :tempoMaximo AND tbl_data_horario.id_data = :id_data
            AND status_agendamento = 'Aguardando' LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':tempoMinimo' => $tempoMinimo,
                ':tempoMaximo' => $tempoMaximo,
                ':id_data' => $data
            ]);

            if((int)$stmt->rowCount() === 0){
                return false;
            } else {
                return true;
            }
        } catch(PDOException $e){
            return null;
        }
    }

}
