<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Fornecedor_model', 'Despesas_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header_refresh_pedido');
        $this->load->view('basico/nav_principal');

        #$this->load->view('relatorio/nav_secundario');
        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador n�o suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }		
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }
    
    public function despesas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
			'Campo',
			'Ordenamento',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

        $data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Pedido',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );
		
        $data['titulo'] = 'Gestor de Despesas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE);
            $data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE);
			
            $data['list_combinar'] = $this->load->view('despesas/list_despesas_combinar', $data, TRUE);
			$data['list_aprovar'] = $this->load->view('despesas/list_despesas_aprovar', $data, TRUE);
            $data['list_pagonline'] = $this->load->view('despesas/list_despesas_pagonline', $data, TRUE);
            $data['list_producao'] = $this->load->view('despesas/list_despesas_producao', $data, TRUE);
            $data['list_envio'] = $this->load->view('despesas/list_despesas_envio', $data, TRUE);
            $data['list_entrega'] = $this->load->view('despesas/list_despesas_entrega', $data, TRUE);
			$data['list_pagamento'] = $this->load->view('despesas/list_despesas_pagamento', $data, TRUE);
        }

        $this->load->view('despesas/tela_despesas', $data);

        $this->load->view('basico/footer');
    }
}