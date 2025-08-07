<?php

class Servico extends Database{
    public function getServicos(){
        $sql = "SELECT * FROM tbl_servico ORDER BY id_servico";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCombos(){
        $sql = "SELECT * FROM tbl_combo_servico WHERE id_servico_3 IS NULL ORDER BY id_combo";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount(){
        $sql = "SELECT COUNT(*) AS total FROM tbl_servico";

        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCount_combo(){
        $sql = "SELECT COUNT(*) AS total FROM tbl_combo_servico";

        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getServico_edit($servico){
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :servico";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':servico' => (int)$servico
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCombo_edit($combo){
        $sql = "SELECT * FROM tbl_combo_servico WHERE id_combo_servico = :combo";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':combo' => (int)$combo
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addServico($campos){
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