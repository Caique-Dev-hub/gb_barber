<?php

class Notificacao extends Database
{
    public function getNotificacaoLida(int $id): ?array
    {
        if(empty($id)){
            return null;
        }

        try{
            $sql = "SELECT * FROM tbl_notificacao WHERE id_cliente = :cliente AND status_notificacao = 'Lido'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cliente' => $id
            ]);

            $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fetch;

        } catch(PDOException $e){
            return null;
        }
    }

    public function getNotificacaoNaoLida(int $id): ?array
    {
        if(empty($id)){
            return null;
        }

        try{
            $sql = "SELECT * FROM tbl_notificacao WHERE id_cliente = :cliente AND status_notificacao = 'Aguardando'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cliente' => $id
            ]);

            $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fetch;

        } catch(PDOException $e){
            return null;
        }
    }



    public function updateNotificacaoLida(int $id_notificacao): ?true
    {
        if(empty($id_notificacao)){
            return null;
        }

        try{
            $sql = "UPDATE tbl_notificacao SET status_notificacao = 'Lido' 
            WHERE id_notificacao = :notificacao";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':notificacao' => $id_notificacao
            ]);

            return true;
        } catch(PDOException $e){
            return null;
        }
    }
}
