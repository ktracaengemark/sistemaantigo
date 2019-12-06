<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Relatorio_model', 'Loginempresa_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

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
    
	public function financeiro1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',

            'OT.idApp_OrcaTrata' => 'Número do Orçamento',
            'OT.AprovadoOrca' => 'Orçamento Aprovado?',
            'OT.DataOrca' => 'Data do Orçamento',
            'OT.ValorOrca' => 'Valor do Orçamento',

            'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.QuitadoOrca' => 'Orçamento Quitado?',
            'OT.DataConclusao' => 'Data de Conclusão',
            'OT.DataQuitado' => 'Data de Quitado',
			'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',
			'PR.DataVencimento' => 'Data do Venc.',
			'PR.DataPago' => 'Data do Pagam.',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimento' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Orçamentos & Pagamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];

            $data['report'] = $this->Relatorio_model->list_financeiro($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_financeiro', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_financeiro', $data);

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
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
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

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		#$this->form_validation->set_rules('Mesvenc', 'Mês do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'Mês do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data In?cio do Vencimento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio2', 'Data In?cio do Pagamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio3', 'Data In?cio do Or?amento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim3', 'Data Fim do Or?amento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'0' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
            '0' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Quit.Parc.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Número da Receita',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimento' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Receitas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['report'] = $this->Relatorio_model->list_receitas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_receitas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_receitas', $data);

        $this->load->view('basico/footer');

    }

	public function despesas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            #'NomeCliente',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
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

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
		#$this->form_validation->set_rules('Mesvenc', 'Mês do Vencimento', 'required|trim');
		#$this->form_validation->set_rules('Mespag', 'Mês do Pagamento', 'required|trim');
		#$this->form_validation->set_rules('Ano', 'Ano', 'required|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Início do Vencimento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio2', 'Data Início do Pagamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio3', 'Data Início do Orçamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim3', 'Data Fim do Orçamento', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'0' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
            '0' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Quit.Parc.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Número da Receita',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Despesa',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		#$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroD();
		#$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tiporeceita();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimento' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Despesas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list_despesas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_despesas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_despesas', $data);

        $this->load->view('basico/footer');

    }

	public function receitasparc() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            #'NomeCliente',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
        ), TRUE));

		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
						
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2018';
		
		if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
/*		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];	   

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

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
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
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Quit.Parc.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Número da Receita',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		#$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimento' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Parcelas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list_receitasparc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_receitasparc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_receitasparc', $data);

        $this->load->view('basico/footer');

    }
	
	public function despesasparc() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            #'NomeCliente',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
        ), TRUE));

		if (!$data['query']['DataInicio2'])
           $data['query']['DataInicio2'] = date("d/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
		
		if (!$data['query']['DataFim2'])
           $data['query']['DataFim2'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
						
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2018';
		
		if (!$data['query']['DataFim'])
           $data['query']['DataFim'] = date("t/m/Y", mktime(0,0,0,date('m'),'01',date('Y')));
	   
/*	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
	   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		
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

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
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
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Quit.Parc.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Número da Receita',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		#$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		#$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		/*
        $data['select']['Pesquisa'] = array(
            'DataEntradaOrca' => 'Data de Entrada',
            'DataVencimento' => 'Data de Vencimento da Parcela',
        );
        */


        $data['titulo'] = 'Parcelas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list_despesasparc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_despesasparc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_despesasparc', $data);

        $this->load->view('basico/footer');

    }

	public function financeiro() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_OrcaTrata',
			'NomeCliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
			'AVAP',
			'FormaPag',
			'Orcarec',
			'Orcades',			
        ), TRUE));
