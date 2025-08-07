<?php

class InicioController extends Controller{
    public function index(){
        $dados = [];

        $servicos = $this->db_servico->getServicos();
        $combo = $this->db_servico->getCombos();

        $dados['servicos'] = array_merge($servicos, $combo);
        
        $this->view('inicio', $dados);
    }
}