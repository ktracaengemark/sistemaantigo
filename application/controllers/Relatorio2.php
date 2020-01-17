<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        #$this->load->view('basico/nav_principal');

        #$this->load->view('relatorio/nav_secundario');
        if ($this->agent->is_browser()) {

            if (
                    (preg_match("/(chrome|Firefox)/i", $this->agent->browser()) && $this->agent->version() < 30) ||
                    (preg_match("/(safari)/i", $this->agent->browser()) && $this->agent->version() < 6) ||
                    (preg_match("/(opera)/i", $this->agent->browser()) && $this->agent->version() < 12) ||
                    (preg_match("/(internet explorer)/i", $this->agent->browser()) && $this->agent->version() < 9 )
            ) {
                $msg = '<h2><strong>Navegador não suportado.</strong></h2>';

                echo $this->basico->erro($msg);
                exit();
            }
        }		
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function produtos2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
			'CodProd',
			'TipoProduto',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Categoria',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.Produtos' => 'Produto',			
			'TP3.Prodaux3' => 'Categoria',
			'TP.Prodaux2' => 'Tipo',			
			'TP.Prodaux1' => 'Esp.',
			'TP.TipoProduto' => 'V/C/A',
			'TP.CodProd' => 'Código',
			#'TP.Categoria' => 'Prod/Serv',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();
		$data['select']['TipoProduto'] = $this->Relatorio_model->select_tipoproduto();

        $data['titulo'] = 'Produtos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtos2', $data, TRUE);

        }

        $this->load->view('relatorio/tela_produtos2', $data);

        $this->load->view('basico/footer');

    }
    
    public function estoque2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
            'CodProd',			
            'DataInicio',
            'DataFim',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(
			'TP.Produtos' => 'Produto',	
			'TP.Prodaux3' => 'Categoria',
			'TP.Prodaux2' => 'Tipo',
			'TP.Prodaux1' => 'Esp.',
			'TP.CodProd' => 'Código',
			'TP.TipoProduto' => 'V/C/A',
			#'TP.Categoria' => 'Prod/Serv',
			#'TP.Prodaux1' => 'Aux1',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );


        $data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();


        $data['titulo'] = 'Relatório de Estoque';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];			
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_estoque($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              #exit();
              #*/

            $data['list'] = $this->load->view('relatorio/list_estoque2', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque2', $data);

        $this->load->view('basico/footer');

    }

    public function clientes3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'Ativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Ativo'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idApp_Cliente' => 'nº Cliente',
			'C.NomeCliente' => 'Nome do Cliente',
			'C.Ativo' => 'Ativo',
            'C.DataNascimento' => 'Data de Nascimento',
            'C.Sexo' => 'Sexo',
            'C.Bairro' => 'Bairro',
            'C.Municipio' => 'Município',
            'C.Email' => 'E-mail',
			'CC.NomeContatoCliente' => 'Contato do Cliente',
			'TCC.RelaPes' => 'Rel. Pes.',
			'TCC.RelaCom' => 'Rel. Com.',
			'CC.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Clientes';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Ativo'] = $data['query']['Ativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_clientes($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clientes3', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clientes3', $data);

        $this->load->view('basico/footer');



    }

	public function fornecedor3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idApp_Fornecedor' => 'nº Fornecedor',
			'E.NomeFornecedor' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Município',
            'E.Email' => 'E-mail',
			'CE.NomeContatofornec' => 'Contatofornec da Fornecedor',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_fornecedor($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_fornecedor3', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_fornecedor3', $data);

        $this->load->view('basico/footer');

    }

    public function loginempresa() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

		$_SESSION['Empresa'] = $data['query'] = $this->Empresa_model->get_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
        ###################################################
        #só pra eu saber quando estou no banco de testes ou de produção
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

		#$data['select']['idSis_Empresa'] = $this->Loginempresa_model->select_empresa();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa31();
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sessão expirou. Faça o loginempresa novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usuário ativado com sucesso! Faça o loginempresa para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load loginempresa view
            $this->load->view('relatorio/form_loginempresa', $data);
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
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usuário</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('relatorio/form_loginempresa', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['UsuarioEmpresa'] = $query['UsuarioEmpresa'];
                //se for necessário reduzir o tamanho do nome de usuário, que pode ser um email
				$_SESSION['log']['UsuarioEmpresa'] = (strlen($query['UsuarioEmpresa']) > 13) ? substr($query['UsuarioEmpresa'], 0, 13) : $query['UsuarioEmpresa'];
                $_SESSION['log']['Nome'] = $query['NomeAdmin'];
				$_SESSION['log']['Nome2'] = (strlen($query['NomeAdmin']) > 6) ? substr($query['NomeAdmin'], 0, 6) : $query['NomeAdmin'];
				$_SESSION['log']['CpfAdmin'] = $query['CpfAdmin'];
				$_SESSION['log']['CelularAdmin'] = $query['CelularAdmin'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 15) ? substr($query['NomeEmpresa'], 0, 15) : $query['NomeEmpresa'];
				$_SESSION['log']['id'] = $query['idSis_Empresa'];
				$_SESSION['log']['PermissaoEmpresa'] = $query['PermissaoEmp'];
				$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['DataCriacao'] = $query['DataCriacao'];
				$_SESSION['log']['DataDeValidade'] = $query['DataDeValidade'];

                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Loginempresa_model->set_acesso($_SESSION['log']['id'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('relatorio/form_loginempresa');
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
	function valid_celular($celular) {

        if ($this->Loginempresa_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> não existe.');
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
