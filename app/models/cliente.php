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

    public function getEmailTodos($email){
        $sql = "SELECT * FROM tbl_cliente WHERE email_hash = :email AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWhatsappTodos($whatsapp){
        $sql = "SELECT * FROM tbl_cliente WHERE whatsapp_hash = :whatsapp AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':whatsapp' => $whatsapp
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWhatsapp($whatsapp){
        $sql = "SELECT * FROM tbl_cliente WHERE whatsapp_hash = :whatsapp AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':whatsapp' => (string)$whatsapp
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAgendamentoComentario($id){
        $sql = "SELECT * FROM tbl_cliente
        INNER JOIN tbl_agendamento ON tbl_cliente.id_cliente = tbl_agendamento.id_cliente
        INNER JOIN tbl_comentario ON tbl_cliente.id_cliente = tbl_comentario.id_cliente
        WHERE tbl_cliente.id_cliente = :cliente AND tbl_cliente.status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => (int)$id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailsCliente($id){
        $sql = "SELECT nome_cliente, email_cliente, whatsapp_cliente, senha_cliente FROM tbl_cliente 
        WHERE id_cliente = :id AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => (int)$id
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

    public function updateCliente($campos, $id){
        extract($campos);

        $sql = "UPDATE tbl_cliente SET 
        nome_cliente = :nome,
        email_cliente = :email,
        email_hash = :email_hash,
        whatsapp_cliente = :whatsapp,
        whatsapp_hash = :whatsapp_hash,
        senha_cliente = :senha
        WHERE id_cliente = :cliente AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => (string)$nome,
            ':email' => (string)$email,
            ':email_hash' => (string)$email_hash,
            ':whatsapp' => (string)$whatsapp,
            ':whatsapp_hash' => (string)$whatsapp_hash,
            ':senha' => (string)$senha,
            ':cliente' => (int)$id
        ]);
    }

    public function updateEstrela($cliente){
        $sql = "UPDATE tbl_cliente SET estrela_cliente = 1 WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => (int)$cliente
        ]);
    }
}