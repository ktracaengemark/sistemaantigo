<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Produtos_model', 'Prodaux1_model', 'Prodaux2_model', 'Prodaux3_model', 'Fornecedor_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
        $this->load->driver('session');

        
        $this->load->view('basico/header');
        #$this->load->view('basico/nav_principal');

        
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('produtos/tela_index', $data);

        #load footer view
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
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
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



        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
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
		$data['select']['Prodaux33'] = $this->Produtos_model->select_prodaux33();
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
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
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
					$data['valor']['Convdesc'] = trim(mb_strtoupper($data['valor']['Convdesc'], 'ISO-8859-1'));
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
			'ValorProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Ativo',
			'VendaSite',			
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
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

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
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
		$data['select']['Prodaux33'] = $this->Produtos_model->select_prodaux33();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos2/cadastrar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor'])
        if (isset($data['valor']))
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

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
			$data['produtos']['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProduto']));
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
                    $data['valor'][$j]['Convdesc'] = trim(mb_strtoupper($data['valor'][$j]['Convdesc'], 'ISO-8859-1'));
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
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
				redirect(base_url() . 'relatorio2/produtos2/' . $data['msg']);
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
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',           
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
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



        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
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
		$data['select']['Prodaux33'] = $this->Produtos_model->select_prodaux33();
		$data['select']['Produtos'] = $this->Relatorio_model->select_produtos();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'produtos2/cadastrar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor'])
        if (isset($data['valor']))
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

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));
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
					$data['valor']['Convdesc'] = trim(mb_strtoupper($data['valor']['Convdesc'], 'ISO-8859-1'));
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
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
				redirect(base_url() . 'relatorio2/produtos2/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function alterar2($id = FALSE) {

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
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			'CodProd',
			'Fornecedor',
			'ValorProdutoSite',            
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Ativo',
			'VendaSite',			
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
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

        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $data['produtos'] = $this->Produtos_model->get_produtos($id);
           
            #### Carrega os dados do cliente nas variáves de sessão ####
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
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
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
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos2/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Fornecedor']))
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
            $this->load->view('produtos/form_produtos2', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['produtos']['ValorProdutoSite'] = str_replace(',', '.', str_replace('.', '', $data['produtos']['ValorProdutoSite']));

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

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
					
                }

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'ISO-8859-1'));
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
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Produto'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos2', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio2/produtos2/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function excluir2($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        
                $this->Produtos_model->delete_produtos($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio2/produtos2/' . $data['msg']);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
