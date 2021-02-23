<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientepet extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Clientepet_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('clientepet/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('clientepet/tela_index', $data);

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
            'idApp_ClientePet',
            'idApp_Cliente',
            'idSis_Usuario',
            'NomeClientePet',
            'StatusVidaPet',
            'DataNascimentoPet',
			'AtivoPet',
            'SexoPet',
            'EspeciePet',
            'RacaPet',
            'PeloPet',
            'CorPet',
            'ObsPet',
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVidaPet']='V';

		$data['select']['SexoPet'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaPet'] = $this->Clientepet_model->select_status_vida();
		$data['select']['AtivoPet'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Contatos e Responsáveis';
        $data['form_open_path'] = 'clientepet/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('NomeClientePet', 'Nome do Pet', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoPet', 'Data de Nascimento', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientepet/form_clientepet', $data);
        } else {

            $data['query']['NomeClientePet'] = trim(mb_strtoupper($data['query']['NomeClientePet'], 'ISO-8859-1'));
            $data['query']['DataNascimentoPet'] = $this->basico->mascara_data($data['query']['DataNascimentoPet'], 'mysql');
            $data['query']['ObsPet'] = trim(mb_strtoupper($data['query']['ObsPet'], 'ISO-8859-1'));
            $data['query']['EspeciePet'] = trim(mb_strtoupper($data['query']['EspeciePet'], 'ISO-8859-1'));
            $data['query']['RacaPet'] = trim(mb_strtoupper($data['query']['RacaPet'], 'ISO-8859-1'));
            $data['query']['PeloPet'] = trim(mb_strtoupper($data['query']['PeloPet'], 'ISO-8859-1'));
            $data['query']['CorPet'] = trim(mb_strtoupper($data['query']['CorPet'], 'ISO-8859-1'));
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ClientePet'] = $this->Clientepet_model->set_clientepet($data['query']);

            if ($data['idApp_ClientePet'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('clientepet/form_clientepet', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ClientePet'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClientePet', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

        $data['query'] = $this->input->post(array(
            'idApp_ClientePet',
            'idApp_Cliente',
            'NomeClientePet',
            'StatusVidaPet',
            'DataNascimentoPet',
            'SexoPet',
            'EspeciePet',
            'RacaPet',
            'PeloPet',
            'CorPet',
            'ObsPet',
			'AtivoPet',
                ), TRUE);

        if ($id) {
            $_SESSION['ClientePet'] = $data['query'] = $this->Clientepet_model->get_clientepet($id);
            $data['query']['DataNascimentoPet'] = $this->basico->mascara_data($data['query']['DataNascimentoPet'], 'barras');
            //$_SESSION['ClientePet']['idApp_ClientePet'] = $id;
        }
		
		$data['select']['SexoPet'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaPet'] = $this->Clientepet_model->select_status_vida();      
		$data['select']['AtivoPet'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'clientepet/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('NomeClientePet', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoPet', 'Data de Nascimento', 'trim|valid_date');
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientepet/form_clientepet', $data);
        } else {

            $data['query']['NomeClientePet'] = trim(mb_strtoupper($data['query']['NomeClientePet'], 'ISO-8859-1'));
            $data['query']['DataNascimentoPet'] = $this->basico->mascara_data($data['query']['DataNascimentoPet'], 'mysql');
            $data['query']['ObsPet'] = trim(mb_strtoupper($data['query']['ObsPet'], 'ISO-8859-1'));
            $data['query']['EspeciePet'] = trim(mb_strtoupper($data['query']['EspeciePet'], 'ISO-8859-1'));
            $data['query']['RacaPet'] = trim(mb_strtoupper($data['query']['RacaPet'], 'ISO-8859-1'));
            $data['query']['PeloPet'] = trim(mb_strtoupper($data['query']['PeloPet'], 'ISO-8859-1'));
            $data['query']['CorPet'] = trim(mb_strtoupper($data['query']['CorPet'], 'ISO-8859-1'));
            //$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idApp_ClientePet'] = $_SESSION['ClientePet']['idApp_ClientePet'];

            $data['anterior'] = $this->Clientepet_model->get_clientepet($data['query']['idApp_ClientePet']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ClientePet'], TRUE);

            if ($data['auditoriaitem'] && $this->Clientepet_model->update_clientepet($data['query'], $data['query']['idApp_ClientePet']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClientePet', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'cliente/clientepet/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

                $this->Clientepet_model->delete_clientepet($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'clientepet/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
	
    public function pesquisar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'), 0, -3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'), 0, -3);
        }

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
		$_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        $data['query'] = $this->Clientepet_model->lista_clientepet(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('clientepet/list_clientepet', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('clientepet/tela_clientepet', $data);

        $this->load->view('basico/footer');
    }

}
