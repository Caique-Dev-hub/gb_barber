<?php

class Reserva extends Database
{

    public function getReservas(){
        $sql = "SELECT * FROM tbl_reserva
        INNER JOIN tbl_data_horario ON tbl_data_horario.id_data_horario = tbl_reserva.id_data_horario
        INNER JOIN tbl_data ON tbl_data_horario.id_data = tbl_data.id_data
        INNER JOIN tbl_horario ON tbl_horario.id_horario = tbl_data_horario.id_horario
        ORDER BY tbl_data.nome_data ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addReserva(array $campos): ?bool
    {
        foreach($campos as $valor){
            if(empty($valor)){
                return null;
            }
        }

        try{
            extract($campos);

            $sql = "INSERT INTO tbl_reserva (nome_reserva, email_reserva, whatsapp_reserva, id_servico, id_combo, id_data_horario)
            VALUES (:nome, :email, :whatsapp, :servico, :combo, :horario)";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':whatsapp' => $whatsapp,
                ':servico' => $servico ?? null,
                ':combo' => $combo ?? null,
                ':horario' => $horario
            ]);

        } catch(PDOException $e){
            return null;
        }
    }
}
