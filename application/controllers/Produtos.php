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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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
				redirect(base_url() . 'relatorio/produtos2/' . $data['msg']);
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
				redirect(base_url() . 'relatorio/produtos2/' . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function categoria() {
		
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

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
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
				$this->input->post('Tam_Prod_Aux1' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i) ||
				$this->input->post('Ativo_Prod' . $i)){

				$data['derivados'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
				$data['derivados'][$j]['Cor_Prod'] = $this->input->post('Cor_Prod' . $i);
				$data['derivados'][$j]['Tam_Prod_Aux1'] = $this->input->post('Tam_Prod_Aux1' . $i);
				$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
				$data['derivados'][$j]['Ativo_Prod'] = $this->input->post('Ativo_Prod' . $i);
                $j++;
            }

        }
        $data['count']['PDCount'] = $j - 1;		
		*/
		
		
		// O código do produto não é aqui, é lá embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];
		
        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux2', 'Tipo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux1', 'Esp', 'required|trim');
		#$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');		
		
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'Código', 'is_unique[Tab_Produto.'.$data['produtos']['CodProd'].']');
		
		#$this->form_validation->set_rules('CodProd', 'Código', 'required|trim|is_unique[Tab_Produto.CodProd]');
		
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

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
            $this->load->view('produtos/form_produtos', $data);
        } else {
				
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
			#### Tab_Produto ####
			$data['produtos']['Desconto'] = 1;
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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
					$data['valor'][$j]['Convdesc'] = trim(mb_strtoupper($data['valor'][$j]['Convdesc'], 'ISO-8859-1'));
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
					$data['produto'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['produto'][$j]['Nome_Cor_Prod'], 'ISO-8859-1'));
				}
						/*
							echo '<br>';
						echo "<pre>";
						print_r($data['produto']);
						echo "</pre>";
						exit ();
						*/
                $data['produto']['idTab_Cor_Prod'] = $this->Produtos_model->set_produto($data['produto']);
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
					$data['procedimento'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['procedimento'][$j]['Nome_Tam_Prod'], 'ISO-8859-1'));
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
					#$data['derivados'][$j][$k]['Nome_Prod'] = trim(mb_strtoupper($nome_modelo.' '.$nome_tipo.' '.$nome_tamanho, 'ISO-8859-1'));
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
					$tipo = $data['tipo'][$j]['idTab_Cor_Prod'];
					$nome_tipo = $data['tipo'][$j]['Nome_Cor_Prod'];
					
					for($k=1;$k<=$data['count']['Tamanho'];$k++) {
						
						$tamanho = $data['tamanho'][$k]['idTab_Tam_Prod'];
						$nome_tamanho = $data['tamanho'][$k]['Nome_Tam_Prod'];

						$data['derivados'][$j][$k]['Cor_Prod'] = $tipo;
						$data['derivados'][$j][$k]['Tam_Prod_Aux1'] = $tamanho;
						$data['derivados'][$j][$k]['Cat_Prod'] = $categoria;
						$data['derivados'][$j][$k]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['derivados'][$j][$k]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['derivados'][$j][$k]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['derivados'][$j][$k]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
						$data['derivados'][$j][$k]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
						$data['derivados'][$j][$k]['Nome_Prod'] = trim(mb_strtoupper($nome_modelo.' '.$nome_tipo.' '.$nome_tamanho, 'ISO-8859-1'));
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
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
			$data['campos'] = array_keys($data['query']);
			$data['anterior'] = array();
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
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

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.
      
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
				$this->input->post('Tam_Prod_Aux1' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i) ||
				$this->input->post('Ativo_Prod' . $i)){

				$data['derivados'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
				$data['derivados'][$j]['Cor_Prod'] = $this->input->post('Cor_Prod' . $i);
				$data['derivados'][$j]['Tam_Prod_Aux1'] = $this->input->post('Tam_Prod_Aux1' . $i);
				$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
				$data['derivados'][$j]['Ativo_Prod'] = $this->input->post('Ativo_Prod' . $i);
                $j++;
            }

        }
        $data['count']['PDCount'] = $j - 1;		
		*/
		
		
		// O código do produto não é aqui, é lá embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];
		
        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Produto ####

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux2', 'Tipo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux1', 'Esp', 'required|trim');
		#$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim');		
		
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'Código', 'is_unique[Tab_Produto.'.$data['produtos']['CodProd'].']');
		
		#$this->form_validation->set_rules('CodProd', 'Código', 'required|trim|is_unique[Tab_Produto.CodProd]');
		
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

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
        $data['form_open_path'] = 'produtos/cadastrar4';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
		//if ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto'])
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
				
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];
			////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
			#### Tab_Produto ####
			$data['produtos']['Desconto'] = 1;
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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
					$data['valor'][$j]['Convdesc'] = trim(mb_strtoupper($data['valor'][$j]['Convdesc'], 'ISO-8859-1'));
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
					$data['produto'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['produto'][$j]['Nome_Cor_Prod'], 'ISO-8859-1'));
				}
						/*
						echo '<br>';
						echo "<pre>";
						print_r($data['produto']);
						echo "</pre>";
						exit ();
						*/
                $data['produto']['idTab_Cor_Prod'] = $this->Produtos_model->set_produto($data['produto']);
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
					$data['procedimento'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['procedimento'][$j]['Nome_Tam_Prod'], 'ISO-8859-1'));
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
					#$data['derivados'][$j][$k]['Nome_Prod'] = trim(mb_strtoupper($nome_modelo.' '.$nome_tipo.' '.$nome_tamanho, 'ISO-8859-1'));
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
					$tipo = $data['tipo'][$j]['idTab_Cor_Prod'];
					$nome_tipo = $data['tipo'][$j]['Nome_Cor_Prod'];
					
					for($k=1;$k<=$data['count']['Tamanho'];$k++) {
						
						$tamanho = $data['tamanho'][$k]['idTab_Tam_Prod'];
						$nome_tamanho = $data['tamanho'][$k]['Nome_Tam_Prod'];

						$data['derivados'][$j][$k]['Cor_Prod'] = $tipo;
						$data['derivados'][$j][$k]['Tam_Prod_Aux1'] = $tamanho;
						$data['derivados'][$j][$k]['Cat_Prod'] = $categoria;
						$data['derivados'][$j][$k]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						$data['derivados'][$j][$k]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
						$data['derivados'][$j][$k]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
						$data['derivados'][$j][$k]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
						$data['derivados'][$j][$k]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
						$data['derivados'][$j][$k]['Nome_Prod'] = trim(mb_strtoupper($nome_modelo.' '.$nome_tipo.' '.$nome_tamanho, 'ISO-8859-1'));
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
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
			$data['campos'] = array_keys($data['query']);
			$data['anterior'] = array();
			//*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
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
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produto ####
            'idTab_Produto',			
            'TipoProduto',
			'Categoria',
			'UnidadeProduto',
			#'CodProd',
			'Fornecedor',
			'ValorProdutoSite',
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			#'Prodaux3',
			'Prodaux4',
			'Ativo',
			'VendaSite',
			#'Aprovado',
        ), TRUE));

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
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

            if ($this->input->post('Cat_Prod' . $i)) {
				$data['servico'][$j]['idTab_Cat_Prod'] = $this->input->post('idTab_Cat_Prod' . $i);
                $data['servico'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('Nome_Cor_Prod' . $i) || $this->input->post('Cor_Prod' . $i) || 
				$this->input->post('Valor_Cor_Prod' . $i) || $this->input->post('idTab_Promocao' . $i)) {
				$data['produto'][$j]['idTab_Cor_Prod'] = $this->input->post('idTab_Cor_Prod' . $i);
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

            if ($this->input->post('Nome_Tam_Prod' . $i) || $this->input->post('Tam_Prod' . $i) ||
				$this->input->post('Fator_Tam_Prod' . $i) || $this->input->post('idTab_Promocao' . $i)){
				$data['procedimento'][$j]['idTab_Tam_Prod'] = $this->input->post('idTab_Tam_Prod' . $i);
                $data['procedimento'][$j]['Nome_Tam_Prod'] = $this->input->post('Nome_Tam_Prod' . $i);
				$data['procedimento'][$j]['Tam_Prod'] = $this->input->post('Tam_Prod' . $i);
				$data['procedimento'][$j]['Fator_Tam_Prod'] = $this->input->post('Fator_Tam_Prod' . $i);
				$data['procedimento'][$j]['idTab_Promocao'] = $this->input->post('idTab_Promocao' . $i);
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;
		

		$j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i) || $this->input->post('Cor_Prod' . $i) || 
				$this->input->post('Tam_Prod_Aux1' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i)){
				$data['derivados'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				#$data['derivados'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
				$data['derivados'][$j]['Cor_Prod'] = $this->input->post('Cor_Prod' . $i);
				$data['derivados'][$j]['Tam_Prod_Aux1'] = $this->input->post('Tam_Prod_Aux1' . $i);
				#$data['derivados'][$j]['Cod_Prod'] = $this->input->post('Cod_Prod' . $i);
				$data['derivados'][$j]['Nome_Prod'] = $this->input->post('Nome_Prod' . $i);
                $j++;
            }
        }
        $data['count']['PDCount'] = $j - 1;
		
		
		
		// o código do produto não é aqui, é la embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];		
		
        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $_SESSION['Produto'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
           
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
			
            #### Tab_Cat_Prod ####
            $data['servico'] = $this->Produtos_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);
/*
                if (isset($data['servico'])) {

                    for($j=1; $j <= $data['count']['SCount']; $j++)
						
                }
*/				
            }
			
            #### Tab_Cor_Prod ####
            $data['produto'] = $this->Produtos_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);
