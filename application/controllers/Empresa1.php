<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Empresa_model', 'Atividade_model', 'Contato_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('empresa/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('empresa/tela_index', $data);

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
            'idSis_Empresa',
            'NomeEmpresa',
          
            'Endereco',
            'Bairro',
            'Municipio',
			
            
			'Email',
            'idSis_Usuario',

        ), TRUE));

		(!$data['query']['TipoFornec']) ? $data['query']['TipoFornec'] = 'P' : FALSE;
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeEmpresa', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Empresa.NomeEmpresa.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeEmpresa', 'Nome do Responsável', 'required|trim');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        #$this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        #$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		#$this->form_validation->set_rules('Atividade', 'Atividade', 'required|trim');
		
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();

		
		
        $data['titulo'] = 'Cadastrar Empresa';
        $data['form_open_path'] = 'empresa/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        
        if ($data['query']['Endereco'] || $data['query']['Bairro'] || 
                $data['query']['Municipio'] || $data['query']['Email'])
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';            
        
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';        

        $data['tela'] = $this->load->view('empresa/form_empresa', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_empresa', $data);        
        } else {

            $data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idSis_Empresa'] = $this->Empresa_model->set_empresa($data['query']);

            if ($data['idSis_Empresa'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('empresa/form_empresa', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'empresa/prontuario/' . $data['idSis_Empresa'] . $data['msg']);
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
            'idSis_Empresa',
            'NomeEmpresa',
            'Endereco',
            'Bairro',
            'Municipio',
            'idSis_Usuario',
            'Email',

        ), TRUE);

        if ($id) {
            $data['query'] = $this->Empresa_model->get_empresa($id);

        }

        #(!$data['query']['TipoFornec']) ? $data['query']['TipoFornec'] = 'P' : FALSE;
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeEmpresa', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Empresa.NomeEmpresa.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeEmpresa', 'Nome do Responsável', 'required|trim');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        #$this->form_validation->set_rules('Telefone1', 'Telefone1', 'required|trim');
        #$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
        #$this->form_validation->set_rules('Atividade', 'Atividade', 'required|trim'); 
		
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();

		
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'empresa/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        
        if ($data['query']['Endereco'] || $data['query']['Bairro'] || 
                $data['query']['Municipio'] || $data['query']['Email'])
            $data['collapse'] = '';
        else 
            $data['collapse'] = 'class="collapse"';        

        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';
        
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_empresa', $data);
        } else {

            $data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['idSis_Usuario'] = $_SESSION['log']['id'];          

            $data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

            if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'empresa/form_empresa/' . $data['query']['idSis_Empresa'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'empresa/prontuario/' . $data['query']['idSis_Empresa'] . $data['msg']);
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
            'idSis_Empresa',
            'submit'
                ), TRUE);

        if ($id) {
            $data['query'] = $this->Empresa_model->get_empresa($id);

        }

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();

        $data['titulo'] = 'Tem certeza que deseja excluir o registro abaixo?';
        $data['form_open_path'] = 'empresa/excluir';
        $data['readonly'] = 'readonly';
        $data['disabled'] = 'disabled';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;

        $data['tela'] = $this->load->view('empresa/form_empresa', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/tela_empresa', $data); 
        } else {

            if ($data['query']['idSis_Empresa'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('empresa/form_empresa', $data);
            } else {

                $data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
                $data['campos'] = array_keys($data['anterior']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], NULL, $data['campos'], $data['query']['idSis_Empresa'], FALSE, TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'DELETE', $data['auditoriaitem']);

                $this->Empresa_model->delete_empresa($data['query']['idSis_Empresa']);

                $data['msg'] = '?m=1';

                redirect(base_url() . 'empresa' . $data['msg']);
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

                $this->Empresa_model->delete_empresa($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'agenda' . $data['msg'] . $data['redirect']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_empresa');
        
        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);            
        }
        
        $data['titulo'] = "Pesquisar Fornecedor";
        
        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));
        
        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Empresa_model->lista_empresa($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Empresa_model->lista_empresa($data['Pesquisa'], TRUE);
            
            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();
                
                if ($_SESSION['agenda']) 
                    redirect('consulta/cadastrar/' . $info[0]['idSis_Empresa'] );
                else
                    redirect('empresa/prontuario/' . $info[0]['idSis_Empresa'] );
                
                exit();
            } else {
                $data['list'] = $this->load->view('empresa/list_empresa', $data, TRUE);
            }
           
        }
       
        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('empresa/pesq_empresa', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['NomeEmpresa'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;
        
        $_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['query']['idSis_Empresa'];
        $data['resumo']['NomeEmpresa'] = $data['query']['NomeEmpresa'];

        if ($data['query']['Municipio']) {
            $mun = $this->Basico_model->get_municipio($data['query']['Municipio']);
            $data['query']['Municipio'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
        } else {
            $data['query']['Municipio'] = $data['query']['Uf'] = $mun['Uf'] = '';
        }

        #$data['contato'] = $this->Contato_model->lista_contato(TRUE);
        /*
          echo "<pre>";
          print_r($data['contato']);
          echo "</pre>";
          exit();
        
        if (!$data['contato'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contato/list_contato', $data, TRUE);
        
        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);     
        */
		$this->load->view('empresa/tela_empresa', $data);

        $this->load->view('basico/footer');
    }

    function get_empresa($data) {

        if ($this->Empresa_model->lista_empresa($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_empresa', '<strong>Fornecedor</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
