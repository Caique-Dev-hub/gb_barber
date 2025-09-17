<?php

class Contato extends Database{
    public function getComentariosCliente(int $id_cliente): array|bool
    {
        $sql = "SELECT * FROM tbl_comentario
        LEFT JOIN tbl_resposta ON tbl_comentario.id_comentario = tbl_resposta.id_comentario
        INNER JOIN tbl_cliente ON tbl_comentario.id_cliente = tbl_cliente.id_cliente
        WHERE tbl_comentario.id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => $id_cliente
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}