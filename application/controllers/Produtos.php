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
			'TipoCatprod',
        ), TRUE));		
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',  
            'idTab_Catprod',
        ), TRUE));

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
		$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();	
		$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		
        $data['titulo'] = 'Cadastrar Categoria';
        $data['form_open_path'] = 'produtos/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

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

        
		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);		
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('idTab_Catprod', 'Produto', 'required|trim');		
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');	
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
            #### Tab_Produtos ####
			$data['produtos']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['produtos']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['produtos']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['produtos']['idTab_Produtos'] = $this->Produtos_model->set_produtos($data['produtos']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            if ($data['idTab_Produtos'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
	
    public function tela($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'idCat_Atributo',
			'idCat_Opcao',
			'idAtributo_Opcao',
			'idCat_Produto',
			'Codigo',
        ), TRUE));	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',			
            'idTab_Catprod', 
            'idTab_Produto',
			'Opcao_Atributo_1',
			'Opcao_Atributo_2', 
            'Cod_Prod',
        ), TRUE));


        if ($id) {
            #### Tab_Produtos ####
           $_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
        
            #### Tab_Atributo_Select ####
            $_SESSION['Atributo'] = $data['atributo'] = $this->Produtos_model->get_atributos($_SESSION['Produtos']['idTab_Catprod']);
            if (count($data['atributo']) > 0) {
                $data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
                $conta_atributos = count($data['atributo']);
				/*
				echo '<br>';
				  echo "<pre>";
				  print_r($conta_atributos);
				  echo '<br>';
				  echo "</pre>";
				 */ 
				if (isset($data['atributo'])) {
					if ($conta_atributos >= 2) {
						for($j=1; $j <= $conta_atributos; $j++){
							$_SESSION['Atributo'][$j]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
							$_SESSION['Atributo'][$j]['Atributo'] = $data['atributo'][$j]['Atributo'];
							/*
							  echo '<br>';
							  echo "<pre>";
							  //print_r($conta_atributos);
							  echo '<br>';
							  print_r($_SESSION['Atributo'][$j]['idTab_Atributo']);
							  echo '<br>';
							  print_r($_SESSION['Atributo'][$j]['Atributo']);
							  echo "</pre>";					
							*/
						}
					}else{
						for($j=1; $j <= $conta_atributos; $j++){
							$_SESSION['Atributo'][1]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
							$_SESSION['Atributo'][1]['Atributo'] = $data['atributo'][$j]['Atributo'];
						}
						$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
						$_SESSION['Atributo'][2]['Atributo'] = FALSE;
					}
				}
				/*
				$item_atributo = 1;	
				foreach($data['atributo'] as $atributo_view){
					$_SESSION['Atributo'][$item_atributo]['idTab_Atributo'] = $atributo_view['idTab_Atributo'];
					$_SESSION['Atributo'][$item_atributo]['Atributo'] = $atributo_view['Atributo'];
					$item_atributo++;
				}
				*/
				
            }else{
				$_SESSION['Atributo'][1]['idTab_Atributo'] = FALSE;
				$_SESSION['Atributo'][1]['Atributo'] = FALSE;
				$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
				$_SESSION['Atributo'][2]['Atributo'] = FALSE;
			}		
		
		
		}

         // exit ();
		
		
		//$data['cadastrar']['Codigo'] = $data['produtos']['idTab_Catprod'] . ':' . $data['produtos']['idTab_Produto'] . ':' . $data['produtos']['Opcao_Atributo_1'] . ':' . $data['produtos']['Opcao_Atributo_2'];
		  
	

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
		$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
		$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
		$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();	
		$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
		
        $data['titulo'] = 'Tela';
        $data['form_open_path'] = 'produtos/tela';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 4;

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

		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
		
		$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
		$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
		
		$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
		$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
		
		$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
		$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
		
		$data['q'] = $this->Produtos_model->list_produtos($data['produtos'], TRUE);
		$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('idTab_Produto', 'Produto', 'required|trim');
		$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
		//$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');			
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
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['cadastrar']['Codigo']);
			echo "</pre>";
			exit ();
			*/
		
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produtos ####

			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produtos'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);


            //if ($data['idTab_Produtos'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//unset($data['cadastrar']['Codigo']);
				//unset($_SESSION['Produtos']);
                //unset($_SESSION['Atributos']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/alterar2/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
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
			'TipoCatprod',
			'idCat_Atributo',
			'idCat_Opcao',
			'idAtributo_Opcao',
			'idCat_Produto',
			'Codigo',
        ), TRUE));	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',			
            'idTab_Catprod', 
            'idTab_Produto',
			'Opcao_Atributo_1',
			'Opcao_Atributo_2', 
            'Cod_Prod', 
            'Nome_Prod',
        ), TRUE));


        if ($id) {
            #### Tab_Produtos ####
           $_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);

		}
		#### Tab_Atributo_Select ####
		$_SESSION['Atributo'] = $data['atributo'] = $this->Produtos_model->get_atributos($_SESSION['Produtos']['idTab_Catprod']);
		
		$conta_atributos = count($data['atributo']);
		if (count($data['atributo']) > 0) {
			$data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
			
			/*
			echo '<br>';
			  echo "<pre>";
			  print_r($conta_atributos);
			  echo '<br>';
			  echo "</pre>";
			 */ 
			if (isset($data['atributo'])) {
				if ($conta_atributos >= 2) {
					for($j=1; $j <= $conta_atributos; $j++){
						$_SESSION['Atributo'][$j]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
						$_SESSION['Atributo'][$j]['Atributo'] = $data['atributo'][$j]['Atributo'];
						/*
						  echo '<br>';
						  echo "<pre>";
						  //print_r($conta_atributos);
						  echo '<br>';
						  print_r($_SESSION['Atributo'][$j]['idTab_Atributo']);
						  echo '<br>';
						  print_r($_SESSION['Atributo'][$j]['Atributo']);
						  echo "</pre>";					
						*/
					}
				}else{
					for($j=1; $j <= $conta_atributos; $j++){
						$_SESSION['Atributo'][1]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
						$_SESSION['Atributo'][1]['Atributo'] = $data['atributo'][$j]['Atributo'];
					}
					$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['Atributo'] = FALSE;
				}
			}
			/*
			$item_atributo = 1;	
			foreach($data['atributo'] as $atributo_view){
				$_SESSION['Atributo'][$item_atributo]['idTab_Atributo'] = $atributo_view['idTab_Atributo'];
				$_SESSION['Atributo'][$item_atributo]['Atributo'] = $atributo_view['Atributo'];
				$item_atributo++;
			}
			*/
			
		}else{
			$_SESSION['Atributo'][1]['idTab_Atributo'] = FALSE;
			$_SESSION['Atributo'][1]['Atributo'] = FALSE;
			$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
			$_SESSION['Atributo'][2]['Atributo'] = FALSE;
		}		
		
		/*
          echo '<br>';
          echo "<pre>";
          print_r($_SESSION['Produtos']);
          echo "</pre>";
          exit ();
		 */
		//$data['cadastrar']['Codigo'] = $data['produtos']['idTab_Catprod'] . ':' . $data['produtos']['idTab_Produto'] . ':' . $data['produtos']['Opcao_Atributo_1'] . ':' . $data['produtos']['Opcao_Atributo_2'];
		  
		

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
		$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();
		$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
		$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
		$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
		$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();		
		$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();
		$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
		
        $data['titulo'] = 'Cadastrar Produto';
        $data['form_open_path'] = 'produtos/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

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

		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
		
		$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
		$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
		
		$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
		$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
		
		$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
		$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
		
		$data['q'] = $this->Produtos_model->list_produtos($_SESSION['Produtos'], TRUE);
		$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		//$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('idTab_Produto', 'Produto', 'required|trim');
		$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');
		if($conta_atributos > 0){
			if($conta_atributos == 1){
				$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
			}elseif($conta_atributos == 2){
				$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
				$this->form_validation->set_rules('Opcao_Atributo_2', $_SESSION['Atributo'][2]['Atributo'], 'required|trim');
			}
		}          

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtos/form_produtos', $data);
        } else {
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['cadastrar']['Codigo']);
			echo "</pre>";
			exit ();
			*/
		
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produtos ####

			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produtos'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);


            //if ($data['idTab_Produtos'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//unset($data['cadastrar']['Codigo']);
				//unset($_SESSION['Produtos']);
                //unset($_SESSION['Atributos']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				//redirect(base_url() . 'produtos/alterar2/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
				redirect(base_url() . 'produtos/tela/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
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
			'TipoCatprod',
			'idCat_Atributo',
			'idCat_Opcao',
			'idAtributo_Opcao',
			'idCat_Produto',
			'Codigo',
        ), TRUE));	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',			
            'idTab_Catprod', 
            'idTab_Produto',
			'Opcao_Atributo_1',
			'Opcao_Atributo_2', 
            'Cod_Prod', 
            'Nome_Prod',
        ), TRUE));


        if ($id) {
            #### Tab_Produtos ####
           $_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
        }
		#### Tab_Atributo_Select ####
		$_SESSION['Atributo'] = $data['atributo'] = $this->Produtos_model->get_atributos($_SESSION['Produtos']['idTab_Catprod']);
		$conta_atributos = count($data['atributo']);
		if (count($data['atributo']) > 0) {
			$data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
			
			/*
			echo '<br>';
			  echo "<pre>";
			  print_r($conta_atributos);
			  echo '<br>';
			  echo "</pre>";
			 */ 
			if (isset($data['atributo'])) {
				if ($conta_atributos >= 2) {
					for($j=1; $j <= $conta_atributos; $j++){
						$_SESSION['Atributo'][$j]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
						$_SESSION['Atributo'][$j]['Atributo'] = $data['atributo'][$j]['Atributo'];
						/*
						  echo '<br>';
						  echo "<pre>";
						  //print_r($conta_atributos);
						  echo '<br>';
						  print_r($_SESSION['Atributo'][$j]['idTab_Atributo']);
						  echo '<br>';
						  print_r($_SESSION['Atributo'][$j]['Atributo']);
						  echo "</pre>";					
						*/
					}
				}else{
					for($j=1; $j <= $conta_atributos; $j++){
						$_SESSION['Atributo'][1]['idTab_Atributo'] = $data['atributo'][$j]['idTab_Atributo'];
						$_SESSION['Atributo'][1]['Atributo'] = $data['atributo'][$j]['Atributo'];
					}
					$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
					$_SESSION['Atributo'][2]['Atributo'] = FALSE;
				}
			}
			/*
			$item_atributo = 1;	
			foreach($data['atributo'] as $atributo_view){
				$_SESSION['Atributo'][$item_atributo]['idTab_Atributo'] = $atributo_view['idTab_Atributo'];
				$_SESSION['Atributo'][$item_atributo]['Atributo'] = $atributo_view['Atributo'];
				$item_atributo++;
			}
			*/
			
		}else{
			$_SESSION['Atributo'][1]['idTab_Atributo'] = FALSE;
			$_SESSION['Atributo'][1]['Atributo'] = FALSE;
			$_SESSION['Atributo'][2]['idTab_Atributo'] = FALSE;
			$_SESSION['Atributo'][2]['Atributo'] = FALSE;
		}		

		//$data['cadastrar']['Codigo'] = $data['produtos']['idTab_Catprod'] . ':' . $data['produtos']['idTab_Produto'] . ':' . $data['produtos']['Opcao_Atributo_1'] . ':' . $data['produtos']['Opcao_Atributo_2'];
		  
	

        $data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
		$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();
		$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
		$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
		$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
		$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();	
		$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
		$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
		$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
		
        $data['titulo'] = 'Cadastrar Variações';
        $data['form_open_path'] = 'produtos/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 3;

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
		
		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
		
		$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
		$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
		
		$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
		$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
		
		$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
		$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
		
		$data['q'] = $this->Produtos_model->list_produtos($data['produtos'], TRUE);
		$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('idTab_Produto', 'Produto', 'required|trim');
		$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('Cadastrar', 'Após Recarregar, Retorne a chave para a posição "Sim"', 'trim|valid_aprovado');			
		if($conta_atributos > 0){
			if($conta_atributos == 1){
				$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
			}elseif($conta_atributos == 2){
				$this->form_validation->set_rules('Opcao_Atributo_1', $_SESSION['Atributo'][1]['Atributo'], 'required|trim');
				$this->form_validation->set_rules('Opcao_Atributo_2', $_SESSION['Atributo'][2]['Atributo'], 'required|trim');
			}
		}
		
		
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
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['cadastrar']['Codigo']);
			echo "</pre>";
			exit ();
			*/
		
			$data['cadastrar']['Cadastrar'] = $data['cadastrar']['Cadastrar'];			

            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Produtos ####

			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produtos'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);


            //if ($data['idTab_Produtos'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'produtos/listar/' . $data['msg']);
				//unset($data['cadastrar']['Codigo']);
				//unset($_SESSION['Produtos']);
                //unset($_SESSION['Atributos']);
				//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
				redirect(base_url() . 'produtos/tela/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');

    }

    public function tela_precos($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		/*
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'idCat_Atributo',
			'idCat_Opcao',
			'idAtributo_Opcao',
			'idCat_Produto',
			'Codigo',
        ), TRUE));
		*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',			
            //'idTab_Catprod', 
            //'idTab_Produto',
			//'Opcao_Atributo_1',
			//'Opcao_Atributo_2', 
            //'Cod_Prod',
        ), TRUE));


        if ($id) {
            #### Tab_Produtos ####
			$_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
		
		}
		
        //$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		//$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
		//$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
		//$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
		//$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		//$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();	
		//$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
		//$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
		//$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
		
        $data['titulo'] = 'Tela';
        $data['form_open_path'] = 'produtos/tela_precos';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 6;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		/*
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';       
		*/
		/*
		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
		
		$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
		$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
		
		$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
		$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
		
		$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
		$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
		
		$data['q'] = $this->Produtos_model->list_produtos($data['produtos'], TRUE);
		$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);
		*/
		$data['q_precos'] = $this->Produtos_model->list_precos($data['produtos'], TRUE);
		$data['list_precos'] = $this->load->view('produtos/list_precos', $data, TRUE);
		
		$data['q_precos_promocoes'] = $this->Produtos_model->list_precos_promocoes($data['produtos'], TRUE);
		$data['list_precos_promocoes'] = $this->load->view('produtos/list_precos_promocoes', $data, TRUE);			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		//$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('idTab_Produtos', 'Produto', 'required|trim');
		//$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtos/form_produtos', $data);
        } else {
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['cadastrar']['Codigo']);
			echo "</pre>";
			exit ();
			*/
			/*
            #### Tab_Produtos ####

			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produtos'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);
			*/
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                $data['msg'] = '?m=1';
				redirect(base_url() . 'produtos/alterar2/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
				
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function alterar_precos($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		/*
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'idCat_Atributo',
			'idCat_Opcao',
			'idAtributo_Opcao',
			'idCat_Produto',
			'Codigo',
        ), TRUE));
		*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['produtos'] = quotes_to_entities($this->input->post(array(
            #### Tab_Produtos ####
            'idTab_Produtos',			
            //'idTab_Catprod', 
            //'idTab_Produto',
			//'Opcao_Atributo_1',
			//'Opcao_Atributo_2', 
            //'Cod_Prod',
        ), TRUE));

		
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('ValorProduto' . $i)) {
				$data['valor'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['valor'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['valor'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
				//$data['valor'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['valor'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['valor'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
				$data['valor'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
				$data['valor'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
				$data['valor'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
				$data['valor'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;		
		
        if ($id) {
            #### Tab_Produtos ####
           $_SESSION['Produtos'] = $data['produtos'] = $this->Produtos_model->get_produtos($id);
			
            #### Tab_Valor ####
            $data['valor'] = $this->Produtos_model->get_item($id, "1");
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
		
        //$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();
		//$data['select']['idCat_Atributo'] = $this->Basico_model->select_catprod();
		//$data['select']['idCat_Opcao'] = $this->Basico_model->select_catprod();
		//$data['select']['idAtributo_Opcao'] = $this->Basico_model->select_atributo($_SESSION['Produtos']['idTab_Catprod']);	
		//$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		//$data['select']['idCat_Produto'] = $this->Basico_model->select_catprod();	
		//$data['select']['idTab_Produto'] = $this->Basico_model->select_produto($_SESSION['Produtos']['idTab_Catprod']);
		//$data['select']['Opcao_Atributo_1'] = $this->Basico_model->select_opcao_atributo1($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][1]['idTab_Atributo']);
		//$data['select']['Opcao_Atributo_2'] = $this->Basico_model->select_opcao_atributo2($_SESSION['Produtos']['idTab_Catprod'], $_SESSION['Atributo'][2]['idTab_Atributo']);
		$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();		
		
		
        $data['titulo'] = 'Tela';
        $data['form_open_path'] = 'produtos/alterar_precos';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 7;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';
		/*
 		(!$data['cadastrar']['Cadastrar']) ? $data['cadastrar']['Cadastrar'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Cadastrar' => $this->basico->radio_checked($data['cadastrar']['Cadastrar'], 'Cadastrar', 'NS'),
        );
        ($data['cadastrar']['Cadastrar'] == 'N') ?
            $data['div']['Cadastrar'] = '' : $data['div']['Cadastrar'] = 'style="display: none;"';
		*/
		/*
		$data['q1'] = $this->Produtos_model->list_categoria($_SESSION['log'], TRUE);
		$data['list1'] = $this->load->view('produtos/list_categoria', $data, TRUE);
		
		$data['q2'] = $this->Produtos_model->list_produto($data['produtos'], TRUE);
		$data['list2'] = $this->load->view('produtos/list_produto', $data, TRUE);
		
		$data['q3'] = $this->Produtos_model->list_atributo($data['produtos'], TRUE);
		$data['list3'] = $this->load->view('produtos/list_atributo', $data, TRUE);
		
		$data['q4'] = $this->Produtos_model->list_opcao($data['produtos'], TRUE);
		$data['list4'] = $this->load->view('produtos/list_opcao', $data, TRUE);
		
		$data['q'] = $this->Produtos_model->list_produtos($data['produtos'], TRUE);
		$data['list'] = $this->load->view('produtos/list_produtos', $data, TRUE);
		*/
		$data['q_precos'] = $this->Produtos_model->list_precos($data['produtos'], TRUE);
		$data['list_precos'] = $this->load->view('produtos/list_precos', $data, TRUE);			
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		//$this->form_validation->set_rules('idTab_Catprod', 'Categoria', 'required|trim');
		$this->form_validation->set_rules('idTab_Produtos', 'Produto', 'required|trim');
		//$this->form_validation->set_rules('Cod_Prod', 'Código', 'required|trim|is_unique_by_id_empresa[Tab_Produtos.Cod_Prod.' . $data['produtos']['idTab_Produtos'] . '.idSis_Empresa.' . $_SESSION['Produtos']['idSis_Empresa'] . ']');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('produtos/form_produtos', $data);
        } else {
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
			/*
			echo '<br>';
			echo "<pre>";
			print_r($data['cadastrar']['Codigo']);
			echo "</pre>";
			exit ();
			*/
			/*
            #### Tab_Produtos ####
			$data['update']['produtos']['anterior'] = $this->Produtos_model->get_produtos($data['produtos']['idTab_Produtos']);
            $data['update']['produtos']['campos'] = array_keys($data['produtos']);
            $data['update']['produtos']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['produtos']['anterior'],
                $data['produtos'],
                $data['update']['produtos']['campos'],
                $data['produtos']['idTab_Produtos'], TRUE);
            $data['update']['produtos']['bd'] = $this->Produtos_model->update_produtos($data['produtos'], $data['produtos']['idTab_Produtos']);
			*/
            #### Tab_Valor ####
            $data['update']['valor']['anterior'] = $this->Produtos_model->get_item($data['produtos']['idTab_Produtos'], "1");
            if (isset($data['valor']) || (!isset($data['valor']) && isset($data['update']['valor']['anterior']) ) ) {

                if (isset($data['valor']))
                    $data['valor'] = array_values($data['valor']);
                else
                    $data['valor'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['valor'] = $this->basico->tratamento_array_multidimensional($data['valor'], $data['update']['valor']['anterior'], 'idTab_Valor');

                $max = count($data['update']['valor']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['inserir'][$j]['Item_Promocao'] = "1";
					$data['update']['valor']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['valor']['inserir'][$j]['Desconto'] = 1;
					$data['update']['valor']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['valor']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['valor']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['valor']['inserir'][$j]['idTab_Produtos'] = $data['produtos']['idTab_Produtos'];
                    $data['update']['valor']['inserir'][$j]['idTab_Promocao'] = 1;
					$data['update']['valor']['inserir'][$j]['Prodaux3'] = $_SESSION['Produtos']['idTab_Catprod'];
					$data['update']['valor']['inserir'][$j]['idTab_Modelo'] = $_SESSION['Produtos']['idTab_Produto'];
					$data['update']['valor']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ValorProduto']));
					$data['update']['valor']['inserir'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['inserir'][$j]['ComissaoVenda']));
				}

                $max = count($data['update']['valor']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['valor']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ValorProduto']));
					$data['update']['valor']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['valor']['alterar'][$j]['ComissaoVenda']));
					$data['update']['valor']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['valor']['alterar'][$j]['Convdesc'], 'UTF-8'));
				}

                if (count($data['update']['valor']['inserir']))
                    $data['update']['valor']['bd']['inserir'] = $this->Produtos_model->set_valor($data['update']['valor']['inserir']);

                if (count($data['update']['valor']['alterar']))
                    $data['update']['valor']['bd']['alterar'] =  $this->Produtos_model->update_valor($data['update']['valor']['alterar']);

                if (count($data['update']['valor']['excluir']))
                    $data['update']['valor']['bd']['excluir'] = $this->Produtos_model->delete_valor($data['update']['valor']['excluir']);

            }
				
            if ($data['auditoriaitem'] && !$data['update']['produtos']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('produtos/form_produtos', $data);
            } else {

                $data['msg'] = '?m=1';
				redirect(base_url() . 'produtos/tela_precos/' . $data['produtos']['idTab_Produtos'] . $data['msg']);
				
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
				$data['valor'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
				$data['valor'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
				$data['valor'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
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

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
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
            $_SESSION['Produtos'] = $data['query'] = $this->Produtos_model->get_produto($id, TRUE);
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
					$data['anterior'] = $this->Produtos_model->get_produto($data['query']['idTab_Produto']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Produto'], TRUE);

					if ($data['auditoriaitem'] && $this->Produtos_model->update_produto($data['query'], $data['query']['idTab_Produto']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'produtos/alterarlogo/' . $data['query']['idTab_Produto'] . $data['msg']);
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

    public function alterarlogoderivado($id = FALSE) {
		
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
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

						//redirect(base_url() . 'relatorio/produtos/' . $data['msg']);
						redirect(base_url() . 'produtos/tela/' . $data['derivado']['idTab_Produtos'] . $data['msg']);
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

				unset($_SESSION['Produtos']);
                unset($_SESSION['Atributo']);
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
