<?php

#controlador de Loginempresa

defined('BASEPATH') OR exit('No direct script access allowed');

class Loginempresa extends CI_Controller {

public function __construct() {
        parent::__construct();

        $this->load->model(array('Loginempresa_model', 'Basico_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerloginempresa');

        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador n�o suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }
    }

    public function index() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        ###################################################
        #s� pra eu saber quando estou no banco de testes ou de produ��o
        #$CI = & get_instance();
        #$CI->load->database();
        #if ($CI->db->database != 'sishuap')
        #echo $CI->db->database;
        ###################################################
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #Get GET or POST data
        $celular = $this->input->get_post('CelularAdmin');
		$empresa = $this->input->get_post('idSis_Empresa');
        $senha = md5($this->input->get_post('Senha'));

        #set validation rules
        $this->form_validation->set_rules('CelularAdmin', 'Celular do Admin', 'required|trim|callback_valid_celular');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_valid_empresa[' . $celular . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

		$data['select']['idSis_Empresa'] = $this->Loginempresa_model->select_empresa();
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sess�o expirou. Fa�a o loginempresa novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usu�rio ativado com sucesso! Fa�a o loginempresa para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_loginempresa', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('UsuarioEmpresa');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            $query = $this->Loginempresa_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Loginempresa_model->check_dados_empresa($empresa, $celular, TRUE);
			#$_SESSION['log']['Agenda'] = $this->Loginempresa_model->get_agenda_padrao($query['idSis_Empresa']);
			
			
            #echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usu�rio</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_loginempresa', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['UsuarioEmpresa'] = $query['UsuarioEmpresa'];
                //se for necess�rio reduzir o tamanho do nome de usu�rio, que pode ser um email
				$_SESSION['log']['UsuarioEmpresa'] = (strlen($query['UsuarioEmpresa']) > 13) ? substr($query['UsuarioEmpresa'], 0, 13) : $query['UsuarioEmpresa'];
                $_SESSION['log']['Nome'] = $query['NomeAdmin'];
				$_SESSION['log']['Nome2'] = (strlen($query['NomeAdmin']) > 6) ? substr($query['NomeAdmin'], 0, 6) : $query['NomeAdmin'];
				$_SESSION['log']['CpfAdmin'] = $query['CpfAdmin'];
				$_SESSION['log']['CelularAdmin'] = $query['CelularAdmin'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 15) ? substr($query['NomeEmpresa'], 0, 15) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				$_SESSION['log']['PermissaoEmpresa'] = $query['PermissaoEmp'];
				$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['TabelasEmpresa'] = $query['TabelasEmpresa'];
				$_SESSION['log']['DataCriacao'] = $query['DataCriacao'];
				$_SESSION['log']['DataDeValidade'] = $query['DataDeValidade'];

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_loginempresa');
                } else {
					redirect('acessoempresa');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }

