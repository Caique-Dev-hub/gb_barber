<?php

class Servico extends Database
{
    public function getServicos()
    {
        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY id_servico ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetalhe_combo(int $id): ?array
    {
        if(empty(trim($id)) || is_null($id) || !$id){
            return null;
        }

        try{
            $sql = "SELECT * FROM tbl_combo WHERE id_combo = :combo AND status_combo = 'Ativo'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':combo' => $id
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

        } catch(PDOException $e){
            return null;
        }
    }

    public function getDetalhe_servico(int $id): ?array
    {
        if(empty(trim($id)) || is_null($id) || !$id){
            return null;
        }

        try{
            $sql = "SELECT * FROM tbl_servico WHERE id_servico = :servico AND status_servico = 'Ativo'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':servico' => $id
            ]);

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch(PDOException $e){
            return null;
        }
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

    public function getCount(): ?array
    {
        try{
            $sql = "SELECT COUNT(*) AS total FROM tbl_servico WHERE status_servico = 'Ativo'";

            $stmt = $this->db->query($sql);

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

        } catch(PDOException $e){
            return null;
        }
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
}
