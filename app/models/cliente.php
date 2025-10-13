<?php

class Cliente extends Database
{

    // GET
    public function getcliente()
    {
        $sql = "SELECT * FROM tbl_cliente ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deletecliente($id)
    {

        $sql = "UPDATE tbl_cliente SET status_cliente = 'Inativo' WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function AtivarCliente($id)
    {
        $sql = "UPDATE tbl_cliente SET status_cliente = 'Ativo' WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function getEmailCadastro(string $emailHash): ?int
    {
        if (empty($emailHash)) {
            return null;
        }

        try {
            $sql = "SELECT id_cliente FROM tbl_cliente WHERE email_hash = :emailHash AND status_cliente = 'Ativo'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':emailHash' => $emailHash
            ]);

            $rowCount = $stmt->rowCount();

            return (int)$rowCount;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getEmail(string $emailHash): array|false|null
    {
        if (empty($emailHash)) {
            return null;
        }

        try {
            $sql = "SELECT id_cliente, nome_cliente, whatsapp_hash, senha_cliente FROM tbl_cliente
            WHERE email_hash = :emailHash AND status_cliente = 'Ativo' LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':emailHash' => $emailHash
            ]);

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($resultado)) {
                return false;
            }

            return $resultado ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getEmailAtu(string $emailHash, int $id): ?int
    {
        if (empty($emailHash) || $id <= 0) {
            return null;
        }

        try {
            $sql = "SELECT id_cliente FROM tbl_cliente 
            WHERE email_hash = :emailHash AND id_cliente != :cliente AND status_cliente = 'Ativo'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':emailHash' => $emailHash,
                ':cliente' => $id
            ]);

            $rowCount = $stmt->rowCount();

            return (int)$rowCount ?? null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getWhatsappAtu(string $whatsappHash, int $id): ?int
    {
        if (empty($whatsappHash) || $id <= 0) {
            return null;
        }


        try {
            $sql = "SELECT id_cliente FROM tbl_cliente
            WHERE whatsapp_hash = :whatsappHash AND id_cliente != :cliente AND status_cliente";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':whatsappHash' => $whatsappHash,
                ':cliente' => $id
            ]);

            $rowCount = $stmt->rowCount();

            return (int)$rowCount;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getWhatsappCadastro(string $whatsappHash): ?int
    {
        if (empty($whatsappHash)) {
            return null;
        }

        try {
            $sql = "SELECT id_cliente FROM tbl_cliente WHERE whatsapp_hash = :whatsappHash AND status_cliente = 'Ativo'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':whatsappHash' => $whatsappHash
            ]);

            $rowCount = $stmt->rowCount();

            return (int)$rowCount;
        } catch (PDOException $e) {
            return null;
        }
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
        $sql = "SELECT nome_cliente, email_cliente, whatsapp_cliente FROM tbl_cliente WHERE id_cliente = :id AND status_cliente = 'Ativo'";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getClienteByid($id)
    {
        $sql = "SELECT * FROM tbl_cliente WHERE id_cliente = :id AND status_cliente = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSenhaCliente(int $id): ?bool
    {
        if ($id <= 0) {
            return null;
        }

        try {
            $sql = "SELECT senha_cliente FROM tbl_cliente WHERE id_cliente = :cliente AND status_cliente = 'Ativo' LIMIT 1";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cliente' => $id
            ]);

            $senha = $stmt->fetch(PDO::FETCH_ASSOC);

            return is_null($senha['senha_cliente']) || empty($senha['senha_cliente']) ? false : true;
        } catch (PDOException $e) {
            return null;
        }
    }








    // ADD
    public function addCadastro(array $campos): ?int
    {
        foreach ($campos as $valor) {
            if (empty($valor)) {
                return null;
            }
        }

        try {
            extract($campos);

            $sql = "INSERT INTO tbl_cliente (nome_cliente, email_cliente, email_hash, whatsapp_cliente, whatsapp_hash, senha_cliente)
            VALUES (:nome, :email, :emailHash, :whatsapp, :whatsappHash, :senha)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nome' => (string)$nome ?? null,
                ':email' => (string)$email,
                ':emailHash' => (string)$emailHash,
                ':whatsapp' => (string)$whatsapp,
                ':whatsappHash' => (string)$whatsappHash,
                ':senha' => (string)$senha ?? null
            ]);

            $id = $this->db->lastInsertId();

            return (int)$id ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function addCliente($campos)
    {
        extract($campos);
        $sql = "INSERT INTO tbl_cliente (nome_cliente, email_cliente, 
        email_hash, whatsapp_cliente,whatsapp_hash, senha_cliente) 
        VALUES (:nome,:email,:email_hash,:whatsapp,:whatsapp_hash, :senha)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':email_hash' => $email_hash,
            ':whatsapp' => $whatsapp,
            ':whatsapp_hash' => $whatsapp_hash,
            ':senha' => $senha
        ]);
    }








    // UPDATE

    public function updateCadastro(array $campos, int $id): ?true
    {
        if ($id <= 0) {
            return null;
        }

        try {
            extract($campos);

            if (!isset($senha)) {
                $sql = "UPDATE tbl_cliente SET
                nome_cliente = :nome,
                email_cliente = :email,
                email_hash = :emailHash,
                whatsapp_cliente = :whatsapp,
                whatsapp_hash = :whatsappHash
                WHERE id_cliente = :cliente AND status_cliente = 'Ativo'";
            } else {
                $sql = "UPDATE tbl_cliente SET
                nome_cliente = :nome,
                email_cliente = :email,
                email_hash = :emailHash,
                whatsapp_cliente = :whatsapp,
                whatsapp_hash = :whatsappHash,
                senha_cliente = :senha
                WHERE id_cliente = :cliente AND status_cliente = 'Ativo'";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':cliente', $id, PDO::PARAM_INT);
            $stmt->bindValue(':nome', (string)$nome, PDO::PARAM_STR);
            $stmt->bindValue(':email', (string)$email, PDO::PARAM_STR);
            $stmt->bindValue(':emailHash', (string)$emailHash, PDO::PARAM_STR);
            $stmt->bindValue(':whatsapp', (string)$whatsapp, PDO::PARAM_STR);
            $stmt->bindValue(':whatsappHash', (string)$whatsappHash, PDO::PARAM_STR);

            if (isset($senha) && !empty($senha)) {
                $stmt->bindValue(':senha', (string)$senha, PDO::PARAM_STR);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {

            echo json_encode([
                'error' => $e->getMessage()
            ]);
            exit;

            return null;
        }
    }

    public function updateCliente($cliente)
    {
        extract($cliente);

        $sql = "UPDATE tbl_cliente SET nome_cliente = :cliente, 
        whatsapp_cliente = :telefone, email_cliente = :email WHERE id_cliente =  :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => $nome,
            ':telefone' => $telefone,
            ':email' => $email,
            ':id' => $id
        ]);
    }

    public function addestrela($id)
    {
        $sql = "UPDATE tbl_cliente SET estrela_cliente = 1 WHERE id_cliente = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
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