    public function registrar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Email',
            #'UsuarioEmpresa',
			'NomeEmpresa',
            'NomeAdmin',
			'DataNascimento',
			'Sexo',
            'CpfAdmin',
			'Senha',
            'Confirma',
            'CelularAdmin',
			'DataCriacao',
			'DataDeValidade',
			'NumUsuarios',
			'Site',
                ), TRUE);

		(!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		(!$data['query']['DataDeValidade']) ? $data['query']['DataDeValidade'] = date('d/m/Y', strtotime('+1 month')) : FALSE;
        
		if (isset($data['query']['Site'])) {
			$data['query']['Site'] = $this->basico->url_amigavel($data['query']['Site']);
		}
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');
		$this->form_validation->set_rules('Site', 'Nome do Site', 'required|trim|is_unique_site[Sis_Empresa.Site]');		
		$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Empresa.NomeEmpresa]');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim');	
		#$this->form_validation->set_rules('CpfAdmin', 'Cpf', 'required|trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CpfAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');		
        #$this->form_validation->set_rules('UsuarioEmpresa', 'Usu�rio', 'required|trim|is_unique[Sis_Empresa.UsuarioEmpresa]');
		$this->form_validation->set_rules('NomeAdmin', 'Nome do Administrador', 'required|trim');      	
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		$this->form_validation->set_rules('CelularAdmin', 'Celular', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CelularAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		#$this->form_validation->set_rules('CelularAdmin', 'CelularAdmin', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');			
		#$this->form_validation->set_rules('NumUsuarios', 'N�mero de Usu�rios', 'required|trim');

		$data['select']['NumUsuarios'] = $this->Basico_model->select_numusuarios();
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		
		#run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_registrar', $data);
        } else {
			
			$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['NomeAdmin'] = trim(mb_strtoupper($data['query']['NomeAdmin'], 'ISO-8859-1'));
			//$data['query']['Site'] = trim(mb_strtoupper($data['query']['Site'], 'UTF-8'));
			$data['query']['idSis_EmpresaMatriz'] = 2;
			$data['query']['Associado'] = 2;
			$data['query']['PermissaoEmpresa'] = 1;
			$data['query']['NivelEmpresa'] = 4;
			$data['query']['idTab_Modulo'] = 1;
			$data['query']['NumUsuarios'] = 1;
            $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['DataDeValidade'] = $this->basico->mascara_data($data['query']['DataDeValidade'], 'mysql');
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');			
			$data['query']['Senha'] = md5($data['query']['Senha']);
            //$data['query']['Senha'] = password_hash($data['query']['Senha'], PASSWORD_DEFAULT);
			$data['query']['Codigo'] = md5(uniqid(time() . rand()));
			#$data['query']['Site'] = "sitedaempresa";
            #$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_Empresa'] = $this->Loginempresa_model->set_empresa($data['query']);
            $_SESSION['log']['idSis_Empresa'] = 1;

            if ($data['idSis_Empresa'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresa/form_registrar', $data);
            } else {

				//in�cio da cria��o o site da Empresa///
				//este � o NOME do site escolhido na hora da cria��o da empresa!!
				
				$pasta = '../' .$data['query']['Site']. '';

				// checar se a pasta existe
				if (!is_dir($pasta)){
					//cria a pasta
					mkdir($pasta, 0777);
				
					//este � o TAMPLATE do site escolhido na hora da cria��o da empresa!!
					$tamplate = '../site2';				
					if (is_dir($tamplate)){
						foreach(scandir($tamplate) as $arquivo){
							$caminho_arquivo = "$tamplate/$arquivo";
							if(is_file($caminho_arquivo)){
								//echo $caminho_arquivo . PHP_EOL;
								/////copy($caminho_arquivo, "../nomedosite/$arquivo");
								copy($caminho_arquivo, "../" .$data['query']['Site']. "/$arquivo");
							}
						}
					}

					/////$nome_arquivo = "../nomedosite/configuracao.php";
					$nome_arquivo = "../" .$data['query']['Site']. "/configuracao.php";
					//echo $nome_arquivo;
					$arquivo = fopen($nome_arquivo, 'r+');
					fwrite($arquivo, '<?php' . PHP_EOL);
					fwrite($arquivo, '//Dados da Empresa' . PHP_EOL);
					fwrite($arquivo, '$idSis_Empresa = ' . $data['idSis_Empresa'] . ';' . PHP_EOL);
					fclose($arquivo);
				}
				//Fim da cria��o do site da empresa///
				
				$data['usuario'] = array(

					'idSis_Empresa' => $data['idSis_Empresa'],
					'NomeEmpresa' => $data['query']['NomeEmpresa'],
					'Nome' => $data['query']['NomeAdmin'],
					'CelularUsuario' => $data['query']['CelularAdmin'],
					'DataCriacao' => $data['query']['DataCriacao'],
					'DataNascimento' => $data['query']['DataNascimento'],
					'Sexo' => $data['query']['Sexo'],
					'Senha' => $data['query']['Senha'],
					'Codigo' => $data['query']['Codigo'],
					'CpfUsuario' => $data['query']['CpfAdmin'],
					'Inativo' => "0",
					'Funcao' => "1",
					'idTab_Modulo' => "1",
					'Permissao' => "3"
				);
				$data['campos'] = array_keys($data['usuario']);

				$data['idSis_Usuario'] = $this->Loginempresa_model->set_usuario($data['usuario']);
				$_SESSION['log']['idSis_Empresa'] = 1;
				
				
				$data['documentos'] = array(
					'idSis_Empresa' => $data['idSis_Empresa'],
				);
				$data['campos'] = array_keys($data['documentos']);
				
				$data['idApp_Documentos'] = $this->Loginempresa_model->set_documentos($data['documentos']);
				$_SESSION['log']['idSis_Empresa'] = 1;
				
				$pasta1 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/';
				mkdir($pasta1, 0777);
				
				$pasta2 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/';
				mkdir($pasta2, 0777);
				
				$pasta21 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/original/';
				mkdir($pasta21, 0777);
								
				$pasta22 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/';
				mkdir($pasta22, 0777);				
				
				$arquivo_origem2 = 'arquivos/imagens/empresas/1/documentos/miniatura/SuaLogo.jpg';
				$arquivo_destino2 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/SuaLogo.jpg';
				
				copy($arquivo_origem2, $arquivo_destino2);
				
				$pasta3 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/';
				mkdir($pasta3, 0777);
				
				$pasta31 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/original/';
				mkdir($pasta31, 0777);
				
				$pasta32 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/';
				mkdir($pasta32, 0777);				

				$arquivo_origem3 = 'arquivos/imagens/empresas/1/usuarios/miniatura/SuaFoto.jpg';
				$arquivo_destino3 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/SuaFoto.jpg';
				
				copy($arquivo_origem3, $arquivo_destino3);				
				
				$pasta4 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/';
				mkdir($pasta4, 0777);
				
				$pasta41 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/original/';
				mkdir($pasta41, 0777);
				
				$pasta42 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/';
				mkdir($pasta42, 0777);				
				
				$arquivo_origem4 = 'arquivos/imagens/empresas/1/clientes/miniatura/Foto.jpg';
				$arquivo_destino4 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/Foto.jpg';
				
				copy($arquivo_origem4, $arquivo_destino4);
				
				$pasta5 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/';
				mkdir($pasta5, 0777);
				
				$pasta51 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/original/';
				mkdir($pasta51, 0777);
				
				$pasta52 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/';
				mkdir($pasta52, 0777);				
				
				$arquivo_origem5 = 'arquivos/imagens/empresas/1/produtos/miniatura/fotoproduto.jpg';
				$arquivo_destino5 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/fotoproduto.jpg';
				
				copy($arquivo_origem5, $arquivo_destino5);
				
				if ($data['idSis_Usuario'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('loginempresa/form_registrar', $data);
				} else {

					/*
					  echo $this->db->last_query();
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  exit();
					 */
					$data['agenda'] = array(
						'NomeAgenda' => 'Usuario',
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['agenda']);

					$data['idApp_Agenda'] = $this->Loginempresa_model->set_agenda($data['agenda']);

					$data['cliente'] = array(
						'NomeCliente' => 'AAAN�NIMO',
						'idTab_Modulo' => "1",
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['cliente']);

					$data['idApp_Cliente'] = $this->Loginempresa_model->set_cliente($data['cliente']);

					$data['fornecedor'] = array(
						'NomeFornecedor' => 'AAAN�NIMO',
						'idTab_Modulo' => "1",
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['fornecedor']);

					$data['idApp_Fornecedor'] = $this->Loginempresa_model->set_fornecedor($data['fornecedor']);
					
					$data['produto'] = array(
						'Produtos' => 'Produto Nao Cadastrado',
						'idTab_Modulo' => "1",
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['produto']);

					$data['idTab_Produto'] = $this->Loginempresa_model->set_produto($data['produto']);					

					if ($data['idTab_Produto'] === FALSE) {
						$data['msg'] = '?m=2';
						$this->load->view('loginempresa/form_registrar', $data);
					} else {
						
							$data['valor'] = array(
								'idTab_Produto' => $data['idTab_Produto'],
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa'],
								'idTab_Modulo' => "1",
								'ValorProduto' => '0.00'
							);
							$data['campos'] = array_keys($data['valor']);

							$data['idTab_Valor'] = $this->Loginempresa_model->set_valor($data['valor']);					
					
					}	
				
				}
				#$this->load->library('email');

				#$this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
				#$this->email->to($data['query']['Email']);

				#$this->email->subject('[KTRACA] Confirma��o de registro - Usu�rio: ' . $data['query']['UsuarioEmpresa']);
				/*
				  $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
				  . 'http://www.romati.com.br/app/loginempresa/confirmar/' . $data['query']['Codigo']);

				  $this->email->send();

				  $data['aviso'] = ''
				  . '
				  <div class="alert alert-success" role="alert">
				  <h4>
				  <p><b>Usu�rio cadastrado com sucesso!</b></p>
				  <p>O link para ativa��o foi enviado para seu e-mail cadastrado.</p>
				  <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>
				  </h4>
				  </div> '
				  . '';
				 */

				#$this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
						#. 'Qualquer sugest�o ou cr�tica ser� bem vinda. ');

				#$this->email->send();

				$data['aviso'] = ''
						. '
				  <div class="alert alert-success" role="alert">
				  <h4>
				  <p><b>Empresa cadastrado com sucesso!</b></p>
				  <p>Clique no bot�o abaixo e retorne para a tela de Login do Administrador, para entrar no sistema.</p>
				  </h4>
				  <br>
				 
				  </div> '
						. '';

				$this->load->view('loginempresa/tela_msg', $data);
				#redirect(base_url() . 'loginempresa' . $data['msg']);
				#exit();
				
            }
        }

        #$this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }

    public function registrar2() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Email',
            #'UsuarioEmpresa',
			'NomeEmpresa',
            'NomeAdmin',
			'DataNascimento',
			'Sexo',
            'CpfAdmin',
			'Senha',
            'Confirma',
            'CelularAdmin',
			'DataCriacao',
			'DataDeValidade',
			'NumUsuarios',
			'Associado',
			'Site',
                ), TRUE);

		(!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;
		(!$data['query']['DataDeValidade']) ? $data['query']['DataDeValidade'] = date('d/m/Y', strtotime('+1 month')) : FALSE;
		
		if (isset($data['query']['Site'])) {
			$data['query']['Site'] = $this->basico->url_amigavel($data['query']['Site']);
		}		
		
		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');
		$this->form_validation->set_rules('Site', 'Nome do Site', 'required|trim|is_unique_site[Sis_Empresa.Site]');		
		$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_Empresa.NomeEmpresa]');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim');
		#$this->form_validation->set_rules('CpfAdmin', 'Cpf', 'required|trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CpfAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		$this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');		
        #$this->form_validation->set_rules('UsuarioEmpresa', 'Usu�rio', 'required|trim|is_unique[Sis_Empresa.UsuarioEmpresa]');
		$this->form_validation->set_rules('NomeAdmin', 'Nome do Administrador', 'required|trim');      	
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
		$this->form_validation->set_rules('CelularAdmin', 'CelularAdmin', 'required|trim|alpha_numeric_spaces|is_unique_duplo[Sis_Empresa.CelularAdmin.NomeEmpresa.' . $data['query']['NomeEmpresa'] . ']');
		#$this->form_validation->set_rules('CelularAdmin', 'CelularAdmin', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');		
		#$this->form_validation->set_rules('NumUsuarios', 'N�mero de Usu�rios', 'required|trim');
		
		$data['select']['NumUsuarios'] = $this->Basico_model->select_numusuarios();
        $data['select']['Associado'] = $this->Basico_model->select_empresa3();
		$data['select']['Sexo'] = $this->Basico_model->select_sexo();
		
		#run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_registrar2', $data);
        } else {
			
			$data['query']['NomeEmpresa'] = trim(mb_strtoupper($data['query']['NomeEmpresa'], 'ISO-8859-1'));
			$data['query']['NomeAdmin'] = trim(mb_strtoupper($data['query']['NomeAdmin'], 'ISO-8859-1'));			
			$data['query']['idSis_EmpresaMatriz'] = 2;
			$data['query']['Associado'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['PermissaoEmpresa'] = 1;
			$data['query']['NivelEmpresa'] = 4;
			$data['query']['idTab_Modulo'] = 1;
			$data['query']['NumUsuarios'] = 1;
            $data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
			$data['query']['DataDeValidade'] = $this->basico->mascara_data($data['query']['DataDeValidade'], 'mysql');
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');			
			$data['query']['Senha'] = md5($data['query']['Senha']);
            //$data['query']['Senha'] = password_hash($data['query']['Senha'], PASSWORD_DEFAULT);
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
			#$data['query']['Site'] = "sitedaempresa";
            #$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_Empresa'] = $this->Loginempresa_model->set_empresa($data['query']);
            $_SESSION['log']['idSis_Empresa'] = 1;

            if ($data['idSis_Empresa'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresa/form_loginempresa', $data);
            } else {

				//in�cio da cria��o o site da Empresa///
				//este � o NOME do site escolhido na hora da cria��o da empresa!!
				
				$pasta = '../' .$data['query']['Site']. '';

				// checar se a pasta existe
				if (!is_dir($pasta)){
					//cria a pasta
					mkdir($pasta, 0777);
				
					//este � o TAMPLATE do site escolhido na hora da cria��o da empresa!!
					$tamplate = '../site2';				
					if (is_dir($tamplate)){
						foreach(scandir($tamplate) as $arquivo){
							$caminho_arquivo = "$tamplate/$arquivo";
							if(is_file($caminho_arquivo)){
								//echo $caminho_arquivo . PHP_EOL;
								/////copy($caminho_arquivo, "../nomedosite/$arquivo");
								copy($caminho_arquivo, "../" .$data['query']['Site']. "/$arquivo");
							}
						}
					}

					/////$nome_arquivo = "../nomedosite/configuracao.php";
					$nome_arquivo = "../" .$data['query']['Site']. "/configuracao.php";
					//echo $nome_arquivo;
					$arquivo = fopen($nome_arquivo, 'r+');
					fwrite($arquivo, '<?php' . PHP_EOL);
					fwrite($arquivo, '//Dados da Empresa' . PHP_EOL);
					fwrite($arquivo, '$idSis_Empresa = ' . $data['idSis_Empresa'] . ';' . PHP_EOL);
					fclose($arquivo);
				}
				//Fim da cria��o do site da empresa///			
			
                $data['usuario'] = array(

                    'idSis_Empresa' => $data['idSis_Empresa'],
					'NomeEmpresa' => $data['query']['NomeEmpresa'],
					'Nome' => $data['query']['NomeAdmin'],
					'CelularUsuario' => $data['query']['CelularAdmin'],
					'DataCriacao' => $data['query']['DataCriacao'],
					'DataNascimento' => $data['query']['DataNascimento'],
					'Sexo' => $data['query']['Sexo'],
					'Senha' => $data['query']['Senha'],
					'Codigo' => $data['query']['Codigo'],
					'CpfUsuario' => $data['query']['CpfAdmin'],
					'Inativo' => "0",
					'Funcao' => "1",
					'idTab_Modulo' => "1",
					'Permissao' => "3"
                );
                $data['campos'] = array_keys($data['usuario']);

                $data['idSis_Usuario'] = $this->Loginempresa_model->set_usuario($data['usuario']);
				$_SESSION['log']['idSis_Empresa'] = 1;
				
                $data['documentos'] = array(
                    'idSis_Empresa' => $data['idSis_Empresa'],
                );
                $data['campos'] = array_keys($data['documentos']);
                $data['idApp_Documentos'] = $this->Loginempresa_model->set_documentos($data['documentos']);
				$_SESSION['log']['idSis_Empresa'] = 1;				
                
				$pasta1 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/';
				mkdir($pasta1, 0777);
				
				$pasta2 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/';
				mkdir($pasta2, 0777);
				
				$pasta21 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/original/';
				mkdir($pasta21, 0777);
				
				$pasta22 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/';
				mkdir($pasta22, 0777);				
				
				$arquivo_origem2 = 'arquivos/imagens/empresas/1/documentos/miniatura/SuaLogo.jpg';
				$arquivo_destino2 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/documentos/miniatura/SuaLogo.jpg';
				
				copy($arquivo_origem2, $arquivo_destino2);
				
				$pasta3 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/';
				mkdir($pasta3, 0777);
				
				$pasta31 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/original/';
				mkdir($pasta31, 0777);
				
				$pasta32 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/';
				mkdir($pasta32, 0777);				

				$arquivo_origem3 = 'arquivos/imagens/empresas/1/usuarios/miniatura/SuaFoto.jpg';
				$arquivo_destino3 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/usuarios/miniatura/SuaFoto.jpg';
				
				copy($arquivo_origem3, $arquivo_destino3);				
				
				$pasta4 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/';
				mkdir($pasta4, 0777);
				
				$pasta41 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/original/';
				mkdir($pasta41, 0777);
				
				$pasta42 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/';
				mkdir($pasta42, 0777);				
				
				$arquivo_origem4 = 'arquivos/imagens/empresas/1/clientes/miniatura/Foto.jpg';
				$arquivo_destino4 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/clientes/miniatura/Foto.jpg';
				
				copy($arquivo_origem4, $arquivo_destino4);
				
				$pasta5 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/';
				mkdir($pasta5, 0777);
				
				$pasta51 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/original/';
				mkdir($pasta51, 0777);
				
				$pasta52 = $_UP['pasta'] = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/';
				mkdir($pasta52, 0777);				
				
				$arquivo_origem5 = 'arquivos/imagens/empresas/1/produtos/miniatura/fotoproduto.jpg';
				$arquivo_destino5 = '../'.$_SESSION['log']['Site'].'/' .$data['idSis_Empresa'].'/produtos/miniatura/fotoproduto.jpg';
				
				copy($arquivo_origem5, $arquivo_destino5);
				
				if ($data['idSis_Usuario'] === FALSE) {
					$data['msg'] = '?m=2';
					$this->load->view('loginempresa/form_loginempresa', $data);
				} else {

					/*
					  echo $this->db->last_query();
					  echo "<pre>";
					  print_r($data);
					  echo "</pre>";
					  exit();
					 */
					$data['agenda'] = array(
						'NomeAgenda' => 'Usuario',
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['agenda']);

					$data['idApp_Agenda'] = $this->Loginempresa_model->set_agenda($data['agenda']);				
				
					$data['cliente'] = array(
						'NomeCliente' => 'AAAN�NIMO',
						'idTab_Modulo' => "1",
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['cliente']);

					$data['idApp_Cliente'] = $this->Loginempresa_model->set_cliente($data['cliente']);

					$data['fornecedor'] = array(
						'NomeFornecedor' => 'AAAN�NIMO',
						'idTab_Modulo' => "1",
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['fornecedor']);

					$data['idApp_Fornecedor'] = $this->Loginempresa_model->set_fornecedor($data['fornecedor']);
					
					$data['produto'] = array(
						'Produtos' => 'Produto Nao Cadastrado',
						'idTab_Modulo' => "1",
						'idSis_Usuario' => $data['idSis_Usuario'],
						'idSis_Empresa' => $data['idSis_Empresa']
					);
					$data['campos'] = array_keys($data['produto']);

					$data['idTab_Produto'] = $this->Loginempresa_model->set_produto($data['produto']);					

					if ($data['idTab_Produto'] === FALSE) {
						$data['msg'] = '?m=2';
						$this->load->view('loginempresa/form_loginempresa', $data);
					} else {
						
							$data['valor'] = array(
								'idTab_Produto' => $data['idTab_Produto'],
								'idSis_Usuario' => $data['idSis_Usuario'],
								'idSis_Empresa' => $data['idSis_Empresa'],
								'idTab_Modulo' => "1",
								'ValorProduto' => '0.00'
							);
							$data['campos'] = array_keys($data['valor']);

							$data['idTab_Valor'] = $this->Loginempresa_model->set_valor($data['valor']);					
					
					}				
				
				
				}			
			
                 /*          
                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($data['query']['Email']);

                $this->email->subject('[KTRACA] Confirma��o de registro - Usu�rio: ' . $data['query']['UsuarioEmpresa']);
               
                  $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                  . 'http://www.romati.com.br/app/loginempresa/confirmar/' . $data['query']['Codigo']);

                  $this->email->send();

                  $data['aviso'] = ''
                  . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Usu�rio cadastrado com sucesso!</b></p>
                  <p>O link para ativa��o foi enviado para seu e-mail cadastrado.</p>
                  <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>
                  </h4>
                  </div> '
                  . '';
                 

                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugest�o ou cr�tica ser� bem vinda. ');

                $this->email->send();
				*/
                $data['aviso'] = ''
                        . '
                  <div class="alert alert-success" role="alert">
                  <h4>
                  <p><b>Empresa cadastrado com sucesso!</b></p>
                  <p>Clique no bot�o abaixo e retorne para a tela de Login do Administrador, para entrar no sistema.</p>
                  </h4>
                  <br>
                  </div> '
                        . '';

                $this->load->view('loginempresa/tela_msg', $data);
                #redirect(base_url() . 'loginempresa' . $data['msg']);
                #exit();
            }
        }

        #$this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }
	
    public function confirmar($codigo) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;


        $data['anterior'] = array(
            'Inativo' => '1',
            'Codigo' => $codigo
        );

        $data['confirmar'] = array(
            'Inativo' => '0',
            'Codigo' => 'NULL'
        );

        $data['campos'] = array_keys($data['confirmar']);
        $id = $this->Loginempresa_model->get_data_by_codigo($codigo);

        if ($this->Loginempresa_model->ativa_usuario($codigo, $data['confirmar']) === TRUE) {

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_Empresa'], TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem'], $id['idSis_Empresa']);

            $data['msg'] = '?m=4';
            redirect(base_url() . 'loginempresa/' . $data['msg']);
        } else {
            $data['msg'] = '?m=5';
            redirect(base_url() . 'loginempresa/' . $data['msg']);
        }
    }

    public function recuperar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'UsuarioEmpresa',
                ), TRUE);

        if (isset($_GET['usuario']))
            $data['query']['UsuarioEmpresa'] = $_GET['usuario'];

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('UsuarioEmpresa', 'UsuarioEmpresa', 'required|trim|callback_valid_usuario');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_recuperar', $data);
        } else {

            $data['query']['Codigo'] = md5(uniqid(time() . rand()));

            $id = $this->Loginempresa_model->get_data_by_usuario($data['query']['UsuarioEmpresa']);

            if ($this->Loginempresa_model->troca_senha($id['idSis_Empresa'], array('Codigo' => $data['query']['Codigo'])) === FALSE) {

                $data['anterior'] = array(
                    'Codigo' => 'NULL'
                );

                $data['confirmar'] = array(
                    'Codigo' => $data['query']['Codigo']
                );

                $data['campos'] = array_keys($data['confirmar']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_Empresa'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem'], $id['idSis_Empresa']);

                $this->load->library('email');

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($id['Email']);

                $this->email->subject('[KTRACA] Altera��o de Senha - Usu�rio: ' . $data['query']['UsuarioEmpresa']);
                $this->email->message('Por favor, clique no link a seguir para alterar sua senha: '
                        //. 'http://www.romati.com.br/app/loginempresa/trocar_senha/' . $data['query']['Codigo']);
                        . base_url() . 'loginempresa/trocar_senha/' . $data['query']['Codigo']);

                $this->email->send();

                $data['aviso'] = ''
                        . '
                    <div class="alert alert-success" role="alert">
                        <h4>
                            <p><b>Link enviado com sucesso!</b></p>
                            <p>O link para alterar senha foi enviado para seu e-mail.</p>
                            <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>
                        </h4>
                    </div> '
                        . '';

                #$data['msg'] = '?m=4';
                $this->load->view('loginempresa/tela_msg', $data);
            } else {
                $data['msg'] = '?m=5';
                redirect(base_url() . 'loginempresa/' . $data['msg']);
            }
        }
    }

    public function trocar_senha($codigo = NULL) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_Empresa',
            'Email',
            'UsuarioEmpresa',
            'Codigo',
                ), TRUE);

        if ($codigo) {
            $data['query'] = $this->Loginempresa_model->get_data_by_codigo($codigo);
            $data['query']['Codigo'] = $codigo;
        } else {
            $data['query']['Codigo'] = $this->input->post('Codigo', TRUE);
        }

        $data['query']['Senha'] = $this->input->post('Senha', TRUE);
        $data['query']['Confirma'] = $this->input->post('Confirma', TRUE);

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('Codigo', 'C�digo', 'required|trim');
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('loginempresa/form_troca_senha', $data);
        } else {

            ###n�o est� registrando a auditoria do trocar senha. tenho que ver isso
            ###ver tamb�m o link para troca, quando expirado avisar
            #$id = $data['query']['Senha']
            $data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = NULL;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            if ($this->Loginempresa_model->troca_senha($data['query']['idSis_Empresa'], $data['query']) === TRUE) {
                $data['msg'] = '?m=2';
                $this->load->view('loginempresa/form_troca_senha', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_Empresa'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'UPDATE', $data['auditoriaitem'], $data['query']['idSis_Empresa']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['msg'] = '?m=1';
                redirect(base_url() . 'loginempresa' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footerloginempresa');
        $this->load->view('basico/footer');
    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log'] && $m === TRUE) {
            $this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'LOGOUT');
        } else {
            if (!isset($_SESSION['log']['idSis_Empresa'])) {
                $_SESSION['log']['idSis_Empresa'] = 1;
            }
            $this->Loginempresa_model->set_acesso($_SESSION['log']['idSis_Empresa'], 'TIMEOUT');
            $data['msg'] = '?m=2';
        }

        #clear de session data
        $this->session->unset_userdata('log');
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage

        /*
          #load header view
          $this->load->view('basico/headerloginempresa');

          $msg = "<strong>Voc� saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('loginempresa');
          $this->load->view('basico/footer');
         *
         */

        redirect(base_url() . 'loginempresa/' . $data['msg']);
        #redirect('loginempresa');
    }

	function valid_celular($celular) {

        if ($this->Loginempresa_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> n�o existe.');
            return FALSE;
        } else if ($this->Loginempresa_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
	function valid_empresa($empresa, $celular) {

        if ($this->Loginempresa_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function valid_senha($senha, $celular) {

        if ($this->Loginempresa_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	

}
