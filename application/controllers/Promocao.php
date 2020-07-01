<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Promocao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Promocao_model', 'Prodaux1_model', 'Prodaux2_model', 'Prodaux3_model', 'Prodaux4_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
        $this->load->driver('session');

        
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        
    }

    public function index() {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('promocao/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			#'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
            'Promocao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {

                $data['item_promocao'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Promocao.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        $data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'promocao/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Fornecedor'])
        if (isset($data['item_promocao']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
		
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"'; 

 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';			
		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));			
			//$data['promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProduto']));
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['item_promocao'])) {
                $max = count($data['item_promocao']);
                for($j=1;$j<=$max;$j++) {
                    $data['item_promocao'][$j]['Convdesc'] = trim(mb_strtoupper($data['item_promocao'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['item_promocao'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['item_promocao'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['item_promocao'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['item_promocao'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao'][$j]['ValorProduto']));
                    $data['item_promocao'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];					

                }
                $data['item_promocao']['idTab_Valor'] = $this->Promocao_model->set_item_promocao($data['item_promocao']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
			#'ValorProduto',
            'Promocao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Ativo',
			'VendaSite',			
			#'Aprovado',
        ), TRUE));


		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;
		

        $data['item_promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Valor ####
            #'idTab_Promocao',           
			'ValorProduto',

        ), TRUE));
		
            if ($this->input->post('ValorProduto')) {

                $data['item_promocao']['ValorProduto'] = $this->input->post('ValorProduto');

            }



        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Promocao.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();			
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        $data['select']['Desconto'] = $this->Basica_model->select_desconto();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux33'] = $this->Promocao_model->select_prodaux33();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'promocao/cadastrar1';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Fornecedor'])
        if (isset($data['item_promocao']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #$data['q'] = $this->Promocao_model->lista_promocao(TRUE);
        #$data['list'] = $this->load->view('promocao/list_promocao', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao1', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));			
			#$data['promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProduto']));
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['item_promocao'])) { {
					$data['item_promocao']['Convdesc'] = trim(mb_strtoupper($data['item_promocao']['Convdesc'], 'ISO-8859-1'));
                    $data['item_promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['item_promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['item_promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['item_promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao']['ValorProduto']));
                    $data['item_promocao']['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];					

                }
                $data['item_promocao']['idTab_Valor'] = $this->Promocao_model->set_item_promocao1($data['item_promocao']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao1', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        else if ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
			'ValorProduto',
            'Promocao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',			
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {

                $data['item_promocao'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Promocao.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();			
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        $data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux33'] = $this->Promocao_model->select_prodaux33();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'promocao/cadastrar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Fornecedor'])
        if (isset($data['item_promocao']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';  
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('promocao/form_promocao2', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));			
			//$data['promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProduto']));
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['item_promocao'])) {
                $max = count($data['item_promocao']);
                for($j=1;$j<=$max;$j++) {
                    $data['item_promocao'][$j]['Convdesc'] = trim(mb_strtoupper($data['item_promocao'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['item_promocao'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['item_promocao'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['item_promocao'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['item_promocao'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao'][$j]['ValorProduto']));
                    $data['item_promocao'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];					

                }
                $data['item_promocao']['idTab_Valor'] = $this->Promocao_model->set_item_promocao($data['item_promocao']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao2/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
			#'ValorProduto',
            'Promocao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			#'Aprovado',
        ), TRUE));


		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;
		

        $data['item_promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Valor ####
            #'idTab_Promocao',           
			'ValorProduto',

        ), TRUE));
		
            if ($this->input->post('ValorProduto')) {

                $data['item_promocao']['ValorProduto'] = $this->input->post('ValorProduto');

            }



        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Promocao.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        $data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux33'] = $this->Promocao_model->select_prodaux33();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'promocao/cadastrar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Fornecedor'])
        if (isset($data['item_promocao']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #$data['q'] = $this->Promocao_model->lista_promocao(TRUE);
        #$data['list'] = $this->load->view('promocao/list_promocao2', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao3', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));
			#$data['promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProduto']));
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['item_promocao'])) { {
					$data['item_promocao']['Convdesc'] = trim(mb_strtoupper($data['item_promocao']['Convdesc'], 'ISO-8859-1'));
                    $data['item_promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['item_promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['item_promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['item_promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['item_promocao']['ValorProduto']));
                    $data['item_promocao']['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];					

                }
                $data['item_promocao']['idTab_Valor'] = $this->Promocao_model->set_item_promocao1($data['item_promocao']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao3', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao2/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar4() {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			#'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
            'Promocao',
			'Descricao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',			
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		
		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Promoção', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim');
		#$this->form_validation->set_rules('Descricao', 'Descricão', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Promocao.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        #$data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux34();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Cor_Prod'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux1();		
		//$data['select']['idTab_Produto'] = $this->Basico_model->select_produtos();
		//$data['select']['Promocao'] = $this->Relatorio_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'promocao/cadastrar4';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Desconto'])
        if (isset($data['item_promocao']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';		
		
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"'; 

 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';			
		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            //if (1 == 1) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			#$data['promocao']['Desconto'] = 2;
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));			
			//$data['promocao']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProduto']));
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
				#redirect(base_url() . 'agenda' . $data['msg']);
                redirect(base_url() . 'promocao/alterar/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');
    }
		
    public function alterar($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Promocao',
			'Descricao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			'Cat_1',
			'Cat_2',
			'Cat_3',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');		
		
		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;



        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Promocao ####
            $data['promocao'] = $this->Promocao_model->get_promocao($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['promocao']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];



        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Título', 'required|trim');
 		#$this->form_validation->set_rules('Descricao', 'Descricão', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		#$data['select']['Desconto'] = $this->Basico_model->select_desconto();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux34();
		#$data['select']['Cat_1'] = $this->Prodaux3_model->select_prodaux3pr();
		#$data['select']['Cat_2'] = $this->Prodaux3_model->select_prodaux3pr();
		#$data['select']['Cat_3'] = $this->Prodaux3_model->select_prodaux3pr();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();

		$data['select']['Cat_1'] = $this->Basico_model->select_catprod();
		$data['select']['Cat_2'] = $this->Basico_model->select_catprod();
		$data['select']['Cat_3'] = $this->Basico_model->select_catprod();		
		
		$data['select']['idTab_Produto'] = $this->Basico_model->select_produto2();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'promocao/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['item_promocao']) && ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';       
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			#$data['promocao']['Desconto'] = 2;
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Promocao'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				#redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
                redirect(base_url() . 'promocao/alterar3/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
				exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterar3($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Promocao',
			'Descricao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			'Cat_1',
			'Mod_1',
			'Cat_2',
			'Mod_2',
			'Cat_3',
			'Mod_3',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');		
		
		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;



        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Promocao ####
            $_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['promocao']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];



        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Título', 'required|trim');
 		#$this->form_validation->set_rules('Descricao', 'Descricão', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		#$data['select']['Desconto'] = $this->Basico_model->select_desconto();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		#$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		#$data['select']['Cat_1'] = $this->Prodaux3_model->select_prodaux3pr();
		#$data['select']['Cat_2'] = $this->Prodaux3_model->select_prodaux3pr();
		#$data['select']['Cat_3'] = $this->Prodaux3_model->select_prodaux3pr();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		
		$data['select']['Cat_1'] = $this->Basico_model->select_catprod();
		$data['select']['Cat_2'] = $this->Basico_model->select_catprod();
		$data['select']['Cat_3'] = $this->Basico_model->select_catprod();		
		$data['select']['Mod_1'] = $this->Basico_model->select_mod_1($data['promocao']['Cat_1']);
		$data['select']['Mod_2'] = $this->Basico_model->select_mod_2($data['promocao']['Cat_2']);
		$data['select']['Mod_3'] = $this->Basico_model->select_mod_3($data['promocao']['Cat_3']);
		$data['select']['idTab_Produto'] = $this->Basico_model->select_produto2();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'promocao/alterar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 3;

        //if (isset($data['item_promocao']) && ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';       
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			#$data['promocao']['Desconto'] = 2;
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);


/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Promocao'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				#redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
				redirect(base_url() . 'promocao/alterar4/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterar4($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Promocao',
			'Descricao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			'Cat_1',
			'Mod_1',
			'Cat_2',
			'Mod_2',
			'Cat_3',
			'Mod_3',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('PT2Count')) ? $data['count']['PT2Count'] = 0 : $data['count']['PT2Count'] = $this->input->post('PT2Count');
		(!$this->input->post('PT3Count')) ? $data['count']['PT3Count'] = 0 : $data['count']['PT3Count'] = $this->input->post('PT3Count');
		(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');		
		
		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('QtdProdutoDesconto' . $i) || $this->input->post('ValorProduto' . $i)) {
				$data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['item_promocao'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['item_promocao'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
				$data['item_promocao'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PT2Count']; $i++) {

            if ($this->input->post('QtdProdutoDesconto2' . $i) || $this->input->post('ValorProduto2' . $i)) {
				$data['item_promocao2'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor2' . $i);
                $data['item_promocao2'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto2' . $i);
				$data['item_promocao2'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento2' . $i);
				$data['item_promocao2'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos2' . $i);
				$data['item_promocao2'][$j]['ValorProduto'] = $this->input->post('ValorProduto2' . $i);
                $j++;
            }
						
        }
        $data['count']['PT2Count'] = $j - 1;		

        $j = 1;
        for ($i = 1; $i <= $data['count']['PT3Count']; $i++) {

            if ($this->input->post('QtdProdutoDesconto3' . $i) || $this->input->post('ValorProduto3' . $i)) {
				$data['item_promocao3'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor3' . $i);
                $data['item_promocao3'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto3' . $i);
				$data['item_promocao3'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento3' . $i);
				$data['item_promocao3'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos3' . $i);
				$data['item_promocao3'][$j]['ValorProduto'] = $this->input->post('ValorProduto3' . $i);
                $j++;
            }
						
        }
        $data['count']['PT3Count'] = $j - 1;		
		
		
        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Promocao ####
            $_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['promocao']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];
			
            #### Tab_Valor ####
            $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id, "1");
            if (count($data['item_promocao']) > 0) {
                $data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
                $data['count']['PTCount'] = count($data['item_promocao']);
				/*
                if (isset($data['item_promocao'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Valor2 ####
            $data['item_promocao2'] = $this->Promocao_model->get_item_promocao($id, "2");
            if (count($data['item_promocao2']) > 0) {
                $data['item_promocao2'] = array_combine(range(1, count($data['item_promocao2'])), array_values($data['item_promocao2']));
                $data['count']['PT2Count'] = count($data['item_promocao2']);
				/*
                if (isset($data['item_promocao2'])) {

                    for($j=1; $j <= $data['count']['PT2Count']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Valor3 ####
            $data['item_promocao3'] = $this->Promocao_model->get_item_promocao($id, "3");
            if (count($data['item_promocao3']) > 0) {
                $data['item_promocao3'] = array_combine(range(1, count($data['item_promocao3'])), array_values($data['item_promocao3']));
                $data['count']['PT3Count'] = count($data['item_promocao3']);
				/*
                if (isset($data['item_promocao3'])) {

                    for($j=1; $j <= $data['count']['PT3Count']; $j++)
						
                }
				*/				
            }			

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Título', 'required|trim');
 		#$this->form_validation->set_rules('Descricao', 'Descricão', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		#$data['select']['Desconto'] = $this->Basico_model->select_desconto();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux34();
		#$data['select']['Cat_1'] = $this->Prodaux3_model->select_prodaux3pr();
		#$data['select']['Cat_2'] = $this->Prodaux3_model->select_prodaux3pr();
		#$data['select']['Cat_3'] = $this->Prodaux3_model->select_prodaux3pr();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		
		$data['select']['Cat_1'] = $this->Basico_model->select_catprod();
		$data['select']['Cat_2'] = $this->Basico_model->select_catprod();
		$data['select']['Cat_3'] = $this->Basico_model->select_catprod();		
		$data['select']['Mod_1'] = $this->Basico_model->select_mod_1($data['promocao']['Cat_1']);
		$data['select']['Mod_2'] = $this->Basico_model->select_mod_2($data['promocao']['Cat_2']);
		$data['select']['Mod_3'] = $this->Basico_model->select_mod_3($data['promocao']['Cat_3']);
		$data['select']['idTab_Produto'] = $this->Basico_model->select_produto2();
		#$data['select']['idTab_Produtos'] = $this->Basico_model->select_prod_der0();
		$data['select']['idTab_Produtos'] = $this->Basico_model->select_prod_der();
		$data['select']['idTab_Produtos2'] = $this->Basico_model->select_prod_der2();
		$data['select']['idTab_Produtos3'] = $this->Basico_model->select_prod_der3();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'promocao/alterar4';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        //if (isset($data['item_promocao']) && ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0 || $data['count']['PT2Count'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';       
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			#$data['promocao']['Desconto'] = 2;
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);
			
            #### Tab_Valor ####
            $data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "1");
            if (isset($data['item_promocao']) || (!isset($data['item_promocao']) && isset($data['update']['item_promocao']['anterior']) ) ) {

                if (isset($data['item_promocao']))
                    $data['item_promocao'] = array_values($data['item_promocao']);
                else
                    $data['item_promocao'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['item_promocao'] = $this->basico->tratamento_array_multidimensional($data['item_promocao'], $data['update']['item_promocao']['anterior'], 'idTab_Valor');

                $max = count($data['update']['item_promocao']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao']['inserir'][$j]['Item_Promocao'] = "1";
					$data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
					$data['update']['item_promocao']['inserir'][$j]['Desconto'] = $data['promocao']['Desconto'];
					$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					$data['update']['item_promocao']['inserir'][$j]['Prodaux3'] = $data['promocao']['Cat_1'];
					$data['update']['item_promocao']['inserir'][$j]['idTab_Modelo'] = $data['promocao']['Mod_1'];
					$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
                }

                $max = count($data['update']['item_promocao']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao']['alterar'][$j]['Item_Promocao'] = "1";
					$data['update']['item_promocao']['alterar'][$j]['Desconto'] = $data['promocao']['Desconto'];
					$data['update']['item_promocao']['alterar'][$j]['Prodaux3'] = $data['promocao']['Cat_1'];
					$data['update']['item_promocao']['alterar'][$j]['idTab_Modelo'] = $data['promocao']['Mod_1'];
					$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
				}

                if (count($data['update']['item_promocao']['inserir']))
                    $data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

                if (count($data['update']['item_promocao']['alterar']))
                    $data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

                if (count($data['update']['item_promocao']['excluir']))
                    $data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

            }
			
            #### Tab_Valor2 ####
            $data['update']['item_promocao2']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "2");
            if (isset($data['item_promocao2']) || (!isset($data['item_promocao2']) && isset($data['update']['item_promocao2']['anterior']) ) ) {

                if (isset($data['item_promocao2']))
                    $data['item_promocao2'] = array_values($data['item_promocao2']);
                else
                    $data['item_promocao2'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['item_promocao2'] = $this->basico->tratamento_array_multidimensional($data['item_promocao2'], $data['update']['item_promocao2']['anterior'], 'idTab_Valor');

                $max2 = count($data['update']['item_promocao2']['inserir']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['inserir'][$j]['Item_Promocao'] = "2";
					$data['update']['item_promocao2']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
					$data['update']['item_promocao2']['inserir'][$j]['Desconto'] = $data['promocao']['Desconto'];
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					$data['update']['item_promocao2']['inserir'][$j]['Prodaux3'] = $data['promocao']['Cat_2'];
					$data['update']['item_promocao2']['inserir'][$j]['idTab_Modelo'] = $data['promocao']['Mod_2'];
					$data['update']['item_promocao2']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao2']['inserir'][$j]['ValorProduto']));
                }

                $max2 = count($data['update']['item_promocao2']['alterar']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['alterar'][$j]['Item_Promocao'] = "2";
					$data['update']['item_promocao2']['alterar'][$j]['Desconto'] = $data['promocao']['Desconto'];
					$data['update']['item_promocao2']['alterar'][$j]['Prodaux3'] = $data['promocao']['Cat_2'];
					$data['update']['item_promocao2']['alterar'][$j]['idTab_Modelo'] = $data['promocao']['Mod_2'];
					$data['update']['item_promocao2']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao2']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao2']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
				}

                if (count($data['update']['item_promocao2']['inserir']))
                    $data['update']['item_promocao2']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao2']['inserir']);

                if (count($data['update']['item_promocao2']['alterar']))
                    $data['update']['item_promocao2']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao2']['alterar']);

                if (count($data['update']['item_promocao2']['excluir']))
                    $data['update']['item_promocao2']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao2']['excluir']);

            }
			
            #### Tab_Valor3 ####
            $data['update']['item_promocao3']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "3");
            if (isset($data['item_promocao3']) || (!isset($data['item_promocao3']) && isset($data['update']['item_promocao3']['anterior']) ) ) {

                if (isset($data['item_promocao3']))
                    $data['item_promocao3'] = array_values($data['item_promocao3']);
                else
                    $data['item_promocao3'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['item_promocao3'] = $this->basico->tratamento_array_multidimensional($data['item_promocao3'], $data['update']['item_promocao3']['anterior'], 'idTab_Valor');

                $max = count($data['update']['item_promocao3']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['inserir'][$j]['Item_Promocao'] = "3";
					$data['update']['item_promocao3']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
					$data['update']['item_promocao3']['inserir'][$j]['Desconto'] = $data['promocao']['Desconto'];
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					$data['update']['item_promocao3']['inserir'][$j]['Prodaux3'] = $data['promocao']['Cat_3'];
					$data['update']['item_promocao3']['inserir'][$j]['idTab_Modelo'] = $data['promocao']['Mod_3'];
					$data['update']['item_promocao3']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao3']['inserir'][$j]['ValorProduto']));
                }

                $max = count($data['update']['item_promocao3']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['alterar'][$j]['Item_Promocao'] = "3";
					$data['update']['item_promocao3']['alterar'][$j]['Desconto'] = $data['promocao']['Desconto'];
					$data['update']['item_promocao3']['alterar'][$j]['Prodaux3'] = $data['promocao']['Cat_3'];
					$data['update']['item_promocao3']['alterar'][$j]['idTab_Modelo'] = $data['promocao']['Mod_3'];
					$data['update']['item_promocao3']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao3']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao3']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'ISO-8859-1'));
				}

                if (count($data['update']['item_promocao3']['inserir']))
                    $data['update']['item_promocao3']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao3']['inserir']);

                if (count($data['update']['item_promocao3']['alterar']))
                    $data['update']['item_promocao3']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao3']['alterar']);

                if (count($data['update']['item_promocao3']['excluir']))
                    $data['update']['item_promocao3']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao3']['excluir']);

            }			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Promocao'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
				redirect(base_url() . 'promocao/alterar4/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterar_BKP($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Promocao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		
		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
                $data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['item_promocao'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Promocao ####
            $data['promocao'] = $this->Promocao_model->get_promocao($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['promocao']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### Tab_Valor ####
            $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id);
            if (count($data['item_promocao']) > 0) {
                $data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
                $data['count']['PTCount'] = count($data['item_promocao']);
/*
                if (isset($data['item_promocao'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
*/				
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'promocao/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['item_promocao']) && ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Fornecedor']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';       
        
 		(!$data['promocao']['Ativo']) ? $data['promocao']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['promocao']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['promocao']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['promocao']['VendaSite']) ? $data['promocao']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['promocao']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['promocao']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);

            #### Tab_Valor ####
            $data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao']);
            if (isset($data['item_promocao']) || (!isset($data['item_promocao']) && isset($data['update']['item_promocao']['anterior']) ) ) {

                if (isset($data['item_promocao']))
                    $data['item_promocao'] = array_values($data['item_promocao']);
                else
                    $data['item_promocao'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['item_promocao'] = $this->basico->tratamento_array_multidimensional($data['item_promocao'], $data['update']['item_promocao']['anterior'], 'idTab_Valor');

                $max = count($data['update']['item_promocao']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['inserir'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
					
                }

                $max = count($data['update']['item_promocao']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['alterar'][$j]['Convdesc'], 'ISO-8859-1'));
				}

                if (count($data['update']['item_promocao']['inserir']))
                    $data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

                if (count($data['update']['item_promocao']['alterar']))
                    $data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

                if (count($data['update']['item_promocao']['excluir']))
                    $data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Promocao'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
		
    public function alterar_imagem($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'Desconto',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Promocao',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		
		(!$data['promocao']['TipoProduto']) ? $data['promocao']['TipoProduto'] = 'V' : FALSE;
		(!$data['promocao']['Categoria']) ? $data['promocao']['Categoria'] = 'P' : FALSE;
		(!$data['promocao']['UnidadeProduto']) ? $data['promocao']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
                $data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['item_promocao'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Promocao ####
            $data['promocao'] = $this->Promocao_model->get_promocao($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['promocao']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### Tab_Valor ####
            $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id);
            if (count($data['item_promocao']) > 0) {
                $data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
                $data['count']['PTCount'] = count($data['item_promocao']);
/*
                if (isset($data['item_promocao'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
*/				
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Promocao ####

		$this->form_validation->set_rules('Desconto', 'Tipo de Desconto', 'required|trim');
		#$this->form_validation->set_rules('Promocao', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Promocao.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();

        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'promocao/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['item_promocao']) && ($data['item_promocao'][0]['DataValor'] || $data['item_promocao'][0]['Fornecedor']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';       
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'ISO-8859-1'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['promocao']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['ValorProdutoSite']));
			$data['promocao']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['Comissao']));
			$data['promocao']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['promocao']['PesoProduto']));            
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);

            #### Tab_Valor ####
            $data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao']);
            if (isset($data['item_promocao']) || (!isset($data['item_promocao']) && isset($data['update']['item_promocao']['anterior']) ) ) {

                if (isset($data['item_promocao']))
                    $data['item_promocao'] = array_values($data['item_promocao']);
                else
                    $data['item_promocao'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['item_promocao'] = $this->basico->tratamento_array_multidimensional($data['item_promocao'], $data['update']['item_promocao']['anterior'], 'idTab_Valor');

                $max = count($data['update']['item_promocao']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['inserir'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
					
                }

                $max = count($data['update']['item_promocao']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['alterar'][$j]['Convdesc'], 'ISO-8859-1'));
				}

                if (count($data['update']['item_promocao']['inserir']))
                    $data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

                if (count($data['update']['item_promocao']['alterar']))
                    $data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

                if (count($data['update']['item_promocao']['excluir']))
                    $data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Promocao'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Promocao'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarlogo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idTab_Promocao',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Promocao',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Promocao'] = $data['query'] = $this->Promocao_model->get_promocao($id, TRUE);
        }
		
        if ($id)
            $data['file']['idTab_Promocao'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiapromocao($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'promocao/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('promocao/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('promocao/form_perfil', $data);
            }
            else {
			
				$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';		
				$foto = $data['file']['Arquivo'];
				$diretorio = $dir.$foto;					
				$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/';

				switch($_FILES['Arquivo']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
				
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefromjpeg($diretorio);

						$thumb = imagecreatetruecolor(200, 200);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;					

					case 'image/png':
					case 'image/x-png';
						
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefrompng($diretorio);

						$thumb = imagecreatetruecolor(200, 200);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 200, 200, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;
					
				endswitch;			

                $data['camposfile'] = array_keys($data['file']);
				$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
				$data['idSis_Arquivo'] = $this->Promocao_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('promocao/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Promocao_model->get_promocao($data['query']['idTab_Promocao']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Promocao'], TRUE);

					if ($data['auditoriaitem'] && $this->Promocao_model->update_promocao($data['query'], $data['query']['idTab_Promocao']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'promocao/form_perfil/' . $data['query']['idTab_Promocao'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Promocao']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Promocao']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/fotopromocao.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/' . $_SESSION['Promocao']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/fotopromocao.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/miniatura/' . $_SESSION['Promocao']['Arquivo'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Promocao', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function excluir($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        
                $this->Promocao_model->delete_promocao($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'promocao/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Promocao'] = $this->Promocao_model->get_cliente($id, TRUE);
        //$_SESSION['Promocao']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Promocao_model->list_promocao($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Promocao_model->list_promocao($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('promocao/list_promocao', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('promocao/tela_promocao', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Promocao'] = $this->Promocao_model->get_cliente($id, TRUE);
        #$_SESSION['Promocao']['idApp_Cliente'] = $id;
        $data['query'] = $this->Promocao_model->list_promocao(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('promocao/list_promocao', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('promocao/tela_promocao', $data);

        $this->load->view('basico/footer');
    }

}
