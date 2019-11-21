<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedimento extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Procedimento_model', 'Usuario_model', 'Relatorio_model', 'Formapag_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('procedimento/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('procedimento/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Procedimento',
			'Procedimento',
            'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',
			'Prioridade',
			'Compartilhar',

        ), TRUE));

		(!$data['query']['DataProcedimento']) ? $data['query']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;
		(!$data['query']['Compartilhar']) ? $data['query']['Compartilhar'] = '50' : FALSE;
		#(!$data['query']['DataProcedimentoLimite']) ? $data['query']['DataProcedimentoLimite'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');
		$this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
        #$this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');

		$data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Média',
			'3' => 'Baixa',
        );		

        #$data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		
        $data['titulo'] = 'Tarefa';
        $data['form_open_path'] = 'procedimento/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';			

		$data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('procedimento/form_procedimento', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimento', $data);
        } else {

			

            $data['query']['DataProcedimento'] = $this->basico->mascara_data2($data['query']['DataProcedimento'], 'mysql');            
			$data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			$data['query']['idApp_Cliente'] = 0;
			$data['query']['idApp_OrcaTrata'] = 0;
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Procedimento'] = $this->Procedimento_model->set_procedimento($data['query']);

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedimento', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);
				#redirect(base_url() . 'relatorio/procedimento/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($_SESSION['log']['idSis_Empresa'] != 5)
		$data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Procedimento',
			'Procedimento',
            #'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',
			'Prioridade',
			'Compartilhar', 
        ), TRUE);
		 else
        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Procedimento',
			'Procedimento',
            #'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',
			'Prioridade',
        ), TRUE);		

        if ($id) {
            $data['query'] = $this->Procedimento_model->get_procedimento($id);
            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'barras');
			$data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('Procedimento', 'Tarefa', 'required|trim');
        #$this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');

		$data['select']['Compartilhar'] = $this->Procedimento_model->select_compartilhar();
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['Prioridade'] = array (
            '1' => 'Alta',
            '2' => 'Média',
			'3' => 'Baixa',
        );		
		
        $data['titulo'] = 'Editar Tarefa';
        $data['form_open_path'] = 'procedimento/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';			

		$data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('procedimento/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimento2', $data);
        } else {


            #$data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');
            $data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			#$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];						
            $data['anterior'] = $this->Procedimento_model->get_procedimento($data['query']['idApp_Procedimento']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Procedimento'], TRUE);


			
            if ($data['auditoriaitem'] && $this->Procedimento_model->update_procedimento($data['query'], $data['query']['idApp_Procedimento']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'agenda');
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                #redirect(base_url() . 'relatorio/procedimento' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrarcli() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Cliente',
			'idApp_Procedimento',
			'Procedimento',
            'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',

        ), TRUE));

		(!$data['query']['DataProcedimento']) ? $data['query']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;
		#(!$data['query']['DataProcedimentoLimite']) ? $data['query']['DataProcedimentoLimite'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
        $this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');

		
		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();		
		
        $data['titulo'] = 'Cadastrar Procedimento';
        $data['form_open_path'] = 'procedimento/cadastrarcli';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';		

		$data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('procedimento/form_procedimentocli', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimentocli', $data);
        } else {

            $data['query']['DataProcedimento'] = $this->basico->mascara_data2($data['query']['DataProcedimento'], 'mysql');            
			$data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
			#$data['query']['idApp_Cliente'] = 0;
			$data['query']['idApp_OrcaTrata'] = 0;
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Procedimento'] = $this->Procedimento_model->set_procedimento($data['query']);

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedimentocli', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'agenda' . $data['msg']);
				#redirect(base_url() . 'relatorio/procedimento/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarcli($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Cliente',
			'idApp_Procedimento',
			'Procedimento',
            'DataProcedimento',
			'DataProcedimentoLimite',
			'ConcluidoProcedimento',

        ), TRUE);

        if ($id) {
            $data['query'] = $this->Procedimento_model->get_procedimento($id);
            $data['query']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'barras');
			$data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Procedimento', 'Nome do Responsável', 'required|trim|is_unique_duplo[App_Procedimento.Procedimento.DataProcedimento.' . $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql') . ']');

        $this->form_validation->set_rules('DataProcedimento', 'Data do Procedimento', 'trim|valid_date');


		$data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();		
		
        $data['titulo'] = 'Editar Procedimento';
        $data['form_open_path'] = 'procedimento/alterarcli';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		
		$data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('procedimento/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedimentocli', $data);
        } else {


            $data['query']['DataProcedimento'] = $this->basico->mascara_data2($data['query']['DataProcedimento'], 'mysql');
            $data['query']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['query']['DataProcedimentoLimite'], 'mysql');
			$data['query']['Procedimento'] = nl2br($data['query']['Procedimento']);
			#$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
						
            $data['anterior'] = $this->Procedimento_model->get_procedimento($data['query']['idApp_Procedimento']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Procedimento'], TRUE);

            if ($data['auditoriaitem'] && $this->Procedimento_model->update_procedimento($data['query'], $data['query']['idApp_Procedimento']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'procedimento/form_procedimentocli/' . $data['query']['idApp_Procedimento'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                #redirect(base_url() . 'relatorio/procedimento' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Procedimento_model->delete_procedimento($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'agenda' . $data['msg']);
		#redirect(base_url() . 'relatorio/procedimento' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

    public function cadastrarproc($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            'idApp_Procedimento',
            'idApp_Cliente',
            'DataProcedimento',
			'DataProcedimentoLimite',
			'Procedimento',
			'ConcluidoProcedimento',

        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        //Data de hoje como default
        (!$data['orcatrata']['DataProcedimento']) ? $data['orcatrata']['DataProcedimento'] = date('d/m/Y H:i:s', time()) : FALSE;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');


        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();

        $data['titulo'] = 'Cadastar Procedimento com Cliente';
        $data['form_open_path'] = 'procedimento/cadastrarproc';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

		/*
        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

		*/
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';	
		
	/*
        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

	*/
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('procedimento/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            $data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data2($data['orcatrata']['DataProcedimento'], 'mysql');
			$data['orcatrata']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimentoLimite'], 'mysql');
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['orcatrata']['idApp_Procedimento'] = $this->Procedimento_model->set_orcatrata($data['orcatrata']);

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_Procedimento'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterarproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_Procedimento ####
            #'idSis_Usuario',
			'idApp_Procedimento',
            #Não há a necessidade de atualizar o valor do campo a seguir
            #'idApp_Cliente',
            #'DataProcedimento',
			'DataProcedimentoLimite',
			'Procedimento',
			'ConcluidoProcedimento',

        ), TRUE));


        if ($id) {
            #### App_Procedimento ####
            $data['orcatrata'] = $this->Procedimento_model->get_orcatrata($id);
            #$data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'barras');
			$data['orcatrata']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimentoLimite'], 'barras');
            #### Carrega os dados do cliente nas variáves de sessão ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			#$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_Procedimento ####
        $this->form_validation->set_rules('Procedimento', 'Procedimento', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
        $data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();

        $data['titulo'] = 'Editar Procedimento com Cliente';
        $data['form_open_path'] = 'procedimento/alterarproc';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

    /*
		//if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

	*/
		$data['collapse'] = '';
	
		$data['collapse1'] = 'class="collapse"';
	/*	
        #Ver uma solução melhor para este campo
        (!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;

        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
	*/

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('procedimento/form_procedcli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_Procedimento ####
            #$data['orcatrata']['DataProcedimento'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimento'], 'mysql');
			$data['orcatrata']['DataProcedimentoLimite'] = $this->basico->mascara_data($data['orcatrata']['DataProcedimentoLimite'], 'mysql');
			#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            #$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['id'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['update']['orcatrata']['anterior'] = $this->Procedimento_model->get_orcatrata($data['orcatrata']['idApp_Procedimento']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_Procedimento'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Procedimento_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_Procedimento']);


/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_Procedimento'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('procedimento/form_procedcli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Procedimento'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Procedimento', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function excluirproc($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Procedimento_model->delete_orcatrata($id);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'procedimento/listarproc/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
                exit();

        $this->load->view('basico/footer');
    }

    public function listarproc($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['OrcaTrata'] = $this->Procedimento_model->get_cliente($id, TRUE);
        //$_SESSION['OrcaTrata']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Procedimento_model->list_orcamento($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Procedimento_model->list_orcamento($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('procedimento/list_procedcli', $data, TRUE);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('procedimento/list_procedcli', $data);

        $this->load->view('basico/footer');
    }
	
}
