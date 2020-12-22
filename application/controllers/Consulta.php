<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Consulta extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Consulta_model', 'Empresafilial_model', 'Cliente_model', 'Agenda_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('consulta/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
			'idSis_EmpresaFilial',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE));
		
		/*
        if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Clienteusuario_model->get_clienteusuario($idApp_Cliente, TRUE);
        }
		
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
        }
		
        if ($idApp_ContatoCliente) {
            $data['query']['idApp_ContatoCliente'] = $idApp_ContatoCliente;
            $data['query']['Paciente'] = 'D';
        }
		
        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }
		*/
		if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }
		
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
		
/*
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
*/
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
		#$data['resumo'] = $this->Clienteusuario_model->get_clienteusuario($data['query']['idApp_Cliente']);
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		#$data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
/*
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );
*/
        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta', $data);
        } else {

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			
			$data['query']['Tipo'] = 2;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            #$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
            //$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar1($idApp_Cliente = NULL, $idApp_ContatoCliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Empresa',
			'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
            'Data',
            'Data2',
			'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE));

        /*
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
		}
		*/
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}

        if ($idApp_ContatoCliente) {
            $data['query']['idApp_ContatoCliente'] = $idApp_ContatoCliente;
            $data['query']['Paciente'] = 'D';
        }

        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }

        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data do Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');


        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');

        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa3();
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );

        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar1';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta1', $data);
        } else {

			$data['query']['Tipo'] = 2;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            #$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			//$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta1', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function cadastrar2($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'idApp_Cliente',
			#'idSis_EmpresaFilial',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Paciente',
			'idTab_Status',
            'idTab_TipoConsulta',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
                ), TRUE));

		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
		}
/*
        if ($idApp_ContatoCliente) {
            $data['query']['idApp_ContatoCliente'] = $idApp_ContatoCliente;
            $data['query']['Paciente'] = 'D';
        }

        if (isset($_SESSION['agenda']) && !$data['query']['HoraInicio'] && !$data['query']['HoraFim']) {
            $data['query']['Data'] = date('d/m/Y', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraInicio'] = date('H:i', $_SESSION['agenda']['HoraInicio']);
            $data['query']['HoraFim'] = date('H:i', $_SESSION['agenda']['HoraFim']);
        }
*/		
		if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }
		
        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
