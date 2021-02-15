<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorioempresamatriz extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Profissional_model', 'Usuario_model', 'Relatorioempresamatriz_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresamatriz');
        $this->load->view('basico/nav_principalempresamatriz');

        #$this->load->view('relatorio/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('relatorioempresamatriz/tela_index', $data);

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
            'Nome',
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
			'ServicoConcluido',
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

		$data['select']['ServicoConcluido'] = array(
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
			'E.Nome' => 'Nome do Usuario',
			'TR.TipoReceita' => 'Tipo de Receita',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrataEmp' => 'N�mero do Or�amento',
            'OT.DataOrca' => 'Data do Or�amento',
            'OT.ValorOrca' => 'Valor do Or�amento',
            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataRetorno' => 'Data de Retorno',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['Nome'] = $this->Relatorioempresamatriz_model->select_usuarioemp();
		$data['select']['TipoReceita'] = $this->Relatorioempresamatriz_model->select_tiporeceita();
		$data['select']['Mesvenc'] = $this->Relatorioempresamatriz_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorioempresamatriz_model->select_mes();
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
            $data['bd']['Nome'] = $data['query']['Nome'];
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
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];
			$data['bd']['QuitadoRecebiveis'] = $data['query']['QuitadoRecebiveis'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['report'] = $this->Relatorioempresamatriz_model->list_receitas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_receitas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresamatriz/tela_receitas', $data);

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

        $this->load->view('relatorioempresamatriz/tela_adminempresa', $data);

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

        $data['titulo1'] = 'Manute��o';
		$data['titulo2'] = 'Comiss�o';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresamatriz/tela_sistemaempresa', $data);

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
			'idSis_UsuarioMatriz',
			'Nome',
			'Funcao',
			'DataCriacao',			
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.idSis_UsuarioMatriz' => 'id do Usu�rio',
			'F.Nome' => 'Nome do Usu�rio',
			'F.Sexo' => 'Sexo',
			'F.Funcao' => 'Funcao',
			'F.DataCriacao' => 'Data do Cadastro',
			
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresamatriz_model->select_funcionario();

        $data['titulo'] = 'Relat�rio de Funcion�rios';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresamatriz_model->list_funcionario($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_funcionario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresamatriz/tela_funcionario', $data);

        $this->load->view('basico/footer');



    }
	
	public function consultores() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(         
			'idSis_UsuarioMatriz',
			'Nome',
			'Funcao',
			'DataCriacao',			
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'F.idSis_UsuarioMatriz' => 'id do Usu�rio',
			'F.Nome' => 'Nome do Usu�rio',
			'F.Sexo' => 'Sexo',
			'F.Funcao' => 'Funcao',
			'F.DataCriacao' => 'Data do Cadastro',
			
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresamatriz_model->select_consultores();

        $data['titulo'] = 'Relat�rio de Consultores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresamatriz_model->list_consultores($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_consultores', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresamatriz/tela_consultores', $data);

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
            'F.Nome' => 'Nome da Filial',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresamatriz_model->select_empresafilial();

        $data['titulo'] = 'Relat�rio Empresa Filial';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresamatriz_model->list_empresafilial($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_empresafilial', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresamatriz/tela_empresafilial', $data);

        $this->load->view('basico/footer');



    }
	
    public function orcamentoempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Nome',
            'DataInicio',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
			'DataFim4',
			'DataInicio4',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ServicoConcluido',
			'FormaPag',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data In�cio do Or�amento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Or�amento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data In�cio da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data In�cio do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data In�cio do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'N�o',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'TSU.Nome' => 'Nome do Consultor',

            'OT.idApp_OrcaTrata' => 'N�mero do Or�amento',
            'OT.AprovadoOrca' => 'Or�amento Aprovado?',
            'OT.DataOrca' => 'Data do Or�amento',
			'OT.DataEntradaOrca' => 'Validade do Or�amento',
			'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Or�amento',
			'OT.ValorEntradaOrca' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
			'OT.FormaPag' => 'Forma de Pag.?',
            'OT.ServicoConcluido' => 'Servi�o Conclu�do?',
            'OT.QuitadoOrca' => 'Or�amento Quitado?',
            'OT.DataConclusao' => 'Data de Conclus�o',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresamatriz_model->select_usuarioemp();
		$data['select']['FormaPag'] = $this->Relatorioempresamatriz_model->select_formapag();

        $data['titulo'] = 'Usuarios & Or�amentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['Nome'] = $data['query']['Nome'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];

            $data['report'] = $this->Relatorioempresamatriz_model->list_orcamentoempresa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_orcamentoempresa', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresamatriz/tela_orcamentoempresa', $data);

        $this->load->view('basico/footer');



    }	

	public function produtosempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
			'CodProd',
			'Prodaux1',
			'Prodaux2',
			'idTab_Catprod',
			'Categoria',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.CodProd' => 'C�digo',
			'TP.idTab_Produtos' => 'Id',
			'TP.Produtos' => 'Descri��o',
			'TP.Categoria' => 'Prod/Serv',
			'TP.Prodaux1' => 'Aux1',
			'TP.Prodaux2' => 'Aux2',
			'TP.idTab_Catprod' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Produtos'] = $this->Relatorioempresamatriz_model->select_produtosemp();
		$data['select']['Prodaux1'] = $this->Relatorioempresamatriz_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorioempresamatriz_model->select_prodaux2();
		$data['select']['idTab_Catprod'] = $this->Relatorioempresamatriz_model->select_prodaux3();

        $data['titulo'] = 'Produtos, Servi�os e Valores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['idTab_Catprod'] = $data['query']['idTab_Catprod'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorioempresamatriz_model->list_produtosempresa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_produtosempresa', $data, TRUE);

        }

        $this->load->view('relatorioempresamatriz/tela_produtosempresa', $data);

        $this->load->view('basico/footerempresa');

    }
	
    public function balanco() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Ano',
        ), TRUE));
		
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = '2018';		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('Ano', 'Ano', 'required|trim|integer|greater_than[1900]');

        $data['titulo'] = 'Balan�o';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            $data['report'] = $this->Relatorioempresamatriz_model->list_balanco($data['query']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorioempresamatriz/list_balanco', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorioempresamatriz/tela_balanco', $data);

        $this->load->view('basico/footer');

    }
	
}