/*
                if (isset($data['produto'])) {

                    for($j=1; $j <= $data['count']['PCount']; $j++)
						
                }
*/				
            }
			
            #### Tab_Tam_Prod ####
            $data['procedimento'] = $this->Produtos_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);
/*
                if (isset($data['procedimento'])) {

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

		#$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux2', 'Tipo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux1', 'Esp', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'Código', 'is_unique_by_id[Tab_Produto.'.$data['produtos']['CodProd'].'.' . $data['produtos']['idTab_Produto'] . ']');
		
		#$this->form_validation->set_rules('CodProd', 'Código', 'required|trim|is_unique_by_id[Tab_Produto.CodProd.' . $data['produtos']['idTab_Produto'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux14();
		#$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Cor_Prod'] = $this->Basico_model->select_cor_prod();
		$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux14();
		$data['select']['Tam_Prod_Aux1'] = $this->Basico_model->select_tam_prod();
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'produtos/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
		$data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['valor']) && ($data['valor'][0]['DataValor'] || $data['valor'][0]['Desconto']))
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'ISO-8859-1'));
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
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['update']['valor']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }
			
            #### Tab_Cat_Prod ####
            $data['update']['servico']['anterior'] = $this->Produtos_model->get_servico($data['produtos']['idTab_Produto']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idTab_Cat_Prod');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Produtos_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] =  $this->Produtos_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Produtos_model->delete_servico($data['update']['servico']['excluir']);

            }
			
            #### Tab_Cor_Prod ####
            $data['update']['produto']['anterior'] = $this->Produtos_model->get_produto($data['produtos']['idTab_Produto']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idTab_Cor_Prod');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['produto']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['produto']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['produto']['inserir'][$j]['Valor_Cor_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['Valor_Cor_Prod']));
					$data['update']['produto']['inserir'][$j]['idTab_Promocao'] = $data['update']['produto']['inserir'][$j]['idTab_Promocao'];
					$data['update']['produto']['inserir'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['update']['produto']['inserir'][$j]['Nome_Cor_Prod'], 'ISO-8859-1'));
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['alterar'][$j]['Valor_Cor_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['Valor_Cor_Prod']));
					$data['update']['produto']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Promocao'] = $data['update']['produto']['alterar'][$j]['idTab_Promocao'];
					$data['update']['produto']['alterar'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['update']['produto']['alterar'][$j]['Nome_Cor_Prod'], 'ISO-8859-1'));
				}

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Produtos_model->set_produto($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Produtos_model->update_produto($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Produtos_model->delete_produto($data['update']['produto']['excluir']);

            }
			
            #### Tab_Tam_Prod ####
            $data['update']['procedimento']['anterior'] = $this->Produtos_model->get_procedimento($data['produtos']['idTab_Produto']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idTab_Tam_Prod');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['procedimento']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['procedimento']['inserir'][$j]['Fator_Tam_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['procedimento']['inserir'][$j]['Fator_Tam_Prod']));
					$data['update']['procedimento']['inserir'][$j]['idTab_Promocao'] = $data['update']['procedimento']['inserir'][$j]['idTab_Promocao'];
					$data['update']['procedimento']['inserir'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['update']['procedimento']['inserir'][$j]['Nome_Tam_Prod'], 'ISO-8859-1'));
				}

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['procedimento']['alterar'][$j]['Fator_Tam_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['procedimento']['alterar'][$j]['Fator_Tam_Prod']));
					$data['update']['procedimento']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['procedimento']['alterar'][$j]['idTab_Promocao'] = $data['update']['procedimento']['alterar'][$j]['idTab_Promocao'];
					$data['update']['procedimento']['alterar'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['update']['procedimento']['alterar'][$j]['Nome_Tam_Prod'], 'ISO-8859-1'));
				}

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Produtos_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Produtos_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Produtos_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }
			
            #### Tab_Produtos ####
            $data['update']['derivados']['anterior'] = $this->Produtos_model->get_derivados($data['produtos']['idTab_Produto']);
            if (isset($data['derivados']) || (!isset($data['derivados']) && isset($data['update']['derivados']['anterior']) ) ) {

                if (isset($data['derivados']))
                    $data['derivados'] = array_values($data['derivados']);
                else
                    $data['derivados'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['derivados'] = $this->basico->tratamento_array_multidimensional($data['derivados'], $data['update']['derivados']['anterior'], 'idTab_Produtos');

                $max = count($data['update']['derivados']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['derivados']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
					$data['update']['derivados']['inserir'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].'.'.$data['derivados'][$j]['Cor_Prod'].'.'.$data['derivados'][$j]['Tam_Prod_Aux1'];
					$data['update']['derivados']['inserir'][$j]['Cor_Prod'] = $data['update']['derivados']['inserir'][$j]['Cor_Prod'];
					$data['update']['derivados']['inserir'][$j]['Tam_Prod_Aux1'] = $data['update']['derivados']['inserir'][$j]['Tam_Prod_Aux1'];                
				}

                $max = count($data['update']['derivados']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
					$data['update']['derivados']['alterar'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].'.'.$data['derivados'][$j]['Cor_Prod'].'.'.$data['derivados'][$j]['Tam_Prod_Aux1'];					
					$data['update']['derivados']['alterar'][$j]['Cor_Prod'] = $data['update']['derivados']['alterar'][$j]['Cor_Prod'];
					$data['update']['derivados']['alterar'][$j]['Tam_Prod_Aux1'] = $data['update']['derivados']['alterar'][$j]['Tam_Prod_Aux1'];
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
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

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
			#'CodProd',
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

        //Dá pra melhorar/encurtar esse trecho (que vai daqui até onde estiver
        //comentado fim) mas por enquanto, se está funcionando, vou deixar assim.

        
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

            if ($this->input->post('Cat_Prod' . $i)) {
				$data['servico'][$j]['idTab_Cat_Prod'] = $this->input->post('idTab_Cat_Prod' . $i);
                $data['servico'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
                $j++;
            }

        }
        $data['count']['SCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PCount']; $i++) {

            if ($this->input->post('Nome_Cor_Prod' . $i) || $this->input->post('Cor_Prod' . $i) || 
				$this->input->post('Valor_Cor_Prod' . $i) || $this->input->post('idTab_Promocao' . $i)) {
				$data['produto'][$j]['idTab_Cor_Prod'] = $this->input->post('idTab_Cor_Prod' . $i);
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

            if ($this->input->post('Nome_Tam_Prod' . $i) || $this->input->post('Tam_Prod' . $i) ||
				$this->input->post('Fator_Tam_Prod' . $i) || $this->input->post('idTab_Promocao' . $i)){
				$data['procedimento'][$j]['idTab_Tam_Prod'] = $this->input->post('idTab_Tam_Prod' . $i);
                $data['procedimento'][$j]['Nome_Tam_Prod'] = $this->input->post('Nome_Tam_Prod' . $i);
				$data['procedimento'][$j]['Tam_Prod'] = $this->input->post('Tam_Prod' . $i);
				$data['procedimento'][$j]['Fator_Tam_Prod'] = $this->input->post('Fator_Tam_Prod' . $i);
				$data['procedimento'][$j]['idTab_Promocao'] = $this->input->post('idTab_Promocao' . $i);
                $j++;
            }

        }
        $data['count']['PMCount'] = $j - 1;
		

		$j = 1;
        for ($i = 1; $i <= $data['count']['PDCount']; $i++) {

            if ($this->input->post('Cat_Prod' . $i) || $this->input->post('Cor_Prod' . $i) || $this->input->post('Valor_Produto' . $i) || 
				$this->input->post('Tam_Prod_Aux1' . $i) || $this->input->post('Cod_Prod' . $i) || $this->input->post('Nome_Prod' . $i)){
				$data['derivados'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				#$data['derivados'][$j]['Cat_Prod'] = $this->input->post('Cat_Prod' . $i);
				$data['derivados'][$j]['Cor_Prod'] = $this->input->post('Cor_Prod' . $i);
				$data['derivados'][$j]['Tam_Prod_Aux1'] = $this->input->post('Tam_Prod_Aux1' . $i);
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
		
		
		
		// o código do produto não é aqui, é la embaixo
		//$data['produtos']['CodProd'] = $data['produtos']['Prodaux4'].$data['produtos']['Prodaux2'].$data['produtos']['Prodaux1'];		
		
        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Produto ####
            $_SESSION['Produto'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
           
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
			
            #### Tab_Cat_Prod ####
            $data['servico'] = $this->Produtos_model->get_servico($id);
            if (count($data['servico']) > 0) {
                $data['servico'] = array_combine(range(1, count($data['servico'])), array_values($data['servico']));
                $data['count']['SCount'] = count($data['servico']);
/*
                if (isset($data['servico'])) {

                    for($j=1; $j <= $data['count']['SCount']; $j++)
						
                }
*/				
            }
			
            #### Tab_Cor_Prod ####
            $data['produto'] = $this->Produtos_model->get_produto($id);
            if (count($data['produto']) > 0) {
                $data['produto'] = array_combine(range(1, count($data['produto'])), array_values($data['produto']));
                $data['count']['PCount'] = count($data['produto']);
/*
                if (isset($data['produto'])) {

                    for($j=1; $j <= $data['count']['PCount']; $j++)
						
                }
*/				
            }
			
            #### Tab_Tam_Prod ####
            $data['procedimento'] = $this->Produtos_model->get_procedimento($id);
            if (count($data['procedimento']) > 0) {
                $data['procedimento'] = array_combine(range(1, count($data['procedimento'])), array_values($data['procedimento']));
                $data['count']['PMCount'] = count($data['procedimento']);
/*
                if (isset($data['procedimento'])) {

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

		$this->form_validation->set_rules('Prodaux3', 'Categoria', 'required|trim');
		#$this->form_validation->set_rules('Prodaux4', 'Modelo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux2', 'Tipo', 'required|trim');
		#$this->form_validation->set_rules('Prodaux1', 'Esp', 'required|trim');
		$this->form_validation->set_rules('Produtos', 'Produto', 'required|trim'); 		
		
		#$this->form_validation->set_rules($data['produtos']['CodProd'], 'Código', 'is_unique_by_id[Tab_Produto.'.$data['produtos']['CodProd'].'.' . $data['produtos']['idTab_Produto'] . ']');
		
		#$this->form_validation->set_rules('CodProd', 'Código', 'required|trim|is_unique_by_id[Tab_Produto.CodProd.' . $data['produtos']['idTab_Produto'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['Desconto'] = $this->Basico_model->select_desconto();		
		$data['select']['TipoProduto'] = $this->Basico_model->select_tipoproduto();
		$data['select']['Categoria'] = $this->Basico_model->select_categoria();
		#$data['select']['Fornecedor'] = $this->Fornecedor_model->select_Fornecedor();
        $data['select']['UnidadeProduto'] = $this->Basico_model->select_unidadeproduto();
		$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux14();
		#$data['select']['Prodaux1'] = $this->Prodaux1_model->select_prodaux1();
		$data['select']['Prodaux2'] = $this->Prodaux2_model->select_prodaux2();
		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();
		$data['select']['Cat_Prod'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Cor_Prod'] = $this->Basico_model->select_cor_prod();
		$data['select']['Tam_Prod'] = $this->Prodaux1_model->select_prodaux14();
		$data['select']['Tam_Prod_Aux1'] = $this->Basico_model->select_tam_prod();
		$data['select']['idTab_Promocao'] = $this->Basico_model->select_promocao();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();		
		$data['select']['VendaSite'] = $this->Basico_model->select_status_sn();
		
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
                    $data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'ISO-8859-1'));
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
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'ISO-8859-1'));
					$data['update']['valor']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }
			
            #### Tab_Cat_Prod ####
            $data['update']['servico']['anterior'] = $this->Produtos_model->get_servico($data['produtos']['idTab_Produto']);
            if (isset($data['servico']) || (!isset($data['servico']) && isset($data['update']['servico']['anterior']) ) ) {

                if (isset($data['servico']))
                    $data['servico'] = array_values($data['servico']);
                else
                    $data['servico'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['servico'] = $this->basico->tratamento_array_multidimensional($data['servico'], $data['update']['servico']['anterior'], 'idTab_Cat_Prod');

                $max = count($data['update']['servico']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['servico']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['servico']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['servico']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['servico']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
                }

                $max = count($data['update']['servico']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['servico']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
				}

                if (count($data['update']['servico']['inserir']))
                    $data['update']['servico']['bd']['inserir'] = $this->Produtos_model->set_servico($data['update']['servico']['inserir']);

                if (count($data['update']['servico']['alterar']))
                    $data['update']['servico']['bd']['alterar'] =  $this->Produtos_model->update_servico($data['update']['servico']['alterar']);

                if (count($data['update']['servico']['excluir']))
                    $data['update']['servico']['bd']['excluir'] = $this->Produtos_model->delete_servico($data['update']['servico']['excluir']);

            }
			
            #### Tab_Cor_Prod ####
            $data['update']['produto']['anterior'] = $this->Produtos_model->get_produto($data['produtos']['idTab_Produto']);
            if (isset($data['produto']) || (!isset($data['produto']) && isset($data['update']['produto']['anterior']) ) ) {

                if (isset($data['produto']))
                    $data['produto'] = array_values($data['produto']);
                else
                    $data['produto'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['produto'] = $this->basico->tratamento_array_multidimensional($data['produto'], $data['update']['produto']['anterior'], 'idTab_Cor_Prod');

                $max = count($data['update']['produto']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['produto']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['produto']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['produto']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['produto']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['produto']['inserir'][$j]['Valor_Cor_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['inserir'][$j]['Valor_Cor_Prod']));
					$data['update']['produto']['inserir'][$j]['idTab_Promocao'] = $data['update']['produto']['inserir'][$j]['idTab_Promocao'];
					$data['update']['produto']['inserir'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['update']['produto']['inserir'][$j]['Nome_Cor_Prod'], 'ISO-8859-1'));
				}

                $max = count($data['update']['produto']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['produto']['alterar'][$j]['Valor_Cor_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['produto']['alterar'][$j]['Valor_Cor_Prod']));
					$data['update']['produto']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['produto']['alterar'][$j]['idTab_Promocao'] = $data['update']['produto']['alterar'][$j]['idTab_Promocao'];
					$data['update']['produto']['alterar'][$j]['Nome_Cor_Prod'] = trim(mb_strtoupper($data['update']['produto']['alterar'][$j]['Nome_Cor_Prod'], 'ISO-8859-1'));
				}

                if (count($data['update']['produto']['inserir']))
                    $data['update']['produto']['bd']['inserir'] = $this->Produtos_model->set_produto($data['update']['produto']['inserir']);

                if (count($data['update']['produto']['alterar']))
                    $data['update']['produto']['bd']['alterar'] =  $this->Produtos_model->update_produto($data['update']['produto']['alterar']);

                if (count($data['update']['produto']['excluir']))
                    $data['update']['produto']['bd']['excluir'] = $this->Produtos_model->delete_produto($data['update']['produto']['excluir']);

            }
			
            #### Tab_Tam_Prod ####
            $data['update']['procedimento']['anterior'] = $this->Produtos_model->get_procedimento($data['produtos']['idTab_Produto']);
            if (isset($data['procedimento']) || (!isset($data['procedimento']) && isset($data['update']['procedimento']['anterior']) ) ) {

                if (isset($data['procedimento']))
                    $data['procedimento'] = array_values($data['procedimento']);
                else
                    $data['procedimento'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['procedimento'] = $this->basico->tratamento_array_multidimensional($data['procedimento'], $data['update']['procedimento']['anterior'], 'idTab_Tam_Prod');

                $max = count($data['update']['procedimento']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['procedimento']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['procedimento']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['procedimento']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['procedimento']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['procedimento']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['procedimento']['inserir'][$j]['Fator_Tam_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['procedimento']['inserir'][$j]['Fator_Tam_Prod']));
					$data['update']['procedimento']['inserir'][$j]['idTab_Promocao'] = $data['update']['procedimento']['inserir'][$j]['idTab_Promocao'];
					$data['update']['procedimento']['inserir'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['update']['procedimento']['inserir'][$j]['Nome_Tam_Prod'], 'ISO-8859-1'));
				}

                $max = count($data['update']['procedimento']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['procedimento']['alterar'][$j]['Fator_Tam_Prod'] = str_replace(',', '.', str_replace('.', '', $data['update']['procedimento']['alterar'][$j]['Fator_Tam_Prod']));
					$data['update']['procedimento']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['procedimento']['alterar'][$j]['idTab_Promocao'] = $data['update']['procedimento']['alterar'][$j]['idTab_Promocao'];
					$data['update']['procedimento']['alterar'][$j]['Nome_Tam_Prod'] = trim(mb_strtoupper($data['update']['procedimento']['alterar'][$j]['Nome_Tam_Prod'], 'ISO-8859-1'));
				}

                if (count($data['update']['procedimento']['inserir']))
                    $data['update']['procedimento']['bd']['inserir'] = $this->Produtos_model->set_procedimento($data['update']['procedimento']['inserir']);

                if (count($data['update']['procedimento']['alterar']))
                    $data['update']['procedimento']['bd']['alterar'] =  $this->Produtos_model->update_procedimento($data['update']['procedimento']['alterar']);

                if (count($data['update']['procedimento']['excluir']))
                    $data['update']['procedimento']['bd']['excluir'] = $this->Produtos_model->delete_procedimento($data['update']['procedimento']['excluir']);

            }
			
            #### Tab_Produtos ####
            $data['update']['derivados']['anterior'] = $this->Produtos_model->get_derivados($data['produtos']['idTab_Produto']);
            if (isset($data['derivados']) || (!isset($data['derivados']) && isset($data['update']['derivados']['anterior']) ) ) {

                if (isset($data['derivados']))
                    $data['derivados'] = array_values($data['derivados']);
                else
                    $data['derivados'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['derivados'] = $this->basico->tratamento_array_multidimensional($data['derivados'], $data['update']['derivados']['anterior'], 'idTab_Produtos');

                $max = count($data['update']['derivados']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['derivados']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['derivados']['inserir'][$j]['idTab_Produto'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['inserir'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
					$data['update']['derivados']['inserir'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].'.'.$data['derivados'][$j]['Cor_Prod'].'.'.$data['derivados'][$j]['Tam_Prod_Aux1'];
					$data['update']['derivados']['inserir'][$j]['Cor_Prod'] = $data['update']['derivados']['inserir'][$j]['Cor_Prod'];
					$data['update']['derivados']['inserir'][$j]['Tam_Prod_Aux1'] = $data['update']['derivados']['inserir'][$j]['Tam_Prod_Aux1'];                
				}

                $max = count($data['update']['derivados']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['derivados']['alterar'][$j]['idTab_Modelo'] = $data['produtos']['idTab_Produto'];
					$data['update']['derivados']['alterar'][$j]['Nome_Prod'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
					$data['update']['derivados']['alterar'][$j]['Cod_Prod'] = $data['produtos']['idTab_Produto'].'.'.$data['derivados'][$j]['Cor_Prod'].'.'.$data['derivados'][$j]['Tam_Prod_Aux1'];					
					$data['update']['derivados']['alterar'][$j]['Cor_Prod'] = $data['update']['derivados']['alterar'][$j]['Cor_Prod'];
					$data['update']['derivados']['alterar'][$j]['Tam_Prod_Aux1'] = $data['update']['derivados']['alterar'][$j]['Tam_Prod_Aux1'];
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
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produto'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar3/' . $data['produtos']['idTab_Produto'] . $data['msg']);
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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
            'Comissao',
			'PesoProduto',
            'Produtos',
			'Prodaux1',
			'Prodaux2',
			'Prodaux3',
			'Prodaux4',
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
            $this->load->view('produtos/form_produtos', $data);
        } else {
			
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produto ####
			$data['produtos']['Produtos'] = trim(mb_strtoupper($data['produtos']['Produtos'], 'ISO-8859-1'));
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
        
                $this->Produtos_model->delete_produtos($id);

                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
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