/*
		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => 'TODOS',
			'N' => 'Não',
			'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'À Vista',
            'P' => 'À Prazo',
        );		

        $data['select']['Campo'] = array(
			'OT.idApp_OrcaTrata' => 'NºOrçam.',
			'OT.Modalidade' => 'Modalidade',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPag'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();		

        $data['titulo1'] = 'Receitas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
            
			$data['report'] = $this->Relatorio_model->list1_receitas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_receitas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
        $data['titulo2'] = 'Despesas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcades'] = $data['query']['Orcades'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
            
			$data['report'] = $this->Relatorio_model->list2_despesas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_despesas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_financeiro', $data);

        $this->load->view('basico/footer');

    }

	public function compvend() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idApp_OrcaTrata',
			'NomeCliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'DataInicio',
            'DataFim',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
			'AVAP',
			'FormaPag',
			'Orcarec',
			'Orcades',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'DataValidadeProduto',
        ), TRUE));
/*
		   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
   
	   if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['Imprimir']['idApp_OrcaTrata'] = $data['query']['idApp_OrcaTrata'];		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
		
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
		
        $data['select']['AprovadoOrca'] = array(
            '0' => 'TODOS',
			'N' => 'Não',
			'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => 'TODOS',
            'V' => 'À Vista',
            'P' => 'À Prazo',
        );		

        $data['select']['Campo'] = array(
			'TP.Produtos' => 'Produto',
			'TP3.Prodaux3' => 'Categoria',
			'TP2.Prodaux2' => 'Tipo',
			'TP1.Prodaux1' => 'Esp',
			'OT.idApp_OrcaTrata' => 'NºOrçam.',
			'OT.Modalidade' => 'Modalidade',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();		
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		$data['select']['FormaPag'] = $this->Relatorio_model->select_formapag();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();		

        $data['titulo1'] = 'Produtos Vendidos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');            
			$data['report'] = $this->Relatorio_model->list1_produtosvend($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_produtosvend', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
        $data['titulo2'] = 'Produtos Comprados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];
			$data['bd']['Orcades'] = $data['query']['Orcades'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['FormaPag'] = $data['query']['FormaPag'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];			
 			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');           
			$data['report'] = $this->Relatorio_model->list2_produtoscomp($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_produtoscomp', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_compvend', $data);

        $this->load->view('basico/footer');

    }

	public function compvend1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'NomeCliente',
			'CodProd',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
			#'DataInicio',
            #'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));
/*
        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', '|trim');
        #$this->form_validation->set_rules('DataInicio', 'Data Início', '|trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );		

        $data['select']['Campo'] = array(

			'OT.idApp_OrcaTrata' => 'Id Orçam.',
            'OT.DataOrca' => 'Data do Orçam.',
			'TPV.CodProd' => 'Código',
			'TPV.Produtos' => 'Produto',
			'TPV.Prodaux1' => 'Aux1',
			'TPV.Prodaux2' => 'Aux2',
			'TPV.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();

        $data['titulo1'] = 'Produtos Vendidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			#$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            #$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
            $data['report'] = $this->Relatorio_model->list1_produtosvend($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_produtosvend', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
		$data['titulo2'] = 'Produtos Comprados';
		
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			#$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            #$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
            $data['report'] = $this->Relatorio_model->list2_produtoscomp($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_produtoscomp', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_compvend', $data);

        $this->load->view('basico/footer');

    }

	public function fiado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
			'Orcarec',
			'Orcades',
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

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('DataInicio', 'Data Início do Vencimento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio2', 'Data Início do Pagamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio3', 'Data Início do Orçamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim3', 'Data Fim do Orçamento', 'trim|valid_date');

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'0' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODOS',			
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Parc.Quit.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Orçamento',
            'OT.ValorOrca' => 'Valor da Receita',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		

        $data['titulo1'] = 'Receita';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list1_receitasparcfiado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_receitasparcfiado', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
        $data['titulo2'] = 'Despesa';

		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcades'] = $data['query']['Orcades'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list2_despesasparcfiado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_despesasparcfiado', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_fiado', $data);

        $this->load->view('basico/footer');

    }

	public function parcelas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
			'Orcarec',
			'Orcades',
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

		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());	   
*/
        $_SESSION['FiltroAlteraParcela']['Dia'] = $data['query']['Dia'];
        $_SESSION['FiltroAlteraParcela']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroAlteraParcela']['Ano'] = $data['query']['Ano'];
		$_SESSION['FiltroAlteraParcela']['Quitado'] = $data['query']['Quitado'];
		$_SESSION['FiltroAlteraParcela']['Orcarec'] = $data['query']['Orcarec'];
		$_SESSION['FiltroAlteraParcela']['Orcades'] = $data['query']['Orcades'];
		$_SESSION['FiltroAlteraParcela']['NomeCliente'] = $data['query']['NomeCliente'];
		$_SESSION['FiltroAlteraParcela']['NomeFornecedor'] = $data['query']['NomeFornecedor'];		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('DataInicio', 'Data Início do Vencimento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim', 'Data Fim do Vencimento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio2', 'Data Início do Pagamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim2', 'Data Fim do Pagamento', 'trim|valid_date');
		#$this->form_validation->set_rules('DataInicio3', 'Data Início do Orçamento', 'trim|valid_date');
        #$this->form_validation->set_rules('DataFim3', 'Data Fim do Orçamento', 'trim|valid_date');

		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'0' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Parc.Quit.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Orçamento',
            'OT.ValorOrca' => 'Valor da Receita',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Orcarec'] = $this->Relatorio_model->select_orcarec();
		$data['select']['Orcades'] = $this->Relatorio_model->select_orcades();
		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['TipoFinanceiroR'] = $this->Relatorio_model->select_tipofinanceiroR();
		$data['select']['TipoFinanceiroD'] = $this->Relatorio_model->select_tipofinanceiroD();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();		

        $data['titulo1'] = 'Receita';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiroR'] = $data['query']['TipoFinanceiroR'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list1_receitasparc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_receitasparc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }
		
        $data['titulo2'] = 'Despesa';

		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Orcades'] = $data['query']['Orcades'];
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
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list2_despesasparc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_despesasparc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }		

        $this->load->view('relatorio/tela_parcelas', $data);

        $this->load->view('basico/footer');

    }

    public function balanco() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
		$data['query'] = quotes_to_entities($this->input->post(array(
			'Ano',
			'Mesvenc',
			'Mespag',
			'Diavenc',
			'Diapag',
			'TipoFinanceiro',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'Ordenamento',
            'Campo',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'Quitado',
			'Modalidade',
        ), TRUE));

        $_SESSION['FiltroBalanco']['Diavenc'] = $data['query']['Diavenc'];
        $_SESSION['FiltroBalanco']['Mesvenc'] = $data['query']['Mesvenc'];
        $_SESSION['FiltroBalanco']['Ano'] = $data['query']['Ano'];
		
        $data['select']['AprovadoOrca'] = array(
            'S' => 'Sim',
			'N' => 'Não',
			'0' => 'TODOS',
        );

        $data['select']['QuitadoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '0' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Quitado'] = array(
			'0' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => 'TODOS',
            'P' => 'Parcelas',
            'M' => 'Mensal',
        );

        $data['select']['Campo'] = array(
            'PR.DataVencimento' => 'Data do Venc.',
			'PR.Quitado' => 'Quit.Parc.',
			'OT.Modalidade' => 'Modalidade',
            'OT.idApp_OrcaTrata' => 'Número da Receita',
            'OT.ValorOrca' => 'Valor da Receita',
            'OT.ConcluidoOrca' => 'Receita Concluída?',
			'OT.TipoFinanceiro' => 'Tipo de Receita',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['ObsOrca'] = $this->Relatorio_model->select_obsorca();
		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipofinanceiro();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		$data['select']['Mespag'] = $this->Relatorio_model->select_mes();
		$data['select']['Diavenc'] = $this->Relatorio_model->select_dia();
		$data['select']['Diapag'] = $this->Relatorio_model->select_dia();
		$data['select']['Ano'] = $this->Relatorio_model->select_ano();
		/*
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = '2018';
		*/
		
		if (!$data['query']['Diavenc'])
           $data['query']['Diavenc'] = date('d', time());
	   
		if (!$data['query']['Mesvenc'])
           $data['query']['Mesvenc'] = date('m', time());
/*	   
		if (!$data['query']['Mespag'])
           $data['query']['Mespag'] = date('m', time());	   
*/	   
		if (!$data['query']['Ano'])
           $data['query']['Ano'] = date('Y', time());
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Ano', 'Ano', 'required|trim|integer|greater_than[1900]');

        $data['titulo1'] = 'Receita';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Diavenc'] = $data['query']['Diavenc'];
			$data['bd']['Diapag'] = $data['query']['Diapag'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list1_receitadiaria($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list1'] = $this->load->view('relatorio/list1_receitadiaria', $data, TRUE);

        }
		
        $data['titulo2'] = 'Despesa';
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            #$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Diavenc'] = $data['query']['Diavenc'];
			$data['bd']['Diapag'] = $data['query']['Diapag'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Mespag'] = $data['query']['Mespag'];			
			$data['bd']['ObsOrca'] = $data['query']['ObsOrca'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            
			$data['report'] = $this->Relatorio_model->list2_despesadiaria($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list2'] = $this->load->view('relatorio/list2_despesadiaria', $data, TRUE);

        }		
				
        $data['titulo3'] = 'Anual';
        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['report'] = $this->Relatorio_model->list_balancoanual($data['query']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list3'] = $this->load->view('relatorio/list_balancoanual', $data, TRUE);

        }
		

        $this->load->view('relatorio/tela_balanco', $data);

        $this->load->view('basico/footer');

    }
			
    public function estoque() {

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
			'TP.Prodaux3' => 'Categoria',
			'TP.Prodaux2' => 'Tipo',
			'TP.Produtos' => 'Produto',			
			'TP.CodProd' => 'Código',
			#'TP.idTab_Produto' => 'Id',
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

            $data['list'] = $this->load->view('relatorio/list_estoque', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque', $data);

        $this->load->view('basico/footer');

    }

	public function rankingvendas() {

	if ($this->input->get('m') == 1)
		$data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
	elseif ($this->input->get('m') == 2)
		$data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
	else
		$data['msg'] = '';

	$data['query'] = quotes_to_entities($this->input->post(array(
		'ValorOrca',
		'NomeCliente',
		'idApp_Cliente',
		'DataInicio',
		'DataFim',
		'Ordenamento',
		'Campo',
	), TRUE));

	$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
	#$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
	$this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
	$this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

	$data['select']['Campo'] = array(

		'TC.NomeCliente' => 'Cliente',
		'TC.idApp_Cliente' => 'Id',

	);

	$data['select']['Ordenamento'] = array(
		'ASC' => 'Crescente',
		'DESC' => 'Decrescente',
	);



	$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
	$data['select']['idApp_Cliente'] = $this->Relatorio_model->select_cliente();


	$data['titulo'] = 'Ranking de Vendas';

	#run form validation
	if ($this->form_validation->run() !== FALSE) {

		$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
		$data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
		$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
		$data['bd']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
		$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
		$data['bd']['Campo'] = $data['query']['Campo'];

		$data['report'] = $this->Relatorio_model->list_rankingvendas($data['bd']);

		/*
		  echo "<pre>";
		  print_r($data['report']);
		  echo "</pre>";
		  #exit();
		  #*/

		$data['list'] = $this->load->view('relatorio/list_rankingvendas', $data, TRUE);
		//$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
	}

	$this->load->view('relatorio/tela_rankingvendas', $data);

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
        $this->form_validation->set_rules('DataInicio', 'Data Inicio', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(
            'TP.CodProd' => 'Código',
            'TP.idTab_Produto' => 'Id',
            'TP.Produtos' => 'Produto',
            'TP.Categoria' => 'Prod/Serv',
            'TP.Prodaux1' => 'Aux1',
            'TP.Prodaux2' => 'Aux2',
            'TP.Prodaux3' => 'Categoria',

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
        if ($this->form_validation->run() !== FALSE) {

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Produtos'] = $data['query']['Produtos'];
            $data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
            $data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
            $data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_estoque($data['bd']);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_estoque', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_estoque', $data);

        $this->load->view('basico/footer');

    }

	public function admin() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Finanças & Estoque';
		$data['titulo3'] = 'Relatório 3';
		$data['titulo4'] = 'Comissão';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_admin', $data);

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

        $data['titulo1'] = 'Cadastrar';
		$data['titulo2'] = 'Relatórios';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

        }

        $this->load->view('relatorio/tela_adminempresa', $data);

        $this->load->view('basico/footer');

    }

	public function sistema() {

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

        $this->load->view('relatorio/tela_sistema', $data);

        $this->load->view('basico/footer');

    }

	public function produtosvend() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'CodProd',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoOrca',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Id Orçam.',
			'OT.AprovadoOrca' => 'Orç. Aprov./Fechado?',
            'OT.DataOrca' => 'Data do Orçam.',
			'TPV.CodProd' => 'Código',
			'TPV.Produtos' => 'Produto',
			'TPV.Prodaux1' => 'Aux1',
			'TPV.Prodaux2' => 'Aux2',
			'TPV.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();

        $data['titulo'] = 'Produtos Vendidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['report'] = $this->Relatorio_model->list_produtosvend($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtosvend', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtosvend', $data);

        $this->load->view('basico/footer');

    }

	public function produtoscomp() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeFornecedor',
			'CodProd',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoOrca',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeFornecedor' => 'Fornecedor',
			'OT.idApp_OrcaTrata' => 'Id Orçam.',
			'OT.AprovadoOrca' => 'Orç. Aprov./Fechado?',
            'OT.DataOrca' => 'Data do Orçam.',
			'TPV.CodProd' => 'Código',
			'TPV.Produtos' => 'Produto',
			'TPV.Prodaux1' => 'Aux1',
			'TPV.Prodaux2' => 'Aux2',
			'TPV.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeFornecedor'] = $this->Relatorio_model->select_fornecedor();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();

        $data['titulo'] = 'Produtos Comprados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['report'] = $this->Relatorio_model->list_produtoscomp($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtoscomp', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtoscomp', $data);

        $this->load->view('basico/footer');

    }
	
	public function produtosdevol1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'CodProd',
			'TipoDevolucao',
			'idTab_TipoRD',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoOrca',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Nº Dev.',
			'OT.Orcamento' => 'Nº Orç.',
            'OT.DataOrca' => 'Dt. Dev.',
			'OT.AprovadoDespesas' => 'Apr./Fech.',
			'OT.CodProd' => 'Cd. Prod.',
			'OT.TipoDevolucao' => 'Tipo de Devol.',
			'TPV.QtdProduto' => 'Qtd. do Produto',
			'TPV.Produtos' => 'Produto',
			'TPV.Prodaux1' => 'Aux1',
			'TPV.Prodaux2' => 'Aux2',
			'TPV.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['TipoDevolucao'] = $this->Relatorio_model->select_tipodevolucao();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();

		$data['titulo'] = 'Relatório de Produtos Devolvidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['TipoDevolucao'] = $data['query']['TipoDevolucao'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];



            $data['report'] = $this->Relatorio_model->list_produtosdevol1($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtosdevol1', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtosdevol1', $data);

        $this->load->view('basico/footer');

    }

	public function servicosprest1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Id Orçam.',
            'OT.DataOrca' => 'Data do Orçam.',
			'OT.ProfissionalOrca' => 'Responsável',
			'TPB.ServicoBase' => 'Serviço',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

        $data['titulo'] = 'Relatório de Serviços Prestados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_servicosprest($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_servicosprest', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_servicosprest', $data);

        $this->load->view('basico/footer');

    }

	public function servicosprest() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
			'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',

        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');


        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Id Orçam.',
            'OT.DataOrca' => 'Data do Orçam.',
			'OT.ProfissionalOrca' => 'Responsável',
			'PD.NomeServico' => 'Serviço',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

        $data['titulo'] = 'Relatório de Serviços Prestados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_servicosprest($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_servicosprest', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_servicosprest', $data);

        $this->load->view('basico/footer');

    }

	public function consumo() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoFinanceiro',
			'TipoProduto',
			'Produtos',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(

			'TCO.idApp_Despesas' => 'Id do Consumo',
            'TCO.DataDespesas' => 'Data do Consumo',
			'TCO.TipoFinanceiro' => 'Tipo de Consumo',
			'TCO.Despesa' => 'Consumo',
			'APC.QtdProduto' => 'Qtd. do Produto',
			'TPB.Produtos' => 'Produto',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipoconsumo();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();

        $data['titulo'] = 'Relatório de Produtos Cons. Inter.';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_consumo($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_consumo', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_consumo', $data);

        $this->load->view('basico/footer');

    }

	public function produtoscomp1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'TipoFinanceiro',
			'TipoProduto',
			'Produtos',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['Campo'] = array(

			'TCO.idApp_Despesas' => 'Id da Despesa',
            'TCO.DataDespesas' => 'Data da Despesa',
			'TCO.TipoFinanceiro' => 'Tipo de Despesa',
			'TCO.Despesa' => 'Descr. da Despesa',
			'APC.QtdProduto' => 'Qtd. do Produto',
			'TPB.Produtos' => 'Produto',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipodespesa();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();

        $data['titulo'] = 'Relatório de Produtos Comprados';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtoscomp($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtoscomp', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtoscomp', $data);

        $this->load->view('basico/footer');

    }

	public function produtosdevol() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'CodProd',
			'TipoFinanceiro',
			'TipoProduto',
			'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'AprovadoDespesas',
            'DataInicio',
            'DataFim',
			'Ordenamento',
            'Campo',
        ), TRUE));

        if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');
