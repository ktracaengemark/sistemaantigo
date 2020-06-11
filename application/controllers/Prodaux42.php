<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux42 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Prodaux3_model', 'Prodaux4_model', 'Contatocliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        #$this->load->view('basico/nav_principal');

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

    public function cadastrar3($tabela = NULL) {

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
			'Prodaux3',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');

		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();		
		
        $data['titulo'] = 'Cadastrar Modelo';
        $data['form_open_path'] = 'prodaux42/cadastrar3';
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
        $data['list'] = $this->load->view('prodaux4/list_prodaux43', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('prodaux4/pesq_prodaux43', $data);
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
                $this->load->view('prodaux4/cadastrar3', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Prodaux4'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Prodaux4', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'prodaux42/cadastrar3' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar3($id = FALSE) {

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
			'Prodaux3',
                ), TRUE));


        if ($id)
            $data['query'] = $this->Prodaux4_model->get_prodaux4($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
       # $this->form_validation->set_rules('ValorVenda', 'Valor do Convênio', 'required|trim');

		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();	
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		
        $data['titulo'] = 'Editar Modelo';
        $data['form_open_path'] = 'prodaux42/alterar3';
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
        $data['list'] = $this->load->view('prodaux4/list_prodaux43', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('prodaux4/pesq_prodaux43', $data);
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
                redirect(base_url() . 'prodaux42/alterar3/' . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Prodaux4', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'prodaux42/cadastrar3/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
	public function excluir3($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Prodaux4_model->delete_prodaux4($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'prodaux42/cadastrar3/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }
}
