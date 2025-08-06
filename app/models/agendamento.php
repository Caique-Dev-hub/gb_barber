<?php

class Agendamento extends Model
{
    public function addAgendamento($campos)
    {
        extract($campos);

        $sql = "INSERT INTO tbl_agendamento (id_cliente, id_horario, chave_agendamento)
        SELECT id_cliente, :horario, :chave FROM tbl_cliente WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => $cliente,
            ':horario' => $horario,
            ':chave' => password_hash($chave, PASSWORD_DEFAULT)
        ]);
        return $this->db->lastInsertId();
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

    public function updateAgendamento($agendamento, $valor)
    {
        $sql = "UPDATE tbl_agendamento SET valor_agendamento = :valor
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':valor' => (float)$valor,
            ':agendamento' => $agendamento
        ]);
    }

    public function getValor_servico_agendamento($id_agendamento)
    {
        $sql = "SELECT sum(valor_servico) AS valor_total FROM tbl_servico_agendamento 
        INNER JOIN tbl_servico ON tbl_servico_agendamento.id_servico = tbl_servico.id_servico
        INNER JOIN tbl_agendamento ON tbl_servico_agendamento.id_agendamento = tbl_agendamento.id_agendamento
        WHERE tbl_agendamento.id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $id_agendamento
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function removeAgendamento($id_agendamento)
    {
        $stmt1 = $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        $sql = "DELETE tbl_agendamento, tbl_servico_agendamento FROM tbl_agendamento
        INNER JOIN tbl_servico_agendamento ON tbl_agendamento.id_agendamento = tbl_servico_agendamento.id_agendamento
        WHERE tbl_servico_agendamento.id_agendamento = :agendamento AND tbl_agendamento.id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $id_agendamento
        ]);

        return $stmt2 = $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }

    public function getChave()
    {
        $sql = "SELECT id_agendamento, chave_agendamento FROM tbl_agendamento";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAgendamentos($cliente){
        $sql = "SELECT tbl_agendamento.id_agendamento, nome_cliente, email_cliente, whatsapp_cliente, data_horario, hora_inicio, hora_fim, status_agendamento, valor_agendamento FROM tbl_agendamento
        INNER JOIN tbl_cliente ON tbl_cliente.id_cliente = tbl_agendamento.id_cliente
        INNER JOIN tbl_horario ON tbl_horario.id_horario = tbl_agendamento.id_horario
        WHERE tbl_agendamento.id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => $cliente
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getServico_agendamento($agendamento){
        $sql = "SELECT nome_servico, descricao_servico, valor_servico, foto_servico, alt_servico FROM tbl_servico_agendamento
        INNER JOIN tbl_servico ON tbl_servico.id_servico = tbl_servico_agendamento.id_servico
        WHERE id_agendamento = :agendamento";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agendamento' => $agendamento
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateChave($agendamento, $cliente, $chave){
        $sql = "UPDATE tbl_agendamento SET chave_agendamento = :chave
        WHERE id_agendamento = :agendamento AND id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':chave' => password_hash($chave, PASSWORD_DEFAULT),
            ':agendamento' => $agendamento,
            ':cliente' => $cliente
        ]);
    }
}
