<?php

class Servico extends Database{
public function getservico(){
    $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY id_servico ASC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

public function getcombo(){
    $sql = "SELECT * FROM tbl_combo_servico WHERE status_combo = 'Ativo' ORDER BY id_combo ASC LIMIT 3";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

public function getcombotodos(){
    $sql = "SELECT * FROM tbl_combo_servico WHERE status_combo = 'Ativo' ORDER BY id_combo ASC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

public function getCount(){
    $sql = "SELECT COUNT(*) FROM tbl_servico WHERE status_servico = 'Ativo'";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

public function getCountcombo(){
    $sql = "SELECT COUNT(*) FROM tbl_combo_servicco WHERE status_combo = 'Ativo'";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
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