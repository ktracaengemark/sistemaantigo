<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Despesas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Fornecedor_model', 'Despesas_model', 'Relatorio_model', 'Empresa_model', 'Loginempresa_model'));
        $this->load->driver('session');

        #load header view
        //$this->load->view('basico/header_refresh_pedido');
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

        $this->load->view('relatorio/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }
    
    public function despesas() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'Orcamento',
			'Campo',
			'Ordenamento',
            'Fornecedor',
			'NomeFornecedor',
			'Dia',
			'Ano',
			'Mesvenc',
			'Mespag',
			'Tipo_Orca',
			'AVAP',
			'TipoFinanceiro',
			'TipoFinanceiroR',
			'TipoFinanceiroD',
            'DataInicio',
            'DataFim',
			'DataInicio2',
            'DataFim2',
			'DataInicio3',
            'DataFim3',
			'DataInicio4',
            'DataFim4',
			'ObsOrca',
            'AprovadoOrca',
            'QuitadoOrca',
			'ConcluidoOrca',
			'FinalizadoOrca',
			'CanceladoOrca',
			'CombinadoFrete',
			'Quitado',
			'Modalidade',
			'Orcarec',
			'Orcades',
			'FormaPagamento',
			'TipoFrete',
			'selecione',
        ), TRUE));
		
		$data['query']['selecione'] = ' 
			SELECT 
                C.idApp_Fornecedor,
				C.NomeFornecedor,
				C.Telefone1,
				OT.Descricao,
				OT.idApp_OrcaTrata,
				OT.AprovadoOrca,
				DATE_FORMAT(OT.DataOrca, "%d/%m/%Y") AS DataOrca,
				DATE_FORMAT(OT.DataEntregaOrca, "%d/%m/%Y") AS DataEntregaOrca,
				DATE_FORMAT(OT.HoraEntregaOrca, "%H:%i") AS HoraEntregaOrca,
				OT.DataEntradaOrca,
				OT.DataPrazo,
                OT.ValorOrca,
				OT.ValorDev,				
				OT.ValorEntradaOrca,
				OT.ValorRestanteOrca,
				OT.DataVencimentoOrca,
                OT.ConcluidoOrca,
                OT.QuitadoOrca,
				OT.FinalizadoOrca,
				OT.CanceladoOrca,
				OT.EnviadoOrca,
				OT.ProntoOrca,
                OT.DataConclusao,
                OT.DataQuitado,
				OT.DataRetorno,
				OT.idTab_TipoRD,
				OT.FormaPagamento,
				OT.ObsOrca,
				OT.QtdParcelasOrca,
				OT.Tipo_Orca,
				OT.CombinadoFrete,
                PR.idSis_Empresa,
				PR.Parcela,
				CONCAT(PR.Parcela) AS Parcela,
                DATE_FORMAT(PR.DataVencimento, "%d/%m/%Y") AS DataVencimento,
                PR.ValorParcela,
                PR.DataPago,
                PR.ValorPago,
                PR.Quitado,
				PRD.NomeProduto,
				PRD.ConcluidoProduto,
				TF.TipoFrete,
				MD.Modalidade,
				VP.Abrev2,
				VP.AVAP,
				TFP.FormaPag,
				TR.TipoFinanceiro
			FROM 
                App_OrcaTrata AS OT
					LEFT JOIN App_Fornecedor AS C ON C.idApp_Fornecedor = OT.idApp_Fornecedor
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

		$data['collapse'] = '';
		$data['collapse1'] = 'class="collapse"';
		
        $data['select']['AprovadoOrca'] = array(
			'0' => '::TODOS::',		
			'S' => 'Aprovado',
			'N' => 'N�o Aprovado',
        );

        $data['select']['QuitadoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Pago',
            'N' => 'N�o Pago',
        );

		$data['select']['ConcluidoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Entregues',
            'N' => 'N�o Entregues',
        );

		$data['select']['FinalizadoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Finalizado',
            'N' => 'N�o Finalizado',
        );

		$data['select']['CanceladoOrca'] = array(
			'0' => '::TODOS::',            
			'S' => 'Cancelado',
            'N' => 'N�o Cancelado',
        );

		$data['select']['CombinadoFrete'] = array(
			'0' => '::TODOS::',            
			'S' => 'Combinado',
            'N' => 'N�o Combinado',
        );

		$data['select']['Quitado'] = array(
			'0' => '::TODOS::',			
			'S' => 'Quitada',
			'N' => 'N�O Quitada',
        );
		
		$data['select']['Modalidade'] = array(
            '0' => '::TODOS::',
            'P' => 'Dividido',
            'M' => 'Mensal',
        );
		
		$data['select']['AVAP'] = array(
            '0' => '::TODOS::',
            'V' => 'Na Loja',
            'O' => 'On Line',
            'P' => 'Na Entrega',
        );

        $data['select']['Tipo_Orca'] = array(
			'0' => '::TODOS::',			
			'B' => 'Na Loja',
			'O' => 'On line',
        );		

		$data['select']['Campo'] = array(
            'OT.idApp_OrcaTrata' => 'Or�amento',
        );

        $data['select']['Ordenamento'] = array(
            'ASC' => 'Crescente',
            'DESC' => 'Decrescente',
        );
		
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
		$data['select']['FormaPagamento'] = $this->Relatorio_model->select_formapag();
		$data['select']['TipoFrete'] = $this->Relatorio_model->select_tipofrete();		
		
        $data['titulo'] = 'Gestor de Despesas';

        #run form validation
        if ($this->form_validation->run() !== TRUE) {
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Fornecedor'] = $data['query']['Fornecedor'];
            $data['bd']['TipoFinanceiroD'] = $data['query']['TipoFinanceiroD'];
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
			$data['bd']['DataInicio4'] = $this->basico->mascara_data($data['query']['DataInicio4'], 'mysql');
            $data['bd']['DataFim4'] = $this->basico->mascara_data($data['query']['DataFim4'], 'mysql');
			$data['bd']['Ordenamento'] = $data['query']['Ordenamento'];
            $data['bd']['Campo'] = $data['query']['Campo'];
            $data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
            $data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['FinalizadoOrca'] = $data['query']['FinalizadoOrca'];
			$data['bd']['CanceladoOrca'] = $data['query']['CanceladoOrca'];
			$data['bd']['CombinadoFrete'] = $data['query']['CombinadoFrete'];
			$data['bd']['Quitado'] = $data['query']['Quitado'];
			$data['bd']['Modalidade'] = $data['query']['Modalidade'];
            $data['bd']['FormaPagamento'] = $data['query']['FormaPagamento'];
			$data['bd']['TipoFrete'] = $data['query']['TipoFrete'];
			$data['bd']['Tipo_Orca'] = $data['query']['Tipo_Orca'];
			$data['bd']['AVAP'] = $data['query']['AVAP'];
			$data['bd']['selecione'] = $data['query']['selecione'];

            $data['report_combinar'] = $this->Despesas_model->list_despesas_combinar($data['bd'],TRUE);
			$data['report_aprovar'] = $this->Despesas_model->list_despesas_aprovar($data['bd'],TRUE);
            $data['report_pagonline'] = $this->Despesas_model->list_despesas_pagonline($data['bd'],TRUE);
            $data['report_producao'] = $this->Despesas_model->list_despesas_producao($data['bd'],TRUE);
            $data['report_envio'] = $this->Despesas_model->list_despesas_envio($data['bd'],TRUE);
            $data['report_entrega'] = $this->Despesas_model->list_despesas_entrega($data['bd'],TRUE);
            $data['report_pagamento'] = $this->Despesas_model->list_despesas_pagamento($data['bd'],TRUE);

			$data['pesquisar'] = $this->Despesas_model->list_despesas_pesquisar($data['bd'],TRUE);
			
			if ($data['pesquisar']->num_rows() == 1) {
				$info = $data['pesquisar']->result_array();
				
				redirect('Orcatrata/alterardesp/' . $info[0]['idApp_OrcaTrata'] );

				exit();
				
			} else {			
				$data['list_combinar'] = $this->load->view('despesas/list_despesas_combinar', $data, TRUE);
				$data['list_aprovar'] = $this->load->view('despesas/list_despesas_aprovar', $data, TRUE);
				$data['list_pagonline'] = $this->load->view('despesas/list_despesas_pagonline', $data, TRUE);
				$data['list_producao'] = $this->load->view('despesas/list_despesas_producao', $data, TRUE);
				$data['list_envio'] = $this->load->view('despesas/list_despesas_envio', $data, TRUE);
				$data['list_entrega'] = $this->load->view('despesas/list_despesas_entrega', $data, TRUE);
				$data['list_pagamento'] = $this->load->view('despesas/list_despesas_pagamento', $data, TRUE);
			}
        }

        $this->load->view('despesas/tela_despesas', $data);

        $this->load->view('basico/footer');
    }
}