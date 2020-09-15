<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Produtos_model', 'Prodaux1_model', 'Prodaux2_model', 'Prodaux3_model', 'Prodaux4_model','Fornecedor_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
        $this->load->driver('session');

        
        $this->load->view('basico/header');
        $this->load->view('basico/nav_principal');

        
    }

    public function index() {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('produtos/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
			elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			#'Fornecedor',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {

                $data['valor'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

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
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor'])
        if (isset($data['valor']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
			
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"'; 

 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));			
			//$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
            $data['produtos']['idTab_Produto'] = $this->Produtos_model->set_produtos($data['produtos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['valor'])) {
                $max = count($data['valor']);
                for($j=1;$j<=$max;$j++) {
                    $data['valor'][$j]['Convdesc'] = trim(mb_strtoupper($data['valor'][$j]['Convdesc'], 'UTF-8'));
					$data['valor'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['valor'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['valor'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['valor'][$j]['ValorProduto']));
                    $data['valor'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];					

                }
                $data['valor']['idTab_Valor'] = $this->Produtos_model->set_valor($data['valor']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Produto'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar1() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
			#'ValorProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Ativo',
			'VendaSite',			
			#'Aprovado',
        ), TRUE));


		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;
		

        $data['valor'] = quotes_to_entities($this->input->post(array(
            #### Tab_Valor ####
            #'idTab_Produto',           
			'ValorProduto',

        ), TRUE));
		
            if ($this->input->post('ValorProduto')) {

                $data['valor']['ValorProduto'] = $this->input->post('ValorProduto');

            }



        //Fim do trecho de c�digo que d� pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();			
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        #$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux33'] = $this->Produtos_model->select_prodaux33();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos/cadastrar1';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor'])
        if (isset($data['valor']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #$data['q'] = $this->Produtos_model->lista_produtos(TRUE);
        #$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtos/form_produtos1', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));			
			#$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
            $data['produtos']['idTab_Produto'] = $this->Produtos_model->set_produtos($data['produtos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['valor'])) { {
					$data['valor']['Convdesc'] = trim(mb_strtoupper($data['valor']['Convdesc'], 'UTF-8'));
                    $data['valor']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['valor']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['valor']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['valor']['ValorProduto']));
                    $data['valor']['idTab_Produto'] = $data['produtos']['idTab_Produto'];					

                }
                $data['valor']['idTab_Valor'] = $this->Produtos_model->set_valor1($data['valor']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Produto'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos1', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function cadastrar2() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        else if ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
			'ValorProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',			
			#'Aprovado',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');

		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {

                $data['valor'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();			
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        #$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux33'] = $this->Produtos_model->select_prodaux33();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos/cadastrar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor'])
        if (isset($data['valor']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos2', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));			
			//$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
            $data['produtos']['idTab_Produto'] = $this->Produtos_model->set_produtos($data['produtos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['valor'])) {
                $max = count($data['valor']);
                for($j=1;$j<=$max;$j++) {
                    $data['valor'][$j]['Convdesc'] = trim(mb_strtoupper($data['valor'][$j]['Convdesc'], 'UTF-8'));
					$data['valor'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['valor'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['valor'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['valor'][$j]['ValorProduto']));
                    $data['valor'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];					

                }
                $data['valor']['idTab_Valor'] = $this->Produtos_model->set_valor($data['valor']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Produto'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos2/' . $data['msg']);
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
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
			#'ValorProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			#'Aprovado',
        ), TRUE));


		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;
		

        $data['valor'] = quotes_to_entities($this->input->post(array(
            #### Tab_Valor ####
            #'idTab_Produto',           
			'ValorProduto',

        ), TRUE));
		
            if ($this->input->post('ValorProduto')) {

                $data['valor']['ValorProduto'] = $this->input->post('ValorProduto');

            }



        //Fim do trecho de c�digo que d� pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['Fornecedor'] = $this->Fornecedor_model->select_fornecedor();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
        #$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux33'] = $this->Produtos_model->select_prodaux33();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos/cadastrar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor'])
        if (isset($data['valor']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
            $data['div']['VendaSite'] = '' : $data['div']['VendaSite'] = 'style="display: none;"';		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          exit ();
          */

        #$data['q'] = $this->Produtos_model->lista_produtos(TRUE);
        #$data['list'] = $this->load->view('produtos/list_produtos2', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtos/form_produtos3', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));
			#$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
            $data['produtos']['idTab_Produto'] = $this->Produtos_model->set_produtos($data['produtos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            #### Tab_Valor ####
            if (isset($data['valor'])) { {
					$data['valor']['Convdesc'] = trim(mb_strtoupper($data['valor']['Convdesc'], 'UTF-8'));
                    $data['valor']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['valor']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['valor']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['valor']['ValorProduto']));
                    $data['valor']['idTab_Produto'] = $data['produtos']['idTab_Produto'];					

                }
                $data['valor']['idTab_Valor'] = $this->Produtos_model->set_valor1($data['valor']);
            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            if ($data['idTab_Produto'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos3', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos2/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function categoria() {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			#'CodProd',
			#'Fornecedor',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.
      
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');        
		(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
		(!$this->input->post('PDCount')) ? $data['count']['PDCount'] = 0 : $data['count']['PDCount'] = $this->input->post('PDCount');

		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('QtdProdutoDesconto' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
				
                $data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

		$j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i)) {

                $data['servico'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {
			
            if ($this->input->post('Nome_Cor_Prod' . $i) || $this->input->post('Cor_Prod' . $i) || $this->input->post('Valor_Cor_Prod' . $i) || $this->input->post('idTab_Promocao' . $i)){
				$data['produto'][$j]['Nome_Cor_Prod'] = $this->input->post('Nome_Cor_Prod' . $i);
                $data['produto'][$j]['Cor_Prod'] = $this->input->post('Cor_Prod' . $i);
				$data['produto'][$j]['Valor_Cor_Prod'] = $this->input->post('Valor_Cor_Prod' . $i);
				$data['produto'][$j]['idTab_Promocao'] = $this->input->post('idTab_Promocao' . $i);
				$j++;
            }
        }
        $data['count']['PCount'] = $j - 1;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('Nome_Tam_Prod' . $i) || $this->input->post('Tam_Prod' . $i) || $this->input->post('Fator_Tam_Prod' . $i) || $this->input->post('idTab_Promocao' . $i)){
				$data['procedimento'][$j]['Nome_Tam_Prod'] = $this->input->post('Nome_Tam_Prod' . $i);
				$data['procedimento'][$j]['Tam_Prod'] = $this->input->post('Tam_Prod' . $i);
				$data['procedimento'][$j]['Fator_Tam_Prod'] = $this->input->post('Fator_Tam_Prod' . $i);
				$data['procedimento'][$j]['idTab_Promocao'] = $this->input->post('idTab_Promocao' . $i);
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;
		
		/*
        $j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i) || $this->input->post('Cor_Prod' . $i) || 
				$this->input->post('Opcao_Atributo_2' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i) ||
				$this->input->post('Ativo' . $i)){

				$data['derivados'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
				$data['derivados'][$j]['Cor_Prod'] = $this->input->post('Cor_Prod' . $i);
				$data['derivados'][$j]['Opcao_Atributo_2'] = $this->input->post('Opcao_Atributo_2' . $i);
				$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
				$data['derivados'][$j]['Ativo'] = $this->input->post('Ativo' . $i);
                $j++;
            }

        }
        $data['count']['PDCount'] = $j - 1;		
		*/
		
		
		// O c�digo do produto n�o � aqui, � l� embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];
		
        //Fim do trecho de c�digo que d� pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux2', 'Tipo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux1', 'Esp', 'required|trim');
		#$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');		
		
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'C�digo', 'is_unique[Tab_Produto.'.$data['produtos']['CodProd'].']');
		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'required|trim|is_unique[Tab_Produto.CodProd]');
		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();		
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		#$data['select']['Cor_Prod'] = $this->Basico_model->select_cor_prod();
		#$data['select']['Tam_Prod'] = $this->Basico_model->select_tam_prod();		
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos/categoria';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto'])
        if (isset($data['valor']))
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
		
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"'; 

 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
				
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
			#### Tab_Produto ####
			$data['produtos']['Desconto'] = 1;
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
			$data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));			
			//$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
			$data['produtos']['idTab_Produto'] = $this->Produtos_model->set_produtos($data['produtos']);
			/*
			echo count($data['servico']);
			echo '<br>';
			echo "<pre>";
			print_r($data['servico']);
			echo "</pre>";
			exit ();
			*/

			#### Tab_Valor ####
			if (isset($data['valor'])) {
				$max = count($data['valor']);
				for($j=1;$j<=$max;$j++) {
					$data['valor'][$j]['Desconto'] = 1;
					$data['valor'][$j]['Convdesc'] = trim(mb_strtoupper($data['valor'][$j]['Convdesc'], 'UTF-8'));
					$data['valor'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['valor'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['valor'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['valor'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['valor'][$j]['ValorProduto']));
					$data['valor'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
				}
				$data['valor']['idTab_Valor'] = $this->Produtos_model->set_valor($data['valor']);
			}
			
            #### App_Servico ####
            if (isset($data['servico'])) {
                $max = count($data['servico']);
                for($j=1;$j<=$max;$j++) {
                    $data['servico'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['servico'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['servico'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['servico'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['servico'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}
                $data['servico']['idTab_Cat_Prod'] = $this->Produtos_model->set_servico($data['servico']);
            }

            #### App_Produto ####
            if (isset($data['produto'])) {
                $max = count($data['produto']);
                for($j=1;$j<=$max;$j++) {
					$data['produto'][$j]['idTab_Promocao'] = $data['produto'][$j]['idTab_Promocao'];
					$data['produto'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['produto'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['produto'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['produto'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['produto'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['produto'][$j]['Valor_Cor_Prod'] = str_replace(',', '.', str_replace('.', '', $data['produto'][$j]['Valor_Cor_Prod']));
					$data['produto'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['produto'][$j]['Nome_Cor_Prod'], 'UTF-8'));
				}
						/*
							echo '<br>';
						echo "<pre>";
						print_r($data['produto']);
						echo "</pre>";
						exit ();
						*/
                $data['produto']['idTab_Opcao_Select'] = $this->Produtos_model->set_produto($data['produto']);
            }

            #### App_Procedimento ####
            if (isset($data['procedimento'])) {
                $max = count($data['procedimento']);
                for($j=1;$j<=$max;$j++) {
                    $data['procedimento'][$j]['idTab_Promocao'] = $data['procedimento'][$j]['idTab_Promocao'];
					$data['procedimento'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['procedimento'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['procedimento'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
                    $data['procedimento'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['procedimento'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['procedimento'][$j]['Fator_Tam_Prod'] = str_replace(',', '.', str_replace('.', '', $data['procedimento'][$j]['Fator_Tam_Prod']));
					$data['procedimento'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['procedimento'][$j]['Nome_Tam_Prod'], 'UTF-8'));
                }
                $data['procedimento']['idTab_Tam_Prod'] = $this->Produtos_model->set_procedimento($data['procedimento']);
            }			
			
			#### Tab_Produtos Derivados ####
            if (isset($data['derivados'])) {
                $max = count($data['derivados']);
                for($j=1;$j<=$max;$j++) {
					$data['derivados'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
					$data['derivados'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['derivados'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['derivados'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['derivados'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					#$data['derivados'][$j][$k]['Nome_Prod'] = trim(mb_strtoupper($nome_modelo.' '.$nome_tipo.' '.$nome_tamanho, 'UTF-8'));
					#$data['derivados'][$j][$k]['Cod_Prod'] = $data['produtos']['idTab_Produto'].'.'.$tipo.'.'.$tamanho;				
				}
                $data['derivados']['idTab_Produtos'] = $this->Produtos_model->set_derivados($data['derivados']);
            }
			
			/*
			#### Tab_Produtos Derivados ####
			if (isset($data['produto']) && isset($data['procedimento'])) {
                
				#### Tab_Produto ####
				$data['modelo'] = $this->Produtos_model->get_modelo($data['produtos']['idTab_Produto']);
				if (count($data['modelo']) > 0) {
					$data['modelo'] = array_combine(range(1, count($data['modelo'])), array_values($data['modelo']));
					$data['count']['Modelo'] = count($data['modelo']);
					
					$nome_modelo = $data['modelo']['1']['Produtos'];
					$categoria = $data['modelo']['1']['Prodaux3'];
				}
						
				#### Tab_Cor_Prod ####
				$data['tipo'] = $this->Produtos_model->get_produto($data['produtos']['idTab_Produto']);
				if (count($data['tipo']) > 0) {
					$data['tipo'] = array_combine(range(1, count($data['tipo'])), array_values($data['tipo']));
					$data['count']['Tipo'] = count($data['tipo']);
				}
				
				#### Tab_Tam_Prod ####
				//$data['procedimento'] = $this->Produtos_model->get_procedimento($id);
				$data['tamanho'] = $this->Produtos_model->get_procedimento($data['produtos']['idTab_Produto']);
				if (count($data['tamanho']) > 0) {
					$data['tamanho'] = array_combine(range(1, count($data['tamanho'])), array_values($data['tamanho']));
					$data['count']['Tamanho'] = count($data['tamanho']);
				}
				
				for($j=1;$j<=$data['count']['Tipo'];$j++) {

					//$j=1;
					$tipo = $data['tipo'][$j]['idTab_Opcao_Select'];
					$nome_tipo = $data['tipo'][$j]['Nome_Cor_Prod'];
					
					for($k=1;$k<=$data['count']['Tamanho'];$k++) {
						
						$tamanho = $data['tamanho'][$k]['idTab_Tam_Prod'];
						$nome_tamanho = $data['tamanho'][$k]['Nome_Tam_Prod'];

						$data['derivados'][$j][$k]['Cor_Prod'] = $tipo;
						$data['derivados'][$j][$k]['Opcao_Atributo_2'] = $tamanho;
						$data['derivados'][$j][$k]['Cat_Prod'] = $categoria;
						$data['derivados'][$j][$k]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['derivados'][$j][$k]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['derivados'][$j][$k]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['derivados'][$j][$k]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
						$data['derivados'][$j][$k]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
						$data['derivados'][$j][$k]['Nome_Prod'] = trim(mb_strtoupper($nome_modelo.' '.$nome_tipo.' '.$nome_tamanho, 'UTF-8'));
						$data['derivados'][$j][$k]['Cod_Prod'] = $data['produtos']['idTab_Produto'].'.'.$tipo.'.'.$tamanho;

					}
					$data['derivados']['idTab_Produtos'] = $this->Produtos_model->set_derivados($data['derivados']);
				}
					
					echo '<br>';
					echo "<pre>";
					print_r($data['derivados']);
					echo "</pre>";
					exit ();
					
				//$data['derivados']['idTab_Produtos'] = $this->Produtos_model->set_derivados($data['derivados']);
			}			
			*/
			
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
			$data['campos'] = array_keys($data['query']);
			$data['anterior'] = array();
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

			if ($data['idTab_Produto'] === FALSE) {
				$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

				$this->basico->erro($msg);
				$this->load->view('produtos/form_produtos', $data);
			} else {

				//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
				//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
				$data['msg'] = '?m=1';

				//redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar/' . $data['produtos']['idTab_Produto'] . $data['msg']);
				exit();
			}
        }
        $this->load->view('basico/footer');
    }
	
    public function cadastrar4() {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'Prod_Serv',
			'UnidadeProduto',
			#'CodProd',
			#'Fornecedor',
			'ValorProdutoSite',
			'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.
      
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		#$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Prod_Serv', 'Prod/Serv', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'required|trim|is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		#$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();		
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Prod_Serv'] = $this->Basico_model->select_prod_serv();
		$data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		//$data['select']['Prodaux3'] = $this->Basico_model->select_catprod1();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();		
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos/cadastrar4';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 0;
	
        #Ver uma solu��o melhor para este campo

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
		
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"'; 

 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
				
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
			#### Tab_Produto ####
			$data['produtos']['Desconto'] = 1;
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
			$data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));			
			//$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
			$data['produtos']['idTab_Produto'] = $this->Produtos_model->set_produtos($data['produtos']);
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
						//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						$data['campos'] = array_keys($data['query']);
						$data['anterior'] = array();
						//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
			//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
			*/

			if ($data['idTab_Produto'] === FALSE) {
				$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

				$this->basico->erro($msg);
				$this->load->view('produtos/form_produtos', $data);
			} else {

				//$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
				//$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
				$data['msg'] = '?m=1';

				//redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar1/' . $data['produtos']['idTab_Produto'] . $data['msg']);
				exit();
			}
        }
        $this->load->view('basico/footer');
    }

    public function alterar1($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			#'Prod_Serv',
			'UnidadeProduto',
			#'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'ValorProduto',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			#'Atributo_1',
			#'Atributo_2',
			#'Atributo_3',			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PT2Count')) ? $data['count']['PT2Count'] = 0 : $data['count']['PT2Count'] = $this->input->post('PT2Count');
		(!$this->input->post('PT3Count')) ? $data['count']['PT3Count'] = 0 : $data['count']['PT3Count'] = $this->input->post('PT3Count');
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');        
		(!$this->input->post('TCount')) ? $data['count']['TCount'] = 0 : $data['count']['TCount'] = $this->input->post('TCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
        (!$this->input->post('PDCount')) ? $data['count']['PDCount'] = 0 : $data['count']['PDCount'] = $this->input->post('PDCount');
		
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Desconto' . $i) || $this->input->post('QtdProdutoDesconto' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
				$data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);                
				$data['valor'][$j]['Desconto'] = $this->input->post('Desconto' . $i);
                $data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Atributo' . $i)) {
				$data['servico'][$j]['idTab_Atributo_Select'] = $this->input->post('idTab_Atributo_Select' . $i);
                $data['servico'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PT2Count']; $i++) {

            if ($this->input->post('idTab_Opcao2' . $i)) {
				$data['item_promocao2'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select2' . $i);
				$data['item_promocao2'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao2' . $i);
                $j++;
            }
						
        }
        $data['count']['PT2Count'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('idTab_Opcao3' . $i)) {
				$data['item_promocao3'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select3' . $i);
				$data['item_promocao3'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao3' . $i);
                $j++;
            }
						
        }
        $data['count']['PMCount'] = $j - 1;		
		
		$j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i) || $this->input->post('Opcao_Atributo_1' . $i) || 
				$this->input->post('Opcao_Atributo_2' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i)){
				$data['derivados'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				#$data['derivados'][$j]['Prod_Serv'] = $this->input->post('Prod_Serv' . $i);
				$data['derivados'][$j]['Opcao_Atributo_1'] = $this->input->post('Opcao_Atributo_1' . $i);
				$data['derivados'][$j]['Opcao_Atributo_2'] = $this->input->post('Opcao_Atributo_2' . $i);
				#$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
                $j++;
            }
        }
        $data['count']['PDCount'] = $j - 1;
		
		
		
		// o c�digo do produto n�o � aqui, � la embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];		
		
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $_SESSION['Produto'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
				/*
			echo '<br>';
          echo "<pre>";
          print_r($_SESSION['Produto']['Prod_Serv']);
          echo "</pre>";
          exit ();
          */
			$tipoprodserv = $data['produtos']['Prod_Serv'];
			$categoria = $data['produtos']['Prodaux3'];
			
			$data['atributos'] = $this->Produtos_model->get_atributos($categoria, TRUE);
            
			if (count($data['atributos']) > 0) {
                $data['atributos'] = array_combine(range(1, count($data['atributos'])), array_values($data['atributos']));
                
				$contagem = count($data['atributos']);
	
				$item_atributo = '0';	
				foreach($data['atributos'] as $atributos_view){
					$item_atributo++;
					$_SESSION['Atributos'][$item_atributo] = $atributos_view['idTab_Atributo'];
				}

            }

				/*
				#echo count($data['atributos']);
				echo '<br>';
				echo "<pre>";
				print_r($contagem);
				echo "</pre>";
				echo '<br>';
				echo "<pre>";
				print_r($data['atributos']);
				echo "</pre>";				
				exit ();
				*/
			
            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
				/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Cat_Prod ####
            $data['servico'] = $this->Produtos_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);
				
				$item_servico = '0';	
				foreach($data['servico'] as $servico_view){
					$item_servico++;
					$_SESSION['Servico'][$item_servico] = $servico_view['idTab_Atributo'];
				}
                
				/*
				if (isset($data['servico'])) {

                    for($j=1; $j <= $data['count']['SCount']; $j++)

				}
				*/
            }
			
            #### Tab_Valor2 ####
            #$data['item_promocao2'] = $this->Produtos_model->get_opcao_select2($id);
			$data['item_promocao2'] = $this->Produtos_model->get_opcao_select($id, "2");
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
            #$data['item_promocao3'] = $this->Produtos_model->get_opcao_select1($id);
            $data['item_promocao3'] = $this->Produtos_model->get_opcao_select($id, "1");
			if (count($data['item_promocao3']) > 0) {
                $data['item_promocao3'] = array_combine(range(1, count($data['item_promocao3'])), array_values($data['item_promocao3']));
                $data['count']['PMCount'] = count($data['item_promocao3']);
				/*
                if (isset($data['item_promocao3'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
						
                }
				*/				
            }			
			
            #### Tab_Tam_Prod ####
            $data['derivados'] = $this->Produtos_model->get_derivados($id);
            if (count($data['derivados']) > 0) {
                $data['derivados'] = array_combine(range(1, count($data['derivados'])), array_values($data['derivados']));
                $data['count']['PDCount'] = count($data['derivados']);
				/*
                if (isset($data['derivados'])) {

                    for($j=1; $j <= $data['count']['PDCount']; $j++)
						
                }
				*/				
            }			

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Produto ####

		#$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prod_Serv', 'Prod/Serv', 'required|trim');
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'C�digo', 'is_unique_by_id[Tab_Produto.'.$data['produtos']['CodProd'].'.' . $data['produtos']['idTab_Produto'] . ']');
		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'required|trim|is_unique_by_id[Tab_Produto.CodProd.' . $data['produtos']['idTab_Produto'] . ']');
		#$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Prod_Serv'] = $this->Basico_model->select_prod_serv();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux14();
		#$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		#$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		#$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Cor_Prod'] = $this->Prodaux2_model->select_prodaux24();
		$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux14();
		
		#$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_tam_prod();
		#$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_cor_prod();
		
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
		$data['select']['Prodaux3'] = $this->Basico_model->select_catprod1($_SESSION['Produto']['Prod_Serv']);
		$data['select']['idTab_Atributo'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		$data['select']['idTab_Opcao2'] = $this->Basico_model->select_opcao_2();
		$data['select']['idTab_Opcao3'] = $this->Basico_model->select_opcao_3();
		
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_select2();
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_select3();		
		
		#$data['select']['Atributo_1'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_2'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_3'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);		
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos/alterar1';
        $data['readonly'] = '';
        $data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['metodo'] = 1;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['Atributo_1'] = $_SESSION['Servico'][1];
			$data['produtos']['Atributo_2'] = $_SESSION['Servico'][2];
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produto']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produto'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produto']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produto']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }
			
            #### Tab_Atributo_Select ####
            $data['update']['servico']['anterior'] = $this->Produtos_model->get_servico($data['produtos']['idTab_Produto']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idTab_Atributo_Select');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['inserir'][$j]['idTab_Atributo'] = $data['update']['servico']['inserir'][$j]['idTab_Atributo'];
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['alterar'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Atributo'] = $data['update']['servico']['alterar'][$j]['idTab_Atributo'];
				}

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Produtos_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] =  $this->Produtos_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Produtos_model->delete_servico($data['update']['servico']['excluir']);

            }
			
            #### Tab_Valor2 ####
            #$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select2($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "2");
            if (isset($data['item_promocao2']) || (!isset($data['item_promocao2']) && isset($data['update']['item_promocao2']['anterior']) ) ) {

                if (isset($data['item_promocao2']))
                    $data['item_promocao2'] = array_values($data['item_promocao2']);
                else
                    $data['item_promocao2'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao2'] = $this->basico->tratamento_array_multidimensional($data['item_promocao2'], $data['update']['item_promocao2']['anterior'], 'idTab_Opcao_Select');

                $max2 = count($data['update']['item_promocao2']['inserir']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['inserir'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao2']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max2 = count($data['update']['item_promocao2']['alterar']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['alterar'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao2']['inserir']))
                    $data['update']['item_promocao2']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao2']['inserir']);

                if (count($data['update']['item_promocao2']['alterar']))
                    $data['update']['item_promocao2']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao2']['alterar']);

                if (count($data['update']['item_promocao2']['excluir']))
                    $data['update']['item_promocao2']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao2']['excluir']);

            }
			
            #### Tab_Valor3 ####
            #$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select1($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "1");
            if (isset($data['item_promocao3']) || (!isset($data['item_promocao3']) && isset($data['update']['item_promocao3']['anterior']) ) ) {

                if (isset($data['item_promocao3']))
                    $data['item_promocao3'] = array_values($data['item_promocao3']);
                else
                    $data['item_promocao3'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao3'] = $this->basico->tratamento_array_multidimensional($data['item_promocao3'], $data['update']['item_promocao3']['anterior'], 'idTab_Opcao_Select');

                $max = count($data['update']['item_promocao3']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['inserir'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao3']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max = count($data['update']['item_promocao3']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['alterar'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao3']['inserir']))
                    $data['update']['item_promocao3']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao3']['inserir']);

                if (count($data['update']['item_promocao3']['alterar']))
                    $data['update']['item_promocao3']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao3']['alterar']);

                if (count($data['update']['item_promocao3']['excluir']))
                    $data['update']['item_promocao3']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao3']['excluir']);

            }			
			
            #### Tab_Produtos ####
            $data['update']['derivados']['anterior'] = $this->Produtos_model->get_derivados($data['produtos']['idTab_Produto']);
            if (isset($data['derivados']) || (!isset($data['derivados']) && isset($data['update']['derivados']['anterior']) ) ) {

                if (isset($data['derivados']))
                    $data['derivados'] = array_values($data['derivados']);
                else
                    $data['derivados'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['derivados'] = $this->basico->tratamento_array_multidimensional($data['derivados'], $data['update']['derivados']['anterior'], 'idTab_Produtos');

                $max = count($data['update']['derivados']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['derivados']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['Prod_Serv'] = $data['produtos']['Prod_Serv'];
					$data['update']['derivados']['inserir'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'];                
				}

                $max = count($data['update']['derivados']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['alterar'][$j]['Prod_Serv'] = $data['produtos']['Prod_Serv'];
					$data['update']['derivados']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];					
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'];
				}

                if (count($data['update']['derivados']['inserir']))
                    $data['update']['derivados']['bd']['inserir'] = $this->Produtos_model->set_derivados($data['update']['derivados']['inserir']);

                if (count($data['update']['derivados']['alterar']))
                    $data['update']['derivados']['bd']['alterar'] =  $this->Produtos_model->update_derivados($data['update']['derivados']['alterar']);

                if (count($data['update']['derivados']['excluir']))
                    $data['update']['derivados']['bd']['excluir'] = $this->Produtos_model->delete_derivados($data['update']['derivados']['excluir']);

            }
				/*
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
							$data['campos'] = array_keys($data['query']);
							$data['anterior'] = array();
							//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
				//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
				*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                unset($_SESSION['Atributos']);
				unset($_SESSION['Servico']);
				#redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar2/' . $data['produtos']['idTab_Produto'] . $data['msg']);
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
			'Cadastrar',
        ), TRUE));
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			#'Prod_Serv',
			'UnidadeProduto',
			#'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'ValorProduto',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			#'Atributo_1',
			#'Atributo_2',
			#'Atributo_3',			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

		(!$this->input->post('PT2Count')) ? $data['count']['PT2Count'] = 0 : $data['count']['PT2Count'] = $this->input->post('PT2Count');
		(!$this->input->post('PT3Count')) ? $data['count']['PT3Count'] = 0 : $data['count']['PT3Count'] = $this->input->post('PT3Count');
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');        
		(!$this->input->post('TCount')) ? $data['count']['TCount'] = 0 : $data['count']['TCount'] = $this->input->post('TCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
        (!$this->input->post('PDCount')) ? $data['count']['PDCount'] = 0 : $data['count']['PDCount'] = $this->input->post('PDCount');
		
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Desconto' . $i) || $this->input->post('QtdProdutoDesconto' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
				$data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);                
				$data['valor'][$j]['Desconto'] = $this->input->post('Desconto' . $i);
                $data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Atributo' . $i)) {
				$data['servico'][$j]['idTab_Atributo_Select'] = $this->input->post('idTab_Atributo_Select' . $i);
                $data['servico'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PT2Count']; $i++) {

            if ($this->input->post('idTab_Opcao2' . $i)) {
				$data['item_promocao2'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select2' . $i);
				$data['item_promocao2'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao2' . $i);
                $j++;
            }
						
        }
        $data['count']['PT2Count'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('idTab_Opcao3' . $i)) {
				$data['item_promocao3'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select3' . $i);
				$data['item_promocao3'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao3' . $i);
                $j++;
            }
						
        }
        $data['count']['PMCount'] = $j - 1;		
		
		$j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i) || $this->input->post('Opcao_Atributo_1' . $i) || 
				$this->input->post('Opcao_Atributo_2' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i)){
				$data['derivados'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				#$data['derivados'][$j]['Prod_Serv'] = $this->input->post('Prod_Serv' . $i);
				$data['derivados'][$j]['Opcao_Atributo_1'] = $this->input->post('Opcao_Atributo_1' . $i);
				$data['derivados'][$j]['Opcao_Atributo_2'] = $this->input->post('Opcao_Atributo_2' . $i);
				#$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
                $j++;
            }
        }
        $data['count']['PDCount'] = $j - 1;
		
		
		
		// o c�digo do produto n�o � aqui, � la embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];		
		
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $_SESSION['Produto'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
				/*
					echo '<br>';
          echo "<pre>";
          print_r($_SESSION['Produto']['Prod_Serv']);
          echo "</pre>";
          exit ();
          */
			$tipoprodserv = $data['produtos']['Prod_Serv'];
			$categoria = $data['produtos']['Prodaux3'];
			
			$data['atributos'] = $this->Produtos_model->get_atributos($categoria, TRUE);
            
			if (count($data['atributos']) > 0) {
                $data['atributos'] = array_combine(range(1, count($data['atributos'])), array_values($data['atributos']));
                
				$contagem = count($data['atributos']);
	
				$item_atributo = '0';	
				foreach($data['atributos'] as $atributos_view){
					$item_atributo++;
					$_SESSION['Atributos'][$item_atributo] = $atributos_view['idTab_Atributo'];
				}

            }

				/*
				#echo count($data['atributos']);
				echo '<br>';
				echo "<pre>";
				print_r($contagem);
				echo "</pre>";
				echo '<br>';
				echo "<pre>";
				print_r($data['atributos']);
				echo "</pre>";				
				exit ();
				*/
			
            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
				/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Cat_Prod ####
            $data['servico'] = $this->Produtos_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);
				
				$item_servico = '0';	
				foreach($data['servico'] as $servico_view){
					$item_servico++;
					$_SESSION['Servico'][$item_servico] = $servico_view['idTab_Atributo'];
				}
                
				/*
				if (isset($data['servico'])) {

                    for($j=1; $j <= $data['count']['SCount']; $j++)

				}
				*/
            }
			
            #### Tab_Valor2 ####
            #$data['item_promocao2'] = $this->Produtos_model->get_opcao_select2($id);
			$data['item_promocao2'] = $this->Produtos_model->get_opcao_select($id, "2");
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
            #$data['item_promocao3'] = $this->Produtos_model->get_opcao_select1($id);
            $data['item_promocao3'] = $this->Produtos_model->get_opcao_select($id, "1");
			if (count($data['item_promocao3']) > 0) {
                $data['item_promocao3'] = array_combine(range(1, count($data['item_promocao3'])), array_values($data['item_promocao3']));
                $data['count']['PMCount'] = count($data['item_promocao3']);
				/*
                if (isset($data['item_promocao3'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
						
                }
				*/				
            }			
			
            #### Tab_Tam_Prod ####
            $data['derivados'] = $this->Produtos_model->get_derivados($id);
            if (count($data['derivados']) > 0) {
                $data['derivados'] = array_combine(range(1, count($data['derivados'])), array_values($data['derivados']));
                $data['count']['PDCount'] = count($data['derivados']);
				/*
                if (isset($data['derivados'])) {

                    for($j=1; $j <= $data['count']['PDCount']; $j++)
						
                }
				*/				
            }			

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Produto ####

		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prod_Serv', 'Prod/Serv', 'required|trim');
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'C�digo', 'is_unique_by_id[Tab_Produto.'.$data['produtos']['CodProd'].'.' . $data['produtos']['idTab_Produto'] . ']');
		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'required|trim|is_unique_by_id[Tab_Produto.CodProd.' . $data['produtos']['idTab_Produto'] . ']');
		#$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Prod_Serv'] = $this->Basico_model->select_prod_serv();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux14();
		#$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		#$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		#$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Cor_Prod'] = $this->Prodaux2_model->select_prodaux24();
		$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux14();
		
		#$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_tam_prod();
		#$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_cor_prod();
		
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
		$data['select']['Prodaux3'] = $this->Basico_model->select_catprod1($_SESSION['Produto']['Prod_Serv']);
		$data['select']['idTab_Atributo'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		$data['select']['idTab_Opcao2'] = $this->Basico_model->select_opcao_2();
		$data['select']['idTab_Opcao3'] = $this->Basico_model->select_opcao_3();
		
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_select2();
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_select3();		
		
		#$data['select']['Atributo_1'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_2'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_3'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);		
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['Atributo_1'] = $_SESSION['Servico'][1];
			$data['produtos']['Atributo_2'] = $_SESSION['Servico'][2];
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produto']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produto'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produto']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produto']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }
			
            #### Tab_Atributo_Select ####
            $data['update']['servico']['anterior'] = $this->Produtos_model->get_servico($data['produtos']['idTab_Produto']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idTab_Atributo_Select');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['inserir'][$j]['idTab_Atributo'] = $data['update']['servico']['inserir'][$j]['idTab_Atributo'];
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['alterar'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Atributo'] = $data['update']['servico']['alterar'][$j]['idTab_Atributo'];
				}

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Produtos_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] =  $this->Produtos_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Produtos_model->delete_servico($data['update']['servico']['excluir']);

            }
			
            #### Tab_Valor2 ####
            #$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select2($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "2");
            if (isset($data['item_promocao2']) || (!isset($data['item_promocao2']) && isset($data['update']['item_promocao2']['anterior']) ) ) {

                if (isset($data['item_promocao2']))
                    $data['item_promocao2'] = array_values($data['item_promocao2']);
                else
                    $data['item_promocao2'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao2'] = $this->basico->tratamento_array_multidimensional($data['item_promocao2'], $data['update']['item_promocao2']['anterior'], 'idTab_Opcao_Select');

                $max2 = count($data['update']['item_promocao2']['inserir']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['inserir'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao2']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max2 = count($data['update']['item_promocao2']['alterar']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['alterar'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao2']['inserir']))
                    $data['update']['item_promocao2']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao2']['inserir']);

                if (count($data['update']['item_promocao2']['alterar']))
                    $data['update']['item_promocao2']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao2']['alterar']);

                if (count($data['update']['item_promocao2']['excluir']))
                    $data['update']['item_promocao2']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao2']['excluir']);

            }
			
            #### Tab_Valor3 ####
            #$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select1($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "1");
            if (isset($data['item_promocao3']) || (!isset($data['item_promocao3']) && isset($data['update']['item_promocao3']['anterior']) ) ) {

                if (isset($data['item_promocao3']))
                    $data['item_promocao3'] = array_values($data['item_promocao3']);
                else
                    $data['item_promocao3'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao3'] = $this->basico->tratamento_array_multidimensional($data['item_promocao3'], $data['update']['item_promocao3']['anterior'], 'idTab_Opcao_Select');

                $max = count($data['update']['item_promocao3']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['inserir'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao3']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max = count($data['update']['item_promocao3']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['alterar'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao3']['inserir']))
                    $data['update']['item_promocao3']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao3']['inserir']);

                if (count($data['update']['item_promocao3']['alterar']))
                    $data['update']['item_promocao3']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao3']['alterar']);

                if (count($data['update']['item_promocao3']['excluir']))
                    $data['update']['item_promocao3']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao3']['excluir']);

            }			
			
            #### Tab_Produtos ####
            $data['update']['derivados']['anterior'] = $this->Produtos_model->get_derivados($data['produtos']['idTab_Produto']);
            if (isset($data['derivados']) || (!isset($data['derivados']) && isset($data['update']['derivados']['anterior']) ) ) {

                if (isset($data['derivados']))
                    $data['derivados'] = array_values($data['derivados']);
                else
                    $data['derivados'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['derivados'] = $this->basico->tratamento_array_multidimensional($data['derivados'], $data['update']['derivados']['anterior'], 'idTab_Produtos');

                $max = count($data['update']['derivados']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['derivados']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['Prod_Serv'] = $data['produtos']['Prod_Serv'];
					$data['update']['derivados']['inserir'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'];                
				}

                $max = count($data['update']['derivados']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['alterar'][$j]['Prod_Serv'] = $data['produtos']['Prod_Serv'];
					$data['update']['derivados']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];					
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'];
				}

                if (count($data['update']['derivados']['inserir']))
                    $data['update']['derivados']['bd']['inserir'] = $this->Produtos_model->set_derivados($data['update']['derivados']['inserir']);

                if (count($data['update']['derivados']['alterar']))
                    $data['update']['derivados']['bd']['alterar'] =  $this->Produtos_model->update_derivados($data['update']['derivados']['alterar']);

                if (count($data['update']['derivados']['excluir']))
                    $data['update']['derivados']['bd']['excluir'] = $this->Produtos_model->delete_derivados($data['update']['derivados']['excluir']);

            }
				/*
				/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
							//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
							$data['campos'] = array_keys($data['query']);
							$data['anterior'] = array();
							//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
				//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
				*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                unset($_SESSION['Atributos']);
				unset($_SESSION['Servico']);
				#redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar3/' . $data['produtos']['idTab_Produto'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterar3($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			#'Prod_Serv',
			'UnidadeProduto',
			#'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'ValorProduto',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			#'Atributo_1',
			#'Atributo_2',
			#'Atributo_3',			
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        
		(!$this->input->post('PT3Count')) ? $data['count']['PT3Count'] = 0 : $data['count']['PT3Count'] = $this->input->post('PT3Count');
		(!$this->input->post('PT2Count')) ? $data['count']['PT2Count'] = 0 : $data['count']['PT2Count'] = $this->input->post('PT2Count');        
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');        
		(!$this->input->post('TCount')) ? $data['count']['TCount'] = 0 : $data['count']['TCount'] = $this->input->post('TCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
        (!$this->input->post('PDCount')) ? $data['count']['PDCount'] = 0 : $data['count']['PDCount'] = $this->input->post('PDCount');
		
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Desconto' . $i) || $this->input->post('QtdProdutoDesconto' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
				$data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);                
				$data['valor'][$j]['Desconto'] = $this->input->post('Desconto' . $i);
                $data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Atributo' . $i)) {
				$data['servico'][$j]['idTab_Atributo_Select'] = $this->input->post('idTab_Atributo_Select' . $i);
                $data['servico'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('idTab_Opcao3' . $i)) {
				$data['item_promocao3'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select3' . $i);
				$data['item_promocao3'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao3' . $i);
                $j++;
            }
						
        }
        $data['count']['PMCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PT2Count']; $i++) {

            if ($this->input->post('idTab_Opcao2' . $i)) {
				$data['item_promocao2'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select2' . $i);
				$data['item_promocao2'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao2' . $i);
                $j++;
            }
						
        }
        $data['count']['PT2Count'] = $j - 1;
		

		$j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i) || $this->input->post('Opcao_Atributo_1' . $i) || $this->input->post('Valor_Produto' . $i) || 
				$this->input->post('Opcao_Atributo_2' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i)){
				$data['derivados'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				#$data['derivados'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
				$data['derivados'][$j]['Opcao_Atributo_1'] = $this->input->post('Opcao_Atributo_1' . $i);
				$data['derivados'][$j]['Opcao_Atributo_2'] = $this->input->post('Opcao_Atributo_2' . $i);
				#$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
				#$data['derivados'][$j]['Qtd_Prod_Desc'] = $this->input->post('Qtd_Prod_Desc' . $i);
				#$data['derivados'][$j]['Qtd_Prod_Incr'] = $this->input->post('Qtd_Prod_Incr' . $i);
				#$data['derivados'][$j]['Tipo_Valor_Prod'] = $this->input->post('Tipo_Valor_Prod' . $i);
				$data['derivados'][$j]['Valor_Produto'] = $this->input->post('Valor_Produto' . $i);
                $j++;
            }
        }
        $data['count']['PDCount'] = $j - 1;
		
		
		
		// o c�digo do produto n�o � aqui, � la embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];		
		
        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $_SESSION['Produto'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
			/*
          echo '<br>';
          echo "<pre>";
          print_r($_SESSION['Produto']['Prod_Serv']);
          echo "</pre>";
          exit ();
          */
			
			$tipoprodserv = $data['produtos']['Prod_Serv'];
			$categoria = $data['produtos']['Prodaux3'];
			
			$data['atributos'] = $this->Produtos_model->get_atributos($categoria, TRUE);
            
			if (count($data['atributos']) > 0) {
                $data['atributos'] = array_combine(range(1, count($data['atributos'])), array_values($data['atributos']));
                #$data['count']['SCount'] = count($data['atributos']);
				
				$item_atributo = '0';	
				foreach($data['atributos'] as $atributos_view){
					$item_atributo++;
					$_SESSION['Atributos'][$item_atributo] = $atributos_view['idTab_Atributo'];
				
				}

            }			
			
			
            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
				/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Atributo_Select ####
            $data['servico'] = $this->Produtos_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);
				
				$item_servico = '0';	
				foreach($data['servico'] as $servico_view){
					$item_servico++;
					$_SESSION['Servico'][$item_servico] = $servico_view['idTab_Atributo'];
				}
				
				/*
                if (isset($data['servico'])) {

                    for($j=1; $j <= $data['count']['SCount']; $j++)
						
                }
				*/
            }
			
            #### Tab_Valor ####
            #$data['item_promocao3'] = $this->Produtos_model->get_opcao_select1($id);
			$data['item_promocao3'] = $this->Produtos_model->get_opcao_select($id, "1");
            if (count($data['item_promocao3']) > 0) {
                $data['item_promocao3'] = array_combine(range(1, count($data['item_promocao3'])), array_values($data['item_promocao3']));
                $data['count']['PMCount'] = count($data['item_promocao3']);
				/*
                if (isset($data['item_promocao3'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Valor2 ####
            #$data['item_promocao2'] = $this->Produtos_model->get_opcao_select2($id);
			$data['item_promocao2'] = $this->Produtos_model->get_opcao_select($id, "2");
            if (count($data['item_promocao2']) > 0) {
                $data['item_promocao2'] = array_combine(range(1, count($data['item_promocao2'])), array_values($data['item_promocao2']));
                $data['count']['PT2Count'] = count($data['item_promocao2']);
				/*
                if (isset($data['item_promocao2'])) {

                    for($j=1; $j <= $data['count']['PT2Count']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Tam_Prod ####
            $data['derivados'] = $this->Produtos_model->get_derivados($id);
            if (count($data['derivados']) > 0) {
                $data['derivados'] = array_combine(range(1, count($data['derivados'])), array_values($data['derivados']));
                $data['count']['PDCount'] = count($data['derivados']);
/*
                if (isset($data['derivados'])) {

                    for($j=1; $j <= $data['count']['PDCount']; $j++)
						
                }
*/				
            }			

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Produto ####

		#$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prod_Serv', 'Prod/Serv', 'required|trim');
		#$this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux2', 'Tipo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux1', 'Esp', 'required|trim');
		#$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'C�digo', 'is_unique_by_id[Tab_Produto.'.$data['produtos']['CodProd'].'.' . $data['produtos']['idTab_Produto'] . ']');
		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'required|trim|is_unique_by_id[Tab_Produto.CodProd.' . $data['produtos']['idTab_Produto'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Prod_Serv'] = $this->Basico_model->select_prod_serv();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux14();
		#$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		#$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		#$data['select']['Cor_Prod'] = $this->Prodaux2_model->select_prodaux24();
		#$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux14();
		
		#$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_cor_prod();
		#$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_tam_prod();
		
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
		
		$data['select']['Cor_Prod'] = $this->Basico_model->select_opcao2();
		$data['select']['Tam_Prod'] = $this->Basico_model->select_opcao1();
		
		$data['select']['Prodaux3'] = $this->Basico_model->select_catprod1($_SESSION['Produto']['Prod_Serv']);
		$data['select']['idTab_Atributo'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		$data['select']['idTab_Opcao2'] = $this->Basico_model->select_opcao_2();
		$data['select']['idTab_Opcao3'] = $this->Basico_model->select_opcao_3();
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_select2();
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_select3();
		#$data['select']['Atributo_1'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_2'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_3'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos/alterar3';
        $data['readonly'] = '';
		$data['readonly2'] = 'readonly';
        $data['disabled'] = '';
        $data['disabled2'] = 'disabled';		
        $data['panel'] = 'primary';
        $data['metodo'] = 3;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['Atributo_1'] = $_SESSION['Servico'][1];
			$data['produtos']['Atributo_2'] = $_SESSION['Servico'][2];			
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produto']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produto'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produto']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produto']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }
			
            #### Tab_Atributo_Select ####
            $data['update']['servico']['anterior'] = $this->Produtos_model->get_servico($data['produtos']['idTab_Produto']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idTab_Atributo_Select');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['inserir'][$j]['idTab_Atributo'] = $data['update']['servico']['inserir'][$j]['idTab_Atributo'];
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['alterar'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Atributo'] = $data['update']['servico']['alterar'][$j]['idTab_Atributo'];
				}

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Produtos_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] =  $this->Produtos_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Produtos_model->delete_servico($data['update']['servico']['excluir']);

            }
			
            #### Tab_Valor2 ####
            #$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select2($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "2");
            if (isset($data['item_promocao2']) || (!isset($data['item_promocao2']) && isset($data['update']['item_promocao2']['anterior']) ) ) {

                if (isset($data['item_promocao2']))
                    $data['item_promocao2'] = array_values($data['item_promocao2']);
                else
                    $data['item_promocao2'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao2'] = $this->basico->tratamento_array_multidimensional($data['item_promocao2'], $data['update']['item_promocao2']['anterior'], 'idTab_Opcao_Select');

                $max2 = count($data['update']['item_promocao2']['inserir']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['inserir'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao2']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max2 = count($data['update']['item_promocao2']['alterar']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['alterar'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao2']['inserir']))
                    $data['update']['item_promocao2']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao2']['inserir']);

                if (count($data['update']['item_promocao2']['alterar']))
                    $data['update']['item_promocao2']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao2']['alterar']);

                if (count($data['update']['item_promocao2']['excluir']))
                    $data['update']['item_promocao2']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao2']['excluir']);

            }
			
            #### Tab_Valor3 ####
            #$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select1($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "1");
            if (isset($data['item_promocao3']) || (!isset($data['item_promocao3']) && isset($data['update']['item_promocao3']['anterior']) ) ) {

                if (isset($data['item_promocao3']))
                    $data['item_promocao3'] = array_values($data['item_promocao3']);
                else
                    $data['item_promocao3'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao3'] = $this->basico->tratamento_array_multidimensional($data['item_promocao3'], $data['update']['item_promocao3']['anterior'], 'idTab_Opcao_Select');

                $max = count($data['update']['item_promocao3']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['inserir'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao3']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max = count($data['update']['item_promocao3']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['alterar'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao3']['inserir']))
                    $data['update']['item_promocao3']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao3']['inserir']);

                if (count($data['update']['item_promocao3']['alterar']))
                    $data['update']['item_promocao3']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao3']['alterar']);

                if (count($data['update']['item_promocao3']['excluir']))
                    $data['update']['item_promocao3']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao3']['excluir']);

            }
			
            #### Tab_Produtos ####
            $data['update']['derivados']['anterior'] = $this->Produtos_model->get_derivados($data['produtos']['idTab_Produto']);
            if (isset($data['derivados']) || (!isset($data['derivados']) && isset($data['update']['derivados']['anterior']) ) ) {

                if (isset($data['derivados']))
                    $data['derivados'] = array_values($data['derivados']);
                else
                    $data['derivados'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['derivados'] = $this->basico->tratamento_array_multidimensional($data['derivados'], $data['update']['derivados']['anterior'], 'idTab_Produtos');

                $max = count($data['update']['derivados']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['derivados']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['Prod_Serv'] = $_SESSION['Produto']['Prod_Serv'];
					$data['update']['derivados']['inserir'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'];                
				}

                $max = count($data['update']['derivados']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['alterar'][$j]['Prod_Serv'] = $_SESSION['Produto']['Prod_Serv'];
					$data['update']['derivados']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];					
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'];
				}

                if (count($data['update']['derivados']['inserir']))
                    $data['update']['derivados']['bd']['inserir'] = $this->Produtos_model->set_derivados($data['update']['derivados']['inserir']);

                if (count($data['update']['derivados']['alterar']))
                    $data['update']['derivados']['bd']['alterar'] =  $this->Produtos_model->update_derivados($data['update']['derivados']['alterar']);

                if (count($data['update']['derivados']['excluir']))
                    $data['update']['derivados']['bd']['excluir'] = $this->Produtos_model->delete_derivados($data['update']['derivados']['excluir']);

            }
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                unset($_SESSION['Atributos']);
				unset($_SESSION['Servico']);
				unset($_SESSION['Produto']);
				#redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				//redirect(base_url() . 'produtos/alterar3/' . $data['produtos']['idTab_Produto'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function alterar4($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			'Prod_Serv',
			'UnidadeProduto',
			#'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
			'ValorProduto',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
			#'Atributo_1',
			#'Atributo_2',
			#'Atributo_3',
			
        ), TRUE));
        
        (!$this->input->post('PT3Count')) ? $data['count']['PT3Count'] = 0 : $data['count']['PT3Count'] = $this->input->post('PT3Count');
		(!$this->input->post('PT2Count')) ? $data['count']['PT2Count'] = 0 : $data['count']['PT2Count'] = $this->input->post('PT2Count');
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('SCount')) ? $data['count']['SCount'] = 0 : $data['count']['SCount'] = $this->input->post('SCount');        
		#(!$this->input->post('PCount')) ? $data['count']['PCount'] = 0 : $data['count']['PCount'] = $this->input->post('PCount');		
        (!$this->input->post('PMCount')) ? $data['count']['PMCount'] = 0 : $data['count']['PMCount'] = $this->input->post('PMCount');
        (!$this->input->post('PDCount')) ? $data['count']['PDCount'] = 0 : $data['count']['PDCount'] = $this->input->post('PDCount');
		(!$this->input->post('TCount')) ? $data['count']['TCount'] = 0 : $data['count']['TCount'] = $this->input->post('TCount');
		
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('ValorProduto' . $i)) {
				$data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['valor'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['valor'][$j]['idTab_Promocao'] = $this->input->post('idTab_Promocao' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
                $data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['valor'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);				
                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['SCount']; $i++) {

            if ($this->input->post('idTab_Atributo' . $i)) {
				$data['servico'][$j]['idTab_Atributo_Select'] = $this->input->post('idTab_Atributo_Select' . $i);
                $data['servico'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;        
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PMCount']; $i++) {

            if ($this->input->post('idTab_Opcao3' . $i)) {
				$data['item_promocao3'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select3' . $i);
				$data['item_promocao3'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao3' . $i);
                $j++;
            }
						
        }
        $data['count']['PMCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PT2Count']; $i++) {

            if ($this->input->post('idTab_Opcao2' . $i)) {
				$data['item_promocao2'][$j]['idTab_Opcao_Select'] = $this->input->post('idTab_Opcao_Select2' . $i);
				$data['item_promocao2'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao2' . $i);
                $j++;
            }
						
        }
        $data['count']['PT2Count'] = $j - 1;
		

		$j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Opcao_Atributo_1' . $i) || $this->input->post('Opcao_Atributo_2' . $i) || $this->input->post('Nome_Prod' . $i)){
				$data['derivados'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['derivados'][$j]['idTab_Produto'] = $this->input->post('idTab_Produto' . $i);
				$data['derivados'][$j]['Opcao_Atributo_1'] = $this->input->post('Opcao_Atributo_1' . $i);
				$data['derivados'][$j]['Opcao_Atributo_2'] = $this->input->post('Opcao_Atributo_2' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
				$data['derivados'][$j]['Valor_Produto'] = $this->input->post('Valor_Produto' . $i);
                $j++;
            }
        }
        $data['count']['PDCount'] = $j - 1;

        if ($id) {
            #### Tab_Produto ####
            $_SESSION['Produto'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);

			$categoria = $data['produtos']['Prodaux3'];
			
			$data['atributos'] = $this->Produtos_model->get_atributos($categoria, TRUE);
            
			if (count($data['atributos']) > 0) {
                $data['atributos'] = array_combine(range(1, count($data['atributos'])), array_values($data['atributos']));
                #$data['count']['SCount'] = count($data['atributos']);
				
				$item_atributo = '0';	
				foreach($data['atributos'] as $atributos_view){
					$item_atributo++;
					$_SESSION['Atributos'][$item_atributo] = $atributos_view['idTab_Atributo'];
				
				}

            }			
			
            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
				/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Atributo_Select ####
            $data['servico'] = $this->Produtos_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);
				
				$item_servico = '0';	
				foreach($data['servico'] as $servico_view){
					$item_servico++;
					$_SESSION['Servico'][$item_servico] = $servico_view['idTab_Atributo'];
				}
				
				/*
                if (isset($data['servico'])) {

                    for($j=1; $j <= $data['count']['SCount']; $j++)
						
                }
				*/
            }			
			
            #### Tab_Valor ####
            #$data['item_promocao3'] = $this->Produtos_model->get_opcao_select1($id);
			$data['item_promocao3'] = $this->Produtos_model->get_opcao_select($id, "1");
            if (count($data['item_promocao3']) > 0) {
                $data['item_promocao3'] = array_combine(range(1, count($data['item_promocao3'])), array_values($data['item_promocao3']));
                $data['count']['PMCount'] = count($data['item_promocao3']);
				/*
                if (isset($data['item_promocao3'])) {

                    for($j=1; $j <= $data['count']['PMCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Valor2 ####
            #$data['item_promocao2'] = $this->Produtos_model->get_opcao_select2($id);
			$data['item_promocao2'] = $this->Produtos_model->get_opcao_select($id, "2");
            if (count($data['item_promocao2']) > 0) {
                $data['item_promocao2'] = array_combine(range(1, count($data['item_promocao2'])), array_values($data['item_promocao2']));
                $data['count']['PT2Count'] = count($data['item_promocao2']);
				/*
                if (isset($data['item_promocao2'])) {

                    for($j=1; $j <= $data['count']['PT2Count']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Tam_Prod ####
            $data['derivados'] = $this->Produtos_model->get_derivados($id);
            if (count($data['derivados']) > 0) {
                $data['derivados'] = array_combine(range(1, count($data['derivados'])), array_values($data['derivados']));
                $data['count']['PDCount'] = count($data['derivados']);
				/*
                if (isset($data['derivados'])) {

                    for($j=1; $j <= $data['count']['PDCount']; $j++)
						
                }
				*/				
            }			

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');
 		$this->form_validation->set_rules('Prod_Serv', 'Prod/Serv', 'required|trim');
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'C�digo', 'is_unique_by_id[Tab_Produto.'.$data['produtos']['CodProd'].'.' . $data['produtos']['idTab_Produto'] . ']');
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'required|trim|is_unique_by_id[Tab_Produto.CodProd.' . $data['produtos']['idTab_Produto'] . ']');
		#$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		$data['select']['Prod_Serv'] = $this->Basico_model->select_prod_serv();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux14();
		#$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		#$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		#$data['select']['Cor_Prod'] = $this->Prodaux2_model->select_prodaux24();
		#$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux14();
		
		#$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_tam_prod();
		#$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_cor_prod();
		
		#$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['idTab_Produtos'] = $this->Basico_model->select_prod_der0();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
		$data['select']['Cor_Prod'] = $this->Basico_model->select_opcao2();
		$data['select']['Tam_Prod'] = $this->Basico_model->select_opcao1();		
		
		$data['select']['Prodaux3'] = $this->Basico_model->select_catprod1($_SESSION['Produto']['Prod_Serv']);
		$data['select']['idTab_Atributo'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		$data['select']['idTab_Opcao2'] = $this->Basico_model->select_opcao_2();
		$data['select']['idTab_Opcao3'] = $this->Basico_model->select_opcao_3();
		
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_select2();
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_select3();
		
		#$data['select']['Atributo_1'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_2'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);
		#$data['select']['Atributo_3'] = $this->Basico_model->select_atributo($_SESSION['Produto']['Prodaux3']);		
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos/alterar4';
        $data['readonly'] = '';
		$data['readonly2'] = 'readonly';
        $data['disabled'] = '';
        $data['disabled2'] = 'disabled';		
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['Atributo_1'] = $_SESSION['Servico'][1];
			$data['produtos']['Atributo_2'] = $_SESSION['Servico'][2];			
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produto']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produto'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produto']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produto']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['inserir'][$j]['idTab_Produtos'] = $data['update']['valor']['inserir'][$j]['idTab_Produtos'];
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['Desconto'] = '1';
					$data['update']['valor']['inserir'][$j]['QtdProdutoDesconto'] = $data['update']['valor']['inserir'][$j]['QtdProdutoDesconto'];
					$data['update']['valor']['inserir'][$j]['QtdProdutoIncremento'] = $data['update']['valor']['inserir'][$j]['QtdProdutoIncremento'];
					$data['update']['valor']['inserir'][$j]['idTab_Promocao'] = '0';
					$data['update']['valor']['inserir'][$j]['Prodaux3'] = $data['produtos']['Prodaux3'];
					$data['update']['valor']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['idTab_Produtos'] = $data['update']['valor']['alterar'][$j]['idTab_Produtos'];
					$data['update']['valor']['alterar'][$j]['QtdProdutoDesconto'] = $data['update']['valor']['alterar'][$j]['QtdProdutoDesconto'];
					$data['update']['valor']['alterar'][$j]['QtdProdutoIncremento'] = $data['update']['valor']['alterar'][$j]['QtdProdutoIncremento'];
					$data['update']['valor']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }

            #### Tab_Atributo_Select ####
            $data['update']['servico']['anterior'] = $this->Produtos_model->get_servico($data['produtos']['idTab_Produto']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idTab_Atributo_Select');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['inserir'][$j]['idTab_Atributo'] = $data['update']['servico']['inserir'][$j]['idTab_Atributo'];
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['alterar'][$j]['idTab_Catprod'] = $data['produtos']['Prodaux3'];
					$data['update']['servico']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['alterar'][$j]['idTab_Atributo'] = $data['update']['servico']['alterar'][$j]['idTab_Atributo'];
				}

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Produtos_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] =  $this->Produtos_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Produtos_model->delete_servico($data['update']['servico']['excluir']);

            }			
			
            #### Tab_Valor2 ####
            #$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select2($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao2']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "2");
            if (isset($data['item_promocao2']) || (!isset($data['item_promocao2']) && isset($data['update']['item_promocao2']['anterior']) ) ) {

                if (isset($data['item_promocao2']))
                    $data['item_promocao2'] = array_values($data['item_promocao2']);
                else
                    $data['item_promocao2'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao2'] = $this->basico->tratamento_array_multidimensional($data['item_promocao2'], $data['update']['item_promocao2']['anterior'], 'idTab_Opcao_Select');

                $max2 = count($data['update']['item_promocao2']['inserir']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['inserir'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao2']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao2']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao2']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max2 = count($data['update']['item_promocao2']['alterar']);
                for($j=0;$j<$max2;$j++) {
					$data['update']['item_promocao2']['alterar'][$j]['Item_Atributo'] = "2";
					$data['update']['item_promocao2']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao2']['inserir']))
                    $data['update']['item_promocao2']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao2']['inserir']);

                if (count($data['update']['item_promocao2']['alterar']))
                    $data['update']['item_promocao2']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao2']['alterar']);

                if (count($data['update']['item_promocao2']['excluir']))
                    $data['update']['item_promocao2']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao2']['excluir']);

            }
			
            #### Tab_Valor3 ####
            #$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select1($data['produtos']['idTab_Produto']);
			$data['update']['item_promocao3']['anterior'] = $this->Produtos_model->get_opcao_select($data['produtos']['idTab_Produto'], "1");
            if (isset($data['item_promocao3']) || (!isset($data['item_promocao3']) && isset($data['update']['item_promocao3']['anterior']) ) ) {

                if (isset($data['item_promocao3']))
                    $data['item_promocao3'] = array_values($data['item_promocao3']);
                else
                    $data['item_promocao3'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['item_promocao3'] = $this->basico->tratamento_array_multidimensional($data['item_promocao3'], $data['update']['item_promocao3']['anterior'], 'idTab_Opcao_Select');

                $max = count($data['update']['item_promocao3']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['inserir'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao3']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao3']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['item_promocao3']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
                }

                $max = count($data['update']['item_promocao3']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao3']['alterar'][$j]['Item_Atributo'] = "1";
					$data['update']['item_promocao3']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					
				}

                if (count($data['update']['item_promocao3']['inserir']))
                    $data['update']['item_promocao3']['bd']['inserir'] = $this->Produtos_model->set_opcao_select($data['update']['item_promocao3']['inserir']);

                if (count($data['update']['item_promocao3']['alterar']))
                    $data['update']['item_promocao3']['bd']['alterar'] =  $this->Produtos_model->update_opcao_select($data['update']['item_promocao3']['alterar']);

                if (count($data['update']['item_promocao3']['excluir']))
                    $data['update']['item_promocao3']['bd']['excluir'] = $this->Produtos_model->delete_opcao_select($data['update']['item_promocao3']['excluir']);

            }
			
            #### Tab_Produtos ####
            $data['update']['derivados']['anterior'] = $this->Produtos_model->get_derivados($data['produtos']['idTab_Produto']);
            if (isset($data['derivados']) || (!isset($data['derivados']) && isset($data['update']['derivados']['anterior']) ) ) {

                if (isset($data['derivados']))
                    $data['derivados'] = array_values($data['derivados']);
                else
                    $data['derivados'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['derivados'] = $this->basico->tratamento_array_multidimensional($data['derivados'], $data['update']['derivados']['anterior'], 'idTab_Produtos');

                $max = count($data['update']['derivados']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['inserir'][$j]['Valor_Produto'] = str_replace(',', '.', str_replace('.', '', $data['update']['derivados']['inserir'][$j]['Valor_Produto']));
					$data['update']['derivados']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['derivados']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['Prod_Serv'] = $data['produtos']['Prod_Serv'];
					$data['update']['derivados']['inserir'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['inserir'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['inserir'][$j]['Opcao_Atributo_2'];                
				}

                $max = count($data['update']['derivados']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['alterar'][$j]['Prod_Serv'] = $data['produtos']['Prod_Serv'];
					$data['update']['derivados']['alterar'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['NomeProdutos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
					$data['update']['derivados']['alterar'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].':'.$data['derivados'][$j]['Opcao_Atributo_1'].':'.$data['derivados'][$j]['Opcao_Atributo_2'];					
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_1'];
					$data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'] = $data['update']['derivados']['alterar'][$j]['Opcao_Atributo_2'];
					$data['update']['derivados']['alterar'][$j]['Valor_Produto'] = str_replace(',', '.', str_replace('.', '', $data['update']['derivados']['alterar'][$j]['Valor_Produto']));
				}

                if (count($data['update']['derivados']['inserir']))
                    $data['update']['derivados']['bd']['inserir'] = $this->Produtos_model->set_derivados($data['update']['derivados']['inserir']);

                if (count($data['update']['derivados']['alterar']))
                    $data['update']['derivados']['bd']['alterar'] =  $this->Produtos_model->update_derivados($data['update']['derivados']['alterar']);

                if (count($data['update']['derivados']['excluir']))
                    $data['update']['derivados']['bd']['excluir'] = $this->Produtos_model->delete_derivados($data['update']['derivados']['excluir']);

            }
			/*
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
						$data['campos'] = array_keys($data['query']);
						$data['anterior'] = array();
						//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
			//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
			*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				
				unset($_SESSION['Atributos']);
				unset($_SESSION['Servico']);
				unset($_SESSION['Produto']);
                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				#redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar4/' . $data['produtos']['idTab_Produto'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterar_BKP($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
                $data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['valor'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $data['produtos'] = $this->Produtos_model->get_produtos($id);
           
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['produtos']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
*/				
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'is_unique[Tab_Produto.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

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
        $data['form_open_path'] = 'produtos/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
        
 		(!$data['produtos']['Ativo']) ? $data['produtos']['Ativo'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo' => $this->basico->radio_checked($data['produtos']['Ativo'], 'Ativo', 'NS'),
        );
        ($data['produtos']['Ativo'] == 'S') ?
            $data['div']['Ativo'] = '' : $data['div']['Ativo'] = 'style="display: none;"';		
		
 		(!$data['produtos']['VendaSite']) ? $data['produtos']['VendaSite'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'VendaSite' => $this->basico->radio_checked($data['produtos']['VendaSite'], 'VendaSite', 'NS'),
        );
        ($data['produtos']['VendaSite'] == 'S') ?
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produto']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produto'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produto']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produto']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
					
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
		
    public function alterar_imagem($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
        ), TRUE));
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
			#'Aprovado',
        ), TRUE));

        //D� pra melhorar/encurtar esse trecho (que vai daqui at� onde estiver
        //comentado fim) mas por enquanto, se est� funcionando, vou deixar assim.

        
        (!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		
		(!$data['produtos']['TipoProduto']) ? $data['produtos']['TipoProduto'] = 'V' : FALSE;
		(!$data['produtos']['Categoria']) ? $data['produtos']['Categoria'] = 'P' : FALSE;
		(!$data['produtos']['UnidadeProduto']) ? $data['produtos']['UnidadeProduto'] = 'UNID' : FALSE;

        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Fornecedor' . $i) || $this->input->post('Convdesc' . $i) || $this->input->post('ValorProduto' . $i)) {
                $data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['valor'][$j]['Fornecedor'] = $this->input->post('Fornecedor' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
                $data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);

                $j++;
            }

        }
        $data['count']['PTCount'] = $j - 1;

        //Fim do trecho de c�digo que d� pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $data['produtos'] = $this->Produtos_model->get_produtos($id);
           
            #### Carrega os dados do cliente nas vari�ves de sess�o ####
            #$this->load->model('Cliente_model');
            #$_SESSION['Cliente'] = $this->Cliente_model->get_cliente($data['produtos']['idApp_Cliente'], TRUE);
            #$_SESSION['log']['idApp_Cliente'] = $_SESSION['Cliente']['idApp_Cliente'];

            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_valor($id);
            if (count($data['valor']) > 0) {
                $data['valor'] = array_combine(range(1, count($data['valor'])), array_values($data['valor']));
                $data['count']['PTCount'] = count($data['valor']);
/*
                if (isset($data['valor'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
*/				
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		
        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'C�digo', 'is_unique[Tab_Produto.CodProd]');
		$this->form_validation->set_rules('Cadastrar', 'Ap�s Recarregar, Retorne a chave para a posi��o "Sim"', 'trim|valid_aprovado');		

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

        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solu��o melhor para este campo

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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inser��o Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'UTF-8'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['Comissao'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['Comissao']));
			$data['produtos']['PesoProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['PesoProduto']));            
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produto']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produto'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produto']);

            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_valor($data['produtos']['idTab_Produto']);
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da vari�vel multidimensional, que ira separar o que deve ser inserido, alterado e exclu�do
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
					
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDAN�AS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterarlogo($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = $this->input->post(array(
			'idTab_Produto',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Produto',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Produtos'] = $data['query'] = $this->Produtos_model->get_produtos($id, TRUE);
        }
		
        if ($id)
            $data['file']['idTab_Produto'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaprodutos($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'produtos/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('produtos/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('produtos/form_perfil', $data);
            }
            else {
			
				$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';		
				$foto = $data['file']['Arquivo'];
				$diretorio = $dir.$foto;					
				$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/';

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
				$data['idSis_Arquivo'] = $this->Produtos_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('produtos/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Produtos_model->get_produtos($data['query']['idTab_Produto']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Produto'], TRUE);

					if ($data['auditoriaitem'] && $this->Produtos_model->update_produtos($data['query'], $data['query']['idTab_Produto']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'produtos/form_perfil/' . $data['query']['idTab_Produto'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Produtos']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Produtos']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/fotoproduto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Produtos']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produtos']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produtos']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/fotoproduto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Produtos']['Arquivo'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/produtos2/' . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }

    public function alterarlogoderivado($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['derivado'] = $this->input->post(array(
			'idTab_Produtos',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Produtos',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            //$data['derivado']['idTab_Produtos'] = $id;
			$_SESSION['Derivados'] = $data['derivado'] = $this->Produtos_model->get_produtosderivados($id, TRUE);
				/*
				echo "<pre>";
				print_r($data['derivado']);
				echo "</pre>";
				exit();
				*/
		
		}
		
        if ($id)
            $data['file']['idTab_Produtos'] = $id;
			
			//$_SESSION['File'] = $this->Produtos_model->get_produtosderivados($id, TRUE);
			/*
			echo "<pre>";
			print_r($_SESSION['File']);
			echo "</pre>";
			exit();
			*/
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaderivado($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'produtos/alterarlogoderivado';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
		/*
		echo "<pre>";
		print_r($data['file']);
		echo "</pre>";
		exit();
		*/		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('produtos/form_derivado', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('produtos/form_derivado', $data);
            }
            else {
			
				$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';		
				$foto = $data['file']['Arquivo'];
				$diretorio = $dir.$foto;					
				$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/';

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
				$data['idSis_Arquivo'] = $this->Produtos_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('produtos/form_derivado', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['derivado']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Produtos_model->get_produtosderivados($data['derivado']['idTab_Produtos']);
					$data['campos'] = array_keys($data['derivado']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['derivado'], $data['campos'], $data['derivado']['idTab_Produtos'], TRUE);

					if ($data['auditoriaitem'] && $this->Produtos_model->update_produtosderivados($data['derivado'], $data['derivado']['idTab_Produtos']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'produtos/form_derivado/' . $data['derivado']['idTab_Produtos'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Derivados']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Derivados']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/fotoproduto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Derivados']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Derivados']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Derivados']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/fotoproduto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Derivados']['Arquivo'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
						exit();
					}				
				}
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
        
                $this->Produtos_model->delete_produtos($id);

                $data['msg'] = '?m=1';

                unset($_SESSION['Atributos']);
				unset($_SESSION['Servico']);
				unset($_SESSION['Produto']);
				#redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
                exit();
            //}
        //}

        $this->load->view('basico/footer');
    }

    public function listar($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Produtos'] = $this->Produtos_model->get_cliente($id, TRUE);
        //$_SESSION['Produtos']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Produtos_model->list_produtos($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Produtos_model->list_produtos($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('produtos/tela_produtos', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Produtos'] = $this->Produtos_model->get_cliente($id, TRUE);
        #$_SESSION['Produtos']['idApp_Cliente'] = $id;
        $data['query'] = $this->Produtos_model->list_produtos(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('produtos/tela_produtos', $data);

        $this->load->view('basico/footer');
    }

}