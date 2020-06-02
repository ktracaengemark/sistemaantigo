<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux4 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Prodaux4_model', 'Contatocliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idTab_Prodaux4',
            'Prodaux4',
			'Abrev4',
			'idSis_Empresa',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		$this->form_validation->set_rules('Abrev4', 'Abreviação', 'required|trim');

        $data['titulo'] = 'Cadastrar Aux4';
        $data['form_open_path'] = 'prodaux4/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['button'] =
                '
                <button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-plus"></span> Cadastrar
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Prodaux4_model->lista_prodaux4(TRUE);
        $data['list'] = $this->load->view('prodaux4/list_prodaux4', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('prodaux4/pesq_prodaux4', $data);
        } else {

            $data['query']['Prodaux4'] = trim(mb_strtoupper($data['query']['Prodaux4'], 'ISO-8859-1'));
			$data['query']['Abrev4'] = trim(mb_strtoupper($data['query']['Abrev4'], 'ISO-8859-1'));
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Prodaux4'] = $this->Prodaux4_model->set_prodaux4($data['query']);

            if ($data['idTab_Prodaux4'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('prodaux4/cadastrar', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Prodaux4'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Prodaux4', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'prodaux4/cadastrar' . $data['msg']);
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

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idTab_Prodaux4',
            'Prodaux4',
            'Abrev4',
			'idSis_Empresa',
                ), TRUE));


        if ($id)
            $data['query'] = $this->Prodaux4_model->get_prodaux4($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		$this->form_validation->set_rules('Abrev4', 'Abreviação', 'required|trim');
       # $this->form_validation->set_rules('ValorVenda', 'Valor do Convênio', 'required|trim');

        $data['titulo'] = 'Editar Aux4';
        $data['form_open_path'] = 'prodaux4/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['button'] =
                '
                <button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-edit"></span> Salvar Alteração
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Prodaux4_model->lista_prodaux4(TRUE);
        $data['list'] = $this->load->view('prodaux4/list_prodaux4', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('prodaux4/pesq_prodaux4', $data);
        } else {

            $data['query']['Prodaux4'] = trim(mb_strtoupper($data['query']['Prodaux4'], 'ISO-8859-1'));
			$data['query']['Abrev4'] = trim(mb_strtoupper($data['query']['Abrev4'], 'ISO-8859-1'));
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['anterior'] = $this->Prodaux4_model->get_prodaux4($data['query']['idTab_Prodaux4']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Prodaux4'], TRUE);

            if ($data['auditoriaitem'] && $this->Prodaux4_model->update_prodaux4($data['query'], $data['query']['idTab_Prodaux4']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'prodaux4/alterar/' . $data['query']['idApp_Cliente'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Prodaux4', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'prodaux4/cadastrar/' . $data['msg']);
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

                $this->Prodaux4_model->delete_prodaux4($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'prodaux4/cadastrar/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

}
