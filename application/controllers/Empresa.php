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
        $this->load->model(array('Basico_model', 'Funcao_model', 'Empresa_model'));
        #$this->load->model(array('Basico_model', 'Empresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('empresa/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idSis_Empresa',
			'UsuarioEmpresa',
            'NomeAdmin',
			#'Senha',
			#'Confirma',
            #'DataNascimento',
            'CelularAdmin',
			'Email',
            #'Sexo',
			'Inativo',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[Sis_Empresa.Email]');
        $this->form_validation->set_rules('UsuarioEmpresa', 'NomeAdmin do Func./ Usu�rio', 'required|trim|is_unique[Sis_Empresa.UsuarioEmpresa]');
		$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Usu�rio', 'required|trim');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim');

		$this->form_validation->set_rules('Funcao', 'Funcao', 'required|trim');

        #$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Empresa'] = $this->Basico_model->select_status_sn();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();


        $data['titulo'] = 'Cadastrar Usu�rio';
        $data['form_open_path'] = 'empresa/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('empresa/form_empresa', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('empresa/form_empresa', $data);
        } else {


			$data['query']['Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			#$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);


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
				#redirect(base_url() . 'relatorio/empresa/' .  $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(

			'idSis_Empresa',
			#'UsuarioEmpresa',
            'NomeAdmin',
            'DataNascimento',
            #'CelularAdmin',
            'Email',
			'Cnpj',
			'InscEstadual',
			'Endereco',
			'Bairro',
			'Municipio',
			'Estado',
			'Cep',
			'Telefone',
			'Atuacao',
			#'Sexo',
			#'Inativo',
			'CategoriaEmpresa',
			#'Site',
            #'Senha',			
        ), TRUE);
				

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
			//$data['query'] = $this->Empresa_model->get_empresa($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Respons�vel', 'required|trim|is_unique_duplo[Sis_Empresa.NomeAdmin.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('NomeAdmin', 'NomeAdmin do Respons�vel', 'required|trim');
        #$this->form_validation->set_rules('Site', 'Site', 'trim|is_unique[Sis_Empresa.Site]');
		$this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        #$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
        #$this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        #$this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');		

        $data['select']['Municipio'] = $this->Basico_model->select_municipio();
		$data['select']['CategoriaEmpresa'] = $this->Basico_model->select_categoriaempresa();
        #$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		#$data['select']['Empresa'] = $this->Basico_model->select_status_sn();
		#$data['select']['Inativo'] = $this->Basico_model->select_inativo();

        $data['titulo'] = 'Editar Empresa';
        $data['form_open_path'] = 'empresa/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Endereco'] || $data['query']['Bairro'] ||
			$data['query']['Municipio'] || $data['query']['Cep'])
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

            $data['query']['NomeAdmin'] = trim(mb_strtoupper($data['query']['NomeAdmin'], 'ISO-8859-1'));
            #$data['query']['Senha'] = md5($data['query']['Senha']);            
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            #$data['query']['Obs'] = nl2br($data['query']['Obs']);
            #$data['query']['Empresa'] = $_SESSION['log']['idSis_Empresa'];

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

    public function alterarlogo_bkp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiaempresa($data['file']['Arquivo'], 'arquivos/imagens/empresas/');
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_perfil', $data);
        }
        else {

            $config['upload_path'] = 'arquivos/imagens/empresas/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('empresa/form_perfil', $data);
            }
            else {

                $data['camposfile'] = array_keys($data['file']);
				$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('empresa/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

					if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'empresa/form_perfil/' . $data['query']['idSis_Empresa'] . $data['msg']);
						exit();
					} else {

						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'empresa/prontuario/' . $data['file']['idSis_Empresa'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarlogo_bkp2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo',
			'Arquivo1',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiaempresa($data['file']['Arquivo'], 'arquivos/imagens/empresas/');
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }
		
        if (isset($_FILES['Arquivo1']) && $_FILES['Arquivo1']['name']) {
            
			$data['file']['Arquivo1'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo1']['name']);
			$data['file']['Arquivo1'] = $this->basico->renomeiaempresa1($data['file']['Arquivo1'], 'arquivos/imagens/paginas/');
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'required');
        }		

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_perfil', $data);
        }
        else {

            $config['upload_path'] = 'arquivos/imagens/empresas/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $config1['upload_path'] = 'arquivos/imagens/paginas/';
            $config1['max_size'] = 1000;
            $config1['allowed_types'] = ['jpg', 'jpeg', 'gif', 'png'];
            $config1['file_name'] = $data['file']['Arquivo1'];			
			
            $this->load->library('upload', $config);
			$this->load->library('upload', $config1);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('empresa/form_perfil', $data);
            } else if (!$this->upload->do_upload('Arquivo1')) {
					$data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
					$this->load->view('empresa/form_perfil', $data);
            }	else {

					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('empresa/form_perfil', $data);
					}
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
						
						$data['query']['Arquivo'] = $data['file']['Arquivo'];
						$data['query']['Arquivo1'] = $data['file']['Arquivo1'];
						$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
						$data['campos'] = array_keys($data['query']);

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

						if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
							$data['msg'] = '?m=2';
							redirect(base_url() . 'empresa/form_perfil/' . $data['query']['idSis_Empresa'] . $data['msg']);
							exit();
						} else {

							if ($data['auditoriaitem'] === FALSE) {
								$data['msg'] = '';
							} else {
								$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
								$data['msg'] = '?m=1';
							}

							redirect(base_url() . 'empresa/prontuario/' . $data['file']['idSis_Empresa'] . $data['msg']);
							exit();
						}				
					}
				}
        }

        $this->load->view('basico/footer');
    }

    public function alterarlogo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idSis_Empresa',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idSis_Empresa',
            'Arquivo',
			'Arquivo1',
		), TRUE);

        if ($id) {
            $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        }
		
        if ($id)
            $data['file']['idSis_Empresa'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo']['name']);
			$data['file']['Arquivo'] = $this->basico->renomeiaempresa($data['file']['Arquivo'], 'arquivos/imagens/empresas/');
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }
		
        if (isset($_FILES['Arquivo1']) && $_FILES['Arquivo1']['name']) {
            
			$data['file']['Arquivo1'] = $this->basico->limpa_nome_arquivo($_FILES['Arquivo1']['name']);
			$data['file']['Arquivo1'] = $this->basico->renomeiaempresa1($data['file']['Arquivo1'], 'arquivos/imagens/empresas/');
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo1', 'Arquivo1', 'required');
        }		

		$diretorio = "arquivos/imagens/empresas/";
		
		$arquivo = isset($_FILES['Arquivo']) ? $_FILES['Arquivo'] : FALSE;	
			$destino = $diretorio."/".$data['file']['Arquivo'];
			if(move_uploaded_file($arquivo['tmp_name'], $destino)){
				echo "Upload realizado com sucesso<br>";
			}else{
				echo "Erro ao realizar upload";
			}
		$arquivo1 = isset($_FILES['Arquivo1']) ? $_FILES['Arquivo1'] : FALSE;	
			$destino1 = $diretorio."/".$data['file']['Arquivo1'];
			if(move_uploaded_file($arquivo1['tmp_name'], $destino1)){
				echo "Upload realizado com sucesso<br>";
			}else{
				echo "Erro ao realizar upload";
			}		

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'empresa/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('empresa/form_perfil', $data);
        }
        else {
			$data['camposfile'] = array_keys($data['file']);
			$data['idSis_Arquivo'] = $this->Empresa_model->set_arquivo($data['file']);

			if ($data['idSis_Arquivo'] === FALSE) {
				$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
				$this->basico->erro($msg);
				$this->load->view('empresa/form_perfil', $data);
			}
			else {

				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
				$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
				
				$data['query']['Arquivo'] = $data['file']['Arquivo'];
				$data['query']['Arquivo1'] = $data['file']['Arquivo1'];
				$data['anterior'] = $this->Empresa_model->get_empresa($data['query']['idSis_Empresa']);
				$data['campos'] = array_keys($data['query']);

				$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);

				if ($data['auditoriaitem'] && $this->Empresa_model->update_empresa($data['query'], $data['query']['idSis_Empresa']) === FALSE) {
					$data['msg'] = '?m=2';
					redirect(base_url() . 'empresa/form_perfil/' . $data['query']['idSis_Empresa'] . $data['msg']);
					exit();
				} else {

					if ($data['auditoriaitem'] === FALSE) {
						$data['msg'] = '';
					} else {
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem']);
						$data['msg'] = '?m=1';
					}

					redirect(base_url() . 'empresa/prontuario/' . $data['file']['idSis_Empresa'] . $data['msg']);
					exit();
				}				
			}
				
        }

        $this->load->view('basico/footer');
    }
	
    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Empresa_model->delete_empresa($id);

        $data['msg'] = '?m=1';

		redirect(base_url() . 'agenda' . $data['msg']);
		exit();

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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

        $data['titulo'] = "Pesquisar Empresa";

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
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($id, TRUE);
        #$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontu�rio ' ;
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        $_SESSION['log']['idSis_Empresa'] = $data['resumo']['idSis_Empresa'] = $data['query']['idSis_Empresa'];
        $data['resumo']['NomeAdmin'] = $data['query']['NomeAdmin'];

        $data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataCriacao']);
        $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'barras');

        /*
        if ($data['query']['Sexo'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['Sexo'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        */
        #$data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

        #$data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		$data['query']['Inativo'] = $this->Basico_model->get_inativo($data['query']['Inativo']);
		$data['query']['Empresa'] = $this->Basico_model->get_empresa($data['query']['NomeEmpresa']);
		$data['query']['CategoriaEmpresa'] = $this->Basico_model->get_categoriaempresa($data['query']['CategoriaEmpresa']);
		#$data['query']['Empresa'] = $data['query']['Empresa'];

        $data['query']['Telefone'] = $data['query']['CelularAdmin'];

        $data['contatoempresa'] = $this->Empresa_model->lista_contatoempresa($id, TRUE);
        /*
          echo "<pre>";
          print_r($data['contatoempresa']);
          echo "</pre>";
          exit();
          */
        if (!$data['contatoempresa'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('empresa/list_contatoempresa', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('empresa/nav_secundario', $data, TRUE);
        $this->load->view('empresa/tela_empresa', $data);

        $this->load->view('basico/footer');
    }
	
}
