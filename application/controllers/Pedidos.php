<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Pedidos_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
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
                $msg = '<h2><strong>Navegador não suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }		
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }
    
    public function pedidos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
		
        $data['titulo'] = 'Gestor de Pedidos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE);
            $data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE);
			
            $data['list_combinar'] = $this->load->view('pedidos/list_pedidos_combinar', $data, TRUE);
            $data['list_pagonline'] = $this->load->view('pedidos/list_pedidos_pagonline', $data, TRUE);
            $data['list_producao'] = $this->load->view('pedidos/list_pedidos_producao', $data, TRUE);
            $data['list_envio'] = $this->load->view('pedidos/list_pedidos_envio', $data, TRUE);
            $data['list_entrega'] = $this->load->view('pedidos/list_pedidos_entrega', $data, TRUE);
			$data['list_pagamento'] = $this->load->view('pedidos/list_pedidos_pagamento', $data, TRUE);

			// Caso seja preciso, fiz essa mandada direta para a alteração de pedido ou status //			
			/*
			if ($data['report_combinar']->num_rows() == 1) {
				
				$info = $data['report_combinar']->result_array();
				
				redirect('Orcatrata/alteraronline/' . $info[0]['idApp_OrcaTrata'] );

				exit();
				
			} elseif ($data['report_pagonline']->num_rows() == 1){
				
				$info = $data['report_pagonline']->result_array();
				
				redirect('statuspedido/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

				exit();
				
			} elseif ($data['report_producao']->num_rows() == 1){
				
				$info = $data['report_producao']->result_array();
				
				redirect('statuspedido/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

				exit();	
				
			} elseif ($data['report_envio']->num_rows() == 1){
				
				$info = $data['report_envio']->result_array();
				
				redirect('statuspedido/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

				exit();	
				
			} elseif ($data['report_entrega']->num_rows() == 1){
				
				$info = $data['report_entrega']->result_array();
				
				redirect('statuspedido/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

				exit();	
				
			} elseif ($data['report_pagamento']->num_rows() == 1){
				
				$info = $data['report_pagamento']->result_array();
				
				redirect('statuspedido/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

				exit();
				
			} else {
				$data['list_combinar'] = $this->load->view('pedidos/list_pedidos_combinar', $data, TRUE);
				$data['list_pagonline'] = $this->load->view('pedidos/list_pedidos_pagonline', $data, TRUE);
				$data['list_producao'] = $this->load->view('pedidos/list_pedidos_producao', $data, TRUE);
				$data['list_envio'] = $this->load->view('pedidos/list_pedidos_envio', $data, TRUE);
				$data['list_entrega'] = $this->load->view('pedidos/list_pedidos_entrega', $data, TRUE);
				$data['list_pagamento'] = $this->load->view('pedidos/list_pedidos_pagamento', $data, TRUE);
			}
			*/
        }

        $this->load->view('pedidos/tela_pedidos', $data);

        $this->load->view('basico/footer');
    }
}