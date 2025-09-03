<?php

class Cliente extends Database{

    // GET
    public function getEmail(string $email_hash): array|bool
    {
        $sql = "SELECT * FROM tbl_cliente WHERE email_hash = :email AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email_hash
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmailAtu(string $email_hash, int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_cliente WHERE email_hash = :email AND id_cliente != :id AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $email_hash,
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWhatsappAtu(string $whatsapp_hash, int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_cliente WHERE whatsapp_hash = :whatsapp AND id_cliente = :id AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':whatsapp' => $whatsapp_hash,
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWhatsapp(string $whatsapp_hash): array|bool
    {
        $sql = "SELECT * FROM tbl_cliente WHERE whatsapp_hash = :whatsapp AND status_cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':whatsapp' => $whatsapp_hash
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

    public function getDetalheCliente(int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_cliente WHERE id_cliente = :id AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ADD

    public function addCadastro(array $campos): int
    {
        extract($campos);

        $sql = "INSERT INTO tbl_cliente (nome_cliente, email_cliente, email_hash, whatsapp_cliente, whatsapp_hash, senha_cliente)
        VALUES (:nome, :email, :email_hash, :whatsapp, :whatsapp_hash, :senha)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':nome' => (string)$nome,
            ':email' => (string)$email,
            ':email_hash' => (string)$email_hash,
            ':whatsapp' => (string)$whatsapp,
            ':whatsapp_hash' => (string)$whatsapp_hash,
            ':senha' => (string)$senha
        ]);
        return $this->db->lastInsertId();
    }




    // UPDATE

    public function updateCadastro(array $campos, int $id): bool
    {
        extract($campos);

        $sql = "UPDATE tbl_cliente SET 
        nome_cliente = :nome,
        email_cliente = :email,
        email_hash = :email_hash,
        whatsapp_cliente = :whatsapp,
        whatsapp_hash = :whatsapp_hash,
        senha_cliente = :senha
        WHERE id_cliente = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nome' => $nome,
            ':email' => $email,
            ':email_hash' => $email_hash,
            ':whatsapp' => $whatsapp,
            ':whatsapp_hash' => $whatsapp_hash,
            ':senha_cliente' => $senha ?? NULL
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