<?php

class Servico extends Database
{
    public function adicionarServico($dados){
        extract($dados);

        $sql = "INSERT INTO tbl_servico(nome_servico, descricao_servico, valor_servico, 
        tempo_estimado, imagem_servico, alt_servico)
        VALUES (:nome,:descricao,:valor,:tempo,:imagem, :alt)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':imagem' => $imagem,
            ':valor' => $valor,
            ':tempo' => $tempo,
            ':descricao' => $descricao,
            ':alt' => $nome
        ]);
    }

    public function adicionarCombo($dados){
       extract($dados);
       $sql = "INSERT INTO tbl_combo_servico(id_servico_1, id_servico_2, nome_combo, valor_combo, descricao_combo, tempo_estimado, imagem_combo, alt_combo)
       VALUES (:id1,:id2,:nome, :valor, :descricao, :tempo, :imagem, :alt)";
       $stmt = $this->db->prepare($sql);
       return $stmt->execute([
        ':id1' => $id1,
        ':id2' => $id2,
        ':nome' => $combo,
        ':valor' => $valor,
        ':descricao' => $descricao,
        ':tempo' => $tempo,
        ':imagem' => $imagem,
        ':alt' => $combo,
    ]);
    }

    public function salvarCombo($dadosAtualizacaoCombo)
    {
        $sql = "UPDATE tbl_combo_servico SET nome_combo = :nome,
        valor_combo = :valor,tempo_estimado = :tempo,imagem_combo = :imagem, descricao_combo = :descricao
        WHERE id_combo = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $dadosAtualizacaoCombo['nome'],
            ':valor' => $dadosAtualizacaoCombo['valor'],
            ':descricao' => $dadosAtualizacaoCombo['descricao'],
            ':tempo' => $dadosAtualizacaoCombo['tempo'],
            ':imagem' => $dadosAtualizacaoCombo['imagem'],
            ':id' => $dadosAtualizacaoCombo['id']
        ]);
        return $stmt->rowCount();
    }

    public function salvarServico($dadosAtualizacaoServico)
    {
        $sql = "UPDATE tbl_servico SET nome_servico = :nome,
        valor_servico = :valor,tempo_estimado = :tempo,imagem_servico = :imagem, descricao_servico = :descricao
        WHERE id_servico = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $dadosAtualizacaoServico['nome'],
            ':valor' => $dadosAtualizacaoServico['valor'],
            ':descricao' => $dadosAtualizacaoServico['descricao'],
            ':tempo' => $dadosAtualizacaoServico['tempo'],
            ':imagem' => $dadosAtualizacaoServico['imagem'],
            ':id' => $dadosAtualizacaoServico['id']
        ]);
        return $stmt->rowCount();
    }



    public function getServicosByid($id)
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id ORDER BY id_servico ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getComboByid($id)
    {
        $sql = "SELECT * FROM tbl_combo_servico WHERE id_combo = :id ORDER BY id_combo ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletarServico($id)
    {
        $sql = "UPDATE tbl_servico SET status_servico = 'Inativo' WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function deletarCombo($id)
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");

        $sql = "UPDATE tbl_combo_servico SET status_combo = 'Inativo' WHERE id_combo = :id ";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id
        ]);

        return $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
    }
    
    public function getServicos()
    {
        $sql = "SELECT * FROM tbl_servico  ORDER BY id_servico ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetalhe_combo(int $id): array
    {
        $sql = "SELECT * FROM tbl_combo_servico WHERE id_combo = :id AND status_combo = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetalhe_servico(int $id): array
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id AND status_servico = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCombos()
    {
        $sql = "SELECT * FROM tbl_combo_servico  ORDER BY id_combo ASC LIMIT 3";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getcombotodos()
    {
        $sql = "SELECT * FROM tbl_combo_servico  ORDER BY id_combo ASC";

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

    public function addServico(array $campos): bool
    {
        extract($campos);

        $sql = "INSERT INTO tbl_servico (nome_servico, descricao_servico, valor_servico, valor_antigo, tempo_estimado, imagem_servico, alt_servico, status_servico)
        VALUES (:nome, :descricao, :valor, 0.00, :tempo, :imagem, :alt, 'Ativo')";

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

    public function alterStatusServico($id){
        $sql = "UPDATE tbl_servico SET status_servico = 'Ativo' WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function alterStatusCombo($id){
        $sql = "UPDATE tbl_combo_servico SET status_combo = 'Ativo' WHERE id_servico = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id
        ]);
    }
}
