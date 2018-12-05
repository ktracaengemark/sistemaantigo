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
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorioempresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/headerempresa');
        $this->load->view('basico/nav_principalempresa');

        #$this->load->view('relatorio/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
		#$this->form_validation->set_rules('Mesvenc', 'Mês do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'Mês do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');        
		$this->form_validation->set_rules('DataInicio', 'Data Início do Vencimento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início do Pagamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Orçamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Orçamento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'#' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ServicoConcluido'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['QuitadoRecebiveis'] = array(
            '#' => 'TODOS',
			'N' => 'Não',
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
            'OT.idApp_OrcaTrataCli' => 'Número do Orçamento',
            'OT.DataOrca' => 'Data do Orçamento',
            'OT.ValorOrca' => 'Valor do Orçamento',
            'OT.ServicoConcluido' => 'Serviço Concluído?',
            'OT.QuitadoOrca' => 'Orçamento Quitado?',
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
			$data['bd']['ServicoConcluido'] = $data['query']['ServicoConcluido'];
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Relatório 1';
		$data['titulo2'] = 'Relatório 2';
		$data['titulo2'] = 'Relatório 3';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresa/tela_adminempresa', $data);

        $this->load->view('basico/footer');

    }	

	public function sistemaempresa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Manuteção';
		$data['titulo2'] = 'Comissão';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorioempresa/tela_sistemaempresa', $data);

        $this->load->view('basico/footer');

    }

	public function funcionario() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            'F.Nome' => 'Nome do Usuário',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_funcionario();

        $data['titulo'] = 'Relatório de Funcionários';

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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            'F.Nome' => 'Nome do Usuário',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorioempresa_model->select_empresafilial();

        $data['titulo'] = 'Relatório Empresa ';

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

	public function empresas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            'E.idSis_Empresa' => 'nº Empresa',
			'E.NomeEmpresa' => 'Nome da Empresa',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Município',
            'E.Email' => 'E-mail',


        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorioempresa_model->select_empresas();

        $data['titulo'] = 'Relatório de Empresas';

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
	
}
