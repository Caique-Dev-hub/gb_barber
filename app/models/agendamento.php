<?php

class Agendamento extends Database
{
    public function addAgendamento_reserva($cliente, $campos){
        extract($campos);

        if(!isset($id_combo)){
            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_servico, id_data)
            SELECT id_cliente, :servico, :dataHorario FROM tbl_cliente WHERE id_cliente = :cliente";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':servico' => (int)$id_servico,
                ':dataHorario' => (int)$id_data,
                ':cliente' => (int)$cliente
            ]);
        } else{
            $sql = "INSERT INTO tbl_agendamento (id_cliente, id_combo_servico, id_data)
            SELECT id_cliente, :combo, :dataHorario FROM tbl_cliente WHERE id_cliente = :cliente";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':combo' => (int)$id_combo_servico,
                ':dataHorario' => (int)$id_data,
                ':cliente' => (int)$cliente
            ]);
        }
    }

    public function addServico_agendamento($id_agendamento, $servico)
    {
        $sql = "INSERT INTO tbl_servico_agendamento (id_servico, id_agendamento)
        SELECT :servico, id_agendamento FROM tbl_agendamento WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':agendamento' => $id_agendamento,
            ':servico' => $servico
        ]);
    }

    public function updateValor($agendamento, $valor)
    {
        $sql = "UPDATE tbl_agendamento SET valor_agendamento = :valor
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':valor' => (float)$valor,
            ':agendamento' => $agendamento
        ]);
    }

    public function getValor_servico($agendamento)
    {
        $sql = "SELECT sum(valor_servico) AS valor_total FROM tbl_servico
        INNER JOIN tbl_servico_agendamento ON tbl_servico.id_servico = tbl_servico_agendamento.id_servico
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $agendamento
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteAgendamento($agendamento){

        $this->db->beginTransaction();

        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        $sql = "DELETE tbl_servico_agendamento, tbl_agendamento FROM tbl_agendamento
        INNER JOIN tbl_servico_agendamento ON tbl_agendamento.id_agendamento = tbl_servico_agendamento.id_agendamento
        WHERE tbl_agendamento.id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $verify = $stmt->execute([
            ':agendamento' => $agendamento
        ]);

        $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        
        if(!$verify){
            return $this->db->rollBack();
        } else{
            return $this->db->commit();
        }
    }

    public function getAgendamentos($cliente)
    {
        $sql = "SELECT * FROM tbl_agendamento
        INNER JOIN tbl_cliente ON tbl_agendamento.id_cliente = tbl_cliente.id_cliente
        INNER JOIN tbl_horario ON tbl_agendamento.id_horario = tbl_horario.id_horario
        INNER JOIN tbl_data ON tbl_horario.id_data = tbl_data.id_data
        WHERE tbl_agendamento.id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => $cliente
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getServico_agendamento($agendamento)
    {
        $sql = "SELECT id_servico_agendamento, nome_servico, descricao_servico, valor_servico, foto_servico, alt_servico FROM tbl_servico_agendamento
        INNER JOIN tbl_servico ON tbl_servico.id_servico = tbl_servico_agendamento.id_servico
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $agendamento
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServicos_agendamento($agendamento)
    {
        $sql = "SELECT * FROM tbl_servico
        INNER JOIN tbl_servico_agendamento ON tbl_servico.id_servico = tbl_servico_agendamento.id_servico
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $agendamento
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteServico_agendamento($agendamento){
        $sql = "DELETE FROM tbl_servico_agendamento WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':agendamento' => $agendamento
        ]);
    }

    public function updateAgendamento($agendamento, $campos){
        extract($campos);

        $sql = "UPDATE tbl_agendamento SET id_horario = :horario,
        valor_agendamento = :valor WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':horario' => $horario,
            ':valor' => $valor,
            ':agendamento' => $agendamento
        ]);
    }

    public function updateStatus_indisponivel($horario){
        $sql = "UPDATE tbl_horario SET status_horario = 'Indisponível'
        WHERE id_horario = :horario";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':horario' => $horario
        ]);
    }

    public function updateStatus_disponivel($horario){
        $sql = "UPDATE tbl_horario SET status_horario = 'Disponível'
        WHERE id_horario = :horario";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':horario' => $horario
        ]);
    }
}
