<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Orcatrata extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Pedidos_model', 'Usuario_model', 'Cliente_model', 'Fornecedor_model', 'Relatorio_model', 'Formapag_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        #$this->load->view('orcatrata/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
			else
            $data['msg'] = '';

		$this->load->view('orcatrata/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($idApp_Cliente = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            'idApp_Cliente',
            'DataOrca',
			'HoraOrca',
			'DataPrazo',
			'TipoFinanceiro',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'ValorDev',
			'QtdPrdOrca',
			'QtdSrvOrca',
            'ValorEntradaOrca',
			'ValorDinheiro',
			'ValorTroco',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
			'Modalidade',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			'idTab_TipoRD',
			'AVAP',
			'EnviadoOrca',
			'Cep',
			'Logradouro',
			'Numero',
			'Complemento',
			'Bairro',
			'Cidade',
			'Estado',
			'Referencia',
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'CombinadoFrete',
			'PrazoEntrega',
			'ValorTotalOrca',
			'FinalizadoOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			'Cli_Forn_Orca',
			'Prd_Srv_Orca',
			
        ), TRUE));
		
		$data['cliente'] = $this->input->post(array(
			'idApp_Cliente',
			'CepCliente',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
        ), TRUE);
		
		if ($idApp_Cliente) {
            $data['query']['idApp_Cliente'] = $idApp_Cliente;
			$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($idApp_Cliente, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($idApp_Cliente);
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
		if(isset($data['query']['CepCliente'])){
			(!$data['orcatrata']['Cep']) ? $data['orcatrata']['Cep'] = $data['query']['CepCliente'] : FALSE;
		}
		
		if(isset($data['query']['EnderecoCliente'])){
			(!$data['orcatrata']['Logradouro']) ? $data['orcatrata']['Logradouro'] = $data['query']['EnderecoCliente'] : FALSE;
		}
		
		if(isset($data['query']['NumeroCliente'])){
			(!$data['orcatrata']['Numero']) ? $data['orcatrata']['Numero'] = $data['query']['NumeroCliente'] : FALSE;
		}
		
		if(isset($data['query']['ComplementoCliente'])){	
			(!$data['orcatrata']['Complemento']) ? $data['orcatrata']['Complemento'] = $data['query']['ComplementoCliente'] : FALSE;
		}
		
		if(isset($data['query']['BairroCliente'])){
		 (!$data['orcatrata']['Bairro']) ? $data['orcatrata']['Bairro'] = $data['query']['BairroCliente'] : FALSE;
		}
		
		if(isset($data['query']['CidadeCliente'])){
		 (!$data['orcatrata']['Cidade']) ? $data['orcatrata']['Cidade'] = $data['query']['CidadeCliente'] : FALSE;
		}
			
		if(isset($data['query']['EstadoCliente'])){
		 (!$data['orcatrata']['Estado']) ? $data['orcatrata']['Estado'] = $data['query']['EstadoCliente'] : FALSE;
		}
		
		if(isset($data['query']['ReferenciaCliente'])){
		 (!$data['orcatrata']['Referencia']) ? $data['orcatrata']['Referencia'] = $data['query']['ReferenciaCliente'] : FALSE;
		}

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        //Data de hoje como default
		(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
        (!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
		#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "2" : FALSE;
		(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
		(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
		(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
		(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
		//(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;

		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
				$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
				$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);                
				$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
				$j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataProcedimentoLimite' . $i) || 
					$this->input->post('Profissional' . $i) || $this->input->post('Prioridade' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
				$data['procedimento'][$j]['DataProcedimentoLimite'] = $this->input->post('DataProcedimentoLimite' . $i);
                $data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
				#$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
				
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;

		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;
		
		if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
			
            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];
				
				if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
				}
            }
			
        }
		
		/*
        if ($data['orcatrata']['ValorTotalOrca'] > 0) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

				if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
				}
           
			}

        }
		*/

        //Fim do trecho de c�digo que d� pra melhorar
		
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
		
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}
		
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('Modalidade', 'Tipo de Recebimento', 'required|trim');		
		#$this->form_validation->set_rules('ValorRestanteOrca', 'Valor da Receita', 'required|trim');		
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
		$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
        $data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
        $data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
        $data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Nova Receita';
        $data['form_open_path'] = 'orcatrata/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

		
		if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';

		
		$data['collapse'] = '';	

		$data['collapse1'] = 'class="collapse"';	
		
        if ($_SESSION['log']['NivelEmpresa'] >= '4' )
            $data['visivel'] = '';
        else
            $data['visivel'] = 'style="display: none;"';		
	
        #Ver uma solu��o melhor para este campo
        (!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '31' : FALSE;
		
		#(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		
		/*
        $data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		*/
		
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;		
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;       
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
        (!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
		
		($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
		
        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';		
		
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
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
			
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';

		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			
			
        $data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Or�amento Concluido', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

		$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
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
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('orcatrata/form_orcatrata', $data);
        } else {

			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            if ($data['orcatrata']['TipoFrete'] == '1') {
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
			} else {	
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			}
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
			$data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
            $data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
			$data['orcatrata']['Tipo_Orca'] = "B";
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
			
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
			$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			$data['orcatrata']['idTab_TipoRD'] = "2";
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['orcatrata']['Associado'] = $_SESSION['log']['idSis_Usuario'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['orcatrata']['Cli_Forn_Orca'] = 'S';
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
            $data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);

			#### APP_Cliente ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
				$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
				$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				/*
				$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['cliente']['anterior'],
					$data['cliente'],
					$data['update']['cliente']['campos'],
					$data['cliente']['idApp_Cliente'], TRUE);
				*/	
				$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */			
			
            #### App_Servico ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['servico'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
					$data['servico'][$j]['idTab_TipoRD'] = "2";
					$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'mysql');
                    $data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
                    unset($data['servico'][$j]['SubtotalProduto']);
					unset($data['servico'][$j]['SubtotalComissaoProduto']);
					unset($data['servico'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['servico'][$j]['ConcluidoProduto'] = 'S';
					}else{
						$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
					}	
				}
                $data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
            }

            #### App_Produto ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
					if ($data['produto'][$j]['idSis_Usuario']) {$data['produto'][$j]['idSis_Usuario'] = $data['produto'][$j]['idSis_Usuario'];
					}else {$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];}
                    $data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
					$data['produto'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['produto'][$j]['idTab_TipoRD'] = "2";
					$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
					$data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
                    $data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
                    $data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['NomeProduto'];
                    unset($data['produto'][$j]['SubtotalProduto']);
					unset($data['produto'][$j]['SubtotalComissaoProduto']);
					unset($data['produto'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['produto'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['produto'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
					}
				}
                $data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelasrec'])) {
                $max = count($data['parcelasrec']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
					$data['parcelasrec'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
                    $data['parcelasrec'][$j]['idTab_TipoRD'] = "2";
					$data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
                    $data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
                    $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');
					$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') {
						$data['parcelasrec'][$j]['Quitado'] = 'S';
					} else {
						$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
					}
                }
                $data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
            }

            #### App_Procedimento ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
					$data['procedimento'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['procedimento'][$j]['Profissional'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
                    $data['procedimento'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimentoLimite'], 'mysql');

                }
                $data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
            }
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}

			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_OrcaTrata'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_orcatrata', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				#redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);	
				exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function cadastrar3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            'idApp_Cliente',
            'DataOrca',
			'HoraOrca',
			'DataPrazo',
			'TipoFinanceiro',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
            'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'ValorDev',
			'QtdPrdOrca',
			'QtdSrvOrca',
            'ValorEntradaOrca',
			'ValorDinheiro',
			'ValorTroco',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
			'Modalidade',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			'idTab_TipoRD',
			'AVAP',
			'EnviadoOrca',
			'Cep',
			'Logradouro',
			'Numero',
			'Complemento',
			'Bairro',
			'Cidade',
			'Estado',
			'Referencia',
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'CombinadoFrete',
			'PrazoEntrega',
			'ValorTotalOrca',
			'FinalizadoOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			'Cli_Forn_Orca',
			'Prd_Srv_Orca',
        ), TRUE));
		
		$data['cliente'] = $this->input->post(array(
			'idApp_Cliente',
			'CepCliente',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
        ), TRUE);
		
        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('P2Count')) ? $data['count']['P2Count'] = 0 : $data['count']['P2Count'] = $this->input->post('P2Count');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		//(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');

        //Data de hoje como default
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
		(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;        
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
		#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
        (!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "2" : FALSE;
		(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
		(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
		(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
		(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
		//(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = '0.00' : FALSE;
		//(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
		//(!$data['orcatrata']['ValorRestanteOrca']) ? $data['orcatrata']['ValorRestanteOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorTotalOrca']) ? $data['orcatrata']['ValorTotalOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = 1 : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		
		/*
		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
				$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		*/
		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
				$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
				$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
				$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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

		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;
		
		if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
			
            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];
				
				if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
				}
            }
			
        }
		
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];

        //Fim do trecho de c�digo que d� pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
		
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}
		
		if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Cli_Forn_Orca'] == "S") {
			$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
			$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');
		} else {
			$data['cadastrar']['Cadastrar'] = 'S';
		}
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		if ($_SESSION['log']['NivelEmpresa'] >= '4') {
			$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		}
		//$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas Tem que ser maior que "0" ', 'required|trim|valid_qtdparcelas');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas Tem que ser maior que "0" ', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
		$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
        $data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
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
        #$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
        $data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Novo Pedido';
        $data['form_open_path'] = 'orcatrata/cadastrar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
		$data['tipofinan1'] = '1';

		$data['tipofinan12'] = '12';			
		
        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';
		
        if ($_SESSION['log']['NivelEmpresa'] >= '4' )
            $data['visivel'] = '';
        else
            $data['visivel'] = 'style="display: none;"';
		
		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		//(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		//(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		//(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;

		($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
        ($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		
		/*
		$data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';	        
		*/
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';		

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	

			
        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Prontos p/Entrega', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
        );
		($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';
			
			
        #Ver uma solu��o melhor para este campo
        #(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '1' : FALSE;
/*
        $data['radio'] = array(
            'TipoFinanceiro' => $this->basico->radio_checked($data['orcatrata']['TipoFinanceiro'], 'Tarefa Aprovado', 'NS'),
        );

        ($data['orcatrata']['TipoFinanceiro'] == '1') ? $data['div']['TipoFinanceiro'] = '' : $data['div']['TipoFinanceiro'] = 'style="display: none;"';			
*/
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

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

		$_SESSION['Empresa'] = $data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
		/*	 
		echo '<br>';
		echo "<pre>";
		print_r($_SESSION['Empresa']['CepEmpresa']);
		echo "</pre>";
		exit ();
		*/
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('orcatrata/form_orcatrata3', $data);
        } else {
		
			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];
            
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
			if ($data['orcatrata']['TipoFrete'] == '1') {
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
			} else {	
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			}
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
			$data['orcatrata']['Tipo_Orca'] = "B";
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
			
			$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
			$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			$data['orcatrata']['idTab_TipoRD'] = "2";
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa']; 
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['orcatrata']['Associado'] = $_SESSION['log']['idSis_Usuario'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
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
		
			$data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);
            
			#### APP_Cliente ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
				$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
				$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				/*
				$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['cliente']['anterior'],
					$data['cliente'],
					$data['update']['cliente']['campos'],
					$data['cliente']['idApp_Cliente'], TRUE);
				*/	
				$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */
			
            #### App_Servico ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['servico'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
					$data['servico'][$j]['idTab_TipoRD'] = "2";
					$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'mysql');
                    $data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
                    unset($data['servico'][$j]['SubtotalProduto']);
					unset($data['servico'][$j]['SubtotalComissaoProduto']);
					unset($data['servico'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['servico'][$j]['ConcluidoProduto'] = 'S';
					}else{
						$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
					}	
				}
                $data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
            }

            #### App_Produto ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
					if ($data['produto'][$j]['idSis_Usuario']) {$data['produto'][$j]['idSis_Usuario'] = $data['produto'][$j]['idSis_Usuario'];
					}else {$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];}
					$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['produto'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
					$data['produto'][$j]['idTab_TipoRD'] = "2";
					$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
                    $data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
                    $data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
                    $data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['NomeProduto'];
					unset($data['produto'][$j]['SubtotalProduto']);
					unset($data['produto'][$j]['SubtotalComissaoProduto']);
					unset($data['produto'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['produto'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['produto'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
					}
				}
                $data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelasrec'])) {
                $max = count($data['parcelasrec']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['parcelasrec'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];					
					$data['parcelasrec'][$j]['idTab_TipoRD'] = "2";
                    $data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
                    $data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
                    $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');
					$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') {
						$data['parcelasrec'][$j]['Quitado'] = 'S';
					} else {
						$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
					}
                }
                $data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
            }			

            #### App_Procedimento ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['procedimento'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
					$data['procedimento'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimentoLimite'], 'mysql');					
                }
                $data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
            }
			/*
			$data['update']['servico']['posterior'] = $this->Orcatrata_model->get_servico_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['servico']['posterior'])){
				$max_produto = count($data['update']['servico']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['ConcluidoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['CombinadoFrete'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			*/
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}

			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_OrcaTrata'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_orcatrata3', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/cadastrardesp/' . $data['msg']);
				redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);				
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

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            #N�o h� a necessidade de atualizar o valor do campo a seguir
            'idApp_Cliente',
            'DataOrca',
			'TipoFinanceiro',
			'DataPrazo',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
			'FinalizadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'QtdPrdOrca',
			'QtdSrvOrca',
			'ValorDev',
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
			'AVAP',
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
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'CombinadoFrete',
			'PrazoEntrega',
			'ValorTotalOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			//'Cli_Forn_Orca',
			//'Prd_Srv_Orca',
        ), TRUE));
		
		$data['cliente'] = $this->input->post(array(
			'idApp_Cliente',
			'CepCliente',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
        ), TRUE);

		//D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
		//(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		//(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE; 		
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);                
				$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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
		
		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;	

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];            
			
			if ($data['valoredit'][$i] > 0.00){
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;
		/*
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];		
		*/
		
		
		/*
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;
		*/
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
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
			$data['valortotalorca'] = $data['orcatrata']['ValorTotalOrca'];
			
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
            $this->load->model('Cliente_model');
            $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
            $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			
            #### App_Servico ####
            $data['servico'] = $this->Orcatrata_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
						$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
						$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
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
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						///talvez tenha que retirar esta linha///
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

		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}
		
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
        $data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
        $data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
        $data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['ProntoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoFrete'] = $this->Basico_model->select_tipofrete();
		$data['select']['DevolvidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['Modalidade'] = $this->Basico_model->select_modalidade();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Pedido';
        $data['form_open_path'] = 'orcatrata/alterar';
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

        #Ver uma solu��o melhor para este campo
		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		/*
        $data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		*/
		
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
 		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;		
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE; 
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		
		($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
        );
        ($data['orcatrata']['Modalidade'] == 'P') ?
            $data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
        
		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';		
		
		
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );

        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Pronto p/Entrega', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
		
        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"'; 		
		
        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';				

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
		*/
		
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
		
		$data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
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
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_orcatrataalterar', $data);
        } else {

			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            if ($data['orcatrata']['TipoFrete'] == '1') {
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
			} else {	
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			}
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
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
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
			
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));		
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
				$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			}else{
				$data['orcatrata']['ValorSomaOrca'] = $data['orcatrata']['ValorSomaOrca'];
				$data['orcatrata']['ValorTotalOrca'] = $data['orcatrata']['ValorTotalOrca'];
			}
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
			/*
            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrata'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
			*/
			#### APP_Cliente ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
				$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
				$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				/*
				$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['cliente']['anterior'],
					$data['cliente'],
					$data['update']['cliente']['campos'],
					$data['cliente']['idApp_Cliente'], TRUE);
				*/	
				$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */			
			
			#### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['ProfissionalProduto'] = $data['update']['servico']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
                    $data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    $data['update']['produto']['inserir'][$j]['NomeProduto'] = $data['update']['produto']['inserir'][$j]['NomeProduto'];
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
                    $data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
					}	
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                
				}

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
					}else {
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterar', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				#redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterar2($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            #N�o h� a necessidade de atualizar o valor do campo a seguir
            'idApp_Cliente',
            'DataOrca',
			'TipoFinanceiro',
			'DataPrazo',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
			'FinalizadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'QtdPrdOrca',
			'QtdSrvOrca',
			'ValorDev',
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
			'AVAP',
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
			'CombinadoFrete',
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'PrazoEntrega',
			'ValorTotalOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			//'Cli_Forn_Orca',
			//'Prd_Srv_Orca',
        ), TRUE));
		
		$data['cliente'] = $this->input->post(array(
			'idApp_Cliente',
			'CepCliente',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
        ), TRUE);

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
		//(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		//(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE; 		
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		/*
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		*/
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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

		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;	

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];            
			
			if ($data['valoredit'][$i] > 0.00){
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;
		/*
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];		
		
		echo '<br>';
		echo "<pre>";
		print_r($data['valortotalorca']);
		echo '<br>';
		print_r($data['somatotal']);
		echo '<br>';
		print_r($data['diferenca']);
		echo "</pre>";								
        */
		//Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
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
			$data['valortotalorca'] = $data['orcatrata']['ValorTotalOrca'];
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['valortotalorca']);
			echo "</pre>";
			exit ();
			*/
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
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
						$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
						$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
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
						//$data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
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

		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];		
		/*
		echo '<br>';
		echo "<pre>";
		print_r($data['valortotalorca']);
		echo '<br>';
		print_r($data['somatotal']);
		echo '<br>';
		print_r($data['diferenca']);
		echo "</pre>";		
		*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}		
		
		if ($_SESSION['log']['NivelEmpresa'] >= '4' ){
			//$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
			$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		}
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
        $data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
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
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Pedido';
        $data['form_open_path'] = 'orcatrata/alterar2';
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
		
		//(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
 		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
		
        ($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
		
		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
		*/
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
			
        $data['radio'] = array(
            'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
        );
        ($data['orcatrata']['Modalidade'] == 'P') ?
            $data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
        		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
		*/

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
            $this->load->view('orcatrata/form_orcatrataalterar2', $data);
		    	
		} else {
			
			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            if ($data['orcatrata']['TipoFrete'] == '1') {
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
			} else {	
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			}
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
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
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
					
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
				$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			}else{
				$data['orcatrata']['ValorSomaOrca'] = $data['orcatrata']['ValorSomaOrca'];
				$data['orcatrata']['ValorTotalOrca'] = $data['orcatrata']['ValorTotalOrca'];
			}
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
			/*
            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrata'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
			*/
            
			#### APP_Cliente ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
				$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
				$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				/*
				$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['cliente']['anterior'],
					$data['cliente'],
					$data['update']['cliente']['campos'],
					$data['cliente']['idApp_Cliente'], TRUE);
				*/	
				$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */			
			
			
			#### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['ProfissionalProduto'] = $data['update']['servico']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    $data['update']['produto']['inserir'][$j]['NomeProduto'] = $data['update']['produto']['inserir'][$j]['NomeProduto'];
					unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}                
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['ProfissionalProduto'] = $data['update']['produto']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
                    $data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
					unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
					}	
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    /*
					if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
					}else{
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
					*/
					$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
				}	

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
					}else {
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterar2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alteraronline($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            #N�o h� a necessidade de atualizar o valor do campo a seguir
            'idApp_Cliente',
            'DataOrca',
			'TipoFinanceiro',
			'DataPrazo',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
			'FinalizadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'QtdPrdOrca',
			'QtdSrvOrca',
			'ValorDev',
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
			'AVAP',
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
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'CombinadoFrete',
			'PrazoEntrega',
			'ValorTotalOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			//'Cli_Forn_Orca',
			//'Prd_Srv_Orca',
			'status',
        ), TRUE));
		
		$data['cliente'] = $this->input->post(array(
			'idApp_Cliente',
			'CepCliente',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
        ), TRUE);

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
		//(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		//(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE; 		
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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
		
		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;
		
		if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
			
            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];
				
				if ($this->input->post('idApp_Parcelas' . $i) || $this->input->post('Parcela' . $i) || 
					$this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
					$data['parcelasrec'][$i]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
				}
            }
			
        }
		/*
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];		
		*/
		/*
        if ($data['orcatrata']['QtdParcelasOrca'] > 0 ) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {
				
				if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
					$data['parcelasrec'][$i]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
					//$data['parcelasrec'][$i]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				}
            }

        }		
		*/
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
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
			$data['valortotalorca'] = $data['orcatrata']['ValorTotalOrca'];
            
			#### Carrega os dados do cliente nas vari�ves de sess�o ####
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
						$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
						$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
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
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
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

		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}
		
		if ($_SESSION['log']['NivelEmpresa'] >= '4' ){
			//$this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
			$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		}
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
        $data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroR();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
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
		/*
		if ($data['orcatrata']['Tipo_Orca']= 'B' ){
			$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();
		}else{
			$data['select']['idApp_Cliente'] = $this->Cliente_model->select_clienteonline();
		}
		*/
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Pedido';
        $data['form_open_path'] = 'orcatrata/alteraronline';
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

		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'S' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'S' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'S' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;		
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
 		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
		
        ($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
		
		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
		*/
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
			
        $data['radio'] = array(
            'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
        );
        ($data['orcatrata']['Modalidade'] == 'P') ?
            $data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
        		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
		*/

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
            //$this->load->view('orcatrata/form_orcatrataalterar2', $data);
			$this->load->view('orcatrata/form_orcatrata_online', $data);
			/*
			if ($data['orcatrata']['Tipo_Orca']= 'B' ){
				$this->load->view('orcatrata/form_orcatrataalterar2', $data);
			} else if($data['orcatrata']['Tipo_Orca']= 'O' ){
				$this->load->view('orcatrata/form_orcatrata3', $data);
			}
			*/
		} else {

			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            if ($data['orcatrata']['TipoFrete'] == '1') {
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
			} else {	
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			}
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
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
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
			
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
				$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			}else{
				$data['orcatrata']['ValorSomaOrca'] = $data['orcatrata']['ValorSomaOrca'];
				$data['orcatrata']['ValorTotalOrca'] = $data['orcatrata']['ValorTotalOrca'];
			}
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
			/*
            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrata'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
			*/
            
			#### APP_Cliente ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
				$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
				$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				/*
				$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['cliente']['anterior'],
					$data['cliente'],
					$data['update']['cliente']['campos'],
					$data['cliente']['idApp_Cliente'], TRUE);
				*/	
				$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */			
			
			
			#### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
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
                    $data['update']['servico']['alterar'][$j]['ProfissionalProduto'] = $data['update']['servico']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
					$data['update']['produto']['inserir'][$j]['NomeProduto'] = $data['update']['produto']['inserir'][$j]['NomeProduto'];
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}               
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
                    $data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
					unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
					}	
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					/* 
					if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
					}else{
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
					*/
					$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
					}else {
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				//$this->load->view('orcatrata/form_orcatrataalterar2', $data);
				$this->load->view('orcatrata/form_orcatrata_online', $data);
				/*
				if ($data['orcatrata']['Tipo_Orca']= 'B' ){
					$this->load->view('orcatrata/form_orcatrataalterar2', $data);
				} else if($data['orcatrata']['Tipo_Orca']= 'O' ){
					$this->load->view('orcatrata/form_orcatrata3', $data);
				}
				*/
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				redirect(base_url() . 'OrcatrataPrint/imprimir/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarstatus($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            #N�o h� a necessidade de atualizar o valor do campo a seguir
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
			'QtdPrdOrca',
			'QtdSrvOrca',
			'ValorDev',
            'ValorEntradaOrca',
			'ValorDinheiro',
			'ValorTroco',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			#'Modalidade',
			#'idTab_TipoRD',
			'AVAP',
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
			'CombinadoFrete',
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'PrazoEntrega',
			'ValorTotalOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			//'Cli_Forn_Orca',
			//'Prd_Srv_Orca',
        ), TRUE));
		
		$data['cliente'] = $this->input->post(array(
			'idApp_Cliente',
			'CepCliente',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
        ), TRUE);

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['idApp_Cliente']) ? $data['orcatrata']['idApp_Cliente'] = '0' : FALSE;
		//(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		//(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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
				//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
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
			
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
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
						$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
						$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
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
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
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
        
		#$this->form_validation->set_rules('DataProcedimento', 'DataProcedimento', 'required|trim');
        #$this->form_validation->set_rules('Parcela', 'Parcela', 'required|trim');
        #$this->form_validation->set_rules('ProfissionalOrca', 'Profissional', 'required|trim');
		//if ($_SESSION['log']['NivelEmpresa'] >= '4' ) $this->form_validation->set_rules('idApp_Cliente', 'Cliente', 'required|trim');
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		if ($_SESSION['log']['NivelEmpresa'] >= '4') {
			$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		}
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
        $data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
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
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Produto'] = $this->Basico_model->select_produtos3();
		$data['select']['Servico'] = $this->Basico_model->select_servicos3();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Pedido';
        $data['form_open_path'] = 'orcatrata/alterarstatus';
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

		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		//(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;		
		//(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
 		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
		
        ($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
		
		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
		*/
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
		/*	
        $data['radio'] = array(
            'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
        );
        ($data['orcatrata']['Modalidade'] == 'P') ?
            $data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
        */		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
		*/

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

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
            if ($data['orcatrata']['TipoFrete'] == '1') {
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
			} else {	
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			}
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
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
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}		
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            
			$data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
				$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			}else{
				$data['orcatrata']['ValorSomaOrca'] = $data['orcatrata']['ValorSomaOrca'];
				$data['orcatrata']['ValorTotalOrca'] = $data['orcatrata']['ValorTotalOrca'];
			}
			
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
            
			#### APP_Cliente ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['cliente']['CepCliente'] = $data['orcatrata']['Cep'];
				$data['cliente']['EnderecoCliente'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['cliente']['NumeroCliente'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['cliente']['ComplementoCliente'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['cliente']['BairroCliente'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['cliente']['CidadeCliente'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['cliente']['EstadoCliente'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['cliente']['ReferenciaCliente'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['cliente']['anterior'] = $this->Orcatrata_model->get_cliente($data['orcatrata']['idApp_Cliente']);
				$data['update']['cliente']['campos'] = array_keys($data['cliente']);
				/*
				$data['update']['cliente']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['cliente']['anterior'],
					$data['cliente'],
					$data['update']['cliente']['campos'],
					$data['cliente']['idApp_Cliente'], TRUE);
				*/	
				$data['update']['cliente']['bd'] = $this->Orcatrata_model->update_cliente($data['cliente'], $data['orcatrata']['idApp_Cliente']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */			
			
			
			#### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servico($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['ProfissionalProduto'] = $data['update']['servico']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    $data['update']['produto']['inserir'][$j]['NomeProduto'] = $data['update']['produto']['inserir'][$j]['NomeProduto'];
					unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}                
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['ProfissionalProduto'] = $data['update']['produto']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
                    $data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
					unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
					}	
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    /*
					if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
					}else{
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
					*/
					$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Cliente'] = $data['orcatrata']['idApp_Cliente'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
				}	

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
					}else {
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
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
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
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

				redirect(base_url() . 'orcatrata/pedidos/' . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function cadastrardesp() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            'idApp_Fornecedor',
            'DataOrca',
			'HoraOrca',
			'DataPrazo',
			'TipoFinanceiro',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'ValorDev',
			'QtdPrdOrca',
			'QtdSrvOrca',
            'ValorEntradaOrca',
			'ValorDinheiro',
			'ValorTroco',
            'DataEntradaOrca',
            'ValorRestanteOrca',
            'FormaPagamento',
			'Modalidade',
            'QtdParcelasOrca',
            'DataVencimentoOrca',
            'ObsOrca',
			'idTab_TipoRD',
			'AVAP',
			'EnviadoOrca',
			'Cep',
			'Logradouro',
			'Numero',
			'Complemento',
			'Bairro',
			'Cidade',
			'Estado',
			'Referencia',
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'CombinadoFrete',
			'PrazoEntrega',
			'ValorTotalOrca',
			'FinalizadoOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			'Cli_Forn_Orca',
			'Prd_Srv_Orca',
        ), TRUE));
		
		$data['fornecedor'] = $this->input->post(array(
			'idApp_Fornecedor',
			'CepFornecedor',
            'EnderecoFornecedor',
			'NumeroFornecedor',
			'ComplementoFornecedor',
			'CidadeFornecedor',
            'BairroFornecedor',
            'MunicipioFornecedor',
			'EstadoFornecedor',
			'ReferenciaFornecedor',
        ), TRUE);
		
        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('P2Count')) ? $data['count']['P2Count'] = 0 : $data['count']['P2Count'] = $this->input->post('P2Count');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        //Data de hoje como default
		(!$data['orcatrata']['idApp_Fornecedor']) ? $data['orcatrata']['idApp_Fornecedor'] = '0' : FALSE;
		(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraOrca']) ? $data['orcatrata']['HoraOrca'] = date('H:i:s', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['DataVencimentoOrca']) ? $data['orcatrata']['DataVencimentoOrca'] = date('d/m/Y', time()) : FALSE;
		#(!$data['orcatrata']['DataPrazo']) ? $data['orcatrata']['DataPrazo'] = date('d/m/Y', time()) : FALSE;
        (!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['ValorOrca']) ? $data['orcatrata']['ValorOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorComissao']) ? $data['orcatrata']['ValorComissao'] = '0.00' : FALSE;
		(!$data['orcatrata']['QtdPrdOrca']) ? $data['orcatrata']['QtdPrdOrca'] = '0' : FALSE;
		(!$data['orcatrata']['QtdSrvOrca']) ? $data['orcatrata']['QtdSrvOrca'] = '0' : FALSE;
		(!$data['orcatrata']['ValorDev']) ? $data['orcatrata']['ValorDev'] = '0.00' : FALSE;
		//(!$data['orcatrata']['ValorExtraOrca']) ? $data['orcatrata']['ValorExtraOrca'] = '0.00' : FALSE;
		(!$data['orcatrata']['ValorSomaOrca']) ? $data['orcatrata']['ValorSomaOrca'] = '0.00' : FALSE;
		//(!$data['orcatrata']['ValorFrete']) ? $data['orcatrata']['ValorFrete'] = '0.00' : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		/*
		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
                $data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
				$data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		*/
		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
				$data['produto'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Produto' . $i);
				$data['produto'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Produto' . $i);
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
				$data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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

		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;
		
		if ($data['valortotalorca'] > 0.00 && $data['orcatrata']['QtdParcelasOrca'] >=1) {
			
            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];
				
				if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || $this->input->post('DataVencimento' . $i)){
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
				}
            }
			
        }
		
		
		/*
        if ($data['orcatrata']['ValorTotalOrca'] > 0 ) {

            for ($i = 1; $i <= $data['orcatrata']['QtdParcelasOrca']; $i++) {
				
				if ($this->input->post('ValorParcela' . $i) > 0 && $this->input->post('ValorParcela' . $i) != ''){
					$data['parcelasrec'][$i]['Parcela'] = $this->input->post('Parcela' . $i);
					$data['parcelasrec'][$i]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
					$data['parcelasrec'][$i]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
					$data['parcelasrec'][$i]['ValorPago'] = $this->input->post('ValorPago' . $i);
					$data['parcelasrec'][$i]['DataPago'] = $this->input->post('DataPago' . $i);
					$data['parcelasrec'][$i]['Quitado'] = $this->input->post('Quitado' . $i);
				}
            }

        }
		*/
        //Fim do trecho de c�digo que d� pra melhorar
		
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}
		
		if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Cli_Forn_Orca'] == "S") {
			$this->form_validation->set_rules('idApp_Fornecedor', 'Fornecedor', 'required|trim');
			$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');
		} else {
			$data['cadastrar']['Cadastrar'] = 'S';
		}
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		if ($_SESSION['log']['NivelEmpresa'] >= '4') {
			$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		}
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');	

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
		$data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
        $data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroD();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
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
        #$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['idApp_Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
        $data['select']['Produto'] = $this->Basico_model->select_produto2();
		$data['select']['Servico'] = $this->Basico_model->select_servico2();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Nova Despesa';
        $data['form_open_path'] = 'orcatrata/cadastrardesp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 1;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';
		
		$data['tipofinan1'] = '1';

		$data['tipofinan12'] = '12';			
		
        if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorDev'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['orcatrata']['FormaPagamento'] || $data['orcatrata']['QtdParcelasOrca'] || $data['orcatrata']['DataVencimentoOrca'])
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';

        //if ($data['procedimento'][0]['DataProcedimento'] || $data['procedimento'][0]['Profissional'])
        if (isset($data['procedimento']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';
		
        if ($_SESSION['log']['NivelEmpresa'] >= '4' )
            $data['visivel'] = '';
        else
            $data['visivel'] = 'style="display: none;"';
		
		#(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		//(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		//(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;

		($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
        ($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		
		/*
		$data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';	        
		*/
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';		

		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	

			
        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Prontos p/Entrega', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
        );
        ($data['orcatrata']['QuitadoOrca'] == 'S') ?
            $data['div']['QuitadoOrca'] = '' : $data['div']['QuitadoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Finalizado', 'NS'),
        );
		($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
			
			
        #Ver uma solu��o melhor para este campo
        #(!$data['orcatrata']['TipoFinanceiro']) ? $data['orcatrata']['TipoFinanceiro'] = '1' : FALSE;
/*
        $data['radio'] = array(
            'TipoFinanceiro' => $this->basico->radio_checked($data['orcatrata']['TipoFinanceiro'], 'Tarefa Aprovado', 'NS'),
        );

        ($data['orcatrata']['TipoFinanceiro'] == '1') ? $data['div']['TipoFinanceiro'] = '' : $data['div']['TipoFinanceiro'] = 'style="display: none;"';			
*/
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

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

		$_SESSION['Empresa'] = $data['empresa'] = $this->Basico_model->get_end_empresa($_SESSION['log']['idSis_Empresa'], TRUE);
		/*	 
		echo '<br>';
		echo "<pre>";
		print_r($_SESSION['Empresa']['CepEmpresa']);
		echo "</pre>";
		exit ();
		*/
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('orcatrata/form_orcatratadesp', $data);
        } else {

			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			$data['cadastrar']['AtualizaEndereco'] = $data['cadastrar']['AtualizaEndereco'];
            
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
				/*
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
				*/
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['TipoFinanceiro'] = $data['orcatrata']['TipoFinanceiro'];
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');
            $data['orcatrata']['DataEntregaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntregaOrca'], 'mysql');
			$data['orcatrata']['DataPrazo'] = $this->basico->mascara_data($data['orcatrata']['DataPrazo'], 'mysql');
			$data['orcatrata']['DataConclusao'] = $this->basico->mascara_data($data['orcatrata']['DataConclusao'], 'mysql');
            $data['orcatrata']['DataRetorno'] = $this->basico->mascara_data($data['orcatrata']['DataRetorno'], 'mysql');
            $data['orcatrata']['DataQuitado'] = $this->basico->mascara_data($data['orcatrata']['DataQuitado'], 'mysql');
			$data['orcatrata']['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcatrata']['DataVencimentoOrca'], 'mysql');
			$data['orcatrata']['Tipo_Orca'] = "B";
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
			
			$data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
			$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			$data['orcatrata']['idTab_TipoRD'] = "1";
			$data['orcatrata']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa']; 
            $data['orcatrata']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['orcatrata']['Associado'] = $_SESSION['log']['idSis_Usuario'];
            $data['orcatrata']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
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
            /*
			echo "<pre>";
            echo '<br>';
			print_r($data['orcatrata']['ValorComissao']);
            echo "</pre>";
            exit ();			
			*/
			$data['orcatrata']['idApp_OrcaTrata'] = $this->Orcatrata_model->set_orcatrata($data['orcatrata']);
            
			#### APP_Fornecedor ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['fornecedor']['CepFornecedor'] = $data['orcatrata']['Cep'];
				$data['fornecedor']['EnderecoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['fornecedor']['NumeroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['fornecedor']['ComplementoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['fornecedor']['BairroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['fornecedor']['CidadeFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['fornecedor']['EstadoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['fornecedor']['ReferenciaFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['fornecedor']['anterior'] = $this->Orcatrata_model->get_fornecedor($data['orcatrata']['idApp_Fornecedor']);
				$data['update']['fornecedor']['campos'] = array_keys($data['fornecedor']);
				/*
				$data['update']['fornecedor']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['fornecedor']['anterior'],
					$data['fornecedor'],
					$data['update']['fornecedor']['campos'],
					$data['fornecedor']['idApp_Fornecedor'], TRUE);
				*/	
				$data['update']['fornecedor']['bd'] = $this->Orcatrata_model->update_fornecedor($data['fornecedor'], $data['orcatrata']['idApp_Fornecedor']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['fornecedor']);
            echo "</pre>";
            exit ();
            */
			
            #### App_Servico ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['servico'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
					$data['servico'][$j]['idTab_TipoRD'] = "1";
					$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'mysql');
                    $data['servico'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['servico'][$j]['ValorProduto']));
                    unset($data['servico'][$j]['SubtotalProduto']);
					unset($data['servico'][$j]['SubtotalComissaoProduto']);
					unset($data['servico'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['servico'][$j]['ConcluidoProduto'] = 'S';
					}else{
						$data['servico'][$j]['ConcluidoProduto'] = $data['servico'][$j]['ConcluidoProduto'];
					}	
				}
                $data['servico']['idApp_Produto'] = $this->Orcatrata_model->set_servico($data['servico']);
            }

            #### App_Produto ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
					if ($data['produto'][$j]['idSis_Usuario']) {$data['produto'][$j]['idSis_Usuario'] = $data['produto'][$j]['idSis_Usuario'];
					}else {$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];}
					$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['produto'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
					$data['produto'][$j]['idTab_TipoRD'] = "1";
					$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'mysql');
                    $data['produto'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['ValorProduto']));
                    $data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
                    $data['produto'][$j]['NomeProduto'] = $data['produto'][$j]['NomeProduto'];
					unset($data['produto'][$j]['SubtotalProduto']);
					unset($data['produto'][$j]['SubtotalComissaoProduto']);
					unset($data['produto'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['produto'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['produto'][$j]['ConcluidoProduto'] = $data['produto'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['produto'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['produto'][$j]['DevolvidoProduto'] = $data['produto'][$j]['DevolvidoProduto'];
					}
				}
                $data['produto']['idApp_Produto'] = $this->Orcatrata_model->set_produto($data['produto']);
            }

            #### App_ParcelasRec ####
            if (isset($data['parcelasrec'])) {
                $max = count($data['parcelasrec']);
                for($j=1;$j<=$max;$j++) {
                    $data['parcelasrec'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['parcelasrec'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['parcelasrec'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['parcelasrec'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['parcelasrec'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
					$data['parcelasrec'][$j]['idTab_TipoRD'] = "1";
                    $data['parcelasrec'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorParcela']));
                    $data['parcelasrec'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['parcelasrec'][$j]['ValorPago']));
                    $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'mysql');					
					$data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') {
						$data['parcelasrec'][$j]['Quitado'] = 'S';
					} else {
						$data['parcelasrec'][$j]['Quitado'] = $data['parcelasrec'][$j]['Quitado'];
					}
                }
                $data['parcelasrec']['idApp_Parcelas'] = $this->Orcatrata_model->set_parcelas($data['parcelasrec']);
            }			

            #### App_Procedimento ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['procedimento'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
					$data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'mysql');
					$data['procedimento'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimentoLimite'], 'mysql');					
                }
                $data['procedimento']['idApp_Procedimento'] = $this->Orcatrata_model->set_procedimento($data['procedimento']);
            }
			/*
			$data['update']['servico']['posterior'] = $this->Orcatrata_model->get_servico_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['servico']['posterior'])){
				$max_produto = count($data['update']['servico']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['ConcluidoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['CombinadoFrete'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			*/
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}

			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}

			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idApp_OrcaTrata'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_orcatratadesp', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/cadastrardesp/' . $data['msg']);
				redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);				
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
		
    public function alterardesp($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'ConcluidoProduto',
			'QuitadoParcelas',
			'Cadastrar',
			'AtualizaEndereco',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### App_OrcaTrata ####
            'idApp_OrcaTrata',
            #N�o h� a necessidade de atualizar o valor do campo a seguir
            'idApp_Fornecedor',
            'DataOrca',
			'TipoFinanceiro',
			'DataPrazo',
			'Descricao',
            'ProfissionalOrca',
            'AprovadoOrca',
            'ConcluidoOrca',
			'BrindeOrca',
			'DevolvidoOrca',
			'ProntoOrca',
            'QuitadoOrca',
			'FinalizadoOrca',
            'DataConclusao',
            'DataRetorno',
			'DataQuitado',
            'ValorOrca',
			'ValorComissao',
			'QtdPrdOrca',
			'QtdSrvOrca',
			'ValorDev',
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
			'AVAP',
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
			'CombinadoFrete',
			'TipoFrete',
			'ValorFrete',
			'ValorExtraOrca',
			'ValorSomaOrca',
			'PrazoEntrega',
			'ValorTotalOrca',
			'Entregador',
			'DataEntregaOrca',
			'HoraEntregaOrca',
			'NomeRec',
			'TelefoneRec',
			'ParentescoRec',
			'ObsEntrega',
			'Aux1Entrega',
			'Aux2Entrega',
			'DetalhadaEntrega',
			'CanceladoOrca',
			'Cli_Forn_Orca',
			//'Prd_Srv_Orca',
        ), TRUE));
		
		$data['fornecedor'] = $this->input->post(array(
			'idApp_Fornecedor',
			'CepFornecedor',
            'EnderecoFornecedor',
			'NumeroFornecedor',
			'ComplementoFornecedor',
			'CidadeFornecedor',
            'BairroFornecedor',
            'MunicipioFornecedor',
			'EstadoFornecedor',
			'ReferenciaFornecedor',
        ), TRUE);

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		#(!$data['orcatrata']['idTab_TipoRD']) ? $data['orcatrata']['idTab_TipoRD'] = "1" : FALSE;
		(!$data['orcatrata']['idApp_Fornecedor']) ? $data['orcatrata']['idApp_Fornecedor'] = '0' : FALSE;
		(!$data['orcatrata']['Cli_Forn_Orca']) ? $data['orcatrata']['Cli_Forn_Orca'] = 'S' : FALSE;
		//(!$data['orcatrata']['Prd_Srv_Orca']) ? $data['orcatrata']['Prd_Srv_Orca'] = 'S' : FALSE;  
		(!$data['orcatrata']['DataOrca']) ? $data['orcatrata']['DataOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['DataEntregaOrca']) ? $data['orcatrata']['DataEntregaOrca'] = date('d/m/Y', time()) : FALSE;
		(!$data['orcatrata']['HoraEntregaOrca']) ? $data['orcatrata']['HoraEntregaOrca'] = date('H:i:s', strtotime('+1 hour')) : FALSE;
		(!$data['orcatrata']['QtdParcelasOrca']) ? $data['orcatrata']['QtdParcelasOrca'] = "1" : FALSE;
		(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		/*
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		*/
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Produto'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Produto'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Produto'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Produto'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeProduto'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoProduto'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorProduto'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdProduto'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalProduto'] = $this->input->post('SubtotalServico' . $i);
				$data['servico'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoServico' . $i);
				$data['servico'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdServico' . $i);
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
				$data['produto'][$j]['Prod_Serv_Produto'] = $this->input->post('Prod_Serv_Produto' . $i);
                $data['produto'][$j]['ComissaoProduto'] = $this->input->post('ComissaoProduto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['produto'][$j]['NomeProduto'] = $this->input->post('NomeProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
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

		$data['valortotalorca'] = str_replace(',', '.', $data['orcatrata']['ValorTotalOrca']);
		//$data['valortotalorca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
		$data['somatotal'] = 0;	

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

				$data['valoredit'][$i] =  str_replace(',', '.', str_replace('.', '', $this->input->post('ValorParcela' . $i)));
				$data['somatotal'] += $data['valoredit'][$i];            
			
			if ($data['valoredit'][$i] > 0.00){
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				//$data['parcelasrec'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;
		/*
		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];		
		*/
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### App_OrcaTrata ####
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
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
			$data['valortotalorca'] = $data['orcatrata']['ValorTotalOrca'];
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
           # $this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);
           # $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
			#$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### App_Servico ####
            $data['servico'] = $this->Orcatrata_model->get_servicodesp($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalProduto'] = number_format(($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto']), 2, ',', '.');
						$data['servico'][$j]['SubtotalComissaoProduto'] = ($data['servico'][$j]['ValorProduto'] * $data['servico'][$j]['QtdProduto'] * $data['servico'][$j]['ComissaoProduto'] /100);
						$data['servico'][$j]['SubtotalQtdProduto'] = ($data['servico'][$j]['QtdIncrementoProduto'] * $data['servico'][$j]['QtdProduto']);
						$data['servico'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeProduto'], 'barras');
					}
                }
            }

            #### App_Produto ####
            $data['produto'] = $this->Orcatrata_model->get_produtodesp($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						//$data['produto'][$j]['ComissaoProduto'] = $data['produto'][$j]['ComissaoProduto'];
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
						///esta linha deve ser retirada ap�s corre��o dos nomes dos pedidos antigos///
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

		$data['somatotal'] = number_format($data['somatotal'],2,",",".");
		$data['somatotal'] = str_replace(',', '.', str_replace(',', '.', $data['somatotal']));
		$data['diferenca'] = $data['valortotalorca'] - $data['somatotal'];

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
        
		if(isset($data['diferenca']) && $data['orcatrata']['Modalidade'] == "P"){
			if($data['diferenca'] < 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' menor, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_maior');	
			}elseif($data['diferenca'] > 0.00){
				$data['diferenca'] = number_format($data['diferenca'],2,",",".");
				$data['diferenca'] = str_replace('.', ',', str_replace('.', ',', $data['diferenca']));
				$this->form_validation->set_rules('ValorTotalOrca', 'O Total do Pedido �  R$ ' . $data['diferenca'] . ' maior, que a Soma dos Valores das Parcelas!', 'trim|valid_soma_menor');
			}
		}
		if ($data['valortotalorca'] <= 0.00 ) {
			$this->form_validation->set_rules('BrindeOrca', 'Se quiser Permitir Total = 0,00, ent�o coloque a chave na posi��o "Sim".<br>Com o Total = 0,00, as parcelas geradas n�o ser�o salvas.', 'trim|valid_brinde');
		}
		
		if ($_SESSION['log']['NivelEmpresa'] >= '4' && $data['orcatrata']['Cli_Forn_Orca'] == "S") {
			$this->form_validation->set_rules('idApp_Fornecedor', 'Fornecedor', 'required|trim');
			$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');
		} else {
			$data['cadastrar']['Cadastrar'] = 'S';
		}
		$this->form_validation->set_rules('DataOrca', 'Data do Or�amento', 'required|trim|valid_date');
		$this->form_validation->set_rules('AVAP', '� Vista ou � Prazo', 'required|trim');
		$this->form_validation->set_rules('FormaPagamento', 'Forma de Pagamento', 'required|trim');
		if ($_SESSION['log']['NivelEmpresa'] >= '4') {	
			$this->form_validation->set_rules('TipoFrete', 'Forma de Entrega', 'required|trim');
		}
		$this->form_validation->set_rules('QtdParcelasOrca', 'Qtd de Parcelas', 'required|trim');
		$this->form_validation->set_rules('DataVencimentoOrca', 'Data do 1�Venc.', 'required|trim|valid_date');	

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Cli_Forn_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prd_Srv_Orca'] = $this->Basico_model->select_status_sn();
		$data['select']['AtualizaEndereco'] = $this->Basico_model->select_status_sn();
        $data['select']['DetalhadaEntrega'] = $this->Basico_model->select_status_sn();
		$data['select']['TipoFinanceiro'] = $this->Basico_model->select_tipofinanceiroD();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CanceladoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['CombinadoFrete'] = $this->Basico_model->select_status_sn();
		$data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['FormaPagamento'] = $this->Formapag_model->select_formapag();
        $data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
        $data['select']['BrindeOrca'] = $this->Basico_model->select_status_sn();
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
		$data['select']['idApp_Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['Profissional'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalServico'] = $this->Usuario_model->select_usuario();
		$data['select']['ProfissionalProduto'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Entregador'] = $this->Usuario_model->select_usuario();
		$data['select']['Produto'] = $this->Basico_model->select_produto2();
		$data['select']['Servico'] = $this->Basico_model->select_servico2();
		#$data['select']['AVAP'] = $this->Basico_model->select_modalidade2();
		$data['select']['AVAP'] = $this->Basico_model->select_avap();
		$data['select']['EnviadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'M�dia',
			'3' => 'Baixa',
        );
		
        $data['titulo'] = 'Editar Despesa';
        $data['form_open_path'] = 'orcatrata/alterardesp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
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
		
		//(!$data['orcatrata']['TipoFrete']) ? $data['orcatrata']['TipoFrete'] = "1" : FALSE;
		//(!$data['orcatrata']['AVAP']) ? $data['orcatrata']['AVAP'] = 'V' : FALSE;
		(!$data['orcatrata']['CombinadoFrete']) ? $data['orcatrata']['CombinadoFrete'] = 'N' : FALSE;
		(!$data['orcatrata']['AprovadoOrca']) ? $data['orcatrata']['AprovadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['EnviadoOrca']) ? $data['orcatrata']['EnviadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['FinalizadoOrca']) ? $data['orcatrata']['FinalizadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['CanceladoOrca']) ? $data['orcatrata']['CanceladoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ConcluidoOrca']) ? $data['orcatrata']['ConcluidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['ProntoOrca']) ? $data['orcatrata']['ProntoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['DevolvidoOrca']) ? $data['orcatrata']['DevolvidoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['QuitadoOrca']) ? $data['orcatrata']['QuitadoOrca'] = 'N' : FALSE;
		(!$data['orcatrata']['Modalidade']) ? $data['orcatrata']['Modalidade'] = 'P' : FALSE;		
		
 		(!$data['orcatrata']['DetalhadaEntrega']) ? $data['orcatrata']['DetalhadaEntrega'] = 'N' : FALSE;
		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;
		(!$data['orcatrata']['BrindeOrca']) ? $data['orcatrata']['BrindeOrca'] = 'N' : FALSE;
		(!$data['cadastrar']['AtualizaEndereco']) ? $data['cadastrar']['AtualizaEndereco'] = 'N' : FALSE;
		
        ($data['orcatrata']['TipoFrete'] == '1') ? $data['div']['TipoFrete'] = 'style="display: none;"' : $data['div']['TipoFrete'] = '';
		
		$data['radio'] = array(
            'DetalhadaEntrega' => $this->basico->radio_checked($data['orcatrata']['DetalhadaEntrega'], 'DetalhadaEntrega', 'SN'),
        );
        ($data['orcatrata']['DetalhadaEntrega'] == 'S') ? $data['div']['DetalhadaEntrega'] = '' : $data['div']['DetalhadaEntrega'] = 'style="display: none;"';
		
		($data['orcatrata']['AVAP'] != 'V') ? $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'AVAP' => $this->basico->radio_checked($data['orcatrata']['AVAP'], 'AVAP', 'VP'),
        );
        ($data['orcatrata']['AVAP'] == 'P') ?
            $data['div']['AVAP'] = '' : $data['div']['AVAP'] = 'style="display: none;"';		
		*/
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AtualizaEndereco' => $this->basico->radio_checked($data['cadastrar']['AtualizaEndereco'], 'AtualizaEndereco', 'NS'),
        );
        ($data['cadastrar']['AtualizaEndereco'] == 'N') ?
            $data['div']['AtualizaEndereco'] = '' : $data['div']['AtualizaEndereco'] = 'style="display: none;"';	
			
        $data['radio'] = array(
            'Modalidade' => $this->basico->radio_checked($data['orcatrata']['Modalidade'], 'Modalidade', 'PM'),
        );
        ($data['orcatrata']['Modalidade'] == 'P') ?
            $data['div']['Modalidade'] = '' : $data['div']['Modalidade'] = 'style="display: none;"';
        		
		$data['radio'] = array(
            'CombinadoFrete' => $this->basico->radio_checked($data['orcatrata']['CombinadoFrete'], 'Combinado Entrega', 'NS'),
        );
        ($data['orcatrata']['CombinadoFrete'] == 'S') ?
            $data['div']['CombinadoFrete'] = '' : $data['div']['CombinadoFrete'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'AprovadoOrca' => $this->basico->radio_checked($data['orcatrata']['AprovadoOrca'], 'Or�amento Aprovado', 'NS'),
        );
        ($data['orcatrata']['AprovadoOrca'] == 'S') ?
            $data['div']['AprovadoOrca'] = '' : $data['div']['AprovadoOrca'] = 'style="display: none;"';
			
		$data['radio'] = array(
            'EnviadoOrca' => $this->basico->radio_checked($data['orcatrata']['EnviadoOrca'], 'Pedido Enviado', 'NS'),
        );
        ($data['orcatrata']['EnviadoOrca'] == 'S') ?
            $data['div']['EnviadoOrca'] = '' : $data['div']['EnviadoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'FinalizadoOrca' => $this->basico->radio_checked($data['orcatrata']['FinalizadoOrca'], 'Or�amento Cancelado', 'NS'),
        );
        ($data['orcatrata']['FinalizadoOrca'] == 'N') ?
            $data['div']['FinalizadoOrca'] = '' : $data['div']['FinalizadoOrca'] = 'style="display: none;"';        
		
		$data['radio'] = array(
            'CanceladoOrca' => $this->basico->radio_checked($data['orcatrata']['CanceladoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['CanceladoOrca'] == 'N') ?
            $data['div']['CanceladoOrca'] = '' : $data['div']['CanceladoOrca'] = 'style="display: none;"';
		
		$data['radio'] = array(
            'Cli_Forn_Orca' => $this->basico->radio_checked($data['orcatrata']['Cli_Forn_Orca'], 'Cliente/Fornecedor', 'NS'),
        );
        ($data['orcatrata']['Cli_Forn_Orca'] == 'S') ?
            $data['div']['Cli_Forn_Orca'] = '' : $data['div']['Cli_Forn_Orca'] = 'style="display: none;"';
		/*
		$data['radio'] = array(
            'Prd_Srv_Orca' => $this->basico->radio_checked($data['orcatrata']['Prd_Srv_Orca'], 'Prd/Srv', 'NS'),
        );
        ($data['orcatrata']['Prd_Srv_Orca'] == 'S') ?
            $data['div']['Prd_Srv_Orca'] = '' : $data['div']['Prd_Srv_Orca'] = 'style="display: none;"';
		*/
		$data['radio'] = array(
            'ConcluidoOrca' => $this->basico->radio_checked($data['orcatrata']['ConcluidoOrca'], 'Produtos Entregues', 'NS'),
        );
        ($data['orcatrata']['ConcluidoOrca'] == 'N') ?
            $data['div']['ConcluidoOrca'] = '' : $data['div']['ConcluidoOrca'] = 'style="display: none;"';

			
        $data['radio'] = array(
            'BrindeOrca' => $this->basico->radio_checked($data['orcatrata']['BrindeOrca'], 'Brinde', 'NS'),
        );
        ($data['orcatrata']['BrindeOrca'] == 'N') ?
            $data['div']['BrindeOrca'] = '' : $data['div']['BrindeOrca'] = 'style="display: none;"';

        $data['radio'] = array(
            'ProntoOrca' => $this->basico->radio_checked($data['orcatrata']['ProntoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['ProntoOrca'] == 'S') ?
            $data['div']['ProntoOrca'] = '' : $data['div']['ProntoOrca'] = 'style="display: none;"';
			
        $data['radio'] = array(
            'DevolvidoOrca' => $this->basico->radio_checked($data['orcatrata']['DevolvidoOrca'], 'Produtos Devolvidos', 'NS'),
        );
        ($data['orcatrata']['DevolvidoOrca'] == 'S') ?
            $data['div']['DevolvidoOrca'] = '' : $data['div']['DevolvidoOrca'] = 'style="display: none;"';			

        $data['radio'] = array(
            'QuitadoOrca' => $this->basico->radio_checked($data['orcatrata']['QuitadoOrca'], 'Or�amento Quitado', 'NS'),
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
            $this->load->view('orcatrata/form_orcatrataalterardesp', $data);
		} else {

			$data['cadastrar']['QuitadoParcelas'] = $data['cadastrar']['QuitadoParcelas'];
			$data['cadastrar']['ConcluidoProduto'] = $data['cadastrar']['ConcluidoProduto'];
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
				/*
				$data['orcatrata']['Cep'] = $data['empresa']['CepEmpresa'];
				$data['orcatrata']['Logradouro'] = $data['empresa']['EnderecoEmpresa'];
				$data['orcatrata']['Numero'] = $data['empresa']['NumeroEmpresa'];
				$data['orcatrata']['Complemento'] = $data['empresa']['ComplementoEmpresa'];
				$data['orcatrata']['Bairro'] = $data['empresa']['BairroEmpresa'];
				$data['orcatrata']['Cidade'] = $data['empresa']['MunicipioEmpresa'];
				$data['orcatrata']['Estado'] = $data['empresa']['EstadoEmpresa'];
				$data['orcatrata']['Referencia'] = '';
				*/
				$data['orcatrata']['Cep'] = $data['orcatrata']['Cep'];
				$data['orcatrata']['Logradouro'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['orcatrata']['Numero'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['orcatrata']['Complemento'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['orcatrata']['Bairro'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['orcatrata']['Cidade'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['orcatrata']['Estado'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['orcatrata']['Referencia'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
			
			$data['orcatrata']['NomeRec'] = trim(mb_strtoupper($data['orcatrata']['NomeRec'], 'ISO-8859-1'));
			$data['orcatrata']['ParentescoRec'] = trim(mb_strtoupper($data['orcatrata']['ParentescoRec'], 'ISO-8859-1'));
			$data['orcatrata']['ObsEntrega'] = trim(mb_strtoupper($data['orcatrata']['ObsEntrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux1Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux1Entrega'], 'ISO-8859-1'));
			$data['orcatrata']['Aux2Entrega'] = trim(mb_strtoupper($data['orcatrata']['Aux2Entrega'], 'ISO-8859-1'));			
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
			
				if ($data['orcatrata']['FinalizadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
						$data['orcatrata']['ConcluidoOrca'] = "S";
						$data['orcatrata']['QuitadoOrca'] = "S";
				} elseif($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
				} elseif ($data['orcatrata']['TipoFrete'] == '1' && $data['orcatrata']['ProntoOrca'] == 'S') {
						$data['orcatrata']['EnviadoOrca'] = "S";
				}
					
            $data['orcatrata']['ValorOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorOrca']));
			$data['orcatrata']['ValorComissao'] = $data['orcatrata']['ValorComissao'];
            $data['orcatrata']['ValorDev'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDev']));
			$data['orcatrata']['ValorEntradaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorEntradaOrca']));
			$data['orcatrata']['ValorDinheiro'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorDinheiro']));
			if($data['orcatrata']['ValorTroco'] > 0){
				$data['orcatrata']['ValorTroco'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTroco']));
			}else{
				$data['orcatrata']['ValorTroco'] = 0.00;
			}
            $data['orcatrata']['DataEntradaOrca'] = $this->basico->mascara_data($data['orcatrata']['DataEntradaOrca'], 'mysql');
            $data['orcatrata']['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorRestanteOrca']));
			$data['orcatrata']['ValorFrete'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorFrete']));
			$data['orcatrata']['ValorExtraOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorExtraOrca']));
			
			if ($_SESSION['log']['NivelEmpresa'] >= '4') {
				$data['orcatrata']['ValorSomaOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorSomaOrca']));
				$data['orcatrata']['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['orcatrata']['ValorTotalOrca']));
			}else{
				$data['orcatrata']['ValorSomaOrca'] = $data['orcatrata']['ValorSomaOrca'];
				$data['orcatrata']['ValorTotalOrca'] = $data['orcatrata']['ValorTotalOrca'];
			}
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
			/*
            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idApp_OrcaTrata'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);
			*/
            
			#### APP_Fornecedor ####
			if ($data['cadastrar']['AtualizaEndereco'] == 'S'){
				$data['fornecedor']['CepFornecedor'] = $data['orcatrata']['Cep'];
				$data['fornecedor']['EnderecoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Logradouro'], 'ISO-8859-1'));
				$data['fornecedor']['NumeroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Numero'], 'ISO-8859-1'));
				$data['fornecedor']['ComplementoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Complemento'], 'ISO-8859-1'));
				$data['fornecedor']['BairroFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Bairro'], 'ISO-8859-1'));
				$data['fornecedor']['CidadeFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Cidade'], 'ISO-8859-1'));
				$data['fornecedor']['EstadoFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Estado'], 'ISO-8859-1'));
				$data['fornecedor']['ReferenciaFornecedor'] = trim(mb_strtoupper($data['orcatrata']['Referencia'], 'ISO-8859-1'));
							
				$data['update']['fornecedor']['anterior'] = $this->Orcatrata_model->get_fornecedor($data['orcatrata']['idApp_Fornecedor']);
				$data['update']['fornecedor']['campos'] = array_keys($data['fornecedor']);
				/*
				$data['update']['fornecedor']['auditoriaitem'] = $this->basico->set_log(
					$data['update']['fornecedor']['anterior'],
					$data['fornecedor'],
					$data['update']['fornecedor']['campos'],
					$data['fornecedor']['idApp_Fornecedor'], TRUE);
				*/	
				$data['update']['fornecedor']['bd'] = $this->Orcatrata_model->update_fornecedor($data['fornecedor'], $data['orcatrata']['idApp_Fornecedor']);
				
				/*
				// ""ver modo correto de fazer o set_log e set_auditoria""
				if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Fornecedor', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }
				*/
				
			}
			
			/*
            //echo count($data['servico']);
			echo '<br>';
            echo "<pre>";
            print_r($data['cliente']);
            echo "</pre>";
            exit ();
            */			
			
			
			#### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_servicodesp($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Produto');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['servico']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['servico']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
					$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "1";
					$data['update']['servico']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['servico']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorProduto']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['inserir'][$j]['ConcluidoProduto'] = $data['update']['servico']['inserir'][$j]['ConcluidoProduto'];
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['ProfissionalProduto'] = $data['update']['servico']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['servico']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorProduto']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['servico']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['servico']['alterar'][$j]['ConcluidoProduto'] = $data['update']['servico']['alterar'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['servico']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
            }

            #### App_Produto ####
            $data['update']['produto']['anterior'] = $this->Orcatrata_model->get_produtodesp($data['orcatrata']['idApp_OrcaTrata']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    if ($data['update']['produto']['inserir'][$j]['idSis_Usuario']) {$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $data['update']['produto']['inserir'][$j]['idSis_Usuario'];
					}else {$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];}
					$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['produto']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['produto']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
					$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "1";
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    $data['update']['produto']['inserir'][$j]['NomeProduto'] = $data['update']['produto']['inserir'][$j]['NomeProduto'];
					unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['ProfissionalProduto'] = $data['update']['produto']['alterar'][$j]['ProfissionalProduto'];
					$data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
                    $data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
					unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = $data['update']['produto']['alterar'][$j]['ConcluidoProduto'];
					}	
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
					} else {	
						$data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = $data['update']['produto']['alterar'][$j]['DevolvidoProduto'];
					}
					if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['produto']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    /*
					if ($data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario']){
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'];
					}else{
						$data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
					*/
					$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['parcelasrec']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "1";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
					}else {
						$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = $data['update']['parcelasrec']['alterar'][$j]['Quitado'];
					}
					if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['parcelasrec']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];					
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

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['procedimento']['inserir'][$j]['idApp_OrcaTrata'] = $data['orcatrata']['idApp_OrcaTrata'];
                    $data['update']['procedimento']['inserir'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
					$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'], 'mysql');
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'], 'mysql');					
					if ($data['orcatrata']['idApp_Fornecedor']) $data['update']['procedimento']['alterar'][$j]['idApp_Fornecedor'] = $data['orcatrata']['idApp_Fornecedor'];
                }

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Orcatrata_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Orcatrata_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['orcatrata']['idApp_OrcaTrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}			
			
			$data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata($data['orcatrata']['idApp_OrcaTrata']);
			$data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
			$data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
				$data['update']['orcatrata']['anterior'],
				$data['orcatrata'],
				$data['update']['orcatrata']['campos'],
				$data['orcatrata']['idApp_OrcaTrata'], TRUE);
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['orcatrata']['idApp_OrcaTrata']);			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterardesp', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                //redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				redirect(base_url() . 'OrcatrataPrint/imprimirdesp/' . $data['orcatrata']['idApp_OrcaTrata'] . $data['msg']);
				exit();
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

			$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata($id);
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
            $this->load->model('Cliente_model');
            $data['query'] = $this->Cliente_model->get_cliente($data['orcatrata']['idApp_Cliente'], TRUE);	

			$this->Orcatrata_model->delete_orcatrata($id);

			$data['msg'] = '?m=1';

			//redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
			redirect(base_url() . 'orcatrata/listar/' . $data['query']['idApp_Cliente'] . $data['msg']);
			#redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
			
			exit();


        $this->load->view('basico/footer');
    }
	
    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

			$this->Orcatrata_model->delete_orcatrata($id);

			$data['msg'] = '?m=1';

			#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
			#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
			#redirect(base_url() . 'relatorio/parcelasrec/' . $data['msg']);
			#redirect(base_url() . 'relatorio/orcamento/' . $data['msg']);
			
			redirect(base_url() . 'pedidos/pedidos/' . $data['msg']);
			
			exit();
				
        $this->load->view('basico/footer');
    }

    public function excluirdesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

 
                $this->Orcatrata_model->delete_orcatrata($id);

                $data['msg'] = '?m=1';

				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelasdesp/' . $data['msg']);
				#redirect(base_url() . 'relatorio/orcamento2/' . $data['msg']);
				redirect(base_url() . 'despesas/despesas/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }	
    
    public function pedidos() {

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
            'Cliente',
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
		
		$data['query']['selecione'] = 'SELECT 
                C.idApp_Cliente,
				C.NomeCliente,
				C.CelularCliente,
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
					LEFT JOIN App_Cliente AS C ON C.idApp_Cliente = OT.idApp_Cliente
					LEFT JOIN Tab_FormaPag AS TFP ON TFP.idTab_FormaPag = OT.FormaPagamento
					LEFT JOIN App_Parcelas AS PR ON PR.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN App_Produto AS PRD ON PRD.idApp_OrcaTrata = OT.idApp_OrcaTrata
					LEFT JOIN Tab_TipoFinanceiro AS TR ON TR.idTab_TipoFinanceiro = OT.TipoFinanceiro
					LEFT JOIN Tab_Modalidade AS MD ON MD.Abrev = OT.Modalidade
					LEFT JOIN Tab_AVAP AS VP ON VP.Abrev2 = OT.AVAP
					LEFT JOIN Tab_TipoFrete AS TF ON TF.idTab_TipoFrete = OT.TipoFrete';		

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
        //$this->form_validation->set_rules('Orcamento', 'Orcamento', 'trim');

		$data['collapse'] = 'class="collapse"';
		$data['collapse1'] = '';
		
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
		
        $data['titulo'] = 'Gestor de Pedidos Est�tico';
        $data['form_open_path'] = 'Orcatrata/pedidos';
		$data['relatorio'] = 'relatorio/comissao/';
        $data['status'] = 'Orcatrata/alterarstatus/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		
        #run form validation
        if ($this->form_validation->run() !== TRUE) {
		
            $data['bd']['Orcamento'] = $data['query']['Orcamento'];
            $data['bd']['Cliente'] = $data['query']['Cliente'];
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

            $data['report_combinar'] = $this->Pedidos_model->list_pedidos_combinar($data['bd'],TRUE);
			$data['report_aprovar'] = $this->Pedidos_model->list_pedidos_aprovar($data['bd'],TRUE);
            $data['report_pagonline'] = $this->Pedidos_model->list_pedidos_pagonline($data['bd'],TRUE);
            $data['report_producao'] = $this->Pedidos_model->list_pedidos_producao($data['bd'],TRUE);
            $data['report_envio'] = $this->Pedidos_model->list_pedidos_envio($data['bd'],TRUE);
            $data['report_entrega'] = $this->Pedidos_model->list_pedidos_entrega($data['bd'],TRUE);
            $data['report_pagamento'] = $this->Pedidos_model->list_pedidos_pagamento($data['bd'],TRUE);
			
			$data['pesquisar'] = $this->Pedidos_model->list_pedidos_pesquisar($data['bd'],TRUE);
			
			if ($data['pesquisar']->num_rows() == 1) {
				$info = $data['pesquisar']->result_array();
				
				redirect('Orcatrata/alterarstatus/' . $info[0]['idApp_OrcaTrata'] );

				exit();
				
			} else {
				$data['list_combinar'] = $this->load->view('pedidos/list_pedidos_combinar', $data, TRUE);
				$data['list_aprovar'] = $this->load->view('pedidos/list_pedidos_aprovar', $data, TRUE);
				$data['list_pagonline'] = $this->load->view('pedidos/list_pedidos_pagonline', $data, TRUE);
				$data['list_producao'] = $this->load->view('pedidos/list_pedidos_producao', $data, TRUE);
				$data['list_envio'] = $this->load->view('pedidos/list_pedidos_envio', $data, TRUE);
				$data['list_entrega'] = $this->load->view('pedidos/list_pedidos_entrega', $data, TRUE);
				$data['list_pagamento'] = $this->load->view('pedidos/list_pedidos_pagamento', $data, TRUE);
			}
        }

        $this->load->view('pedidos/tela_pedidos', $data);

        $this->load->view('basico/footer');
    }

    public function baixadareceita($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
		
        $data['titulo'] = 'Baixa da Receita';
        $data['form_open_path'] = 'orcatrata/baixadareceita';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;
		
        #run form validation
		
		
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
			$data['orcatrata']['CombinadoFrete'] = "S";
			$data['orcatrata']['AprovadoOrca'] = "S";
			$data['orcatrata']['ConcluidoOrca'] = "S";
			$data['orcatrata']['QuitadoOrca'] = "S";
			$data['orcatrata']['FinalizadoOrca'] = "S";
			$data['orcatrata']['ProntoOrca'] = "S";
			$data['orcatrata']['EnviadoOrca'] = "S";

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata_baixa($id);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $id, 
			TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $id);

            #### App_Produto ####
            $data['update']['produto']['alterar'] = $this->Orcatrata_model->get_produto_posterior($id);
            if (isset($data['update']['produto']['alterar'])){

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';				
                }
                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

            }

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['alterar'] = $this->Orcatrata_model->get_parcelas_posterior($id);
            if (isset($data['update']['parcelasrec']['alterar'])){
			
                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';				
				}
                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

            }

            #### App_Procedimento ####
            $data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($id);
            if (isset($data['update']['procedimento']['alterar'])){
			
                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['procedimento']['alterar'][$j]['ConcluidoProcedimento'] = 'S';				
				}
                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

            }

            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterar2', $data);
            } else {

                $data['msg'] = '?m=1';

				redirect(base_url() . 'relatorio/alterarreceitas/' . $data['msg']);
				exit();
            }
        

        $this->load->view('basico/footer');

    }

    public function baixadadespesa($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
		
        $data['titulo'] = 'Baixa da Despesa';
        $data['form_open_path'] = 'orcatrata/baixadadespesa';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 1;
		
        #run form validation
		
		
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
			$data['orcatrata']['CombinadoFrete'] = "S";
			$data['orcatrata']['AprovadoOrca'] = "S";
			$data['orcatrata']['ConcluidoOrca'] = "S";
			$data['orcatrata']['QuitadoOrca'] = "S";
			$data['orcatrata']['FinalizadoOrca'] = "S";
			$data['orcatrata']['ProntoOrca'] = "S";
			$data['orcatrata']['EnviadoOrca'] = "S";

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrata_baixa($id);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $id, 
			TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $id);

            #### App_Produto ####
            $data['update']['produto']['alterar'] = $this->Orcatrata_model->get_produto_posterior($id);
            if (isset($data['update']['produto']['alterar'])){

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';				
                }
                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

            }

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['alterar'] = $this->Orcatrata_model->get_parcelas_posterior($id);
            if (isset($data['update']['parcelasrec']['alterar'])){
			
                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';				
				}
                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

            }

            #### App_Procedimento ####
            $data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($id);
            if (isset($data['update']['procedimento']['alterar'])){
			
                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['procedimento']['alterar'][$j]['ConcluidoProcedimento'] = 'S';				
				}
                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

            }

            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterar2', $data);
            } else {

                $data['msg'] = '?m=1';

				redirect(base_url() . 'relatorio/alterardespesas/' . $data['msg']);
				exit();
            }
        

        $this->load->view('basico/footer');

    }

    public function baixadaparcelarec($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
		
        $data['titulo'] = 'Baixa da Receita';
        $data['form_open_path'] = 'orcatrata/baixadaparcelarec';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;
		
        #run form validation
		
		
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
			$data['parcela']['Quitado'] = "S";
			
            $data['update']['parcela']['anterior'] = $this->Orcatrata_model->get_parcela($id);
            $data['id_orcatrata'] = $data['update']['parcela']['anterior']['idApp_OrcaTrata'];
			$data['update']['parcela']['campos'] = array_keys($data['parcela']);
            $data['update']['parcela']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['parcela']['anterior'],
                $data['parcela'],
                $data['update']['parcela']['campos'],
                $id, 
			TRUE);
            /*
			echo '<br>';
			echo "<pre>";
			print_r($data['id_orcatrata']);
			echo "</pre>";			
			*/
			
			$data['update']['parcela']['bd'] = $this->Orcatrata_model->update_parcela($data['parcela'], $id);			

			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['id_orcatrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}	
			}
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['id_orcatrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			
				#### App_Procedimento ####
				$data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($data['id_orcatrata']);
				if (isset($data['update']['procedimento']['alterar'])){
				
					$max = count($data['update']['procedimento']['alterar']);
					for($j=0;$j<$max;$j++) {
						$data['update']['procedimento']['alterar'][$j]['ConcluidoProcedimento'] = 'S';				
					}
					if (count($data['update']['procedimento']['alterar']))
						$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

				}
			
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}			
			
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['id_orcatrata']);			

            if ($data['auditoriaitem'] && !$data['update']['parcela']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterar2', $data);
            } else {

                $data['msg'] = '?m=1';

				redirect(base_url() . 'relatorio/cobrancas/' . $data['msg']);
				exit();
            }
        

        $this->load->view('basico/footer');

    }

    public function baixadaparceladesp($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### App_OrcaTrata ####
		
        $data['titulo'] = 'Baixa da Receita';
        $data['form_open_path'] = 'orcatrata/baixadaparceladesp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;
		
        #run form validation
		
		
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### App_OrcaTrata ####
			$data['parcela']['Quitado'] = "S";
			
            $data['update']['parcela']['anterior'] = $this->Orcatrata_model->get_parcela($id);
            $data['id_orcatrata'] = $data['update']['parcela']['anterior']['idApp_OrcaTrata'];
			$data['update']['parcela']['campos'] = array_keys($data['parcela']);
            $data['update']['parcela']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['parcela']['anterior'],
                $data['parcela'],
                $data['update']['parcela']['campos'],
                $id, 
			TRUE);
            /*
			echo '<br>';
			echo "<pre>";
			print_r($data['id_orcatrata']);
			echo "</pre>";			
			*/
			
			$data['update']['parcela']['bd'] = $this->Orcatrata_model->update_parcela($data['parcela'], $id);			

			$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['id_orcatrata']);
			if (isset($data['update']['parcelasrec']['posterior'])){
				$max_parcela = count($data['update']['parcelasrec']['posterior']);
				if($max_parcela == 0){
					$data['orcatrata']['QuitadoOrca'] = "S";				
				}else{
					$data['orcatrata']['QuitadoOrca'] = "N";
				}	
			}
			
			$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['id_orcatrata']);
			if (isset($data['update']['produto']['posterior'])){
				$max_produto = count($data['update']['produto']['posterior']);
				if($max_produto == 0){
					$data['orcatrata']['CombinadoFrete'] = "S";
					$data['orcatrata']['AprovadoOrca'] = "S";
					$data['orcatrata']['ProntoOrca'] = "S";
					$data['orcatrata']['EnviadoOrca'] = "S";
					$data['orcatrata']['ConcluidoOrca'] = "S";
				}else{
					$data['orcatrata']['ConcluidoOrca'] = "N";
				}
			}
			
			if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
				$data['orcatrata']['AprovadoOrca'] = "S";
				$data['orcatrata']['FinalizadoOrca'] = "S";
				$data['orcatrata']['CombinadoFrete'] = "S";
				$data['orcatrata']['ProntoOrca'] = "S";
				$data['orcatrata']['EnviadoOrca'] = "S";
			
				#### App_Procedimento ####
				$data['update']['procedimento']['alterar'] = $this->Orcatrata_model->get_procedimento_posterior($data['id_orcatrata']);
				if (isset($data['update']['procedimento']['alterar'])){
				
					$max = count($data['update']['procedimento']['alterar']);
					for($j=0;$j<$max;$j++) {
						$data['update']['procedimento']['alterar'][$j]['ConcluidoProcedimento'] = 'S';				
					}
					if (count($data['update']['procedimento']['alterar']))
						$data['update']['procedimento']['bd']['alterar'] =  $this->Orcatrata_model->update_procedimento($data['update']['procedimento']['alterar']);

				}
			
			}else{
				$data['orcatrata']['FinalizadoOrca'] = "N";
			}			
			
			$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['id_orcatrata']);			

            if ($data['auditoriaitem'] && !$data['update']['parcela']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
				$this->load->view('orcatrata/form_orcatrataalterar2', $data);
            } else {

                $data['msg'] = '?m=1';

				redirect(base_url() . 'relatorio/debitos/' . $data['msg']);
				exit();
            }
        

        $this->load->view('basico/footer');

    }
	
    public function alterarreceitas($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoComiss�o',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ValorTotalOrca' . $i) || $this->input->post('DataEntregaOrca' . $i) || $this->input->post('FinalizadoOrca' . $i)) {
                $data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
                $data['orcamento'][$j]['ValorTotalOrca'] = $this->input->post('ValorTotalOrca' . $i);
                $data['orcamento'][$j]['DataEntregaOrca'] = $this->input->post('DataEntregaOrca' . $i);
                $data['orcamento'][$j]['FinalizadoOrca'] = $this->input->post('FinalizadoOrca' . $i);
				$j++;
            }
		}
		
		$data['count']['PRCount'] = $j - 1;

		$data['somatotal'] = 0;
		
        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_OrcaTrata ####
            $data['orcamento'] = $this->Orcatrata_model->get_alterarorcamentos($id);
            if (count($data['orcamento']) > 0) {
                $data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
				$data['count']['PRCount'] = count($data['orcamento']);
                if (isset($data['orcamento'])) {
                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
						$data['somatotal'] += $data['orcamento'][$j]['ValorTotalOrca'];
						$data['orcamento'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataEntregaOrca'], 'barras');
					}
					$data['somatotal'] = number_format($data['somatotal'],2,",",".");
                }
            }
			
        }
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data['somatotal']);
          echo "</pre>";
          exit ();
		*/
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoComiss�o'] = $this->Basico_model->select_status_sn();
        $data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Baixa das Receitas';
        $data['form_open_path'] = 'orcatrata/alterarreceitas';
		$data['relatorio'] = 'relatorio/alterarreceitas/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 3;
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'statuspedido/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarorcamentos', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoComiss�o'] = $data['query']['QuitadoComiss�o'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////

            #### App_OrcaTrata ####
            $data['update']['orcamento']['anterior'] = $this->Orcatrata_model->get_alterarorcamentos($data['empresa']['idSis_Empresa']);
            if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

                if (isset($data['orcamento']))
                    $data['orcamento'] = array_values($data['orcamento']);
                else
                    $data['orcamento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

                $max = count($data['update']['orcamento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['orcamento']['alterar'][$j]['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorTotalOrca']));
                    $data['update']['orcamento']['alterar'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['update']['orcamento']['alterar'][$j]['DataEntregaOrca'], 'mysql');
					if ($data['query']['QuitadoComiss�o'] == 'S') $data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] = 'S';
					if ($data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] == 'S') {
						
						$data['update']['orcamento']['alterar'][$j]['CombinadoFrete'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['AprovadoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['ProntoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['EnviadoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['ConcluidoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['QuitadoOrca'] = 'S';
				
						$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'][$j])){
							$max_produto = count($data['update']['produto']['posterior'][$j]);
							for($k=0;$k<$max_produto;$k++) {
								
								$data['update']['produto']['posterior'][$j][$k]['ConcluidoProduto'] = 'S';
							
								$data['update']['produto']['bd'][$j] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['posterior'][$j][$k], $data['update']['produto']['posterior'][$j][$k]['idApp_Produto']);
							
							}
							
						}
						
						$data['update']['parcelasrec']['posterior'][$j] = $this->Orcatrata_model->get_parcelas_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'][$j])){
							$max_parcela = count($data['update']['parcelasrec']['posterior'][$j]);
							
							for($k=0;$k<$max_parcela;$k++) {
								
								$data['update']['parcelasrec']['posterior'][$j][$k]['Quitado'] = 'S';
							
								$data['update']['parcelasrec']['bd'][$j] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelasrec']['posterior'][$j][$k], $data['update']['parcelasrec']['posterior'][$j][$k]['idApp_Parcelas']);
							
							}
						}
						
						$data['update']['procedimento']['posterior'][$j] = $this->Orcatrata_model->get_procedimento_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
						if (isset($data['update']['procedimento']['posterior'][$j])){
							$max_parcela = count($data['update']['procedimento']['posterior'][$j]);
							
							for($k=0;$k<$max_parcela;$k++) {
								
								$data['update']['procedimento']['posterior'][$j][$k]['ConcluidoProcedimento'] = 'S';
							
								$data['update']['procedimento']['bd'][$j] = $this->Orcatrata_model->update_procedimento_id($data['update']['procedimento']['posterior'][$j][$k], $data['update']['procedimento']['posterior'][$j][$k]['idApp_Procedimento']);
							
							}
						}
							
					}
					
					$data['update']['orcamento']['bd'] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamento']['alterar'][$j], $data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);

				}

            }
			
			$data['msg'] = '?m=1';
			
			redirect(base_url() . 'orcatrata/alterarreceitas/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

			exit();			
			
        }

        $this->load->view('basico/footer');

    }

    public function alterardespesas($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoComiss�o',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ValorTotalOrca' . $i) || $this->input->post('DataEntregaOrca' . $i) || $this->input->post('FinalizadoOrca' . $i)) {
                $data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
                $data['orcamento'][$j]['ValorTotalOrca'] = $this->input->post('ValorTotalOrca' . $i);
                $data['orcamento'][$j]['DataEntregaOrca'] = $this->input->post('DataEntregaOrca' . $i);
                $data['orcamento'][$j]['FinalizadoOrca'] = $this->input->post('FinalizadoOrca' . $i);
				$j++;
            }
		}
		
		$data['count']['PRCount'] = $j - 1;

		$data['somatotal'] = 0;
		
        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_OrcaTrata ####
            $data['orcamento'] = $this->Orcatrata_model->get_alterarorcamentos($id);
            if (count($data['orcamento']) > 0) {
                $data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
				$data['count']['PRCount'] = count($data['orcamento']);
                if (isset($data['orcamento'])) {
                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
						$data['somatotal'] += $data['orcamento'][$j]['ValorTotalOrca'];
						$data['orcamento'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataEntregaOrca'], 'barras');
					}
					$data['somatotal'] = number_format($data['somatotal'],2,",",".");
                }
            }
			
        }
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data['somatotal']);
          echo "</pre>";
          exit ();
		*/
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoComiss�o'] = $this->Basico_model->select_status_sn();
        $data['select']['FinalizadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Baixa das Despesas';
        $data['form_open_path'] = 'orcatrata/alterardespesas';
		$data['relatorio'] = 'relatorio/alterardespesas/';
		$data['imprimir'] = 'OrcatrataPrintComissao/imprimir/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 3;
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		$data['edit'] = 'statuspedido/alterarstatus/';
		$data['alterarparc'] = 'Orcatrata/alterarparcelarec/';

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarorcamentos', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoComiss�o'] = $data['query']['QuitadoComiss�o'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////

            #### App_OrcaTrata ####
            $data['update']['orcamento']['anterior'] = $this->Orcatrata_model->get_alterarorcamentos($data['empresa']['idSis_Empresa']);
            if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

                if (isset($data['orcamento']))
                    $data['orcamento'] = array_values($data['orcamento']);
                else
                    $data['orcamento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

                $max = count($data['update']['orcamento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['orcamento']['alterar'][$j]['ValorTotalOrca'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorTotalOrca']));
                    $data['update']['orcamento']['alterar'][$j]['DataEntregaOrca'] = $this->basico->mascara_data($data['update']['orcamento']['alterar'][$j]['DataEntregaOrca'], 'mysql');
					if ($data['query']['QuitadoComiss�o'] == 'S') $data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] = 'S';
					if ($data['update']['orcamento']['alterar'][$j]['FinalizadoOrca'] == 'S') {
						
						$data['update']['orcamento']['alterar'][$j]['CombinadoFrete'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['AprovadoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['ProntoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['EnviadoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['ConcluidoOrca'] = 'S';
						$data['update']['orcamento']['alterar'][$j]['QuitadoOrca'] = 'S';
				
						$data['update']['produto']['posterior'][$j] = $this->Orcatrata_model->get_produto_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
						if (isset($data['update']['produto']['posterior'][$j])){
							$max_produto = count($data['update']['produto']['posterior'][$j]);
							for($k=0;$k<$max_produto;$k++) {
								
								$data['update']['produto']['posterior'][$j][$k]['ConcluidoProduto'] = 'S';
							
								$data['update']['produto']['bd'][$j] = $this->Orcatrata_model->update_produto_id($data['update']['produto']['posterior'][$j][$k], $data['update']['produto']['posterior'][$j][$k]['idApp_Produto']);
							
							}
							
						}
						
						$data['update']['parcelasrec']['posterior'][$j] = $this->Orcatrata_model->get_parcelas_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
						if (isset($data['update']['parcelasrec']['posterior'][$j])){
							$max_parcela = count($data['update']['parcelasrec']['posterior'][$j]);
							
							for($k=0;$k<$max_parcela;$k++) {
								
								$data['update']['parcelasrec']['posterior'][$j][$k]['Quitado'] = 'S';
							
								$data['update']['parcelasrec']['bd'][$j] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelasrec']['posterior'][$j][$k], $data['update']['parcelasrec']['posterior'][$j][$k]['idApp_Parcelas']);
							
							}
						}
						
						$data['update']['procedimento']['posterior'][$j] = $this->Orcatrata_model->get_procedimento_posterior($data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);
						if (isset($data['update']['procedimento']['posterior'][$j])){
							$max_parcela = count($data['update']['procedimento']['posterior'][$j]);
							
							for($k=0;$k<$max_parcela;$k++) {
								
								$data['update']['procedimento']['posterior'][$j][$k]['ConcluidoProcedimento'] = 'S';
							
								$data['update']['procedimento']['bd'][$j] = $this->Orcatrata_model->update_procedimento_id($data['update']['procedimento']['posterior'][$j][$k], $data['update']['procedimento']['posterior'][$j][$k]['idApp_Procedimento']);
							
							}
						}
							
					}
					
					$data['update']['orcamento']['bd'] = $this->Orcatrata_model->update_orcatrata($data['update']['orcamento']['alterar'][$j], $data['update']['orcamento']['alterar'][$j]['idApp_OrcaTrata']);

				}

            }
			
			$data['msg'] = '?m=1';
			
			redirect(base_url() . 'orcatrata/alterarreceitas/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

			exit();			
			
        }

        $this->load->view('basico/footer');

    }

    public function baixadacomissao($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoComiss�o',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ValorRestanteOrca' . $i) || $this->input->post('DataVencimentoOrca' . $i) || $this->input->post('StatusComissaoOrca' . $i)) {
                $data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
                $data['orcamento'][$j]['ValorRestanteOrca'] = $this->input->post('ValorRestanteOrca' . $i);
                $data['orcamento'][$j]['ValorComissao'] = $this->input->post('ValorComissao' . $i);
                $data['orcamento'][$j]['DataVencimentoOrca'] = $this->input->post('DataVencimentoOrca' . $i);
                $data['orcamento'][$j]['StatusComissaoOrca'] = $this->input->post('StatusComissaoOrca' . $i);
				$j++;
            }
		}
		
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar
		$data['somatotal'] = 0;
        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Parcelas ####
            $data['orcamento'] = $this->Orcatrata_model->get_baixadacomissao($id);
            if (count($data['orcamento']) > 0) {
                $data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
				$data['count']['PRCount'] = count($data['orcamento']);
				
                if (isset($data['orcamento'])) {

					//$data['somatotal'] = 0;
					
                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        
						$data['somatotal'] += $data['orcamento'][$j]['ValorComissao'];
						
						$data['orcamento'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataVencimentoOrca'], 'barras');
                    
					}
					
					$data['somatotal'] = number_format($data['somatotal'],2,",",".");
                }
            }

        }
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data['somatotal']);
          echo "</pre>";
          exit ();
		*/
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoComiss�o'] = $this->Basico_model->select_status_sn();
        $data['select']['StatusComissaoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Baixa da Comissao NaLoja';
        $data['form_open_path'] = 'orcatrata/baixadacomissao';
		$data['relatorio'] = 'relatorio/comissao/';
		$data['imprimir'] = 'OrcatrataPrint/imprimircomissao/';
        $data['nomeusuario'] = 'NomeColaborador';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 1;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_baixadacomissao', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoComiss�o'] = $data['query']['QuitadoComiss�o'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####
			/*
			$data['empresa']['DataOrca'] = $this->basico->mascara_data($data['empresa']['DataOrca'], 'mysql');


            $data['update']['empresa']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['empresa']['idSis_Empresa']);
            $data['update']['empresa']['campos'] = array_keys($data['empresa']);
            $data['update']['empresa']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['empresa']['anterior'],
                $data['empresa'],
                $data['update']['empresa']['campos'],
                $data['empresa']['idSis_Empresa'], TRUE);
            $data['update']['empresa']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['empresa'], $data['empresa']['idSis_Empresa']);
			*/

            #### App_ParcelasRec ####
            $data['update']['orcamento']['anterior'] = $this->Orcatrata_model->get_baixadacomissao($data['empresa']['idSis_Empresa']);
            if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

                if (isset($data['orcamento']))
                    $data['orcamento'] = array_values($data['orcamento']);
                else
                    $data['orcamento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

                $max = count($data['update']['orcamento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['orcamento']['alterar'][$j]['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorRestanteOrca']));
                    $data['update']['orcamento']['alterar'][$j]['ValorComissao'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorComissao']));
                    $data['update']['orcamento']['alterar'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['update']['orcamento']['alterar'][$j]['DataVencimentoOrca'], 'mysql');
					if ($data['query']['QuitadoComiss�o'] == 'S') $data['update']['orcamento']['alterar'][$j]['StatusComissaoOrca'] = 'S';
				}

                if (count($data['update']['orcamento']['alterar']))
                    $data['update']['orcamento']['bd']['alterar'] =  $this->Orcatrata_model->update_comissao($data['update']['orcamento']['alterar']);

            }
			/*
            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['empresa']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_baixadacomissao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				//redirect(base_url() . 'relatorio/comissao/' . $data['msg']);
				redirect(base_url() . 'orcatrata/baixadacomissao/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

				exit();
            }
			*/
			$data['msg'] = '?m=1';

			//redirect(base_url() . 'relatorio/comissao/' . $data['msg']);
			redirect(base_url() . 'orcatrata/baixadacomissao/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

			exit();			
			
        }

        $this->load->view('basico/footer');

    }

    public function baixadacomissao_online($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoComiss�o',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('ValorRestanteOrca' . $i) || $this->input->post('DataVencimentoOrca' . $i) || $this->input->post('StatusComissaoOrca_Online' . $i)) {
                $data['orcamento'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
                $data['orcamento'][$j]['ValorRestanteOrca'] = $this->input->post('ValorRestanteOrca' . $i);
                $data['orcamento'][$j]['ValorComissao'] = $this->input->post('ValorComissao' . $i);
                $data['orcamento'][$j]['DataVencimentoOrca'] = $this->input->post('DataVencimentoOrca' . $i);
                $data['orcamento'][$j]['StatusComissaoOrca_Online'] = $this->input->post('StatusComissaoOrca_Online' . $i);
				$j++;
            }
		}
		
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar
		$data['somatotal'] = 0;
        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Parcelas ####
            $data['orcamento'] = $this->Orcatrata_model->get_baixadacomissao($id);
            if (count($data['orcamento']) > 0) {
                $data['orcamento'] = array_combine(range(1, count($data['orcamento'])), array_values($data['orcamento']));
				$data['count']['PRCount'] = count($data['orcamento']);
				
                if (isset($data['orcamento'])) {

					//$data['somatotal'] = 0;
					
                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        
						$data['somatotal'] += $data['orcamento'][$j]['ValorComissao'];
						
						$data['orcamento'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['orcamento'][$j]['DataVencimentoOrca'], 'barras');
                    
					}
					
					$data['somatotal'] = number_format($data['somatotal'],2,",",".");
                }
            }

        }
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data['somatotal']);
          echo "</pre>";
          exit ();
		*/
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoComiss�o'] = $this->Basico_model->select_status_sn();
        $data['select']['StatusComissaoOrca_Online'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Baixa da Comissao OnLine';
        $data['form_open_path'] = 'orcatrata/baixadacomissao_online';
		$data['relatorio'] = 'relatorio/comissao_online/';
		$data['imprimir'] = 'OrcatrataPrint/imprimircomissao_online/';
        $data['nomeusuario'] = 'NomeAssociado';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_baixadacomissao', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoComiss�o'] = $data['query']['QuitadoComiss�o'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////


            #### App_OrcaTrata ####
            $data['update']['orcamento']['anterior'] = $this->Orcatrata_model->get_baixadacomissao($data['empresa']['idSis_Empresa']);
            if (isset($data['orcamento']) || (!isset($data['orcamento']) && isset($data['update']['orcamento']['anterior']) ) ) {

                if (isset($data['orcamento']))
                    $data['orcamento'] = array_values($data['orcamento']);
                else
                    $data['orcamento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['orcamento'] = $this->basico->tratamento_array_multidimensional($data['orcamento'], $data['update']['orcamento']['anterior'], 'idApp_OrcaTrata');

                $max = count($data['update']['orcamento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['orcamento']['alterar'][$j]['ValorRestanteOrca'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorRestanteOrca']));
                    $data['update']['orcamento']['alterar'][$j]['ValorComissao'] = str_replace(',', '.', str_replace('.', '', $data['update']['orcamento']['alterar'][$j]['ValorComissao']));
                    $data['update']['orcamento']['alterar'][$j]['DataVencimentoOrca'] = $this->basico->mascara_data($data['update']['orcamento']['alterar'][$j]['DataVencimentoOrca'], 'mysql');
					if ($data['query']['QuitadoComiss�o'] == 'S') $data['update']['orcamento']['alterar'][$j]['StatusComissaoOrca_Online'] = 'S';
				}

                if (count($data['update']['orcamento']['alterar']))
                    $data['update']['orcamento']['bd']['alterar'] =  $this->Orcatrata_model->update_comissao($data['update']['orcamento']['alterar']);

            }
			
			$data['msg'] = '?m=1';
			redirect(base_url() . 'orcatrata/baixadacomissao_online/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

			exit();
			
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarparceladesp_Original($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Quitado',
			'Orcades',
			'NomeFornecedor',
			'QuitadoParcelas',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',


        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
				
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || 
					$this->input->post('DataVencimento' . $i) || $this->input->post('ValorPago' . $i) || 
					$this->input->post('DataPago' . $i) || $this->input->post('Quitado' . $i)) {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {   
			#### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_alterarparceladesp($id);
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

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
		$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcades'] = $this->Basico_model->select_orcades();
		$data['select']['NomeFornecedor'] = $this->Basico_model->select_fornecedor();
		
        $data['titulo'] = 'Despesas';
        $data['form_open_path'] = 'orcatrata/alterarparceladesp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarparcela', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcades'] = $data['query']['Orcades'];
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);


            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_alterarparceladesp($data['orcatrata']['idSis_Empresa']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    #$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "1";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
				}

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

            }
			
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarparcela', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/despesasparc/' . $data['msg']);
				redirect(base_url() . 'relatorio/parcelasdesp/' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarparcelarec_Original($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoParcelas',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || 
					$this->input->post('DataVencimento' . $i) || $this->input->post('ValorPago' . $i) || 
					$this->input->post('DataPago' . $i) || $this->input->post('Quitado' . $i)) {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_alterarparcelarec($id);
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

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Receitas';
        $data['form_open_path'] = 'orcatrata/alterarparcelarec';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarparcela', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);


            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_alterarparcelarec($data['orcatrata']['idSis_Empresa']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    #$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
				}

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

            }
			
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarparcela', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/receitasparc/' . $data['msg']);
				redirect(base_url() . 'relatorio/parcelasrec/' . $data['msg']);
				//redirect(base_url() . 'orcatrata/alterarparcelarec/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarparcelarec($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoParcelas',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) ||  
					$this->input->post('DataVencimento' . $i) || $this->input->post('ValorPago' . $i) || 
					$this->input->post('DataPago' . $i) || $this->input->post('Quitado' . $i)) {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;
		
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_alterarparcela($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
				
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
						$data['parcelasrec'][$j]['Modalidade'] = $data['parcelasrec'][$j]['Modalidade'];
						if($data['parcelasrec'][$j]['Modalidade'] == "P"){
							$data['parcelasrec'][$j]['Tipo'] = 'Dividido';
							$data['parcelasrec'][$j]['readonly'] = 'readonly=""';
						}elseif($data['parcelasrec'][$j]['Modalidade'] == "M"){
							$data['parcelasrec'][$j]['Tipo'] = 'Mensal';
							$data['parcelasrec'][$j]['readonly'] = '';
						}
						
						/*        
						echo '<br>';
						echo "<pre>";
						print_r($data['parcelasrec'][$j]['Modalidade']);
						echo '<br>';
						print_r($data['readonly'][$j]);
						echo "</pre>";
						*/	
                    }
					//exit ();

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Receitas';
        $data['form_open_path'] = 'orcatrata/alterarparcelarec';
        $data['readonly'] = 'readonly=""';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;
		$data['TipoFinanceiro'] = 'Receitas';
		$data['TipoRD'] = 2;
        $data['nome'] = 'Cliente';		

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarparcela', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####
			/*
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);
			*/

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_alterarparcela($data['empresa']['idSis_Empresa']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');
				
                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0; $j<$max; $j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					//$data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata'] = $data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata'];
					if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';

					$data['update']['parcelasrec']['bd'] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelasrec']['alterar'][$j], $data['update']['parcelasrec']['alterar'][$j]['idApp_Parcelas']);

					$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_baixa($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					
					$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					if (isset($data['update']['parcelasrec']['posterior'])){
						$max_parcela = count($data['update']['parcelasrec']['posterior']);
						if($max_parcela == 0){
							$data['orcatrata']['QuitadoOrca'] = "S";				
						}else{
							$data['orcatrata']['QuitadoOrca'] = "N";
						}	
					}
					
					$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					if (isset($data['update']['produto']['posterior'])){
						$max_produto = count($data['update']['produto']['posterior']);
						if($max_produto == 0){
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['ConcluidoOrca'] = "S";
						}else{
							$data['orcatrata']['ConcluidoOrca'] = "N";
						}
					}
					
					if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
					}else{
						$data['orcatrata']['FinalizadoOrca'] = "N";
					}
					
					$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);					
					
					/*
					echo '<br>';
					echo "<pre>";
					print_r($data['update']['parcelasrec']['alterar'][$j]['idApp_Parcelas']);
					echo '<br>';
					print_r($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					echo '<br>';
					print_r($max_parcela);
					echo '<br>';
					print_r($max_produto);
					echo '<br>';
					print_r($data['orcatrata']['CombinadoFrete']);
					echo '<br>';
					print_r($data['orcatrata']['AprovadoOrca']);
					echo '<br>';
					print_r($data['orcatrata']['ProntoOrca']);
					echo '<br>';
					print_r($data['orcatrata']['EnviadoOrca']);
					echo '<br>';
					print_r($data['orcatrata']['QuitadoOrca']);
					echo '<br>';
					print_r($data['orcatrata']['ConcluidoOrca']);
					echo '<br>';
					print_r($data['orcatrata']['FinalizadoOrca']);
					echo '<br>';
					echo "</pre>";
					echo '<br>';
					
					echo "<pre>";
					echo '<br>';
					print_r($data['update']['parcelasrec']['posterior']);
					echo '<br>';
					print_r($data['update']['produto']['posterior']);
					echo "</pre>";
					
					echo "<pre>";
					echo '<br>';
					print_r($data['orcatrata']['idApp_OrcaTrata']);
					echo "</pre>";
					*/
				}
				//exit ();
				
                /*
				if (count($data['update']['parcelasrec']['alterar'])){
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);
				}
				*/	
				
			}
			
			$data['msg'] = '?m=1';
			//redirect(base_url() . 'relatorio/cobrancas/' . $data['msg']);
			redirect(base_url() . 'orcatrata/alterarparcelarec/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

			exit();
            
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarparceladesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeFornecedor',
			'QuitadoParcelas',
			'AprovadoOrca',
			'ConcluidoOrca',
			'QuitadoOrca',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['empresa'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) ||  
					$this->input->post('DataVencimento' . $i) || $this->input->post('ValorPago' . $i) || 
					$this->input->post('DataPago' . $i) || $this->input->post('Quitado' . $i)) {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['idApp_OrcaTrata'] = $this->input->post('idApp_OrcaTrata' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;
		
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['empresa'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_alterarparcela($id);
            if (count($data['parcelasrec']) > 0) {
                $data['parcelasrec'] = array_combine(range(1, count($data['parcelasrec'])), array_values($data['parcelasrec']));
				$data['count']['PRCount'] = count($data['parcelasrec']);
				
                if (isset($data['parcelasrec'])) {

                    for($j=1; $j <= $data['count']['PRCount']; $j++) {
                        $data['parcelasrec'][$j]['DataVencimento'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataVencimento'], 'barras');
                        $data['parcelasrec'][$j]['DataPago'] = $this->basico->mascara_data($data['parcelasrec'][$j]['DataPago'], 'barras');
						$data['parcelasrec'][$j]['Modalidade'] = $data['parcelasrec'][$j]['Modalidade'];
						if($data['parcelasrec'][$j]['Modalidade'] == "P"){
							$data['parcelasrec'][$j]['Tipo'] = 'Dividido';
							$data['parcelasrec'][$j]['readonly'] = 'readonly=""';
						}elseif($data['parcelasrec'][$j]['Modalidade'] == "M"){
							$data['parcelasrec'][$j]['Tipo'] = 'Mensal';
							$data['parcelasrec'][$j]['readonly'] = '';
						}
                    }

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['AprovadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoOrca'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeFornecedor'] = $this->Basico_model->select_fornecedor();		
		
        $data['titulo'] = 'Despesas';
        $data['form_open_path'] = 'orcatrata/alterarparceladesp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 1;
		$data['TipoFinanceiro'] = 'Despesas';
		$data['TipoRD'] = 1;
        $data['nome'] = 'Fornecedor';

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarparcela', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			$data['bd']['AprovadoOrca'] = $data['query']['AprovadoOrca'];
			$data['bd']['ConcluidoOrca'] = $data['query']['ConcluidoOrca'];
			$data['bd']['QuitadoOrca'] = $data['query']['QuitadoOrca'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////

            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_alterarparcela($data['empresa']['idSis_Empresa']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');
				
                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0; $j<$max; $j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					//$data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata'] = $data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata'];
					if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';

					$data['update']['parcelasrec']['bd'] = $this->Orcatrata_model->update_parcelas_id($data['update']['parcelasrec']['alterar'][$j], $data['update']['parcelasrec']['alterar'][$j]['idApp_Parcelas']);

					$data['orcatrata'] = $this->Orcatrata_model->get_orcatrata_baixa($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					
					$data['update']['parcelasrec']['posterior'] = $this->Orcatrata_model->get_parcelas_posterior($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					if (isset($data['update']['parcelasrec']['posterior'])){
						$max_parcela = count($data['update']['parcelasrec']['posterior']);
						if($max_parcela == 0){
							$data['orcatrata']['QuitadoOrca'] = "S";				
						}else{
							$data['orcatrata']['QuitadoOrca'] = "N";
						}
					}
					
					$data['update']['produto']['posterior'] = $this->Orcatrata_model->get_produto_posterior($data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);
					if (isset($data['update']['produto']['posterior'])){
						$max_produto = count($data['update']['produto']['posterior']);
						if($max_produto == 0){
							$data['orcatrata']['CombinadoFrete'] = "S";
							$data['orcatrata']['AprovadoOrca'] = "S";
							$data['orcatrata']['ProntoOrca'] = "S";
							$data['orcatrata']['EnviadoOrca'] = "S";
							$data['orcatrata']['ConcluidoOrca'] = "S";
						}else{
							$data['orcatrata']['ConcluidoOrca'] = "N";
						}
					}
					
					if($data['orcatrata']['ConcluidoOrca'] == 'S' && $data['orcatrata']['QuitadoOrca'] == 'S'){
						$data['orcatrata']['AprovadoOrca'] = "S";
						$data['orcatrata']['FinalizadoOrca'] = "S";
						$data['orcatrata']['CombinadoFrete'] = "S";
						$data['orcatrata']['ProntoOrca'] = "S";
						$data['orcatrata']['EnviadoOrca'] = "S";
					}else{
						$data['orcatrata']['FinalizadoOrca'] = "N";
					}					
					
					$data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrata($data['orcatrata'], $data['update']['parcelasrec']['alterar'][$j]['idApp_OrcaTrata']);					
					
				}	
				
			}
			
			$data['msg'] = '?m=1';
			redirect(base_url() . 'orcatrata/alterarparceladesp/' . $_SESSION['log']['idSis_Empresa'] . $data['msg']);

			exit();
            
        }

        $this->load->view('basico/footer');

    }

    public function alterarparceladespfiado($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Quitado',
			'Orcades',
			'NomeFornecedor',
			'QuitadoParcelas',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',


        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
				
        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || 
					$this->input->post('DataVencimento' . $i) || $this->input->post('ValorPago' . $i) || 
					$this->input->post('DataPago' . $i) || $this->input->post('Quitado' . $i)) {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {   
			#### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_alterarparceladespfiado($id);
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

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
		$data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcades'] = $this->Basico_model->select_orcades();
		$data['select']['NomeFornecedor'] = $this->Basico_model->select_fornecedor();
		
        $data['titulo'] = 'Despesas ';
        $data['form_open_path'] = 'orcatrata/alterarparceladespfiado';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarparcela', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcades'] = $data['query']['Orcades'];
			$data['bd']['NomeFornecedor'] = $data['query']['NomeFornecedor'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);


            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_alterarparceladespfiado($data['orcatrata']['idSis_Empresa']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    #$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "1";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
				}

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

            }
			
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarparcela', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/despesasparc/' . $data['msg']);
				redirect(base_url() . 'relatorio/fiadodesp/' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarparcelarecfiado($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',
			'QuitadoParcelas',
        ), TRUE));
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',

        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PRCount')) ? $data['count']['PRCount'] = 0 : $data['count']['PRCount'] = $this->input->post('PRCount');
		
		

        $j = 1;
        for ($i = 1; $i <= $data['count']['PRCount']; $i++) {

            if ($this->input->post('Parcela' . $i) || $this->input->post('ValorParcela' . $i) || 
					$this->input->post('DataVencimento' . $i) || $this->input->post('ValorPago' . $i) || 
					$this->input->post('DataPago' . $i) || $this->input->post('Quitado' . $i)) {
                $data['parcelasrec'][$j]['idApp_Parcelas'] = $this->input->post('idApp_Parcelas' . $i);
                $data['parcelasrec'][$j]['Parcela'] = $this->input->post('Parcela' . $i);
                $data['parcelasrec'][$j]['ValorParcela'] = $this->input->post('ValorParcela' . $i);
                $data['parcelasrec'][$j]['DataVencimento'] = $this->input->post('DataVencimento' . $i);
                $data['parcelasrec'][$j]['ValorPago'] = $this->input->post('ValorPago' . $i);
                $data['parcelasrec'][$j]['DataPago'] = $this->input->post('DataPago' . $i);
                $data['parcelasrec'][$j]['Quitado'] = $this->input->post('Quitado' . $i);
				$j++;
            }
        }
		$data['count']['PRCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Parcelas ####
            $data['parcelasrec'] = $this->Orcatrata_model->get_alterarparcelarecfiado($id);
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

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		
        $data['titulo'] = 'Receitas';
        $data['form_open_path'] = 'orcatrata/alterarparcelarecfiado';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        if ($data['count']['PRCount'] > 0 )
            $data['parcelasin'] = 'in';
        else
            $data['parcelasin'] = '';


        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarparcela', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['NomeCliente'] = $data['query']['NomeCliente'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);


            #### App_ParcelasRec ####
            $data['update']['parcelasrec']['anterior'] = $this->Orcatrata_model->get_alterarparcelarecfiado($data['orcatrata']['idSis_Empresa']);
            if (isset($data['parcelasrec']) || (!isset($data['parcelasrec']) && isset($data['update']['parcelasrec']['anterior']) ) ) {

                if (isset($data['parcelasrec']))
                    $data['parcelasrec'] = array_values($data['parcelasrec']);
                else
                    $data['parcelasrec'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['parcelasrec'] = $this->basico->tratamento_array_multidimensional($data['parcelasrec'], $data['update']['parcelasrec']['anterior'], 'idApp_Parcelas');

                $max = count($data['update']['parcelasrec']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    #$data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['update']['parcelasrec']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
					$data['update']['parcelasrec']['inserir'][$j]['idTab_TipoRD'] = "2";
                    $data['update']['parcelasrec']['inserir'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['inserir'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['inserir'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['inserir'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['inserir'][$j]['DataPago'], 'mysql');
					if ($data['orcatrata']['QuitadoOrca'] == 'S') { 
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = 'S';
					} else {
						$data['update']['parcelasrec']['inserir'][$j]['Quitado'] = $data['update']['parcelasrec']['inserir'][$j]['Quitado'];
					}
                }

                $max = count($data['update']['parcelasrec']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['parcelasrec']['alterar'][$j]['ValorParcela'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorParcela']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataVencimento'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataVencimento'], 'mysql');
                    $data['update']['parcelasrec']['alterar'][$j]['ValorPago'] = str_replace(',', '.', str_replace('.', '', $data['update']['parcelasrec']['alterar'][$j]['ValorPago']));
                    $data['update']['parcelasrec']['alterar'][$j]['DataPago'] = $this->basico->mascara_data($data['update']['parcelasrec']['alterar'][$j]['DataPago'], 'mysql');
					if ($data['query']['QuitadoParcelas'] == 'S') $data['update']['parcelasrec']['alterar'][$j]['Quitado'] = 'S';
				}

                if (count($data['update']['parcelasrec']['inserir']))
                    $data['update']['parcelasrec']['bd']['inserir'] = $this->Orcatrata_model->set_parcelas($data['update']['parcelasrec']['inserir']);

                if (count($data['update']['parcelasrec']['alterar']))
                    $data['update']['parcelasrec']['bd']['alterar'] =  $this->Orcatrata_model->update_parcelas($data['update']['parcelasrec']['alterar']);

                if (count($data['update']['parcelasrec']['excluir']))
                    $data['update']['parcelasrec']['bd']['excluir'] = $this->Orcatrata_model->delete_parcelas($data['update']['parcelasrec']['excluir']);

            }
			
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarparcela', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/receitasparc/' . $data['msg']);
				redirect(base_url() . 'relatorio/fiadorec/' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarprodutodesp($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeFornecedor',			
			'Entregues',
			'Devolvidos',
			'QuitadoParcelas',
			'Cadastrar',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			#'DataOrca',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorProduto' . $i) ||
					$this->input->post('QtdProduto' . $i) || $this->input->post('QtdIncrementoProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)|| 
					$this->input->post('Aux_App_Produto_2' . $i) || $this->input->post('Aux_App_Produto_3' . $i) || 
					$this->input->post('Aux_App_Produto_4' . $i) || $this->input->post('Aux_App_Produto_1' . $i) ||					
					$this->input->post('idSis_Usuario' . $i) || $this->input->post('ConcluidoProduto' . $i) || 
					$this->input->post('DevolvidoProduto' . $i)  || 
					$this->input->post('Aux_App_Produto_5' . $i) || $this->input->post('HoraValidadeProduto' . $i)) {
                $data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
				$j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_Servico ####
            $data['servico'] = $this->Orcatrata_model->get_alterarservicodesp($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorServico'] * $data['servico'][$j]['QtdServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
                }
            }

            #### App_Produto ####
            $data['produto'] = $this->Orcatrata_model->get_alterarprodutodesp($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
					}

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Produto'] = $this->Basico_model->select_produtos();
		$data['select']['Servico'] = $this->Basico_model->select_produtos();
		$data['select']['Entregues'] = $this->Basico_model->select_status_sn();
		$data['select']['Devolvidos'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeFornecedor'] = $this->Basico_model->select_fornecedor();		
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		
        $data['titulo'] = 'Compras';
        $data['form_open_path'] = 'orcatrata/alterarprodutodesp';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'danger';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';
		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarproduto', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			$data['bd']['Entregues'] = $data['query']['Entregues'];
			$data['bd']['Devolvidos'] = $data['query']['Devolvidos'];
			$data['bd']['Cadastrar'] = $data['query']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);

            #### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_alterarservicodesp($data['orcatrata']['idSis_Empresa']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Servico');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];					
					$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "1";
					$data['update']['servico']['inserir'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['inserir'][$j]['ValorServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['servico']['inserir'][$j]['ConcluidoServico'] = 'S';
						}
					}
					else {$data['update']['servico']['inserir'][$j]['ConcluidoServico'] = 'N';
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['idTab_Valor_Servico'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Servico'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Servico'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Servico'];
					$data['update']['servico']['alterar'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['servico']['alterar'][$j]['ConcluidoServico'] = 'S';
						}
					}
					else {$data['update']['servico']['alterar'][$j]['ConcluidoServico'] = 'N';
					}
					
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
            }

            #### App_Produto ####
            $data['update']['produto']['anterior'] = $this->Orcatrata_model->get_alterarprodutodesp($data['orcatrata']['idSis_Empresa']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "1";
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}
				
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
					$data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['query']['Entregues'] == 'S') $data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					if ($data['query']['Devolvidos'] == 'S') $data['update']['produto']['alterar'][$j]['DevolvidoProduto'] = 'S';
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarproduto', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtosvend/' . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarprodutorec($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',			
			'Entregues',
			'Devolvidos',
			'QuitadoParcelas',
			'Cadastrar',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			#'DataOrca',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorProduto' . $i) ||
					$this->input->post('QtdProduto' . $i) || $this->input->post('QtdIncrementoProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)|| 
					$this->input->post('Aux_App_Produto_2' . $i) || $this->input->post('Aux_App_Produto_3' . $i) || 
					$this->input->post('Aux_App_Produto_4' . $i) || $this->input->post('Aux_App_Produto_1' . $i) ||					
					$this->input->post('idSis_Usuario' . $i) || $this->input->post('ConcluidoProduto' . $i) || 
					$this->input->post('DevolvidoProduto' . $i)  || 
					$this->input->post('Aux_App_Produto_5' . $i) || $this->input->post('HoraValidadeProduto' . $i)) {
                $data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
				$j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_Servico ####
            $data['servico'] = $this->Orcatrata_model->get_alterarservicorec($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorServico'] * $data['servico'][$j]['QtdServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
                }
            }

            #### App_Produto ####
            $data['produto'] = $this->Orcatrata_model->get_alterarprodutorec($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
					}

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Produto'] = $this->Basico_model->select_produtos();
		$data['select']['Servico'] = $this->Basico_model->select_produtos();
		$data['select']['Entregues'] = $this->Basico_model->select_status_sn();
		$data['select']['Devolvidos'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		
        $data['titulo'] = 'Vendas';
        $data['form_open_path'] = 'orcatrata/alterarprodutorec';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';
		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarproduto', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			$data['bd']['Entregues'] = $data['query']['Entregues'];
			$data['bd']['Devolvidos'] = $data['query']['Devolvidos'];
			$data['bd']['Cadastrar'] = $data['query']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);

            #### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_alterarservicorec($data['orcatrata']['idSis_Empresa']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Servico');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];					
					$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "2";
					$data['update']['servico']['inserir'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['inserir'][$j]['ValorServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['servico']['inserir'][$j]['ConcluidoServico'] = 'S';
						}
					}
					else {$data['update']['servico']['inserir'][$j]['ConcluidoServico'] = 'N';
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['idTab_Valor_Servico'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Servico'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Servico'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Servico'];
					$data['update']['servico']['alterar'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['servico']['alterar'][$j]['ConcluidoServico'] = 'S';
						}
					}
					else {$data['update']['servico']['alterar'][$j]['ConcluidoServico'] = 'N';
					}
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
            }

            #### App_Produto ####
            $data['update']['produto']['anterior'] = $this->Orcatrata_model->get_alterarprodutorec($data['orcatrata']['idSis_Empresa']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "2";
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}
				
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
					$data['update']['produto']['alterar'][$j]['NomeProduto'] = $data['update']['produto']['alterar'][$j]['NomeProduto'];
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['query']['Entregues'] == 'S') $data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					if ($data['query']['Devolvidos'] == 'S') $data['update']['produto']['alterar'][$j]['DevolvidoServico'] = 'S';
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarproduto', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtosvend/' . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarstatuscomissao($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['query'] = quotes_to_entities($this->input->post(array(
			'Dia',
			'Mesvenc',
			'Ano',
			'Orcarec',
			'NomeCliente',			
			'Entregues',
			'Devolvidos',
			'QuitadoParcelas',
			'Cadastrar',
        ), TRUE));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
			#'DataOrca',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        (!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');
        (!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');
		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Servico' . $i)) {
                $data['servico'][$j]['idApp_Servico'] = $this->input->post('idApp_Servico' . $i);
                $data['servico'][$j]['idTab_Servico'] = $this->input->post('idTab_Servico' . $i);
				$data['servico'][$j]['idTab_Valor_Servico'] = $this->input->post('idTab_Valor_Servico' . $i);
				$data['servico'][$j]['idTab_Produtos_Servico'] = $this->input->post('idTab_Produtos_Servico' . $i);
				$data['servico'][$j]['Prod_Serv_Servico'] = $this->input->post('Prod_Serv_Servico' . $i);
				$data['servico'][$j]['NomeServico'] = $this->input->post('NomeServico' . $i);
				$data['servico'][$j]['ComissaoServico'] = $this->input->post('ComissaoServico' . $i);
                $data['servico'][$j]['ValorServico'] = $this->input->post('ValorServico' . $i);
                $data['servico'][$j]['QtdServico'] = $this->input->post('QtdServico' . $i);
				$data['servico'][$j]['QtdIncrementoServico'] = $this->input->post('QtdIncrementoServico' . $i);
                $data['servico'][$j]['SubtotalServico'] = $this->input->post('SubtotalServico' . $i);
                $data['servico'][$j]['ObsServico'] = $this->input->post('ObsServico' . $i);
				$data['servico'][$j]['DataValidadeServico'] = $this->input->post('DataValidadeServico' . $i);
                $data['servico'][$j]['ConcluidoServico'] = $this->input->post('ConcluidoServico' . $i);
				$data['servico'][$j]['ProfissionalServico'] = $this->input->post('ProfissionalServico' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('idTab_Produto' . $i) || $this->input->post('ValorProduto' . $i) ||
					$this->input->post('QtdProduto' . $i) || $this->input->post('QtdIncrementoProduto' . $i) || $this->input->post('SubtotalProduto' . $i) ||
					$this->input->post('ObsProduto' . $i) || $this->input->post('DataValidadeProduto' . $i)|| 
					$this->input->post('Aux_App_Produto_2' . $i) || $this->input->post('Aux_App_Produto_3' . $i) || 
					$this->input->post('Aux_App_Produto_4' . $i) ||$this->input->post('Aux_App_Produto_1' . $i)	||				
					$this->input->post('idSis_Usuario' . $i) || $this->input->post('ConcluidoProduto' . $i) || 
					$this->input->post('DevolvidoProduto' . $i) || $this->input->post('StatusComissao' . $i)  || 
					$this->input->post('Aux_App_Produto_5' . $i) || $this->input->post('HoraValidadeProduto' . $i)) {
                $data['produto'][$j]['idApp_Produto'] = $this->input->post('idApp_Produto' . $i);
                $data['produto'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
                $data['produto'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $data['produto'][$j]['QtdProduto'] = $this->input->post('QtdProduto' . $i);
				$data['produto'][$j]['QtdIncrementoProduto'] = $this->input->post('QtdIncrementoProduto' . $i);
                $data['produto'][$j]['SubtotalProduto'] = $this->input->post('SubtotalProduto' . $i);
				$data['produto'][$j]['SubtotalComissaoProduto'] = $this->input->post('SubtotalComissaoProduto' . $i);
				$data['produto'][$j]['SubtotalQtdProduto'] = $this->input->post('SubtotalQtdProduto' . $i);
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
				$data['produto'][$j]['StatusComissao'] = $this->input->post('StatusComissao' . $i);
				$data['produto'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);
				$data['produto'][$j]['ProfissionalProduto'] = $this->input->post('ProfissionalProduto' . $i);
				$j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);

            #### App_Servico ####
            $data['servico'] = $this->Orcatrata_model->get_alterarservicorec($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);

                if (isset($data['servico'])) {

                    for($j=1;$j<=$data['count']['SCount'];$j++) {
                        $data['servico'][$j]['SubtotalServico'] = number_format(($data['servico'][$j]['ValorServico'] * $data['servico'][$j]['QtdServico']), 2, ',', '.');
						$data['servico'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['servico'][$j]['DataValidadeServico'], 'barras');
					}
                }
            }

            #### App_Produto ####
            $data['produto'] = $this->Orcatrata_model->get_alterarprodutorec($id);

            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);

                if (isset($data['produto'])) {

                    for($j=1;$j<=$data['count']['PCount'];$j++) {
						$data['produto'][$j]['SubtotalProduto'] = number_format(($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto']), 2, ',', '.');
						$data['produto'][$j]['SubtotalComissaoProduto'] = ($data['produto'][$j]['ValorProduto'] * $data['produto'][$j]['QtdProduto'] * $data['produto'][$j]['ComissaoProduto'] /100);
						$data['produto'][$j]['SubtotalQtdProduto'] = ($data['produto'][$j]['QtdIncrementoProduto'] * $data['produto'][$j]['QtdProduto']);
						$data['produto'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['produto'][$j]['DataValidadeProduto'], 'barras');
					}

                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoServico'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['DevolvidoProduto'] = $this->Basico_model->select_status_sn();
		$data['select']['StatusComissao'] = $this->Basico_model->select_status_sn();
        $data['select']['Quitado'] = $this->Basico_model->select_status_sn();
		$data['select']['Produto'] = $this->Basico_model->select_produtos();
		$data['select']['Servico'] = $this->Basico_model->select_produtos();
		$data['select']['Entregues'] = $this->Basico_model->select_status_sn();
		$data['select']['Devolvidos'] = $this->Basico_model->select_status_sn();
		$data['select']['QuitadoParcelas'] = $this->Basico_model->select_status_sn();
		$data['select']['Dia'] = $this->Basico_model->select_dia();
		$data['select']['Mesvenc'] = $this->Basico_model->select_mes();
		$data['select']['Orcarec'] = $this->Basico_model->select_orcarec();
		$data['select']['NomeCliente'] = $this->Basico_model->select_cliente();		
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		
        $data['titulo'] = 'Comissao';
        $data['form_open_path'] = 'orcatrata/alterarstatuscomissao';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'info';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['SCount'] > 0 || $data['count']['PCount'] > 0)
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';
		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarstatuscomissao', $data);
        } else {

            $data['bd']['Dia'] = $data['query']['Dia'];
			$data['bd']['Mesvenc'] = $data['query']['Mesvenc'];
			$data['bd']['Ano'] = $data['query']['Ano'];
			$data['bd']['Orcarec'] = $data['query']['Orcarec'];
			$data['bd']['QuitadoParcelas'] = $data['query']['QuitadoParcelas'];
			$data['bd']['Entregues'] = $data['query']['Entregues'];
			$data['bd']['Devolvidos'] = $data['query']['Devolvidos'];
			$data['bd']['Cadastrar'] = $data['query']['Cadastrar'];

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');


            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);

            #### App_Servico ####
            $data['update']['servico']['anterior'] = $this->Orcatrata_model->get_alterarservicorec($data['orcatrata']['idSis_Empresa']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idApp_Servico');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {

                    $data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];					
					$data['update']['servico']['inserir'][$j]['idTab_TipoRD'] = "2";
					$data['update']['servico']['inserir'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['inserir'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['inserir'][$j]['ValorServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['inserir'][$j]['ValorServico']));
                    unset($data['update']['servico']['inserir'][$j]['SubtotalServico']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['servico']['inserir'][$j]['ConcluidoServico'] = 'S';
						}
					}
					else {$data['update']['servico']['inserir'][$j]['ConcluidoServico'] = 'N';
					}
				}

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['servico']['alterar'][$j]['idTab_Valor_Servico'] = $data['update']['servico']['alterar'][$j]['idTab_Valor_Servico'];
					$data['update']['servico']['alterar'][$j]['idTab_Produtos_Servico'] = $data['update']['servico']['alterar'][$j]['idTab_Produtos_Servico'];
					$data['update']['servico']['alterar'][$j]['DataValidadeServico'] = $this->basico->mascara_data($data['update']['servico']['alterar'][$j]['DataValidadeServico'], 'mysql');
					$data['update']['servico']['alterar'][$j]['ValorServico'] = str_replace(',', '.', str_replace('.', '', $data['update']['servico']['alterar'][$j]['ValorServico']));
                    unset($data['update']['servico']['alterar'][$j]['SubtotalServico']);
					if ($data['orcatrata']['AprovadoOrca'] == 'S') { 
						if ($data['orcatrata']['ConcluidoOrca'] == 'S') { $data['update']['servico']['alterar'][$j]['ConcluidoServico'] = 'S';
						}
					}
					else {$data['update']['servico']['alterar'][$j]['ConcluidoServico'] = 'N';
					}
                }

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Orcatrata_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] = $this->Orcatrata_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Orcatrata_model->delete_servico($data['update']['servico']['excluir']);
            }

            #### App_Produto ####
            $data['update']['produto']['anterior'] = $this->Orcatrata_model->get_alterarprodutorec($data['orcatrata']['idSis_Empresa']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idApp_Produto');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['produto']['inserir'][$j]['idTab_TipoRD'] = "2";
					$data['update']['produto']['inserir'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['inserir'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['ValorProduto']));
					$data['update']['produto']['inserir'][$j]['ComissaoProduto'] = $data['update']['produto']['inserir'][$j]['ComissaoProduto'];
                    unset($data['update']['produto']['inserir'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['inserir'][$j]['SubtotalQtdProduto']);
					if ($data['orcatrata']['ConcluidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['ConcluidoProduto'] = $data['update']['produto']['inserir'][$j]['ConcluidoProduto'];
					}
					if ($data['orcatrata']['DevolvidoOrca'] == 'S') { 
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = 'S';
					} else {
						$data['update']['produto']['inserir'][$j]['DevolvidoProduto'] = $data['update']['produto']['inserir'][$j]['DevolvidoProduto'];
					}
				
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Valor_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'] = $data['update']['produto']['alterar'][$j]['idTab_Produtos_Produto'];
					$data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'] = $data['update']['produto']['alterar'][$j]['Prod_Serv_Produto'];
					$data['update']['produto']['alterar'][$j]['DataValidadeProduto'] = $this->basico->mascara_data($data['update']['produto']['alterar'][$j]['DataValidadeProduto'], 'mysql');
					$data['update']['produto']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['ValorProduto']));
					$data['update']['produto']['alterar'][$j]['ComissaoProduto'] = $data['update']['produto']['alterar'][$j]['ComissaoProduto'];
                    unset($data['update']['produto']['alterar'][$j]['SubtotalProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalComissaoProduto']);
					unset($data['update']['produto']['alterar'][$j]['SubtotalQtdProduto']);
					if ($data['query']['Entregues'] == 'S') $data['update']['produto']['alterar'][$j]['ConcluidoProduto'] = 'S';
					if ($data['query']['Devolvidos'] == 'S') $data['update']['produto']['alterar'][$j]['DevolvidoServico'] = 'S';
                }

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Orcatrata_model->set_produto($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Orcatrata_model->update_produto($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Orcatrata_model->delete_produto($data['update']['produto']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idApp_OrcaTrata'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarstatuscomissao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_OrcaTrata'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_OrcaTrata', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'relatorio/financeiro/' . $data['msg']);
				#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtosvend/' . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarprocedimento($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
		
		$data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',
        ), TRUE));

        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) ||	$this->input->post('Prioridade' . $i) ||	$this->input->post('Statustarefa' . $i) || $this->input->post('DataProcedimentoLimite' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('Categoria' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['DataProcedimentoLimite'] = $this->input->post('DataProcedimentoLimite' . $i);
				$data['procedimento'][$j]['Prioridade'] = $this->input->post('Prioridade' . $i);
				$data['procedimento'][$j]['Statustarefa'] = $this->input->post('Statustarefa' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['Categoria'] = $this->input->post('Categoria' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;


        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
			#### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);



            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrata_model->get_alterarprocedimento($id);
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

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['Procedimento'] = $this->Basico_model->select_procedimento();
		$data['select']['Categoria'] = $this->Basico_model->select_categoriatarefa();		
		$data['select']['Prioridade'] = array (
			'1' => 'Alta',
			'2' => 'Media',
			'3' => 'Baixa',
        );
		$data['select']['Statustarefa'] = array (
			'1' => 'Fazer',
			'2' => 'Fazendo',
			'3' => 'Feito',
        );		

        $data['titulo'] = 'Tarefas';
        $data['form_open_path'] = 'orcatrata/alterarprocedimento';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['PMCount'] > 0 )
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';
		
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
			
        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarprocedimento', $data);
        } else {

			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####

			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);

            #### App_Procedimento ####
            $data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_alterarprocedimento($data['orcatrata']['idSis_Empresa']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    #$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    #$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					#$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    #$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
                    #$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];
					$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'], 'mysql');
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'], 'mysql');
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarprocedimento', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/alterarprocedimento/' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarprocedimentocli($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',


        ), TRUE));


        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');




        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataProcedimentoLimite' . $i) ||
                    $this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i)) {
                $data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);
                $data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
				$data['procedimento'][$j]['DataProcedimentoLimite'] = $this->input->post('DataProcedimentoLimite' . $i);
                #$data['procedimento'][$j]['Profissional'] = $this->input->post('Profissional' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;


        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);



            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrata_model->get_alterarprocedimentocli($id);
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

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['idApp_Cliente'] = $this->Cliente_model->select_cliente();

        $data['titulo'] = 'Clientes';
        $data['form_open_path'] = 'orcatrata/alterarprocedimentocli';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['PMCount'] > 0 )
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';
		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarprocedimentocli', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####
			
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);
			
            #### App_Procedimento ####
            $data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_alterarprocedimentocli($data['orcatrata']['idSis_Empresa']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    #$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
                    #$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];
					$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimentoLimite'], 'mysql');
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimentoLimite'], 'mysql');
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarprocedimentocli', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/alterarprocedimento/' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarmensagemenv($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',


        ), TRUE));


        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');



        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataProcedimentoCli' . $i) ||
                    
					$this->input->post('idSis_Usuario' . $i) || 
					$this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i) ||
					$this->input->post('ProcedimentoCli' . $i) || $this->input->post('ConcluidoProcedimentoCli' . $i)) {
                $data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);

				$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);

				$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
				$data['procedimento'][$j]['DataProcedimentoCli'] = $this->input->post('DataProcedimentoCli' . $i);
                $data['procedimento'][$j]['ProcedimentoCli'] = $this->input->post('ProcedimentoCli' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimentoCli'] = $this->input->post('ConcluidoProcedimentoCli' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;


        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrata_model->get_alterarmensagemenv($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++) {
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
						$data['procedimento'][$j]['DataProcedimentoCli'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimentoCli'], 'barras');
						$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProcedimentoCli'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_UsuarioCli'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa4();
		$data['select']['idSis_EmpresaCli'] = $this->Basico_model->select_empresa4();

        $data['titulo'] = 'Mensagens Enviadas';
        $data['form_open_path'] = 'orcatrata/alterarmensagemenv';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['PMCount'] > 0 )
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';
		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarmensagemenv', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####
			
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);
			
            #### App_Procedimento ####
            $data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_alterarmensagemenv($data['orcatrata']['idSis_Empresa']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    #$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
                    #$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];
					$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['inserir'][$j]['DataProcedimentoCli'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimentoCli'], 'mysql');
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['alterar'][$j]['DataProcedimentoCli'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimentoCli'], 'mysql');
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarmensagemenv', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/alterarprocedimento/' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterarmensagemrec($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['orcatrata'] = quotes_to_entities($this->input->post(array(
            #### Sis_Empresa ####
            'idSis_Empresa',


        ), TRUE));


        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');



        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('DataProcedimento' . $i) || $this->input->post('DataProcedimentoCli' . $i) ||
                    
					$this->input->post('idSis_Usuario' . $i) || 
					$this->input->post('Procedimento' . $i) || $this->input->post('ConcluidoProcedimento' . $i) ||
					$this->input->post('ProcedimentoCli' . $i) || $this->input->post('ConcluidoProcedimentoCli' . $i)) {
                $data['procedimento'][$j]['idApp_Procedimento'] = $this->input->post('idApp_Procedimento' . $i);

				$data['procedimento'][$j]['idSis_Usuario'] = $this->input->post('idSis_Usuario' . $i);

				$data['procedimento'][$j]['DataProcedimento'] = $this->input->post('DataProcedimento' . $i);
                $data['procedimento'][$j]['Procedimento'] = $this->input->post('Procedimento' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimento'] = $this->input->post('ConcluidoProcedimento' . $i);
				$data['procedimento'][$j]['DataProcedimentoCli'] = $this->input->post('DataProcedimentoCli' . $i);
                $data['procedimento'][$j]['ProcedimentoCli'] = $this->input->post('ProcedimentoCli' . $i);
				$data['procedimento'][$j]['ConcluidoProcedimentoCli'] = $this->input->post('ConcluidoProcedimentoCli' . $i);

                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;


        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Sis_Empresa ####
            $data['orcatrata'] = $this->Orcatrata_model->get_orcatrataalterar($id);


            #### App_Procedimento ####
            $data['procedimento'] = $this->Orcatrata_model->get_alterarmensagemrec($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);

                if (isset($data['procedimento'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++) {
                        $data['procedimento'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimento'], 'barras');
						$data['procedimento'][$j]['DataProcedimentoCli'] = $this->basico->mascara_data($data['procedimento'][$j]['DataProcedimentoCli'], 'barras');
						$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					}
                }
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Sis_Empresa ####
        $this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'trim');

        $data['select']['ConcluidoProcedimento'] = $this->Basico_model->select_status_sn();
		$data['select']['ConcluidoProcedimentoCli'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Usuario'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_UsuarioCli'] = $this->Usuario_model->select_usuario();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresa4();
		$data['select']['idSis_EmpresaCli'] = $this->Basico_model->select_empresa4();

        $data['titulo'] = 'Mensagens Recebidas';
        $data['form_open_path'] = 'orcatrata/alterarmensagemrec';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

		$data['collapse'] = '';	
		$data['collapse1'] = 'class="collapse"';		
		
        //if ($data['orcatrata']['ValorOrca'] || $data['orcatrata']['ValorEntradaOrca'] || $data['orcatrata']['ValorRestanteOrca'])
        if ($data['count']['PMCount'] > 0 )
            $data['orcamentoin'] = 'in';
        else
            $data['orcamentoin'] = '';

        if ($data['count']['PMCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';
		

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';


        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
        */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('orcatrata/form_alterarmensagemrec', $data);
        } else {

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Sis_Empresa ####
			
			$data['orcatrata']['DataOrca'] = $this->basico->mascara_data($data['orcatrata']['DataOrca'], 'mysql');

            $data['update']['orcatrata']['anterior'] = $this->Orcatrata_model->get_orcatrataalterar($data['orcatrata']['idSis_Empresa']);
            $data['update']['orcatrata']['campos'] = array_keys($data['orcatrata']);
            $data['update']['orcatrata']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['orcatrata']['anterior'],
                $data['orcatrata'],
                $data['update']['orcatrata']['campos'],
                $data['orcatrata']['idSis_Empresa'], TRUE);
            $data['update']['orcatrata']['bd'] = $this->Orcatrata_model->update_orcatrataalterar($data['orcatrata'], $data['orcatrata']['idSis_Empresa']);
			
            #### App_Procedimento ####
            $data['update']['procedimento']['anterior'] = $this->Orcatrata_model->get_alterarmensagemrec($data['orcatrata']['idSis_Empresa']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idApp_Procedimento');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    #$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $data['orcatrata']['idSis_Empresa'];
                    #$data['update']['procedimento']['inserir'][$j]['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];
					$data['update']['procedimento']['inserir'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['inserir'][$j]['DataProcedimentoCli'] = $this->basico->mascara_data($data['update']['procedimento']['inserir'][$j]['DataProcedimentoCli'], 'mysql');
                }

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['procedimento']['alterar'][$j]['DataProcedimento'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimento'], 'mysql');
					$data['update']['procedimento']['alterar'][$j]['DataProcedimentoCli'] = $this->basico->mascara_data($data['update']['procedimento']['alterar'][$j]['DataProcedimentoCli'], 'mysql');
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idSis_Empresa'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['orcatrata']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('orcatrata/form_alterarmensagemrec', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idSis_Empresa'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Sis_Empresa', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Cliente']['idApp_Cliente'] . $data['msg']);
				#redirect(base_url() . 'relatorio/alterarprocedimento/' . $data['msg']);
				redirect(base_url() . 'agenda' . $data['msg']);

				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

		$this->load->model('Cliente_model');
		
		if ($id) {
            $data['cliente']['idApp_Cliente'] = $id;
			$_SESSION['Cliente'] = $data['cliente'] = $this->Cliente_model->get_cliente($id, TRUE);
			$data['resumo'] = $this->Cliente_model->get_cliente($id);
			$_SESSION['Cliente']['NomeCompleto'] = $data['resumo']['NomeCliente'];
			$_SESSION['Cliente']['NomeCliente'] = (strlen($data['resumo']['NomeCliente']) > 12) ? substr($data['resumo']['NomeCliente'], 0, 12) : $data['resumo']['NomeCliente'];
		}
		
        $data['combinado'] = $this->Orcatrata_model->list_orcamentocomb($id, 'S', TRUE);
        $data['naocombinado'] = $this->Orcatrata_model->list_orcamentocomb($id, 'N', TRUE);
        $data['aprovado'] = $this->Orcatrata_model->list_orcamento($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Orcatrata_model->list_orcamento($id, 'N', TRUE);
        $data['finalizado'] = $this->Orcatrata_model->list_orcamentofinal($id, 'S', TRUE);
        $data['naofinalizado'] = $this->Orcatrata_model->list_orcamentofinal($id, 'N', TRUE);
        $data['cancelado'] = $this->Orcatrata_model->list_orcamentocancel($id, 'S', TRUE);
        $data['naocancelado'] = $this->Orcatrata_model->list_orcamentocancel($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('orcatrata/list_orcatrata', $data, TRUE);
        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('orcatrata/list_orcatrata', $data);

        $this->load->view('basico/footer');
    }

}
