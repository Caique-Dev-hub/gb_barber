<?php

class Servico extends Database
{
    public function getServicos()
    {
        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY id_servico ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetalhe_combo($id)
    {
        $sql = "SELECT * FROM tbl_combo_servico WHERE id_combo = :id AND status_combo = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => (int)$id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetalhe_servico($id)
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND status_servico = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => (int)$id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCombos()
    {
        $sql = "SELECT * FROM tbl_combo_servico WHERE status_combo = 'Ativo' ORDER BY id_combo ASC LIMIT 3";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getcombotodos()
    {
        $sql = "SELECT * FROM tbl_combo_servico WHERE status_combo = 'Ativo' ORDER BY id_combo ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getCount()
    {
        $sql = "SELECT COUNT(*) AS total FROM tbl_servico WHERE status_servico = 'Ativo'";

        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCountCombo()
    {
        $sql = "SELECT COUNT(*) AS total FROM tbl_combo_servico WHERE status_combo = 'Ativo'";

        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addServico($campos)
    {
        extract($campos);

        $sql = "INSERT INTO tbl_servico 
        (nome_servico, descricao_servico, valor_servico, tempo_estimado, imagem_servico, alt_servico)
        VALUES (:nome, :descricao, :valor, :tempo, :imagem, :alt)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => (string)$nome,
            ':descricao' => (string)$descricao,
            ':valor' => (float)$valor,
            ':tempo' => (string)$tempo,
            ':imagem' => (string)$imagem,
            ':alt' => (string)$nome
        ]);
    }
}
