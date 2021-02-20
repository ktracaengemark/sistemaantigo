<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientedep extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Clientedep_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('clientedep/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('clientedep/tela_index', $data);

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
            'idApp_ClienteDep',
            'idApp_Cliente',
            'idSis_Usuario',
            'NomeClienteDep',
            'StatusVidaDep',
            'DataNascimentoDep',
			'AtivoDep',
            'SexoDep',
            'ObsDep',
                        ), TRUE));

        //echo '<br><br><br><br><br>==========================================='.$data['query']['StatusVidaDep']='V';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeClienteDep', 'Nome do Pet', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoDep', 'Data de Nascimento', 'trim|valid_date');
		$data['select']['SexoDep'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaDep'] = $this->Clientedep_model->select_status_vida();
		$data['select']['AtivoDep'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Contatos e Responsáveis';
        $data['form_open_path'] = 'clientedep/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientedep/form_clientedep', $data);
        } else {

            $data['query']['NomeClienteDep'] = trim(mb_strtoupper($data['query']['NomeClienteDep'], 'ISO-8859-1'));
            $data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'mysql');
            $data['query']['ObsDep'] = nl2br($data['query']['ObsDep']);
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idApp_ClienteDep'] = $this->Clientedep_model->set_clientedep($data['query']);

            if ($data['idApp_ClienteDep'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('clientedep/form_clientedep', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_ClienteDep'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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
            'idApp_ClienteDep',
            'idApp_Cliente',
            'NomeClienteDep',
            'StatusVidaDep',
            'DataNascimentoDep',
            'SexoDep',
            //'idSis_Usuario',
            'ObsDep',
			'AtivoDep',
                ), TRUE);

        if ($id) {
            $_SESSION['ClienteDep'] = $data['query'] = $this->Clientedep_model->get_clientedep($id);
            $data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'barras');
            //$_SESSION['ClienteDep']['idApp_ClienteDep'] = $id;
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('NomeClienteDep', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimentoDep', 'Data de Nascimento', 'trim|valid_date');
		$data['select']['SexoDep'] = $this->Basico_model->select_sexo();
        $data['select']['StatusVidaDep'] = $this->Clientedep_model->select_status_vida();      
		$data['select']['AtivoDep'] = $this->Basico_model->select_status_sn();
		
		$data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'clientedep/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientedep/form_clientedep', $data);
        } else {

            $data['query']['NomeClienteDep'] = trim(mb_strtoupper($data['query']['NomeClienteDep'], 'ISO-8859-1'));
            $data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'mysql');
            $data['query']['ObsDep'] = nl2br($data['query']['ObsDep']);
            //$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idApp_ClienteDep'] = $_SESSION['ClienteDep']['idApp_ClienteDep'];

            $data['anterior'] = $this->Clientedep_model->get_clientedep($data['query']['idApp_ClienteDep']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_ClienteDep'], TRUE);

            if ($data['auditoriaitem'] && $this->Clientedep_model->update_clientedep($data['query'], $data['query']['idApp_ClienteDep']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                redirect(base_url() . 'cliente/clientedep/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idApp_ClienteDep',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Clientedep_model->get_clientedep($id);
            $data['query']['DataNascimentoDep'] = $this->basico->mascara_data($data['query']['DataNascimentoDep'], 'barras');
        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['SexoDep'] = $this->Basico_model->select_sexo();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'clientedep/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('clientedep/form_clientedep', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('clientedep/tela_clientedep', $data);
        } else {

            if ($data['query']['idApp_ClienteDep'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('clientedep/form_clientedep', $data);
            } else {

                $data['anterior'] = $this->Clientedep_model->get_clientedep($data['query']['idApp_ClienteDep']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idApp_ClienteDep'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_ClienteDep', 'DELETE', $data['auditoriaitem']);

                $this->Clientedep_model->delete_clientedep($data['query']['idApp_ClienteDep']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'clientedep' . $data['msg']);
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

                $this->Clientedep_model->delete_clientedep($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'clientedep/pesquisar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
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

        $data['query'] = $this->Clientedep_model->lista_clientedep(TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('clientedep/list_clientedep', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('clientedep/tela_clientedep', $data);

        $this->load->view('basico/footer');
    }

}
