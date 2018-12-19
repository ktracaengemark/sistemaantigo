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

		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'NomeUsuario',
			'NomeCliente',
			'NomeEmpresa',
			'NomeEmpresaCli',
			'Dia',
			'Mesvenc',
			'Ano',
			'Diacli',
			'Mesvenccli',
			'Anocli',
			'Diaemp',
			'Mesvencemp',
			'Anoemp',			
			'ConcluidoProcedimento',
			'Concluidocli',
			'Concluidoemp',			
            'Ordenamento',
            'Campo',
			'Prioridade',
			'Procedimento',
        ), TRUE));

        $_SESSION['FiltroAlteraProcedimento']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraProcedimento']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraProcedimento']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
        $_SESSION['FiltroAlteraProcedimento']['Prioridade'] = $data['query']['Prioridade'];
		$_SESSION['FiltroAlteraProcedimento']['Procedimento'] = $data['query']['Procedimento'];
		$_SESSION['FiltroAlteraProcedimento']['Diacli'] = $data['query']['Diacli'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvenccli'] = $data['query']['Mesvenccli'];
        $_SESSION['FiltroAlteraProcedimento']['Anocli'] = $data['query']['Anocli'];		
		$_SESSION['FiltroAlteraProcedimento']['Concluidocli'] = $data['query']['Concluidocli'];
		$_SESSION['FiltroAlteraProcedimento']['NomeCliente'] = $data['query']['NomeCliente'];		
        $_SESSION['FiltroAlteraProcedimento']['Diaemp'] = $data['query']['Diaemp'];
        $_SESSION['FiltroAlteraProcedimento']['Mesvencemp'] = $data['query']['Mesvencemp'];
        $_SESSION['FiltroAlteraProcedimento']['Anoemp'] = $data['query']['Anoemp'];		
		$_SESSION['FiltroAlteraProcedimento']['Concluidoemp'] = $data['query']['Concluidoemp'];			
		$_SESSION['FiltroAlteraProcedimento']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
		$_SESSION['FiltroAlteraProcedimento']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
        $_SESSION['log']['NomeUsuario'] = ($data['query']['NomeUsuario']) ? $data['query']['NomeUsuario'] : FALSE;
        
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'Não',
        );
		
        $data['select']['Concluidocli'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'Não',
        );

        $data['select']['Concluidoemp'] = array(
			'0' => 'TODOS',
			'S' => 'Sim',
			'N' => 'Não',
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
		
        $data['select']['Prioridade'] = array (
            '0' => 'TODOS',
			'1' => 'Alta',
            '2' => 'Média',
			'3' => 'Baixa',
        );		

        
		$data['select']['Dia'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvenc'] = $this->Agenda_model->select_mes();
		$data['select']['Diacli'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvenccli'] = $this->Agenda_model->select_mes();
		$data['select']['Diaemp'] = $this->Agenda_model->select_dia();
		$data['select']['Mesvencemp'] = $this->Agenda_model->select_mes();		
		$data['select']['NomeCliente'] = $this->Agenda_model->select_cliente();
		$data['select']['NomeEmpresa'] = $this->Agenda_model->select_empresarec();
		$data['select']['NomeEmpresaCli'] = $this->Agenda_model->select_empresaenv();
        $data['select']['NomeUsuario'] = $this->Agenda_model->select_usuario();
		$data['select']['Procedimento'] = $this->Agenda_model->select_procedimento();
		
        $data['titulo1'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['Procedimento'] = $data['query']['Procedimento'];

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
		
		$data['titulo2'] = 'Clientes';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Diacli'] = $data['query']['Diacli'];
			$data['bd']['Mesvenccli'] = $data['query']['Mesvenccli'];
			$data['bd']['Anocli'] = $data['query']['Anocli'];
			$data['bd']['Concluidocli'] = $data['query']['Concluidocli'];
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
		
		$data['titulo3'] = 'Mens. Env.';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
			$data['bd']['Diaemp'] = $data['query']['Diaemp'];
			$data['bd']['Mesvencemp'] = $data['query']['Mesvencemp'];
			$data['bd']['Anoemp'] = $data['query']['Ano'];
			$data['bd']['Concluidoemp'] = $data['query']['Concluidoemp'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list3_mensagemenv($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list3'] = $this->load->view('agenda/list3_mensagemenv', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

		$data['titulo4'] = 'Mens. Rec.';

        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['NomeEmpresaCli'] = $data['query']['NomeEmpresaCli'];
			$data['bd']['Diaemp'] = $data['query']['Diaemp'];
			$data['bd']['Mesvencemp'] = $data['query']['Mesvencemp'];
			$data['bd']['Anoemp'] = $data['query']['Ano'];
			$data['bd']['Concluidoemp'] = $data['query']['Concluidoemp'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Agenda_model->list4_mensagemrec($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list4'] = $this->load->view('agenda/list4_mensagemrec', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		
		

        $data['query']['estatisticas'] = $this->Agenda_model->resumo_estatisticas($_SESSION['log']['id']);
        $data['query']['cliente_aniversariantes'] = $this->Agenda_model->cliente_aniversariantes($_SESSION['log']['id']);
        $data['query']['contatocliente_aniversariantes'] = $this->Agenda_model->contatocliente_aniversariantes($_SESSION['log']['id']);
        #$data['query']['profissional_aniversariantes'] = $this->Agenda_model->profissional_aniversariantes($_SESSION['log']['id']);
		#$data['query']['contatoprof_aniversariantes'] = $this->Agenda_model->contatoprof_aniversariantes($_SESSION['log']['id']);
		$data['query']['procedimento'] = $this->Agenda_model->procedimento($_SESSION['log']['id']);
		$data['query']['procedempresa'] = $this->Agenda_model->procedempresa($_SESSION['log']['id']);
		$data['query']['procedimentorec'] = $this->Agenda_model->procedimentorec($_SESSION['log']['id']);
	
	
		$this->load->view('agenda/tela_agenda', $data);

        #load footer view
        $this->load->view('basico/footer');
    
	}

}
