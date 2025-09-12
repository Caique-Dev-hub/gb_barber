<?php

class Notificacao extends Database
{
    public function getNotificacao(int $id): array|bool
    {
        $sql = "SELECT * FROM tbl_notificacao WHERE id_cliente = :cliente";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':cliente' => $id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
