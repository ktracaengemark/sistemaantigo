<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Promocao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Promocao_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
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
		/*
		$data['cadastrar'] = quotes_to_entities($this->input->post(array(
			'Cadastrar',
			'TipoCatprod',
        ), TRUE));
		*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',  
            'Promocao',  
            'Descricao',
        ), TRUE));

        //$data['select']['Cadastrar'] = $this->Basico_model->select_status_sn();	
		//$data['select']['TipoCatprod'] = $this->Basico_model->select_prod_serv();	
		//$data['select']['idTab_Catprod'] = $this->Basico_model->select_catprod();
		
        $data['titulo'] = 'Cadastrar Promocao';
        $data['form_open_path'] = 'promocao/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

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
        
		$data['q_promocoes'] = $this->Promocao_model->list_promocoes($_SESSION['log'], TRUE);
		$data['list_promocoes'] = $this->load->view('promocao/list_promocoes', $data, TRUE);		
		
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('Promocao', 'Titulo', 'required|trim');
		$this->form_validation->set_rules('Descricao', 'Descrição', 'required|trim');
		#$this->form_validation->set_rules('CodProd', 'Código', 'is_unique[Tab_Produto.CodProd]');
		#$this->form_validation->set_rules('CodProd', 'Código', 'trim|alpha_numeric_spaces|is_unique_duplo[Tab_Produto.CodProd.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
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
            $this->load->view('promocao/form_promocao', $data);
        } else {
			////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

			#### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'UTF-8'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'UTF-8'));
			$data['promocao']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['promocao']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['promocao']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['promocao']['Desconto'] = 2;
            $data['promocao']['idTab_Promocao'] = $this->Promocao_model->set_promocao($data['promocao']);
            /*
            echo count($data['servico']);
            echo '<br>';
            echo "<pre>";
            print_r($data['servico']);
            echo "</pre>";
            exit ();
            */

            if ($data['idTab_Promocao'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Produtos'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produtos', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'Promocao', 
            'Descricao',
        ), TRUE));

		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('ValorProduto' . $i)) {
				$data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['item_promocao'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['item_promocao'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
				$data['item_promocao'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['item_promocao'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
				$data['item_promocao'][$j]['TempoDeEntrega'] = $this->input->post('TempoDeEntrega' . $i);
				$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
				$data['item_promocao'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
				$data['item_promocao'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
				$data['item_promocao'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;		
		
        if ($id) {
            #### Tab_Promocao ####
           $_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id);

            #### Tab_Valor ####
            $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id, "2");
            if (count($data['item_promocao']) > 0) {
                $data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
                $data['count']['PTCount'] = count($data['item_promocao']);
                if (isset($data['item_promocao'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++){
						$_SESSION['Item_Promocao'][$j] = $data['item_promocao'][$j];	 
						/*
						echo '<br>';
						echo "<pre>";
						print_r($_SESSION['Item_Promocao'][$j]);
						echo "</pre>";
						*/
					}
						
                }				
            }			
		
		}
		
		//exit();
		
		$data['select']['idTab_Produtos'] = $this->Basico_model->select_produto_promocao();
		$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();		
		
		
        $data['titulo'] = 'Editar Promoção';
        $data['form_open_path'] = 'promocao/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['q_itens_promocao'] = $this->Promocao_model->list_itens_promocao($data['promocao'], TRUE);
		$data['list_itens_promocao'] = $this->load->view('promocao/list_itens_promocao', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('idTab_Promocao', 'Promocao', 'required|trim');
		$this->form_validation->set_rules('Promocao', 'Titulo', 'required|trim');
		$this->form_validation->set_rules('Descricao', 'Descrição', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'UTF-8'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'UTF-8'));
			
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);
			
            #### Tab_Valor ####
            $data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "2");
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
					$data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['item_promocao']['inserir'][$j]['Desconto'] = 2;
					$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					//$data['update']['item_promocao']['inserir'][$j]['Prodaux3'] = $_SESSION['Promocao']['idTab_Catprod'];
					//$data['update']['item_promocao']['inserir'][$j]['idTab_Modelo'] = $_SESSION['Promocao']['idTab_Produto'];
					$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
					$data['update']['item_promocao']['inserir'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoVenda']));
				}

                $max = count($data['update']['item_promocao']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoVenda']));
					$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['alterar'][$j]['Convdesc'], 'UTF-8'));
				}

                if (count($data['update']['item_promocao']['inserir']))
                    $data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

                if (count($data['update']['item_promocao']['alterar']))
                    $data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

                if (count($data['update']['item_promocao']['excluir']))
                    $data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

            }
				
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                $data['msg'] = '?m=1';
				redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
				
                exit();
            }
        }

        $this->load->view('basico/footer');

    }
	
    public function tela_promocao($id = FALSE) {
			
        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $data['promocao'] = quotes_to_entities($this->input->post(array(
            #### Tab_Promocao ####
            'idTab_Promocao',			
            'Promocao', 
            'Descricao',
        ), TRUE));

		
		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');		
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('ValorProduto' . $i)) {
				$data['item_promocao'][$j]['idTab_Valor'] = $this->input->post('idTab_Valor' . $i);
                $data['item_promocao'][$j]['QtdProdutoDesconto'] = $this->input->post('QtdProdutoDesconto' . $i);
				$data['item_promocao'][$j]['QtdProdutoIncremento'] = $this->input->post('QtdProdutoIncremento' . $i);
				$data['item_promocao'][$j]['idTab_Produtos'] = $this->input->post('idTab_Produtos' . $i);
				$data['item_promocao'][$j]['ValorProduto'] = $this->input->post('ValorProduto' . $i);
				$data['item_promocao'][$j]['ComissaoVenda'] = $this->input->post('ComissaoVenda' . $i);
				$data['item_promocao'][$j]['TempoDeEntrega'] = $this->input->post('TempoDeEntrega' . $i);
				$data['item_promocao'][$j]['Convdesc'] = $this->input->post('Convdesc' . $i);
				$data['item_promocao'][$j]['AtivoPreco'] = $this->input->post('AtivoPreco' . $i);
				$data['item_promocao'][$j]['VendaSitePreco'] = $this->input->post('VendaSitePreco' . $i);
				$data['item_promocao'][$j]['VendaBalcaoPreco'] = $this->input->post('VendaBalcaoPreco' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;		
		
        if ($id) {
            #### Tab_Promocao ####
			$_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id);

            #### Tab_Valor ####
            $_SESSION['Item_Promocao'] = $data['item_promocao'] = $this->Promocao_model->get_item_promocao($id, "2");
            if (count($data['item_promocao']) > 0) {
                $data['item_promocao'] = array_combine(range(1, count($data['item_promocao'])), array_values($data['item_promocao']));
                $data['count']['PTCount'] = count($data['item_promocao']);
				
                if (isset($data['item_promocao'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++){
						$_SESSION['Item_Promocao'][$j] = $data['item_promocao'][$j];	 
						/*
						echo '<br>';
						echo "<pre>";
						print_r($_SESSION['Item_Promocao'][$j]);
						echo "</pre>";
						*/
					}
						
                }
								
            }			
		
		}
		//exit();
		
		$data['select']['idTab_Produtos'] = $this->Basico_model->select_produto_promocao();
		$data['select']['AtivoPreco'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaSitePreco'] = $this->Basico_model->select_status_sn();
		$data['select']['VendaBalcaoPreco'] = $this->Basico_model->select_status_sn();		

        $data['titulo'] = 'Promoção';
        $data['form_open_path'] = 'promocao/tela_promocao';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 3;

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['datepicker'] = 'DatePicker';
        $data['timepicker'] = 'TimePicker';

		$data['q_itens_promocao'] = $this->Promocao_model->list_itens_promocao($data['promocao'], TRUE);
		$data['list_itens_promocao'] = $this->load->view('promocao/list_itens_promocao', $data, TRUE);
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');
		$this->form_validation->set_rules('idTab_Promocao', 'Promocao', 'required|trim');
		$this->form_validation->set_rules('Promocao', 'Titulo', 'required|trim');
		$this->form_validation->set_rules('Descricao', 'Descrição', 'required|trim');

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('promocao/form_promocao', $data);
        } else {
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////

            #### Tab_Promocao ####
			$data['promocao']['Promocao'] = trim(mb_strtoupper($data['promocao']['Promocao'], 'UTF-8'));
			$data['promocao']['Descricao'] = trim(mb_strtoupper($data['promocao']['Descricao'], 'UTF-8'));
			
			$data['update']['promocao']['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
            $data['update']['promocao']['campos'] = array_keys($data['promocao']);
            $data['update']['promocao']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['promocao']['anterior'],
                $data['promocao'],
                $data['update']['promocao']['campos'],
                $data['promocao']['idTab_Promocao'], TRUE);
            $data['update']['promocao']['bd'] = $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']);
			
            #### Tab_Valor ####
            $data['update']['item_promocao']['anterior'] = $this->Promocao_model->get_item_promocao($data['promocao']['idTab_Promocao'], "2");
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
					$data['update']['item_promocao']['inserir'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['inserir'][$j]['Convdesc'], 'UTF-8'));
					$data['update']['item_promocao']['inserir'][$j]['Desconto'] = 2;
					$data['update']['item_promocao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['item_promocao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['item_promocao']['inserir'][$j]['idTab_Promocao'] = $data['promocao']['idTab_Promocao'];
					//$data['update']['item_promocao']['inserir'][$j]['Prodaux3'] = $_SESSION['Promocao']['idTab_Catprod'];
					//$data['update']['item_promocao']['inserir'][$j]['idTab_Modelo'] = $_SESSION['Promocao']['idTab_Produto'];
					$data['update']['item_promocao']['inserir'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ValorProduto']));
					$data['update']['item_promocao']['inserir'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['inserir'][$j]['ComissaoVenda']));
				}

                $max = count($data['update']['item_promocao']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['item_promocao']['alterar'][$j]['ValorProduto'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ValorProduto']));
					$data['update']['item_promocao']['alterar'][$j]['ComissaoVenda'] = str_replace(',', '.', str_replace('.', '', $data['update']['item_promocao']['alterar'][$j]['ComissaoVenda']));
					$data['update']['item_promocao']['alterar'][$j]['Convdesc'] = trim(mb_strtoupper($data['update']['item_promocao']['alterar'][$j]['Convdesc'], 'UTF-8'));
				}

                if (count($data['update']['item_promocao']['inserir']))
                    $data['update']['item_promocao']['bd']['inserir'] = $this->Promocao_model->set_item_promocao($data['update']['item_promocao']['inserir']);

                if (count($data['update']['item_promocao']['alterar']))
                    $data['update']['item_promocao']['bd']['alterar'] =  $this->Promocao_model->update_item_promocao($data['update']['item_promocao']['alterar']);

                if (count($data['update']['item_promocao']['excluir']))
                    $data['update']['item_promocao']['bd']['excluir'] = $this->Promocao_model->delete_item_promocao($data['update']['item_promocao']['excluir']);

            }
				
            if ($data['auditoriaitem'] && !$data['update']['promocao']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('promocao/form_promocao', $data);
            } else {

                $data['msg'] = '?m=1';
				redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
				
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

        $data['promocao'] = $this->input->post(array(
			'idTab_Promocao',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Promocao',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id, TRUE);
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
            $this->load->view('promocao/form_logo_promocao', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/promocao/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('promocao/form_logo_promocao', $data);
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
                    $this->load->view('promocao/form_logo_promocao', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['promocao']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
					$data['campos'] = array_keys($data['promocao']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['promocao'], $data['campos'], $data['promocao']['idTab_Promocao'], TRUE);

					if ($data['auditoriaitem'] && $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'promocao/form_logo_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
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

						redirect(base_url() . 'promocao/tela_promocao/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }	
	
    public function alterarlogo_original($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['promocao'] = $this->input->post(array(
			'idTab_Promocao',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Promocao',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Promocao'] = $data['promocao'] = $this->Promocao_model->get_promocao($id, TRUE);
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
					
					$data['promocao']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Promocao_model->get_promocao($data['promocao']['idTab_Promocao']);
					$data['campos'] = array_keys($data['promocao']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['promocao'], $data['campos'], $data['promocao']['idTab_Promocao'], TRUE);

					if ($data['auditoriaitem'] && $this->Promocao_model->update_promocao($data['promocao'], $data['promocao']['idTab_Promocao']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'promocao/form_perfil/' . $data['promocao']['idTab_Promocao'] . $data['msg']);
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
				#redirect(base_url() . 'relatorio/promocao/' . $data['msg']);
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

}
