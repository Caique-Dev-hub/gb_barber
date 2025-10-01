<?php

class InicioController extends Controller{
    public function index(){
        $dados = [];

        $servicos = $this->db_servico->getServicos();
        $combos = $this->db_servico->getCombos();

        $dados['datas'] = $this->db_data->getDatas();

        $dados['servicos'] = array_merge($servicos, $combos);
 
        $this->view('inicio', $dados);
    }

    public function listar_horarios($id){
        $getHorarios = $this->db_data->getHorarios($id);

        foreach($getHorarios as $atributo){
            extract($atributo);

            echo "<option value='$id_data_horario'>$hora_inicio</option>";
        }
    }
}