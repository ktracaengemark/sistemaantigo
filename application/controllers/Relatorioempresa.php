<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorioempresa extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorioempresa_model', 'Login_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('relatorio/nav_secundario');
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

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorioempresa/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

	public function receitas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'Ano',
			'Mesvenc',
			'Mespag',			
			'TipoReceita',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'QuitadoRecebiveis',
			'Modalidade',
        ), TRUE));
/*
		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
						
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2018';
		
		if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));

	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
	   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());
*/
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());
	   
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		#$this->form_validation->set_rules('Mesvenc', 'M�s do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'M�s do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');        
		$this->form_validation->set_rules('DataInicio', 'Data In�cio do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio do Pagamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Or�amento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'N�o',
			'#' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['QuitadoRecebiveis'] = array(
            '#' => 'TODOS',
			'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['Modalidade'] = array(
            '#' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
        $data['select']['Campo'] = array(
            'PR.DataVencimentoRecebiveis' => 'Data do Venc.',
			'PR.DataPagoRecebiveis' => 'Data do Pagam.',
			'PR.QuitadoRecebiveis' => 'Quit.Parc.',
			'C.NomeCliente' => 'Nome do Cliente',
			'TR.TipoReceita' => 'Tipo de Receita',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrataCli' => 'N�mero do Or�amento',
            'OT.DataOrca' => 'Data do Or�amento',
            'OT.ValorOrca' => 'Valor do Or�amento',
            'OT.ConcluidoOrca' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataRetorno' => 'Data de Retorno',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorioempresa_model->select_cliente();
		$data['select']['TipoReceita'] = $this->Relatorioempresa_model->select_tiporeceita();
		$data['select']['Mesvenc'] = $this->Relatorioempresa_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorioempresa_model->select_mes();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimentoRecebiveis' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Receitas & Pagamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoReceita'] = $data['query']['TipoReceita'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoRecebiveis'] = $data['query']['QuitadoRecebiveis'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['report'] = $this->Relatorioempresa_model->list_receitas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_receitas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_receitas', $data);

        $this->load->view('basico/footer');

    }
	
	public function adminempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Relat�rio 1';
		$data['titulo2'] = 'Relat�rio 2';
		$data['titulo2'] = 'Relat�rio 3';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresa/tela_adminempresa', $data);

        $this->load->view('basico/footer');

    }	

	public function sistemaempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Assinatura';
		$data['titulo2'] = 'Comiss�o';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresa/tela_sistemaempresa', $data);

        $this->load->view('basico/footer');

    }

	public function funcionario() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.Nome' => 'Nome do Usu�rio',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_funcionario();
		$data['select']['Inativo'] = $this->Basico_model->select_inativo();
        
		$data['titulo'] = 'Usu�rios';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_funcionario($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_funcionario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_funcionario', $data);

        $this->load->view('basico/footer');



    }
	
	public function empresafilial() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.Nome' => 'Nome do Usu�rio',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_empresafilial();

        $data['titulo'] = 'Relat�rio Empresa ';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_empresafilial($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_empresafilial', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_empresafilial', $data);

        $this->load->view('basico/footer');



    }

	public function associado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'CategoriaEmpresa',
			'Atuacao',			
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');



		$data['select']['Campo'] = array(
            'E.NomeEmpresa' => 'Nome da Empresa',
			'CE.CategoriaEmpresa' => 'Categoria',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Munic�pio',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_associado();
		$data['select']['CategoriaEmpresa'] = $this->Relatorioempresa_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorioempresa_model->select_atuacao();		

        $data['titulo'] = 'Associados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];			
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_associado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_associado', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_associado', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'CategoriaEmpresa',
			'Atuacao',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.NomeEmpresa' => 'Nome da Empresa',
			'CE.CategoriaEmpresa' => 'Categoria',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Munic�pio',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_empresas();
		$data['select']['CategoriaEmpresa'] = $this->Relatorioempresa_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorioempresa_model->select_atuacao();

        $data['titulo'] = 'Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_empresas', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'E.idSis_Empresa' => 'n� Empresa',
			'E.NomeEmpresa' => 'Nome da Empresa',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Munic�pio',
            'E.Email' => 'E-mail',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_empresas();

        $data['titulo'] = 'Relat�rio de Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresa_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresa/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresa/tela_empresas', $data);

        $this->load->view('basico/footer');

    }

    public function login() {

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
        
		$celular = $this->input->get_post('CelularUsuario');
        $empresa = $this->input->get_post('idSis_Empresa');
		$senha = md5($this->input->get_post('Senha'));

        #set validation rules
        
		$this->form_validation->set_rules('CelularUsuario', 'Celular do Usu�rio', 'required|trim|callback_valid_celular');
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim|callback_check_empresa|callback_valid_empresa[' . $celular . ']');
		$this->form_validation->set_rules('Senha', 'Senha', 'required|trim|md5|callback_valid_senha[' . $celular . ']');

        #$data['select']['idSis_Empresa'] = $this->Login_model->select_empresa2();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa3();
		
		if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 3)
            $data['msg'] = $this->basico->msg('<strong>Sua sess�o expirou. Fa�a o login novamente.</strong>', 'erro', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 4)
            $data['msg'] = $this->basico->msg('<strong>Usu�rio ativado com sucesso! Fa�a o login para acessar o sistema.</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 5)
            $data['msg'] = $this->basico->msg('<strong>Link expirado.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('relatorioempresa/form_login', $data);
        } else {

            session_regenerate_id(true);

            #Get GET or POST data
            #$usuario = $this->input->get_post('Usuario');
            #$senha = md5($this->input->get_post('Senha'));
            /*
              echo "<pre>";
              print_r($query);
              echo "</pre>";
              exit();
             */
            
			$query = $this->Login_model->check_dados_celular($senha, $celular, TRUE);
			$query = $this->Login_model->check_dados_empresa($empresa, $celular, TRUE);
            $_SESSION['log']['Agenda'] = $this->Login_model->get_agenda_padrao($query['idSis_Usuario']);

            
			#### Carrega os dados da Empresa nas vari?ves de sess?o ####

			$_SESSION['log']['NivelEmpresa'] = $this->Login_model->get_empresa($query['idSis_Usuario']);
			$_SESSION['log']['DataDeValidade'] = $this->Login_model->get_empresa2($query['idSis_Usuario']);			
			
			#echo "<pre>".print_r($query)."</pre>";
            #exit();

            if ($query === FALSE) {
                #$msg = "<strong>Senha</strong> incorreta ou <strong>usu�rio</strong> inexistente.";
                #$this->basico->erro($msg);
                $data['msg'] = $this->basico->msg('<strong>Senha</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
				#$data['msg'] = $this->basico->msg('<strong>NomeEmpresa</strong> incorreta.', 'erro', FALSE, FALSE, FALSE);
                $this->load->view('relatorioempresa/form_login', $data);

            } else {
                #initialize session
                $this->load->driver('session');

                #$_SESSION['log']['Usuario'] = $query['Usuario'];
                //se for necess�rio reduzir o tamanho do nome de usu�rio, que pode ser um email
                $_SESSION['log']['Usuario'] = (strlen($query['Usuario']) > 13) ? substr($query['Usuario'], 0, 13) : $query['Usuario'];
				$_SESSION['log']['Nome'] = $query['Nome'];
				$_SESSION['log']['Nome2'] = (strlen($query['Nome']) > 6) ? substr($query['Nome'], 0, 6) : $query['Nome'];
				$_SESSION['log']['CpfUsuario'] = $query['CpfUsuario'];
				$_SESSION['log']['CelularUsuario'] = $query['CelularUsuario'];
				$_SESSION['log']['id'] = $query['idSis_Usuario'];
				$_SESSION['log']['idSis_Empresa'] = $query['idSis_Empresa'];
				#$_SESSION['log']['NivelEmpresa'] = $query['NivelEmpresa'];
				$_SESSION['log']['NomeEmpresa'] = $query['NomeEmpresa'];
				$_SESSION['log']['NomeEmpresa2'] = (strlen($query['NomeEmpresa']) > 6) ? substr($query['NomeEmpresa'], 0, 6) : $query['NomeEmpresa'];
				$_SESSION['log']['idSis_EmpresaMatriz'] = $query['idSis_EmpresaMatriz'];
				$_SESSION['log']['idTab_Modulo'] = $query['idTab_Modulo'];
				$_SESSION['log']['Permissao'] = $query['Permissao'];
				
                $this->load->database();
                $_SESSION['db']['hostname'] = $this->db->hostname;
                $_SESSION['db']['username'] = $this->db->username;
                $_SESSION['db']['password'] = $this->db->password;
                $_SESSION['db']['database'] = $this->db->database;

                if ($this->Login_model->set_acesso($_SESSION['log']['id'], 'LOGIN') === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o Administrador.</strong>";

                    $this->basico->erro($msg);
                    $this->load->view('relatorioempresa/form_login');
                } else {
					redirect('acesso');
					#redirect('agenda');
					#redirect('cliente');
                }
            }
        }

        #load footer view
        #$this->load->view('basico/footerlogin');
        $this->load->view('basico/footer');
    }

    function valid_celular($celular) {

        if ($this->Login_model->check_celular($celular) == 1) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> n�o existe.');
            return FALSE;
        } else if ($this->Login_model->check_celular($celular) == 2) {
            $this->form_validation->set_message('valid_celular', '<strong>%s</strong> inativo! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    function check_empresa($data) {

        if ($this->Login_model->check_empresa($data) == 1) {
            $this->form_validation->set_message('check_empresa', '<strong>%s</strong> n�o existe.');
            return FALSE;
        } else if ($this->Login_model->check_empresa($data) == 2) {
            $this->form_validation->set_message('check_empresa', '<strong>%s</strong> inativa! Fale com o Administrador da sua Empresa!');
            return FALSE;
        } else {
            return TRUE;
        }
    }	
	
	function valid_empresa($empresa, $celular) {

        if ($this->Login_model->check_dados_empresa($empresa, $celular) == FALSE) {
            $this->form_validation->set_message('valid_empresa', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
    function valid_senha($senha, $celular) {

        if ($this->Login_model->check_dados_celular($senha, $celular) == FALSE) {
            $this->form_validation->set_message('valid_senha', '<strong>%s</strong> incorreta!');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	
}
