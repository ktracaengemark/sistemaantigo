<?php

#controlador de Logincli

defined('BASEPATH') OR exit('No direct script access allowed');

class Logincli extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model(array('Logincli_model', 'Basico_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('basico', 'form_validation', 'user_agent', 'email'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerlogin');

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
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
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
        $usuario = $this->input->get_post('UsuarioCli');
		#$nomeempresa = $this->input->get_post('NomeEmpresa');
        $senha = md5($this->input->get_post('Senha'));

        #set validation rules
        $this->form_validation->set_rules('UsuarioCli', 'Usu�rio', 'required|trim|callback_valid_usuario');
		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da Empresa', 'required|trim|callback_valid_nomeempresa[' . $usuario . ']');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $usuario . ']');

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sess�o expirou. Fa�a o logincli novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usu�rio ativado com sucesso! Fa�a o logincli para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load logincli view
            $this->load->view('logincli/form_logincli', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('UsuarioCli');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            $query = $this->Logincli_model->check_dados_usuario($senha, $usuario, TRUE);
            $_SESSION['log']['Agenda'] = $this->Logincli_model->get_agenda_cliente($query['idSis_UsuarioCli']);

            #echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usu�rio</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('form_logincli', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['UsuarioCli'] = $query['UsuarioCli'];
                //se for necess�rio reduzir o tamanho do nome de usu�rio, que pode ser um email
                $_SESSION['log']['UsuarioCli'] = (strlen($query['UsuarioCli']) > 15) ? substr($query['UsuarioCli'], 0, 15) : $query['UsuarioCli'];
				#$_SESSION['log']['Nome'] = (strlen($query['Nome']) > 8) ? substr($query['Nome'], 0, 8) : $query['Nome'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['id'] = $query['idSis_UsuarioCli'];
				#$_SESSION['log']['Empresa'] = $query['Empresa'];
				#$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				#$_SESSION['log']['NomeEmpresa'] = (strlen($query['NomeEmpresa']) > 12) ? substr($query['NomeEmpresa'], 0, 12) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Logincli_model->set_acesso($_SESSION['log']['id'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('form_logincli');
                } else {
					redirect('acessocli');
					#redirect('agendacli');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        $this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    public function registrar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'Email',
            'ConfirmarEmail',
            'UsuarioCli',
			#'NomeEmpresa',
            'Nome',
            'Senha',
            'Confirma',
            'DataNascimento',
            'Celular',
            'Sexo',
			'Funcao',
			'TipoProfissional',
			'DataCriacao',
			#'NumUsuarioClis',


                ), TRUE);

        (!$data['query']['DataCriacao']) ? $data['query']['DataCriacao'] = date('d/m/Y', time()) : FALSE;

		$this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

		#$this->form_validation->set_rules('NomeEmpresa', 'Nome da empresa', 'required|trim|is_unique[Sis_UsuarioCli.NomeEmpresa]');
        $this->form_validation->set_rules('Email', 'E-mail', 'required|trim|valid_email|is_unique[Sis_UsuarioCli.Email]');
        $this->form_validation->set_rules('ConfirmarEmail', 'Confirmar E-mail', 'required|trim|valid_email|matches[Email]');
        $this->form_validation->set_rules('UsuarioCli', 'Usu�rio', 'required|trim|is_unique[Sis_UsuarioCli.UsuarioCli]');
		$this->form_validation->set_rules('Nome', 'Nome do Usu�rio', 'required|trim');
        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
		$this->form_validation->set_rules('Celular', 'Celular', 'required|trim');
		#$this->form_validation->set_rules('NumUsuarioClis', 'N� de Usu�rios', 'required|trim');

		$data['select']['TipoProfissional'] = $this->Basico_model->select_tipoprofissional();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load logincli view
            $this->load->view('logincli/form_registrar', $data);
        } else {

			#$data['query']['Empresa'] = 0;
			#$data['query']['Funcao'] = 95;
			#$data['query']['UsuarioCliEmpresa'] = 1;
			#$data['query']['idSis_EmpresaFilial'] = 33;
			$data['query']['Associado'] = 33;
			$data['query']['Permissao'] = 1;
			$data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['query']['Senha'] = md5($data['query']['Senha']);
			$data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
			$data['query']['DataCriacao'] = $this->basico->mascara_data($data['query']['DataCriacao'], 'mysql');
            $data['query']['Codigo'] = md5(uniqid(time() . rand()));
            //$data['query']['Inativo'] = 1;
            //ACESSO LIBERADO PRA QUEM REALIZAR O CADASTRO
            $data['query']['Inativo'] = 0;
            unset($data['query']['Confirma'], $data['query']['ConfirmarEmail']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            $data['idSis_UsuarioCli'] = $this->Logincli_model->set_usuario($data['query']);
            $_SESSION['log']['id'] = 1;

            if ($data['idSis_UsuarioCli'] === FALSE) {
                $data['msg'] = '?m=2';
                $this->load->view('logincli/form_logincli', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_UsuarioCli']);
                $data['auditoria'] = $this->Basico_model->set_auditoriacli($data['auditoriaitem'], 'Sis_UsuarioCli', 'CREATE', $data['auditoriaitem'], $data['idSis_UsuarioCli']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['agenda'] = array(
                    'NomeAgenda' => 'Cliente',
                    'idSis_UsuarioCli' => $data['idSis_UsuarioCli']
                );
                $data['campos'] = array_keys($data['agenda']);

                $data['idApp_Agenda'] = $this->Logincli_model->set_agenda($data['agenda']);
                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['agenda'], $data['campos'], $data['idSis_UsuarioCli']);
                $data['auditoria'] = $this->Basico_model->set_auditoriacli($data['auditoriaitem'], 'App_Agenda', 'CREATE', $data['auditoriaitem'], $data['idSis_UsuarioCli']);

                #$this->load->library('email');

                //DADOS PARA ENVIO DE E-MAIL DE CONFIRMA��O DE INSCRI��O
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'smtplw.com.br';
                $config['smtp_user'] = 'trial';
                $config['smtp_pass'] = 'XzGyjtXI2256';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wrapchars'] = '50';
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['newline'] = "\r\n";

                $this->email->initialize($config);

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($data['query']['Email']);

                $this->email->subject('[KTRACA] Confirma��o de registro - Usu�rio: ' . $data['query']['UsuarioCli']);

                #$this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                #. 'http://www.romati.com.br/app/logincli/confirmar/' . $data['query']['Codigo']);
                $this->email->message('Por favor, clique no link a seguir para confirmar seu registro: '
                    . base_url() . 'logincli/confirmar/' . $data['query']['Codigo']);

                $this->email->send();
                #echo ($this->email->send(FALSE)) ? "sim" : "n�o";
                #echo $this->email->print_debugger(array('headers'));

                $data['aviso'] = ''
                    . '
                    <div class="alert alert-success" role="alert">
                    <h4>

                        <p><b>Usu�rio cadastrado com sucesso!</b></p>
                        <p>Entretanto, ele ainda encontra-se inativo no sistema. Um link de ativa��o foi gerado e enviado para
                            o e-mail <b>' . $data['query']['Email'] . '</b></p>
                        <p>Entre em sua caixa de e-mail e clique no link de ativa��o para habilitar seu acesso ao sistema.</p>
                        <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>

                    </h4>
                    <br>
                    <a class="btn btn-primary" href="' . base_url() . '" role="button">Acessar o aplicativo</a>
                    </div> '
                . '';

                /*
                $this->email->message('Sua conta foi ativada com sucesso! Aproveite e teste todas as funcionalidades do sistema.'
                        . 'Qualquer sugest�o ou cr�tica ser� bem vinda. ');

                $this->email->send();
                */

                $this->load->view('logincli/tela_msg', $data);
                #redirect(base_url() . 'logincli' . $data['msg']);
                #exit();
            }
        }

        $this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    public function confirmar($codigo) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;


        $data['anterior'] = array(
            'Inativo' => '1',
            'Codigo' => $codigo,
			'Empresa' => $id
        );

        $data['confirmar'] = array(
            'Inativo' => '0',
            'Codigo' => 'NULL',
			'Empresa' => $id
        );

        $data['campos'] = array_keys($data['confirmar']);
        $id = $this->Logincli_model->get_data_by_codigo($codigo);

        if ($this->Logincli_model->ativa_usuario($codigo, $data['confirmar']) === TRUE) {

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_UsuarioCli'], TRUE);
            $data['auditoria'] = $this->Basico_model->set_auditoriacli($data['auditoriaitem'], 'Sis_UsuarioCli', 'UPDATE', $data['auditoriaitem'], $id['idSis_UsuarioCli']);

            $data['msg'] = '?m=4';
            redirect(base_url() . 'logincli/' . $data['msg']);
        } else {
            $data['msg'] = '?m=5';
            redirect(base_url() . 'logincli/' . $data['msg']);
        }
    }

    public function recuperar() {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'UsuarioCli',
                ), TRUE);

        if (isset($_GET['usuario']))
            $data['query']['UsuarioCli'] = $_GET['usuario'];

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('UsuarioCli', 'UsuarioCli', 'required|trim|callback_valid_usuario');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load logincli view
            $this->load->view('logincli/form_recuperar', $data);
        } else {

            $data['query']['Codigo'] = md5(uniqid(time() . rand()));

            $id = $this->Logincli_model->get_data_by_usuario($data['query']['UsuarioCli']);

            if ($this->Logincli_model->troca_senha($id['idSis_UsuarioCli'], array('Codigo' => $data['query']['Codigo'])) === FALSE) {

                $data['anterior'] = array(
                    'Codigo' => 'NULL'
                );

                $data['confirmar'] = array(
                    'Codigo' => $data['query']['Codigo']
                );

                $data['campos'] = array_keys($data['confirmar']);

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['confirmar'], $data['campos'], $id['idSis_UsuarioCli'], TRUE);
                $data['auditoria'] = $this->Basico_model->set_auditoriacli($data['auditoriaitem'], 'Sis_UsuarioCli', 'UPDATE', $data['auditoriaitem'], $id['idSis_UsuarioCli']);

                #$this->load->library('email');

                //DADOS PARA ENVIO DE E-MAIL DE CONFIRMA��O DE INSCRI��O
                $config['protocol'] = 'smtp';
                $config['mailpath'] = "/usr/sbin/sendmail";
                $config['smtp_host'] = 'smtp.zoho.com';
                $config['smtp_user'] = 'contato@ktracaengemark.com.br';
                $config['smtp_pass'] = '20KtracaEngeMark17!';
                $config['charset'] = 'iso-8859-1';
                $config['mailtype'] = 'html';
                $config['wrapchars'] = '50';
                $config['smtp_port'] = '587';
                $config['smtp_crypto'] = 'tls';
                $config['newline'] = "\r\n";

                $this->email->initialize($config);

                $this->email->from('contato@ktracaengemark.com.br', 'KTRACA Engenharia & Marketing');
                $this->email->to($id['Email']);

                $this->email->subject('[KTRACA] Altera��o de Senha - Usu�rio: ' . $data['query']['UsuarioCli']);
                $this->email->message('Por favor, clique no link a seguir para alterar sua senha: '
                        //. 'http://www.romati.com.br/app/logincli/trocar_senha/' . $data['query']['Codigo']);
                    . base_url() . 'logincli/trocar_senha/' . $data['query']['Codigo']);

                $this->email->send();
                #echo ($this->email->send(FALSE)) ? "sim" : "n�o";
                #echo $this->email->print_debugger(array('headers'));

                $data['aviso'] = ''
                        . '
                    <div class="alert alert-success" role="alert">
                        <h4>
                            <p><b>Link enviado com sucesso!</b></p>
                            <p>O link para alterar senha foi enviado para o e-mail <b>' . $id['Email'] . '</b></p>
                            <p>Caso o e-mail com o link n�o esteja na sua caixa de entrada <b>verifique tamb�m sua caixa de SPAM</b>.</p>
                        </h4>
                    </div> '
                        . '';

                #$data['msg'] = '?m=4';
                $this->load->view('logincli/tela_msg', $data);
            } else {
                $data['msg'] = '?m=5';
                redirect(base_url() . 'logincli/' . $data['msg']);
            }
        }
    }

    public function trocar_senha($codigo = NULL) {

        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'ktraca';
        $_SESSION['log']['idTab_Modulo'] = 1;

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
            'idSis_UsuarioCli',
            'Email',
            'UsuarioCli',
            'Codigo',
                ), TRUE);

        if ($codigo) {
            $data['query'] = $this->Logincli_model->get_data_by_codigo($codigo);
            $data['query']['Codigo'] = $codigo;
        } else {
            $data['query']['Codigo'] = $this->input->post('Codigo', TRUE);
        }

        if (!$this->Logincli_model->get_data_by_codigo($data['query']['Codigo']))
            exit("Link expirado. Tente recuperar a senha novamente.");

        $data['query']['Senha'] = $this->input->post('Senha', TRUE);
        $data['query']['Confirma'] = $this->input->post('Confirma', TRUE);

        $this->form_validation->set_error_delimiters('<h5 style="color: red;">', '</h5>');

        $this->form_validation->set_rules('Senha', 'Senha', 'required|trim');
        $this->form_validation->set_rules('Confirma', 'Confirmar Senha', 'required|trim|matches[Senha]');
        #$this->form_validation->set_rules('Codigo', 'C�digo', 'required|trim');
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load logincli view
            $this->load->view('logincli/form_troca_senha', $data);
        } else {

            ###n�o est� registrando a auditoria do trocar senha. tenho que ver isso
            ###ver tamb�m o link para troca, quando expirado avisar
            #$id = $data['query']['Senha']
            $data['query']['Senha'] = md5($data['query']['Senha']);
            $data['query']['Codigo'] = NULL;
            unset($data['query']['Confirma']);

            $data['anterior'] = array();
            $data['campos'] = array_keys($data['query']);

            if ($this->Logincli_model->troca_senha($data['query']['idSis_UsuarioCli'], $data['query']) === TRUE) {
                $data['msg'] = '?m=2';
                $this->load->view('logincli/form_troca_senha', $data);
            } else {

                ##### AUDITORIA DESABILITADA! TENHO QUE VER ISSO! ##########

                #$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idSis_UsuarioCli'], TRUE);
                #$data['auditoria'] = $this->Basico_model->set_auditoriacli($data['auditoriaitem'], 'Sis_UsuarioCli', 'UPDATE', $data['auditoriaitem'], $data['query']['idSis_UsuarioCli']);
                /*
                  echo $this->db->last_query();
                  echo "<pre>";
                  print_r($data);
                  echo "</pre>";
                  exit();
                 */
                $data['msg'] = '?m=1';
                redirect(base_url() . 'logincli' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    public function sair($m = TRUE) {
        #change error delimiter view
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #set logout in database
        if ($_SESSION['log'] && $m === TRUE) {
            $this->Logincli_model->set_acesso($_SESSION['log']['id'], 'LOGOUT');
        } else {
            if (!isset($_SESSION['log']['id'])) {
                $_SESSION['log']['id'] = 1;
            }
            $this->Logincli_model->set_acesso($_SESSION['log']['id'], 'TIMEOUT');
            $data['msg'] = '?m=2';
        }

        #clear de session data
        $this->session->unset_userdata('log');
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage

        /*
          #load header view
          $this->load->view('basico/headerlogin');

          $msg = "<strong>Voc� saiu do sistema.</strong>";

          $this->basico->alerta($msg);
          $this->load->view('logincli');
          $this->load->view('basico/footer');
         *
         */

        redirect(base_url() . 'logincli/' . $data['msg']);
        #redirect('logincli');
    }

    function valid_usuario($data) {

        if ($this->Logincli_model->check_usuario($data) == 1) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> n�o existe.');
            return FALSE;
        } else if ($this->Logincli_model->check_usuario($data) == 2) {
            $this->form_validation->set_message('valid_usuario', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }



    function valid_senha($senha, $usuario) {

        if ($this->Logincli_model->check_dados_usuario($senha, $usuario) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta! Ou este n�o � o M�dulo do seu Sistema.');
            return FALSE;
        } else {
            return TRUE;
        }
    }


}
