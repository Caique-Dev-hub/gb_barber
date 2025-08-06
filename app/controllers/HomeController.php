<?php

class HomeController extends Controller{
    public function index(){
        $dados = array();

        $db_servicos = new Servico();
        $dados['servicos'] = $db_servicos->get_servico();
        $this->carregarViews('home', $dados);
    }

    public function listar(){
        $dados = array();

        $db_servico = new Servico();
        $dados['servicos'] = $db_servico->get_servico();
        $this->carregarViews('home' . $dados);
    }

    public function detalhe($caracter){
        $dados = array();
        $db_servicos = new Servico();
        $servico = $db_servicos->get_servico();

        foreach ($servico as $db) {
            if ($caracter == geral::texto_url($db['nome_servico'])) {
                $dados['detalhe'] = $db;
                $this->carregarViews('detalhe', $dados);
            }
        }
    }
}