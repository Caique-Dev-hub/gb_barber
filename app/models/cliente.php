<?php

class Cliente extends Model{
    public function getEmail(){
        $sql = "SELECT id_cliente, email_cliente FROM tbl_cliente";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWhatsapp(){
        $sql = "SELECT id_cliente, whatsapp_cliente FROM tbl_cliente";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCliente($campos){
        extract($campos);
        $email = Geral::criptografia($email);
        $whatsapp = Geral::criptografia($whatsapp);

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

    public function getCliente(){
        $sql = "SELECT * FROM tbl_cliente";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}