/*
        $data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
*/

		$data['select']['Campo'] = array(
			'C.NomeCliente' => 'Cliente',
			'TCO.idApp_Despesas' => 'Nº da Devol.',
			'TCO.idApp_OrcaTrata' => 'Nº do Orçam.',
            'TCO.DataDespesas' => 'Data da Devol.',
			'TCO.AprovadoDespesas' => 'Devol. Aprov./Fechado?',
			'TCO.CodProd' => 'Código',
			'TCO.TipoFinanceiro' => 'Tipo de Devol.',
			'TCO.Despesa' => 'Descr. da Devol.',
			'APC.QtdProduto' => 'Qtd. do Produto',
			'TPB.Produtos' => 'Produto',
			'TPB.Prodaux1' => 'Aux1',
			'TPB.Prodaux2' => 'Aux2',
			'TPB.Prodaux3' => 'Categoria',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

		$data['select']['TipoFinanceiro'] = $this->Relatorio_model->select_tipodespesa();
		$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Prodaux1'] = $this->Relatorio_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Relatorio_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Relatorio_model->select_prodaux3();



        $data['titulo'] = 'Relatório de Produtos Devolvidos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
			$data['bd']['TipoFinanceiro'] = $data['query']['TipoFinanceiro'];
			$data['bd']['TipoProduto'] = $data['query']['TipoProduto'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtosdevol($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtosdevol', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_produtosdevol', $data);

        $this->load->view('basico/footer');

    }

    public function orcamento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
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
			'ConcluidoOrca',
			'FormaPag',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Orçamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Orçamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',

            'OT.idApp_OrcaTrata' => 'Número do Orçamento',
            'OT.AprovadoOrca' => 'Orçamento Aprovado?',
            'OT.DataOrca' => 'Data do Orçamento',
			'OT.DataEntradaOrca' => 'Validade do Orçamento',
			'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Orçamento',
			'OT.ValorEntradaOrca' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
			'OT.FormaPag' => 'Forma de Pag.?',
            'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.QuitadoOrca' => 'Orçamento Quitado?',
            'OT.DataConclusao' => 'Data de Conclusão',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['FormaPag'] = $this->Relatorio_model->select_formapag();

        $data['titulo'] = 'Clientes & Orçamentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
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
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];

            $data['report'] = $this->Relatorio_model->list_orcamento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamento', $data);

        $this->load->view('basico/footer');



    }

	public function devolucao1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'idTab_TipoRD',
			'TipoDevolucao',
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
			'ConcluidoOrca',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Orçamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Orçamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio4', 'Data Início do Quitado', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim4', 'Data Fim do Quitado', 'trim|valid_date');


        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',

            'OT.idApp_OrcaTrata' => 'Nº Devol.',
            'OT.AprovadoOrca' => 'Apr./Fech.',
            'OT.DataOrca' => 'Dt. Devol.',
			'OT.TipoDevolucao' => 'Tipo Devol.',
			'OT.DataEntradaOrca' => 'Validade do Orçamento',
			'OT.DataPrazo' => 'Data da Entrega',
            'OT.ValorOrca' => 'Valor do Orçamento',
			'OT.ValorEntradaOrca' => 'Valor do Desconto',
			'OT.ValorRestanteOrca' => 'Valor a Receber',
            'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.QuitadoOrca' => 'Orçamento Quitado?',
            'OT.DataConclusao' => 'Data de Conclusão',
			'OT.DataQuitado' => 'Data de Quitado',
            'OT.DataRetorno' => 'Data de Retorno',
			'OT.ProfissionalOrca' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

        $data['titulo'] = 'Clientes & Devoluções';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['idTab_TipoRD'] = $data['query']['TipoDevolucao'];
			$data['bd']['TipoDevolucao'] = $data['query']['idTab_TipoRD'];
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
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];

            $data['report'] = $this->Relatorio_model->list_devolucao1($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_devolucao1', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_devolucao1', $data);

        $this->load->view('basico/footer');



    }

	public function devolucao() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idApp_Despesas',
			'idApp_OrcaTrata',
			'NomeCliente',
            'DataFim',
			'DataInicio',
            'DataFim2',
			'DataInicio2',
            'DataFim3',
			'DataInicio3',
            'Ordenamento',
            'Campo',
            'AprovadoDespesas',
            'QuitadoDespesas',
			'ConcluidoOrcaDespesas',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início do Orçamento', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim do Orçamento', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio2', 'Data Início da Entrega', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim2', 'Data Fim da Entrega', 'trim|valid_date');
		$this->form_validation->set_rules('DataInicio3', 'Data Início do Retorno', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim3', 'Data Fim do Retorno', 'trim|valid_date');


        $data['select']['AprovadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['QuitadoDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoOrcaDespesas'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(

			'C.NomeCliente' => 'Cliente',
            'OT.idApp_Despesas' => 'Número da Devolução',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
            'OT.AprovadoDespesas' => 'Orçamento Aprovado?',
            'OT.DataDespesas' => 'Data do Orçamento',
			'OT.DataEntradaDespesas' => 'Validade do Orçamento',
            'OT.ValorDespesas' => 'Valor do Orçamento',
			'OT.ValorEntradaDespesas' => 'Valor do Desconto',
			'OT.ValorRestanteDespesas' => 'Valor a Receber',

            'OT.ConcluidoOrcaDespesas' => 'Serviço Concluído?',
            'OT.QuitadoDespesas' => 'Orçamento Quitado?',
            'OT.DataConclusaoDespesas' => 'Data de Conclusão',

            'OT.DataRetornoDespesas' => 'Data de Retorno',
			'OT.ProfissionalDespesas' => 'Profissional',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

        $data['titulo'] = 'Clientes & Devoluções';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];

            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
			$data['bd']['DataInicio2'] = $this->basico->mascara_data($data['query']['DataInicio2'], 'mysql');
            $data['bd']['DataFim2'] = $this->basico->mascara_data($data['query']['DataFim2'], 'mysql');
			$data['bd']['DataInicio3'] = $this->basico->mascara_data($data['query']['DataInicio3'], 'mysql');
            $data['bd']['DataFim3'] = $this->basico->mascara_data($data['query']['DataFim3'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoDespesas'] = $data['query']['AprovadoDespesas'];
            $data['bd']['QuitadoDespesas'] = $data['query']['QuitadoDespesas'];
			$data['bd']['ConcluidoOrcaDespesas'] = $data['query']['ConcluidoOrcaDespesas'];

            $data['report'] = $this->Relatorio_model->list_devolucao($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_devolucao', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_devolucao', $data);

        $this->load->view('basico/footer');



    }

    public function clientes() {

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

            $data['list'] = $this->load->view('relatorio/list_clientes', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clientes', $data);

        $this->load->view('basico/footer');



    }

    public function clenkontraki() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeEmpresa',
			'NomeAdmin',
			'Inativo',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['Inativo'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
            'C.idSis_Empresa' => 'nº Emp.',
			'C.NomeEmpresa' => 'Empresa',
			'C.NomeAdmin' => 'Admin',
            'C.DataCriacao' => 'Criação',
			'C.DataDeValidade' => 'Validade',
			'C.NivelEmpresa' => 'Nivel',
			'C.Inativo' => 'Ativo',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_clenkontraki();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;

        $data['titulo'] = 'Clientes Enkontraki';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Inativo'] = $data['query']['Inativo'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_clenkontraki($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clenkontraki', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clenkontraki', $data);

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

	public function associado() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            'C.NomeEmpresa' => 'Nome da Empresa',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_associado();
		$data['select']['CategoriaEmpresa'] = $this->Relatorio_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorio_model->select_atuacao();		

        $data['titulo'] = 'Associados';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];			
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_associado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_associado', $data, TRUE);
        }

        $this->load->view('relatorio/tela_associado', $data);

        $this->load->view('basico/footer');

    }

	public function empresaassociado() {

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
            'C.NomeEmpresa' => 'idSis_Empresa',
            'C.Email' => 'E-mail',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresaassociado();

        $data['titulo'] = 'Relatório de Indicações';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresaassociado($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresaassociado', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresaassociado', $data);

        $this->load->view('basico/footer');

    }

	public function profissionais() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeProfissional',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
            'P.NomeProfissional' => 'Nome do Profissional',
			'P.Funcao' => 'Função',
            'P.DataNascimento' => 'Data de Nascimento',
            'P.Sexo' => 'Sexo',
            'P.Bairro' => 'Bairro',
            'P.Municipio' => 'Município',
            'P.Email' => 'E-mail',
			'CP.NomeContatoProf' => 'Contato do Profissional',
			'TCP.RelaPes' => 'Relação',
			'CP.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

        $data['titulo'] = 'Relatório de Funcionários';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_profissionais($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_profissionais', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_profissionais', $data);

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
            'F.Nome' => 'Nome do Funcionário',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Nome'] = $this->Relatorio_model->select_funcionario();

        $data['titulo'] = 'Relatório de Funcionários';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Nome'] = $data['query']['Nome'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_funcionario($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_funcionario', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_funcionario', $data);

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
            'E.Municipio' => 'Município',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresas();
		$data['select']['CategoriaEmpresa'] = $this->Relatorio_model->select_categoriaempresa();
		$data['select']['Atuacao'] = $this->Relatorio_model->select_atuacao();

        $data['titulo'] = 'Empresas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
			$data['bd']['CategoriaEmpresa'] = $data['query']['CategoriaEmpresa'];
			$data['bd']['Atuacao'] = $data['query']['Atuacao'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresas', $data);

        $this->load->view('basico/footer');

    }
	
	public function empresas1() {

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
            'E.idSis_Empresa' => 'nº idSis_Empresa',
			'E.NomeEmpresa' => 'Nome do Fornecedor',
			'E.Atividade' => 'Atividade',
            #'E.DataNascimento' => 'Data de Nascimento',
            #'E.Sexo' => 'Sexo',
            'E.Bairro' => 'Bairro',
            'E.Municipio' => 'Município',
            'E.Email' => 'E-mail',
			'CE.NomeContato' => 'Contato da idSis_Empresa',
			'TCE.RelaCom' => 'Relação',
			'CE.Sexo' => 'Sexo',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeEmpresa'] = $this->Relatorio_model->select_empresas();

        $data['titulo'] = 'Relatório de Fornecedores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['NomeEmpresa'] = $data['query']['NomeEmpresa'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_empresas($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_empresas', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_empresas', $data);

        $this->load->view('basico/footer');

    }

	public function fornecedor() {

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

            $data['list'] = $this->load->view('relatorio/list_fornecedor', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('profissional/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_fornecedor', $data);

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

	public function produtos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Produtos',
			'CodProd',
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
			'TP3.Prodaux3' => 'Categoria',
			'TP.Prodaux2' => 'Tipo',			
			'TP.Produtos' => 'Produto',			
			'TP.CodProd' => 'Código',
			#'TP.Prodaux1' => 'Aux1',
			#'TP.idTab_Produto' => 'Id',
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

        $data['titulo'] = 'Produtos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_produtos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_produtos', $data, TRUE);

        }

        $this->load->view('relatorio/tela_produtos', $data);

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
			'TP3.Prodaux3' => 'Categoria',
			'TP.Produtos' => 'Descrição',			
			'TP.CodProd' => 'Código',
			'TP.Prodaux1' => 'Aux1',
			'TP.Prodaux2' => 'Aux2',			
			#'TP.idTab_Produto' => 'Id',
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

        $data['titulo'] = 'Produtos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Produtos'] = $data['query']['Produtos'];
			$data['bd']['CodProd'] = $data['query']['CodProd'];
			$data['bd']['Categoria'] = $data['query']['Categoria'];
			$data['bd']['Prodaux1'] = $data['query']['Prodaux1'];
			$data['bd']['Prodaux2'] = $data['query']['Prodaux2'];
			$data['bd']['Prodaux3'] = $data['query']['Prodaux3'];
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

	public function servicos() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contatofornec com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Servicos',
			'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');


        $data['select']['Campo'] = array(
			'TP.idApp_Servicos' => 'id do Serviço',
			'TP.Servicos' => 'Serviço',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['Servicos'] = $this->Relatorio_model->select_servicos();

        $data['titulo'] = 'Servicos e Valores';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
			$data['bd']['Servicos'] = $data['query']['Servicos'];
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_servicos($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_servicos', $data, TRUE);

        }

        $this->load->view('relatorio/tela_servicos', $data);

        $this->load->view('basico/footer');

    }

	public function orcamentopc() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
			'NomeProfissional',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',
			'ConcluidoProcedimento',

        ), TRUE));

		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Orçamento Aprovado?',
			'OT.ValorOrca' => 'Valor do Orçamento',
            #'OT.QuitadoOrca' => 'Orçamento Quitado?',
			'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.DataConclusao' => 'Data de Conclusão',
            #'OT.DataRetorno' => 'Renovação',
			#'PD.QtdProduto' => 'Qtd. do Produto',
			'PD.idTab_Produto' => 'Produto',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional();

		$data['titulo'] = 'Clientes X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentopc($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentopc', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentopc', $data);

        $this->load->view('basico/footer');



    }

	public function tarefa() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'DataInicio',
            'DataFim',
            'NomeProfissional',
			'Profissional',
			'Ordenamento',
            'Campo',
            'TarefaConcluida',
            'Prioridade',
			'Rotina',
			'ConcluidoProcedtarefa',
			'ObsTarefa',
			'Procedtarefa',

        ), TRUE));
		/*
		if (!$data['query']['DataInicio'])
           $data['query']['DataInicio'] = '01/01/2017';
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['TarefaConcluida'] = array(
            'N' => 'Não',
			'#' => 'TODOS',
            'S' => 'Sim',
        );
/*
        $data['select']['Prioridade'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Rotina'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['ConcluidoProcedtarefa'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
        $data['select']['Campo'] = array(
           # 'C.NomeCliente' => 'Nome do Cliente',
			'TF.DataPrazoTarefa' => 'Prazo da Tarefa',
			'TF.DataTarefa' => 'Data do Tarefa',
			#'TF.ProfissionalTarefa' => 'Responsável',
			'TF.idApp_Tarefa' => 'Número do Tarefas',
			'TF.ObsTarefa' => 'Tarefa',
			'TF.Rotina' => 'Rotina',
			'TF.Prioridade' => 'Prioridade',
			'TF.TarefaConcluida' => 'Tarefa Concl.?',
			'TF.DataConclusao' => 'Data da Concl.',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        $data['select']['NomeProfissional'] = $this->Relatorio_model->select_profissional3();
		$data['select']['Profissional'] = $this->Relatorio_model->select_profissional2();
		$data['select']['ObsTarefa'] = $this->Relatorio_model->select_obstarefa();
		$data['select']['Procedtarefa'] = $this->Relatorio_model->select_procedtarefa();

        $data['titulo'] = 'Funcionários & Tarefas';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeProfissional'] = $data['query']['NomeProfissional'];
			$data['bd']['Profissional'] = $data['query']['Profissional'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');
            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['TarefaConcluida'] = $data['query']['TarefaConcluida'];
            $data['bd']['Prioridade'] = $data['query']['Prioridade'];
			$data['bd']['Rotina'] = $data['query']['Rotina'];
			$data['bd']['ConcluidoProcedtarefa'] = $data['query']['ConcluidoProcedtarefa'];
			$data['bd']['ObsTarefa'] = $data['query']['ObsTarefa'];
			$data['bd']['Procedtarefa'] = $data['query']['Procedtarefa'];


            $data['report'] = $this->Relatorio_model->list_tarefa($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_tarefa', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_tarefa', $data);

        $this->load->view('basico/footer');



    }

	public function clienteprod() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Ordenamento',
            'Campo',
			'AprovadoOrca',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

		$data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
			'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.AprovadoOrca' => 'Aprovado?',
			'PD.QtdProduto' => 'Qtd. do Produto',
			'PD.idTab_Produto' => 'Produto',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['titulo'] = 'Relatório Clientes X Produtos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			#$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

            $data['report'] = $this->Relatorio_model->list_clienteprod($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_clienteprod', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_clienteprod', $data);

        $this->load->view('basico/footer');



    }

	public function orcamentosv() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'NomeCliente',
            'DataInicio',
            'DataFim',
            'Ordenamento',
            'Campo',
            'AprovadoOrca',
            #'QuitadoOrca',
			'ConcluidoOrca',
			'ConcluidoProcedimento',

        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');
        $this->form_validation->set_rules('DataInicio', 'Data Início', 'required|trim|valid_date');
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'trim|valid_date');

        $data['select']['AprovadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
/*
        $data['select']['QuitadoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
*/
		$data['select']['ConcluidoOrca'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );
		$data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
            'N' => 'Não',
            'S' => 'Sim',
        );

        $data['select']['Campo'] = array(
            'C.NomeCliente' => 'Nome do Cliente',
			'OT.idApp_OrcaTrata' => 'Número do Orçamento',
			'OT.DataOrca' => 'Data do Orçamento',
            'OT.DataPrazo' => 'Data Prazo',
			'OT.AprovadoOrca' => 'Orçamento Aprovado?',
			'OT.ValorOrca' => 'Valor do Orçamento',
            #'OT.QuitadoOrca' => 'Orçamento Quitado?',
			'OT.ConcluidoOrca' => 'Serviço Concluído?',
            'OT.DataConclusao' => 'Data de Conclusão',
            #'OT.DataRetorno' => 'Renovação',
			#'PD.QtdProduto' => 'Qtd. do Produto',
			#'PD.idTab_Produto' => 'Produto',
			'SV.idTab_Servico' => 'Servico',
			'PC.DataProcedimento' => 'Data do Procedimento',
			'PC.Profissional' => 'Profissional',
			'PC.Procedimento' => 'Procedimento',
			'PC.ConcluidoProcedimento' => 'Proc. Concl.?',
			'PC.DataProcedimentoLimite' => 'Data Limite',

        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );

        $data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();

        $data['titulo'] = 'Relatório de Orçamentos X Procedimentos';

        #run form validation
        if ($this->form_validation->run() !== FALSE) {

            #$data['bd']['Pesquisa'] = $data['query']['Pesquisa'];
            $data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
            $data['bd']['DataInicio'] = $this->basico->mascara_data($data['query']['DataInicio'], 'mysql');
            $data['bd']['DataFim'] = $this->basico->mascara_data($data['query']['DataFim'], 'mysql');

            $data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            #$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];

			#$data['bd']['DataProcedimento'] = $this->basico->mascara_data($data['query']['DataProcedimento'], 'mysql');


            $data['report'] = $this->Relatorio_model->list_orcamentosv($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_orcamentosv', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_orcamentosv', $data);

        $this->load->view('basico/footer');



    }

    public function procedimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
            'N' => 'Não',
            'S' => 'Sim',
			'#' => 'TODOS',
        );

		$data['select']['Campo'] = array(
			'C.DataProcedimento' => 'Data',
			'C.ConcluidoProcedimento' => 'Concl.',
            'C.idApp_Procedimento' => 'id',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		
        $data['titulo'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_procedimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_procedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_procedimento', $data);

        $this->load->view('basico/footer');

    }

    public function alterarprocedimento() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'ConcluidoProcedimento',
            'Ordenamento',
            'Campo',
        ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        #$this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim');

        $data['select']['ConcluidoProcedimento'] = array(
            '#' => 'TODOS',
			'N' => 'Não',
            'S' => 'Sim',
        );

		$data['select']['Campo'] = array(
			'C.DataProcedimento' => 'Data',
			'C.ConcluidoProcedimento' => 'Concl.',
            'C.idApp_Procedimento' => 'id',
        );

        $data['select']['Ordenamento'] = array(
            'DESC' => 'Decrescente',
			'ASC' => 'Crescente',
        );

        #$data['select']['NomeCliente'] = $this->Relatorio_model->select_cliente();
		$data['select']['Dia'] = $this->Relatorio_model->select_dia();
		$data['select']['Mesvenc'] = $this->Relatorio_model->select_mes();
		
        $data['titulo'] = 'Tarefas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {

			$data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['ConcluidoProcedimento'] = $data['query']['ConcluidoProcedimento'];
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];

            $data['report'] = $this->Relatorio_model->list_alterarprocedimento($data['bd'],TRUE);

            /*
              echo "<pre>";
              print_r($data['report']);
              echo "</pre>";
              exit();
              */

            $data['list'] = $this->load->view('relatorio/list_alterarprocedimento', $data, TRUE);
            //$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        }

        $this->load->view('relatorio/tela_alterarprocedimento', $data);

        $this->load->view('basico/footer');

    }

    public function loginempresa() {

        #$_SESSION['log']['cliente'] = $_SESSION['log']['nome_modulo'] =
        $_SESSION['log']['nome_modulo'] = $_SESSION['log']['modulo'] = $data['modulo'] = $data['nome_modulo'] = 'profliberal';
        $_SESSION['log']['idTab_Modulo'] = 1;

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
