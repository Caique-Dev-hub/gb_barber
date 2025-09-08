<?php

class Cliente extends Database
{

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
        $sql = "SELECT * FROM tbl_cliente WHERE whatsapp_hash = :whatsapp AND id_cliente != :id AND status_cliente = 'Ativo'";

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

    public function getAgendamentoComentario($id)
    {
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

        if(is_bool($senha)){
            $sql = "UPDATE tbl_cliente SET
            nome_cliente = :nome,
            email_cliente = :email,
            email_hash = :email_hash,
            whatsapp_cliente = :whatsapp,
            whatsapp_hash = :whatsapp_hash
            WHERE id_cliente = :cliente";
        } else {
            $sql = "UPDATE tbl_cliente SET
            nome_cliente = :nome,
            email_cliente = :email,
            email_hash = :email_hash,
            whatsapp_cliente = :whatsapp,
            whatsapp_hash = :whatsapp_hash,
            senha_cliente = :senha
            WHERE id_cliente = :cliente";
        }

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':email_hash', $email_hash, PDO::PARAM_STR);
        $stmt->bindValue(':whatsapp', $whatsapp, PDO::PARAM_STR);
        $stmt->bindValue(':whatsapp_hash', $whatsapp_hash, PDO::PARAM_STR);
        
        if(is_string($senha)){
            $stmt->bindValue(':senha', $senha, PDO::PARAM_STR);
        }

        $stmt->bindValue(':cliente', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }




    // DELETE
    public function deleteCadastro(int $id): bool
    {
        $sql1 = "DELETE FROM tbl_cliente WHERE id_cliente = :cliente";
        $sql2 = "DELETE FROM tbl_agendamento WHERE id_cliente = :cliente";
        $sql3 = "DELETE FROM tbl_comentario WHERE id_cliente = :cliente";

        $this->db->beginTransaction();

        $stmt1 = $this->db->prepare($sql1);
        $stmt2 = $this->db->prepare($sql2);
        $stmt3 = $this->db->prepare($sql3);


        $resposta[] = $stmt1->execute([
            ':cliente' => $id
        ]);

        $resposta[] = $stmt2->execute([
            ':cliente' => $id
        ]);

        $resposta[] = $stmt3->execute([
            ':cliente' => $id
        ]);


        foreach ($resposta as $valor) {
            if (!$valor) {
                $this->db->rollback();
                return false;
            }
        }

        $this->db->commit();
        return true;
    }
}