/*
        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');

        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
*/
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		
        #echo $data['query']['idApp_Agenda'] . ' ' . $_SESSION['log']['idSis_Usuario'];
        #$data['query']['idApp_Agenda'] = ($_SESSION['log']['Permissao'] > 2) ? $_SESSION['log']['idSis_Usuario'] : FALSE;

        /*
        echo count($data['select']['idApp_Agenda']);
        echo '<br>';
        echo "<pre>";
        print_r($data['select']['idApp_Agenda']);
        echo "</pre>";
        #exit();
        */

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
/*
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );
*/
        $data['titulo'] = 'Agendamento';
        $data['form_open_path'] = 'consulta/cadastrar2';
        $data['panel'] = 'primary';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['metodo'] = 1;

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta2', $data);
        } else {

			$data['query']['Tipo'] = 2;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            //$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            unset($_SESSION['Agenda']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta2', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($idApp_Cliente = NULL, $idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));

        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            #'idApp_Agenda',
            'idApp_Cliente',
            'Data',
            'Data2',
			'HoraInicio',
            'HoraFim',
            'idTab_Status',
            'Paciente',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
			'idTab_TipoConsulta',
                ), TRUE);

        /*
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
		}
		*/
		
        if ($idApp_Consulta) {
            #$data['query']['idApp_Cliente'] = $idApp_Cliente;
            $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['Data2'] = $this->basico->mascara_data($datafim[0], 'barras');
			$data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }
        else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }


        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        #echo $data['query']['DataInicio'];
        #$data['query']['idApp_Agenda'] = 1;


        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');	

        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');
	
        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();	
		$data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa4();
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );

        #$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
		
		if ($_SESSION['log']['idSis_Empresa'] == 5) {
			$data['resumo1'] = $this->Agenda_model->get_agenda($data['query']['idApp_Agenda']);
			$_SESSION['Agenda']['Nome'] = (strlen($data['resumo1']['Nome']) > 30) ? substr($data['resumo1']['Nome'], 0, 30) : $data['resumo1']['Nome'];
			$_SESSION['Agenda']['NomeEmpresa'] = (strlen($data['resumo1']['NomeEmpresa']) > 30) ? substr($data['resumo1']['NomeEmpresa'], 0, 30) : $data['resumo1']['NomeEmpresa'];
		}		
		
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
			#$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 30) ? substr($data['resumo']['NomeCliente'], 0, 30) : $data['resumo']['NomeCliente'];
		
		
		
		}
        //echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];

        $data['titulo'] = 'Editar Agendamento';
        $data['form_open_path'] = 'consulta/alterar';
        #$data['readonly'] = '';
        #$data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            if ($_SESSION['log']['idSis_Empresa'] == 5) {
				$this->load->view('consulta/form_consulta0', $data);
			} else {
				$this->load->view('consulta/form_consulta', $data);
			}	
        } else {

            #echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];
            #exit();
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			
            $data['query']['Tipo'] = 2;
			$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            #$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            unset($_SESSION['Agenda']);

            if ($data['auditoriaitem'] && $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar2($idApp_Cliente = FALSE, $idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            #'idApp_Agenda',
            'idApp_Cliente',
            'Data',
            'Data2',
			'HoraInicio',
            'HoraFim',
            'idTab_Status',
            'Paciente',
            'idApp_ContatoCliente',
            'idApp_Profissional',
            'Procedimento',
            'Obs',
			'idTab_TipoConsulta',
                ), TRUE);

        /*
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
		}
		*/
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}

        if ($idApp_Consulta) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
            $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['Data2'] = $this->basico->mascara_data($datafim[0], 'barras');
			$data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }
        else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }


        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        #echo $data['query']['DataInicio'];
        #$data['query']['idApp_Agenda'] = 1;


        #Ver uma solução melhor para este campo
        (!$data['query']['Paciente']) ? $data['query']['Paciente'] = 'R' : FALSE;

        $data['radio'] = array(
            'Paciente' => $this->basico->radio_checked($data['query']['Paciente'], 'Paciente', 'RD'),
        );

        ($data['query']['Paciente'] == 'D') ?
            $data['div']['Paciente'] = '' : $data['div']['Paciente'] = 'style="display: none;"';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
        #$this->form_validation->set_rules('idTab_TipoConsulta', 'Tipo de Consulta', 'required|trim');
        #$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Profissional', 'required|trim');
		#$this->form_validation->set_rules('idSis_EmpresaFilial', 'Unidade', 'required|trim');


        if ($data['query']['Paciente'] == 'D')
            $this->form_validation->set_rules('idApp_ContatoCliente', 'ContatoCliente', 'required|trim');

		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
        $data['select']['Status'] = $this->Basico_model->select_status();
        $data['select']['TipoConsulta'] = $this->Basico_model->select_tipo_consulta();
        $data['select']['ContatoCliente'] = $this->Consulta_model->select_contatocliente_cliente($data['query']['idApp_Cliente']);
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa4();
		
        $data['select']['Paciente'] = array (
            'R' => 'O Próprio',
            'D' => 'ContatoCliente',
        );

        $data['resumo'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);

        //echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];

        $data['titulo'] = 'Editar Agendamento';
        $data['form_open_path'] = 'consulta/alterar';
        #$data['readonly'] = '';
        #$data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_consulta2', $data);
        } else {

            #echo '<br><br><br><br>================================== '.$data['query']['idTab_Status'];
            #exit();

            $data['query']['Tipo'] = 2;
			$data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            #$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            #unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            unset($_SESSION['Agenda']);

            if ($data['auditoriaitem'] && $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function listar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($idApp_Cliente) {
            $data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
            $_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
		$data['titulo'] = 'Agenda : ';
        $data['panel'] = 'primary';
        $data['novo'] = '';
        $data['metodo'] = 4;

        $data['query'] = array();
        $data['proxima'] = $this->Consulta_model->lista_consulta_proxima($idApp_Cliente);
        $data['anterior'] = $this->Consulta_model->lista_consulta_anterior($idApp_Cliente);

        #$data['tela'] = $this->load->view('consulta/list_consulta', $data, TRUE);
        #$data['resumo'] = $this->Cliente_model->get_cliente($data['Cliente']['idApp_Cliente']);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('consulta/list_consulta', $data);

        $this->load->view('basico/footer');
    }

    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
        ), TRUE));		

		if (!$id) {
            $data['msg'] = '?m=2';
            redirect(base_url() . 'agenda' . $data['msg']);
        } else {

            $data['anterior'] = $this->Consulta_model->get_consulta($id);
			
			$repeticao = $data['anterior']['Repeticao'];
			$quais = $data['alterar']['Quais'];
			$dataini = $data['anterior']['DataInicio'];
			
            $data['campos'] = array_keys($data['anterior']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['anterior']['idApp_Consulta'], FALSE, TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'DELETE', $data['auditoriaitem']);

            $this->Consulta_model->delete_consulta($id, $repeticao, $quais, $dataini);

            $data['msg'] = '?m=1';

            redirect(base_url() . 'agenda' . $data['msg']);
            exit();
        }

        $this->load->view('basico/footer');
    }

    /*
     * Cadastrar/Alterar Eventos
     */

    public function cadastrar_evento($idApp_Cliente = NULL, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'Repetir',
			'Prazo',
			'DataMinima',
        ), TRUE));
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Usuario',
			'idApp_Consulta',
			'idApp_Agenda',
			'idApp_Cliente',
			#'idSis_EmpresaFilial',
			'Data',
			'Data2',
			'HoraInicio',
			'HoraFim',
			'Evento',
			'Obs',
			'idApp_Profissional',
			'idTab_Status',
			'Intervalo',
			'Periodo',
			'Tempo',
			'Tempo2',
			'DataTermino',
			'Recorrencias',
		), TRUE));
		
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'N' : FALSE;
 		(!$data['cadastrar']['Repetir']) ? $data['cadastrar']['Repetir'] = 'N' : FALSE;
		//(!$data['query']['Intervalo']) ? $data['query']['Intervalo'] = '1' : FALSE;
		//(!$data['query']['Periodo']) ? $data['query']['Periodo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo'] = '1' : FALSE;
		(!$data['query']['Tempo']) ? $data['query']['Tempo2'] = '1' : FALSE;

        if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['Data2'] = date('d/m/Y', substr($this->input->get('end'), 0, -3));
			$data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

		$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
		$data2 = $data2->format('Y-m-d');		
		/*
			echo '<br>';
			echo "<pre>";
			print_r($data1);
			echo '<br>';
			print_r($data2);
			echo "</pre>";
			exit();		
		*/
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
		$this->form_validation->set_rules('Prazo', 'Prazo', 'trim|valid_prazo');
        $this->form_validation->set_rules('Data', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        if(strtotime($data2) == strtotime($data1)){
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		}else{
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
		}
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
        
		if ($data['cadastrar']['Repetir'] == 'S') {
			$this->form_validation->set_rules('Intervalo', 'Intervalo', 'required|trim|valid_intervalo');
			$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo');
			//$this->form_validation->set_rules('Periodo', 'Período', 'required|trim|valid_periodo|valid_periodo_intervalo[' . $data['query']['Intervalo'] . ']');
			$this->form_validation->set_rules('Tempo', 'Tempo', 'required|trim');
			$this->form_validation->set_rules('Tempo', 'Tempo2', 'required|trim');
			$this->form_validation->set_rules('DataMinima', 'Data Mínima:', 'trim|valid_date');
			$this->form_validation->set_rules('DataTermino', 'Termina em:', 'required|trim|valid_date|valid_data_termino[' . $data['cadastrar']['DataMinima'] . ']|valid_data_termino2[' . $data['query']['Data'] . ']');
		}
		
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
		$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Repetir'] = $this->Basico_model->select_status_sn();        
		$data['select']['Tempo'] = array (
            '1' => 'Dia(s)',
            '2' => 'Semana(s)',
            '3' => 'Mês(s)',
			'4' => 'Ano(s)',
        );
        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Evento';
        $data['form_open_path'] = 'consulta/cadastrar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 1;

        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'S') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		

		$data['radio'] = array(
            'Repetir' => $this->basico->radio_checked($data['cadastrar']['Repetir'], 'Repetir', 'NS'),
        );
        ($data['cadastrar']['Repetir'] == 'S') ?
            $data['div']['Repetir'] = '' : $data['div']['Repetir'] = 'style="display: none;"';
			
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_evento', $data);
        } else {
		
			$dataini_cad 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
			$datafim_cad 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
			$horaini_cad 	= $data['query']['HoraInicio'];
			$horafim_cad 	= $data['query']['HoraFim'];
			
			if ($data['cadastrar']['Repetir'] == 'N') {
				$data['query']['Intervalo'] = 0;
				$data['query']['Periodo'] = 0;
				$data['query']['Tempo'] = 0;
				$data['query']['Tempo2'] = 0;
				$data['query']['DataTermino'] = "0000-00-00";
			}else{
				
				$tipointervalo = $data['query']['Tempo'];
				if($tipointervalo == 1){
					$semana = 1;
					$ref = "day";
				}elseif($tipointervalo == 2){
					$semana = 7;
					$ref = "day";
				}elseif($tipointervalo == 3){
					$semana = 1;
					$ref = "month";
				}elseif($tipointervalo == 4){
					$semana = 1;
					$ref = "Year";
				}
				
				$tipoperiodo = $data['query']['Tempo2'];
				if($tipoperiodo == 1){
					$semana2 = 1;
					$ref2 = "day";
				}elseif($tipoperiodo == 2){
					$semana2 = 7;
					$ref2 = "day";
				}elseif($tipoperiodo == 3){
					$semana2 = 1;
					$ref2 = "month";
				}elseif($tipoperiodo == 4){
					$semana2 = 1;
					$ref2 = "Year";
				}
				
				$n = $data['query']['Intervalo']; //intervalo - a cada tantos dias
				$periodo = $data['query']['Periodo']; //período das repetições - durante tantos dias
				
				$qtd = $data['query']['Recorrencias'];
				$primeiraocorrencia = date('Y-m-d', strtotime('+ ' . ($semana*$n) .  $ref,strtotime($dataini_cad)));
				$ultimaocorrencia = date('Y-m-d', strtotime('+ ' . ($semana*$n*($qtd - 1)) .  $ref,strtotime($dataini_cad)));				
				
			}
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['cadastrar']['Repetir']);
			echo '<br>';
			print_r($qtd);
			echo '<br>';
			print_r($primeiraocorrencia);
			echo '<br>';
			print_r($ultimaocorrencia);
			echo "</pre>";
			exit();
			*/
			$data['query']['Tipo'] = 1;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			//$data['query']['idTab_Status'] = 1;
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
			
			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

				$data['copiar']['Repeticao'] = $data['idApp_Consulta'];
				if($data['cadastrar']['Repetir'] == 'S'){
					$data['copiar']['DataTermino'] = $ultimaocorrencia;
					$data['copiar']['Recorrencias'] = "1/" . $qtd;
				}else{
					$data['copiar']['Recorrencias'] = "1/1";
					$data['copiar']['DataTermino'] = $dataini_cad;
				}
				
				$data['update']['copiar']['bd'] = $this->Consulta_model->update_consulta($data['copiar'], $data['idApp_Consulta']);
				
				if ($data['update']['copiar']['bd'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

					$this->basico->erro($msg);
					$this->load->view('consulta/form_consulta', $data);
				} else {
					if ($data['cadastrar']['Repetir'] == 'S') {
						for($j=1; $j<$qtd; $j++) {
							$data['repeticao'][$j] = array(
								'Repeticao' 			=> $data['idApp_Consulta'],
								'Intervalo' 			=> $data['query']['Intervalo'],
								'Periodo' 				=> $data['query']['Periodo'],
								'Tempo' 				=> $data['query']['Tempo'],
								'Tempo2' 				=> $data['query']['Tempo2'],
								'DataTermino' 			=> $ultimaocorrencia,
								//'DataTermino' 			=> $data['query']['DataTermino'],
								'Recorrencias' 			=> ($j + 1) .  '/' . $data['query']['Recorrencias'],
								'idApp_Agenda' 			=> $data['query']['idApp_Agenda'],
								'idApp_Cliente' 		=> $data['query']['idApp_Cliente'],
								'Evento' 				=> $data['query']['Evento'],
								'Obs' 					=> $data['query']['Obs'],
								'idApp_Profissional' 	=> $data['query']['idApp_Profissional'],
								'idTab_Status' 			=> $data['query']['idTab_Status'],
								'Tipo' 					=> 1,
								'DataInicio' 			=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) .  $ref,strtotime($dataini_cad))) . ' ' . $horaini_cad,
								'DataFim' 				=> date('Y-m-d', strtotime('+ ' . ($semana*$n*$j) . $ref,strtotime($datafim_cad))) . ' ' . $horafim_cad,
								'idSis_Usuario' 		=> $_SESSION['log']['idSis_Usuario'],
								'idSis_Empresa' 		=> $_SESSION['log']['idSis_Empresa'],
								'idTab_Modulo' 			=> $_SESSION['log']['idTab_Modulo']
							);
							$data['campos'] = array_keys($data['repeticao'][$j]);
							$data['id_Repeticao'] = $this->Consulta_model->set_consulta($data['repeticao'][$j]);
						}
				
					}
			
					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
					$data['msg'] = '?m=1';
					
					redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
					exit();
				}	
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_evento($idApp_Consulta = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['alterar'] = quotes_to_entities($this->input->post(array(
			'Quais',
        ), TRUE));
		
        $data['query'] = $this->input->post(array(
            #'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
			#'idSis_EmpresaFilial',
            'Data2',
			'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			'idApp_Profissional',
			'idTab_Status',
                ), TRUE);

 		(!$data['alterar']['Quais']) ? $data['alterar']['Quais'] = 1 : FALSE;
		
        if ($idApp_Consulta) {
            $_SESSION['Consulta'] = $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);
			$_SESSION['Consulta']['Repeticao'] = $repeticao = $data['query']['Repeticao'];
            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);
            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['Data2'] = $this->basico->mascara_data($datafim[0], 'barras');
			$data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
			$_SESSION['Consulta']['DataInicio'] = $dataini[0];
            $_SESSION['Consulta']['DataFim'] = $datafim[0];
        }
		else {
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
        }
			
        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

		$data1 = DateTime::createFromFormat('d/m/Y', $data['query']['Data']);
		$data1 = $data1->format('Y-m-d');       
		$data2 = DateTime::createFromFormat('d/m/Y', $data['query']['Data2']);
		$data2 = $data2->format('Y-m-d');		
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('Data2', 'Data Fim', 'required|trim|valid_date|valid_periodo_data[' . $data['query']['Data'] . ']');
		$this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        if(strtotime($data2) == strtotime($data1)){
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		}else{
			$this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour');
		}
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');

		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		#$data['select']['idSis_EmpresaFilial'] = $this->Empresafilial_model->select_empresafilial();
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
		$data['select']['Status'] = $this->Basico_model->select_status();
		
		$data['select']['Quais'] = array (
            '1' => 'Apenas Este',
            '2' => 'Este e os Anteriores',
			'3' => 'Este e os Posteriores',
			'4' => 'Todas',
        );
				
        $data['titulo'] = 'Editar Evento';
        $data['form_open_path'] = 'consulta/alterar_evento';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_evento', $data);
        } else {

			$data['query']['Tipo'] = 1;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data2'], 'mysql') . ' ' . $data['query']['HoraFim'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            
			$dataanteriorinicio = strtotime($_SESSION['Consulta']['DataInicio']);
			$dataanteriorfim = strtotime($_SESSION['Consulta']['DataFim']);
			
			$dataposteriorinicio = strtotime($data1);
			$dataposteriorfim = strtotime($data2);
			
			$diferencainicio = ($dataposteriorinicio - $dataanteriorinicio)/86400;
			$diferencafim = ($dataposteriorfim - $dataanteriorfim)/86400;
			
			if($diferencainicio < 0){
				$difinicio = $diferencainicio;
			}else{
				$difinicio = '+' . $diferencainicio;
			}
			
			if($diferencafim < 0){
				$diffim = $diferencafim;
			}else{
				$diffim = '+' . $diferencafim;
			}
			
			$dataini_alt 	= $this->basico->mascara_data($data['query']['Data'], 'mysql');
			$datafim_alt 	= $this->basico->mascara_data($data['query']['Data2'], 'mysql');
			$horaini_alt 	= $data['query']['HoraInicio'];
			$horafim_alt 	= $data['query']['HoraFim'];			

			unset($data['query']['Data'], $data['query']['Data2'], $data['query']['HoraInicio'], $data['query']['HoraFim']);
			
            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);
			$data['update']['query']['bd'] = $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']);	

			$_SESSION['Repeticao'] = $data['repeticao'] = $this->Consulta_model->get_consulta_posterior($data['query']['idApp_Consulta'], $_SESSION['Consulta']['Repeticao'], $data['alterar']['Quais'], $dataini_alt);
			if (count($data['repeticao']) > 0) {
				$data['repeticao'] = array_combine(range(1, count($data['repeticao'])), array_values($data['repeticao']));
                $max = count($data['repeticao']);
				if (isset($data['repeticao'])) {
					for($j=1; $j <= $max; $j++) {
						//pego a data original, de cada linha, e somo a diferença
						$datainicial[$j] 								= explode(' ', $data['repeticao'][$j]['DataInicio']);
						$datafinal[$j] 									= explode(' ', $data['repeticao'][$j]['DataFim']);
						$dataoriginalinicio[$j] 						= $datainicial[$j][0];
						$dataoriginalfim[$j] 							= $datafinal[$j][0];
						$dataatualinicio[$j] 							= date('Y-m-d', strtotime($difinicio  .  'day',strtotime($dataoriginalinicio[$j])));
						$dataatualfim[$j] 								= date('Y-m-d', strtotime($diffim  .  'day',strtotime($dataoriginalfim[$j])));
						if($data['repeticao'][$j]['idApp_Consulta'] != $data['query']['idApp_Consulta']){
							$data['repeticao'][$j]['DataInicio'] 		= $dataatualinicio[$j] . ' ' . $horaini_alt;
							$data['repeticao'][$j]['DataFim'] 			= $dataatualfim[$j] . ' ' . $horafim_alt;
						}
						$data['repeticao'][$j]['idApp_Agenda'] 			= $data['query']['idApp_Agenda'];
						//$data['repeticao'][$j]['idApp_Cliente'] 		= $data['query']['idApp_Cliente'];
						$data['repeticao'][$j]['Obs'] 					= $data['query']['Obs'];
						$data['repeticao'][$j]['idApp_Profissional'] 	= $data['query']['idApp_Profissional'];
						$data['repeticao'][$j]['idTab_Status'] 			= $data['query']['idTab_Status'];
						
						$data['update']['repeticao'][$j]['bd'] 			= $this->Consulta_model->update_consulta($data['repeticao'][$j], $data['repeticao'][$j]['idApp_Consulta']);
					}
				}
			}
			
            if ($data['auditoriaitem'] && $data['update']['query']['bd'] === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
			
        }

        $this->load->view('basico/footer');
    }

	public function cadastrar_particular($idApp_Cliente = NULL, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
                    'idSis_Usuario',
					'idApp_Consulta',
                    'idApp_Agenda',
                    'Data',
                    'HoraInicio',
                    'HoraFim',
                    'Evento',
                    'Obs',
					'idApp_Profissional',
                        ), TRUE));

        if ($this->input->get('start') && $this->input->get('end')) {
            $data['query']['Data'] = date('d/m/Y', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraInicio'] = date('H:i', substr($this->input->get('start'), 0, -3));
            $data['query']['HoraFim'] = date('H:i', substr($this->input->get('end'), 0, -3));
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');

        $data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();

        $data['select']['option'] = ($_SESSION['log']['idSis_Empresa'] != 5 && $_SESSION['log']['Permissao'] <= 2 ) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

		$data['titulo'] = 'Agenda Particular';
        $data['form_open_path'] = 'consulta/cadastrar_particular';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['evento'] = 3;

        $data['readonly'] = '';
        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_particular', $data);
        } else {

			$data['query']['Tipo'] = 3;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_Consulta'] = $this->Consulta_model->set_consulta($data['query']);

            if ($data['idApp_Consulta'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('consulta/form_consulta', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Consulta'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'cliente/prontuario/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar_particular($idApp_Consulta = FALSE, $idApp_Agenda = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Usuario',
			'idApp_Consulta',
            'idApp_Agenda',
            'Data',
            'HoraInicio',
            'HoraFim',
            'Evento',
            'Obs',
			'idApp_Profissional',
                ), TRUE);


        if ($idApp_Consulta) {
            $data['query'] = $this->Consulta_model->get_consulta($idApp_Consulta);

            $dataini = explode(' ', $data['query']['DataInicio']);
            $datafim = explode(' ', $data['query']['DataFim']);

            $data['query']['Data'] = $this->basico->mascara_data($dataini[0], 'barras');
            $data['query']['HoraInicio'] = substr($dataini[1], 0, 5);
            $data['query']['HoraFim'] = substr($datafim[1], 0, 5);
        }

        if ($data['query']['DataFim'] < date('Y-m-d H:i:s', time())) {
            #$data['readonly'] = 'readonly';
            $data['readonly'] = '';
            $data['datepicker'] = '';
            $data['timepicker'] = '';
        } else {
            $data['readonly'] = '';
            $data['datepicker'] = 'DatePicker';
            $data['timepicker'] = 'TimePicker';
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Data', 'Data', 'required|trim|valid_date');
        $this->form_validation->set_rules('HoraInicio', 'Hora Inicial', 'required|trim|valid_hour');
        $this->form_validation->set_rules('HoraFim', 'Hora Final', 'required|trim|valid_hour|valid_periodo_hora[' . $data['query']['HoraInicio'] . ']');
		#$this->form_validation->set_rules('idApp_Profissional', 'Profissional', 'required|trim');
		$this->form_validation->set_rules('idApp_Agenda', 'Agenda do Profissional', 'required|trim');
		$data['select']['idApp_Agenda'] = $this->Basico_model->select_agenda();
        $data['titulo'] = 'Agenda Particular';
        $data['form_open_path'] = 'consulta/alterar_particular';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['evento'] = 1;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('consulta/form_particular', $data);
        } else {

			$data['query']['Tipo'] = 3;
            $data['query']['DataInicio'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraInicio'];
            $data['query']['DataFim'] = $this->basico->mascara_data($data['query']['Data'], 'mysql') . ' ' . $data['query']['HoraFim'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['redirect'] = '&gtd=' . $this->basico->mascara_data($data['query']['Data'], 'mysql');
            //exit();

            unset($data['query']['Data'], $data['query']['HoraInicio'], $data['query']['HoraFim']);

            $data['anterior'] = $this->Consulta_model->get_consulta($data['query']['idApp_Consulta']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Consulta'], TRUE);

            if ($data['auditoriaitem'] && $this->Consulta_model->update_consulta($data['query'], $data['query']['idApp_Consulta']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Consulta'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Consulta', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'consulta/listar/' . $data['query']['idApp_Cliente'] . $data['msg'] . $data['redirect']);
                redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

}
