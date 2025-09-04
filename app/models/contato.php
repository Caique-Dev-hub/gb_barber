<?php

class Contato extends Database{
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
}