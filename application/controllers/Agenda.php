<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Agenda_model', 'Relatorio_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        unset($_SESSION['agenda']);

    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['select']['NomeUsuario'] = $this->Agenda_model->select_usuario();

		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'NomeUsuario',
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $_SESSION['FiltroAlteraProcedimento']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraProcedimento']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
			'N' => 'Não',
            'S' => 'Sim',
			'#' => 'TODOS',
        );

		$data['select']['Campo'] = array(
			'P.DataProcedimento' => 'Data',
			'P.ConcluidoProcedimento' => 'Concl.',
            'P.idApp_Procedimento' => 'id',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeCliente'] = $this->Agenda_model->select_cliente();
		$data['select']['Dia'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvenc'] = $this->Agenda_model->select_mes();
		
        $data['titulo1'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list1_procedimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('agenda/list1_procedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
		$data['titulo2'] = 'Procedimentos';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list2_procedimentocli($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('agenda/list2_procedimentocli', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
        $_SESSION['log']['NomeUsuario'] = ($data['query']['NomeUsuario']) ?
            $data['query']['NomeUsuario'] : FALSE;

        $data['query']['estatisticas'] = $this->Agenda_model->resumo_estatisticas($_SESSION['log']['id']);
        $data['query']['cliente_aniversariantes'] = $this->Agenda_model->cliente_aniversariantes($_SESSION['log']['id']);
        $data['query']['contatocliente_aniversariantes'] = $this->Agenda_model->contatocliente_aniversariantes($_SESSION['log']['id']);
        #$data['query']['profissional_aniversariantes'] = $this->Agenda_model->profissional_aniversariantes($_SESSION['log']['id']);
		#$data['query']['contatoprof_aniversariantes'] = $this->Agenda_model->contatoprof_aniversariantes($_SESSION['log']['id']);
		$data['query']['procedimento'] = $this->Agenda_model->procedimento($_SESSION['log']['id']);
		$data['query']['procedimentocli'] = $this->Agenda_model->procedimentocli($_SESSION['log']['id']);
		$data['query']['procedimentoorc'] = $this->Agenda_model->procedimentoorc($_SESSION['log']['id']);
	
	
		$this->load->view('agenda/tela_agenda', $data);

        #load footer view
        $this->load->view('basico/footer');
    
	}

}
