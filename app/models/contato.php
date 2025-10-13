<?php

class Contato extends Database
{


    public function getComentariosCliente(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        try {
            $sql = "SELECT tbl_comentario.*, tbl_resposta.id_resposta, tbl_resposta.nome_resposta, tbl_resposta.mensagem_resposta, tbl_resposta.data_resposta FROM tbl_comentario
            LEFT JOIN tbl_resposta ON tbl_comentario.id_comentario = tbl_resposta.id_comentario
            WHERE tbl_comentario.id_cliente = :cliente";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cliente' => (int)$id
            ]);

            $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fetch ?: null;

        } catch (PDOException $e) {
           return null;
        }
    }


    public function addComentario(int $id, string $mensagem): bool
    {
        $sql = "INSERT INTO tbl_comentario (id_cliente, data_comentario, mensagem_comentario)
        SELECT id_cliente, NOW(), :mensagem FROM tbl_cliente WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':cliente' => $id,
            ':mensagem' => $mensagem
        ]);
    }

    public function updateComentario(int $id, string $mensagem): bool
    {
        $sql = "UPDATE tbl_comentario SET
        mensagem_comentario = :mensagem,
        data_atualizacao = NOW()
        WHERE id_comentario = :comentario";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':mensagem' => $mensagem,
            ':comentario' => $id
        ]);
    }

    public function deleteComentario(int $id): bool
    {
        $sql = "DELETE tbl_comentario, tbl_resposta FROM tbl_comentario 
        INNER JOIN tbl_resposta ON tbl_comentario.id_comentario = tbl_resposta.id_comentario
        WHERE tbl_comentario.id_comentario = :comentario";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':comentario' => $id
        ]);
    }
}
