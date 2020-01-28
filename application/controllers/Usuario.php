<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresa_model', 'Usuario_model'));
        #$this->load->model(array('Basico_model', 'Usuario_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('usuario/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('usuario/tela_index', $data);

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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
		
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Empresa',
			'idSis_Usuario',
			'Usuario',
            'Nome',
			'Senha',
			'Confirma',
            'DataNascimento',
            'CelularUsuario',
			'Email',
            'Sexo',
			'Permissao',
			'Funcao',
			'Inativo',
			'CpfUsuario',
			'RgUsuario',
			'OrgaoExpUsuario',
			'EstadoEmUsuario',
			'DataEmUsuario',
			'EnderecoUsuario',
			'BairroUsuario',
			'MunicipioUsuario',
			'EstadoUsuario',
			'CepUsuario',
			'CompAgenda',
        ), TRUE));

		#$this->load->model('Empresa_model');
		#$_SESSION['Empresa'] = $this->Empresa_model->get_empresa($idSis_Empresa, TRUE);
		#$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			
			
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		#$this->form_validation->set_rules('CpfUsuario', 'Cpf', 'required|trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[Sis_Usuario.CpfUsuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		#$this->form_validation->set_rules('Usuario', 'Usuario', 'required|trim|is_unique_duplo[Sis_Usuario.Usuario.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
        $this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');		
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');		
		$this->form_validation->set_rules('Permissao', 'Acesso Ás Agendas', 'required|trim');		
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email|is_unique_duplo[Sis_Usuario.Email.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
        $data['titulo'] = 'Cadastrar Usuário';
        $data['form_open_path'] = 'usuario/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['query']['EnderecoUsuario'] || $data['query']['BairroUsuario'] ||
			$data['query']['MunicipioUsuario'] || $data['query']['CepUsuario'] || $data['query']['CpfUsuario'] || 
			$data['query']['RgUsuario']  || $data['query']['OrgaoExpUsuario'] || $data['query']['EstadoEmUsuario']  || $data['query']['DataEmUsuario'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('usuario/form_usuario', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuario', $data);
        } else {

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

			$data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
			$data['query']['QuemCad'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['NomeEmpresa'] = $_SESSION['log']['NomeEmpresa'];
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Inativo'] = 0;
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
			$data['query']['Senha'] = md5($data['query']['Senha']);
			unset($data['query']['Confirma']);


            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idSis_Usuario'] = $this->Usuario_model->set_usuario($data['query']);

            if ($data['idSis_Usuario'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('usuario/form_usuario', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Usuario'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				$data['agenda'] = array(
                    'NomeAgenda' => 'Usuario',
					'idSis_Empresa' => $_SESSION['log']['idSis_Empresa'],
                    'idSis_Usuario' => $data['idSis_Usuario']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Usuario_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_Usuario']);
                $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_Usuario']);
				
                #redirect(base_url() . 'empresa/prontuario/' . $data['msg']);
				redirect(base_url() . 'usuario/prontuario/' . $data['idSis_Usuario'] . $data['msg']);
				#redirect(base_url() . 'relatorio/usuario/' .  $data['msg']);
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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
       
		$data['query'] = $this->input->post(array(
			
			'idSis_Usuario',
			#'Usuario',
            'Nome',
            'DataNascimento',
            'CelularUsuario',
            'Email',
			'Sexo',
			'Permissao',
			'Funcao',
			'Inativo',
			'CpfUsuario',
			'RgUsuario',
			'OrgaoExpUsuario',
			'EstadoEmUsuario',
			'DataEmUsuario',
			'EnderecoUsuario',
			'BairroUsuario',
			'MunicipioUsuario',
			'EstadoUsuario',
			'CepUsuario',
			'CompAgenda',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('Permissao', 'Nível', 'required|trim');
		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posiçao "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
        $data['titulo'] = 'Editar Usuário';
        $data['form_open_path'] = 'usuario/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['EnderecoUsuario'] || $data['query']['BairroUsuario'] ||
			$data['query']['MunicipioUsuario'] || $data['query']['CepUsuario'] || $data['query']['RgUsuario']  || 
			$data['query']['OrgaoExpUsuario'] || $data['query']['EstadoEmUsuario']  || $data['query']['DataEmUsuario'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuarioalterar', $data);
        } else {

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

            $data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);


            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(

			'idSis_Usuario',
			#'Usuario',
            'Nome',
            #'DataNascimento',
            'CelularUsuario',
            #'Email',
			#'Sexo',
			#'Permissao',
			#'Funcao',
			#'Inativo',
			#'CpfUsuario',
			'Senha',
			'Confirma',			
			#'RgUsuario',
			#'OrgaoExpUsuario',
			#'EstadoEmUsuario',
			#'DataEmUsuario',
			#'EnderecoUsuario',
			#'BairroUsuario',
			#'MunicipioUsuario',
			#'EstadoUsuario',
			#'CepUsuario',
			#'CompAgenda',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Usuario_model->get_usuario($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim|is_unique_duplo[Sis_Usuario.Nome.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('Nome', 'Nome do Responsável', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataEmUsuario', 'Data de Emissão', 'trim|valid_date');
		$this->form_validation->set_rules('CelularUsuario', 'CelularUsuario', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		#$this->form_validation->set_rules('Permissao', 'Nível', 'required|trim');
		#$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		
        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
		$data['select']['Permissao'] = $this->Basico_model->select_permissao();
		$data['select']['Funcao'] = $this->Funcao_model->select_funcao();
		$data['select']['CompAgenda'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa2();
		
        $data['titulo'] = 'Editar Usuário';
        $data['form_open_path'] = 'usuario/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
/*
        if ($data['query']['EnderecoUsuario'] || $data['query']['BairroUsuario'] ||
			$data['query']['MunicipioUsuario'] || $data['query']['CepUsuario'] || $data['query']['RgUsuario']  || 
			$data['query']['OrgaoExpUsuario'] || $data['query']['EstadoEmUsuario']  || $data['query']['DataEmUsuario'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';
*/		
        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_usuarioalterar2', $data);
        } else {

            $data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataEmUsuario'] = $this->basico->mascara_data($data['query']['DataEmUsuario'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
			$data['query']['Senha'] = md5($data['query']['Senha']);
			unset($data['query']['Confirma']);

            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'usuario/form_usuarioalterar2/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoriaempresa($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarlogo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Usuario',
			'Nome',
			
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Usuario',
            #'Tipo',
            'Arquivo',
                ), TRUE);		

        if ($id) {
            $_SESSION['Usuario'] = $data['query'] = $this->Usuario_model->get_usuario($id, TRUE);
			//$data['query'] = $this->Empresa_model->get_empresa($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
        }
		
        if ($id)
            $data['file']['idSis_Usuario'] = $id;		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Nome', 'Nome do Usuário', 'required|trim');
		

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
            
			if (file_exists('arquivos/imagens/usuarios/' . $data['file']['Arquivo'])) {

				$data['file']['Arquivo'] = $this->basico->renomeiausuario($data['file']['Arquivo'], 'arquivos/imagens/usuarios/');
            }
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg]|file_size_max[60000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }
		
        $data['titulo'] = 'Editar Perfil';
        $data['form_open_path'] = 'usuario/alterarlogo';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #$data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('usuario/form_empresalogo', $data);
        } else {
			
            $config['upload_path'] = 'arquivos/imagens/usuarios/';
            $config['max_size'] = 60000;
            $config['allowed_types'] = 'jpg';
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('usuario/form_empresalogo', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
                $data['idSis_Arquivo'] = $this->Usuario_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('usuario/form_empresalogo', $data);
                }			
			}
			
			$data['query']['Arquivo'] = $data['file']['Arquivo'];
			$data['query']['Nome'] = trim(mb_strtoupper($data['query']['Nome'], 'ISO-8859-1'));
            $data['anterior'] = $this->Usuario_model->get_usuario($data['query']['idSis_Usuario']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Usuario'], TRUE);

            if ($data['auditoriaitem'] && $this->Usuario_model->update_usuario($data['query'], $data['query']['idSis_Usuario']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'usuario/alterarlogo/' . $data['query']['idSis_Usuario'] . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Usuario', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'usuario/prontuario/' . $data['query']['idSis_Usuario'] . $data['msg']);
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

        $this->Usuario_model->delete_usuario($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'agenda' . $data['msg']);
		exit();

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

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_usuario');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Usuario";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Usuario_model->lista_usuario($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Usuario_model->lista_usuario($data['Pesquisa'], TRUE);

            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idSis_Usuario'] );
                else
                    redirect('usuario/prontuario/' . $info[0]['idSis_Usuario'] );

                exit();
            } else {
                $data['list'] = $this->load->view('usuario/list_usuario', $data, TRUE);
            }

        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('usuario/pesq_usuario', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Usuario'] = $data['query'] = $this->Usuario_model->get_usuario($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontuário ' . $data['query']['Nome'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $_SESSION['log']['idSis_Usuario'] = $data['resumo']['idSis_Usuario'] = $data['query']['idSis_Usuario'];
        $data['resumo']['Nome'] = $data['query']['Nome'];

        $data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
        $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');

        /*
        if ($data['query']['Sexo'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['Sexo'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        */
        $data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

        $data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
		$data['query']['Funcao'] = $this->Basico_model->get_funcao($data['query']['Funcao']);
		$data['query']['Permissao'] = $this->Basico_model->get_permissao($data['query']['Permissao']);
		$data['query']['idSis_Empresa'] = $this->Basico_model->get_empresa($data['query']['idSis_Empresa']);
		#$data['query']['Usuario'] = $data['query']['Usuario'];
		$data['query']['CompAgenda'] = $this->Basico_model->get_compagenda($data['query']['CompAgenda']);
        $data['query']['Telefone'] = $data['query']['CelularUsuario'];
		$data['query']['CpfUsuario'] = $data['query']['CpfUsuario'];

        $data['contatousuario'] = $this->Usuario_model->lista_contatousuario($id, TRUE);
        /*
          echo "<pre>";
          print_r($data['contatousuario']);
          echo "</pre>";
          exit();
          */
        if (!$data['contatousuario'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('usuario/list_contatousuario', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('usuario/nav_secundario', $data, TRUE);
        $this->load->view('usuario/tela_usuario', $data);

        $this->load->view('basico/footer');
    }

    function get_usuario($data) {

        if ($this->Usuario_model->lista_usuario($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_usuario', '<strong>Usuario</strong> não encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
