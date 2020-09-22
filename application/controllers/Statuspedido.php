<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Statuspedido extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Usuario_model', 'Cliente_model', 'Fornecedor_model', 'Relatorio_model', 'Formapag_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header_refresh_statuspedido');
        $this->load->view('basico/nav_principal');

        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
            $data['msg'] = '';

		$this->load->view('orcatrata/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function alterarstatus($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            #Não há a necessidade de atualizar o valor do campo a seguir
            'idApp_Cliente',
            'DataOrca',
			'TipoFinanceiro',
			'DataPrazo',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
			'FinalizadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'ValorDev',
			'QtdPrdOrca',
            'ValorEntradaOrca',
			'ValorDinheiro',
			'ValorTroco',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			'Modalidade',
			#'idTab_TipoRD',
			#'AVAP',
			#'Tipo_Orca',
			'EnviadoOrca',
			'Cep',
			'Logradouro',
			'Numero',
			'Complemento',
			'Bairro',
			'Cidade',
			'Estado',
			'Referencia',
			#'TipoFrete',
			'ValorFrete',
			'CombinadoFrete',
			'PrazoEntrega',
			'ValorTotalOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'CanceladoOrca',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '1' : FALSE; 		
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '1' : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsProduto'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i)) {
                $data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
				$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
				$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
				$data['produto'][$j]['ObsProduto'] = $this->input->post('ObsProduto' . $i);
				$data['produto'][$j]['DataValidadeProduto'] = $this->input->post('DataValidadeProduto' . $i);
				$data['produto'][$j]['Aux_App_Produto_1'] = $this->input->post('Aux_App_Produto_1' . $i);
				$data['produto'][$j]['Aux_App_Produto_2'] = $this->input->post('Aux_App_Produto_2' . $i);
				$data['produto'][$j]['Aux_App_Produto_3'] = $this->input->post('Aux_App_Produto_3' . $i);
				$data['produto'][$j]['Aux_App_Produto_4'] = $this->input->post('Aux_App_Produto_4' . $i);
				$data['produto'][$j]['Aux_App_Produto_5'] = $this->input->post('Aux_App_Produto_5' . $i);
				$data['produto'][$j]['HoraValidadeProduto'] = $this->input->post('HoraValidadeProduto' . $i);
                $data['produto'][$j]['ConcluidoProduto'] = $this->input->post('ConcluidoProduto' . $i);
				$data['produto'][$j]['DevolvidoProduto'] = $this->input->post('DevolvidoProduto' . $i);
				$data['produto'][$j]['CanceladoProduto'] = $this->input->post('CanceladoProduto' . $i);
				$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataProcedimentoLimite' . $i) ||
				$this->input->post('Profissional' . $i) || $this->input->post('Prioridade' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['DataProcedimentoLimite'] = $this->input->post('DataProcedimentoLimite' . $i);				
                #$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
				$data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != '') {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['OrcaTrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata2($id);
            $data['orcatrata']['Tipo_Orca'] = $data['orcatrata']['Tipo_Orca'];
			$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'barras');
			$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'barras');
            $data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'barras');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'barras');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'barras');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'barras');
			$data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'barras');
            $data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'barras');

            #### Carrega os dados do cliente nas variáves de sessão ####
           # $this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
           # $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			#$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_Servico ####
            $data['servico'] = $this->Orcatrata_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
					}
                }
            }

            #### App_Produto ####
            $data['produto'] = $this->Orcatrata_model->get_produto($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['SubtotalComissaoProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100), 2, ',', '.');
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						///esta linha deve ser retirada após correção dos nomes dos pedidos antigos///
						$data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['Produto'];
					}

                }
            }

            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_parcelas($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
				
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
                    }

                }
            }

            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrata_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++) {
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
                        $data['procedimento'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimentoLimite'], 'barras');
					}
                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        #$this->form_validation->set_rules('DataOrca', 'Data do Orçamento', 'required|trim|valid_date');
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('Parcela', 'Parcela', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		if ($_SESSION['log']['NivelEmpresa'] >= '4' )
			$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('AVAP', 'À Vista ou À Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1ºVenc.', 'required|trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoProduto'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'Média',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Pedido';
        $data['form_open_path'] = 'statuspedido/alterarstatus';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if (isset($data['procedimento']) && ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional']))
        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';

        if ($_SESSION['log']['NivelEmpresa'] >= '4' )
            $data['visivel'] = '';
        else
            $data['visivel'] = 'style="display: none;"';		

        #Ver uma solução melhor para este campo
		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;

		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		/*
        $data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		*/
		
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;		

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
        );
        ($data['orcatrata']['Modalidade'] == 'P') ?
            $data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
        		
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Orçamento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Orçamento Finalizado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Orçamento Cancelado', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'S') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Pronto p/Entrega', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Orçamento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */
        $data['q'] = $this->Orcatrata_model->list1_produtosvend(TRUE);
        $data['list1'] = $this->load->view('orcatrata/list1_produtosvend', $data, TRUE);

		$data['q5'] = $this->Orcatrata_model->list5_produtosvend(TRUE);
		$data['list5'] = $this->load->view('orcatrata/list5_produtosvend', $data, TRUE);		
		
        $data['q2'] = $this->Orcatrata_model->list2_rankingfiado(TRUE);
        $data['list2'] = $this->load->view('orcatrata/list2_rankingfiado', $data, TRUE);
		
        $data['q3'] = $this->Orcatrata_model->list3_produtosaluguel(TRUE);
        $data['list3'] = $this->load->view('orcatrata/list3_produtosaluguel', $data, TRUE);

        $data['q6'] = $this->Orcatrata_model->list6_produtosaluguel(TRUE);
        $data['list6'] = $this->load->view('orcatrata/list6_produtosaluguel', $data, TRUE);
		
		$data['q4'] = $this->Orcatrata_model->list4_receitasparc(TRUE);
		$data['list4'] = $this->load->view('orcatrata/list4_receitasparc', $data, TRUE);

		$data['q7'] = $this->Orcatrata_model->list7_combinar(TRUE);
		$data['list7'] = $this->load->view('orcatrata/list7_combinar', $data, TRUE);

		$data['q8'] = $this->Orcatrata_model->list8_pagamentoonline(TRUE);
		$data['list8'] = $this->load->view('orcatrata/list8_pagamentoonline', $data, TRUE);
		
		$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_orcatrataalterarstatus', $data);
		} else {

			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            $data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
			$data['orcatrata']['Entregador'] = $data['orcatrata']['Entregador'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
			$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
            $data['orcatrata']['Descricao'] = $data['orcatrata']['Descricao'];
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
			if ($data['orcatrata']['CanceladoOrca'] == 'N'){
				if ($data['orcatrata']['AprovadoOrca'] == 'S'){
					if ($data['orcatrata']['FinalizadoOrca'] == 'S') {
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
					} else if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
					}
					if ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
					}
					
				} else {
					$data['orcatrata']['QuitadoOrca'] = "N";
					$data['orcatrata']['ConcluidoOrca'] = "N";
					$data['orcatrata']['DevolvidoOrca'] = "N";
				}
			} else {
				$data['orcatrata']['QuitadoOrca'] = "N";
				$data['orcatrata']['ConcluidoOrca'] = "N";
				$data['orcatrata']['DevolvidoOrca'] = "N";
				$data['orcatrata']['ProntoOrca'] = "N";
				$data['orcatrata']['EnviadoOrca'] = "N";
				$data['orcatrata']['AprovadoOrca'] = "N";
				$data['orcatrata']['FinalizadoOrca'] = "S";
			}

            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');

			
			#$data['orcatrata']['idTab_TipoRD'] = $data['orcatrata']['idTab_TipoRD'];
			#$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            #$data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            #$data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			
			if ($data['orcatrata']['PrazoEntrega']){
				$data['orcatrata']['PrazoEntrega'] = $data['orcatrata']['PrazoEntrega'];
			}else{
				//$data1 = date('Y-m-d', time());
				$data1 = $data['orcatrata']['DataOrca'];
				$data2 = $data['orcatrata']['DataEntregaOrca'];
				$intervalo = strtotime($data2)-strtotime($data1); 
				$dias = floor($intervalo / (60 * 60 * 24));
				$data['orcatrata']['PrazoEntrega'] = $dias;
			}

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata2($data['orcatrata']['idApp_OrcaTrata']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrata'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);

            #### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Produto');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['servico']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['servico']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
					$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "2";
					$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeProduto'], 'mysql');
                    unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
							$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
						}
						
					} else {
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'N';
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
                    unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
							$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
						}
					} else {
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'N';
					}
					if ($data['orcatrata']['idApp_Cliente']) $data['update']['servico']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
            }

            #### App_Produto ####
            $data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produto($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    if ($data['update']['produto']['inserir'][$j]['idSis_Usuario']) {$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $data['update']['produto']['inserir'][$j]['idSis_Usuario'];
					}else {$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];}
					$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['produto']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['produto']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "2";
					$data['update']['produto']['inserir'][$j]['NomeProduto'] = $data['update']['produto']['inserir'][$j]['NomeProduto'];
					unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
                    
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
						}
						if ($data['orcatrata']['DevolvidoOrca'] == 'S') { $data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
						}
					}
					else {	$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'N';
							$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'N';
					}                
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
                    $data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
					unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
						}
						if ($data['orcatrata']['DevolvidoOrca'] == 'S') { $data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
						}
					}
					else {	$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'N';
							$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'N';
					}
					if ($data['orcatrata']['idApp_Cliente']) $data['update']['produto']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

            }

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_parcelas($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    //$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
					}else{
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
					$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['QuitadoOrca'] == 'S') { $data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
						}
					}
					else {$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'N';
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['QuitadoOrca'] == 'S') { $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
						}
					}
					else {$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'N';
					}
					if ($data['orcatrata']['idApp_Cliente']) $data['update']['parcelasrec']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
				}

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

            }
			
            #### App_Procedimento ####
            $data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_procedimento($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'], 'mysql');
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'], 'mysql');					
					if ($data['orcatrata']['idApp_Cliente']) $data['update']['procedimento']['alterar'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
                }

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Orcatrata_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Orcatrata_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterarstatus', $data);
				
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				#redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
				redirect(base_url() . 'pedidos/pedidos/' . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

}
