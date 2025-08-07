<?php

class Cliente extends Database{
    public function addCliente($campos){
        
    }

    public function updateEstrela($cliente){
        $sql = "UPDATE tbl_cliente SET estrela_cliente = 1 WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => (int)$cliente
        ]);
    }

    public function addCliente_agendamento($campos){
        extract($campos);

        $sql = "INSERT INTO tbl_cliente (nome_cliente, email_cliente, whatsapp_cliente)
        VALUES (:nome, :email, :whatsapp)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':whatsapp' => $whatsapp
        ]);
        return $this->db->lastInsertId();
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