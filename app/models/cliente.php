<?php

class Cliente extends Database{
    public function getEmail($email){
        $sql = "SELECT * FROM tbl_cliente WHERE email_hash = :email AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => (string)$email
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWhatsapp($whatsapp){
        $sql = "SELECT * FROM tbl_cliente WHERE whatsapp_hash = :whatsapp AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':whatsapp' => (string)$whatsapp
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCliente($campos){
        extract($campos);

        $sql = "INSERT INTO tbl_cliente (nome_cliente, email_cliente, email_hash, whatsapp_cliente, whatsapp_hash, senha_cliente)
        VALUES (:nome, :email, :email_hash, :whatsapp, :whatsapp_hash, :senha)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => (string)$nome,
            ':email' => (string)$email,
            ':email_hash' => (string)$email_hash,
            ':whatsapp' => (string)$whatsapp,
            ':whatsapp_hash' => (string)$whatsapp_hash,
            ':senha' => (string)$senha
        ]);
    }

    public function updateEstrela($cliente){
        $sql = "UPDATE tbl_cliente SET estrela_cliente = 1 WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => (int)$cliente
        ]);
    }

    public function updateSenha($id, $senha){
        $sql = "UPDATE tbl_cliente SET senha_cliente = :senha WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':senha' => $senha,
            ':cliente' => $id
        ]);
    }

    public function getCliente($id){
        $sql = "SELECT * FROM tbl_cliente WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getClientes(){
        $sql = "SELECT * FROM tbl_cliente";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCliente($id, $campos){
        extract($campos);

        $sql = "UPDATE tbl_cliente SET nome_cliente = :nome,
        email_cliente = :email,
        whatsapp_cliente = :whatsapp,
        senha_cliente = :senha WHERE id_cliente = :cliente";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':whatsapp' => $whatsapp,
            ':senha' => $senha,
            ':cliente' => $id
        ]);
    }
}