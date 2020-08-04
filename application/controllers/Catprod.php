<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Catprod extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Catprod_model', 'Prodaux1_model', 'Prodaux2_model', 'Prodaux3_model', 'Prodaux4_model', 'Fornecedor_model', 'Formapag_model', 'Relatorio_model'));
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

        $this->load->view('catprod/tela_index', $data);

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
		
        $data['catprod'] = quotes_to_entities($this->input->post(array(
            #### Tab_Catprod ####
            'idTab_Catprod',
            'Catprod',			
        ), TRUE));
   

        //Fim do trecho de código que dá pra melhorar

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #### Tab_Catprod ####

		$this->form_validation->set_rules('Catprod', 'Categoria', 'required|trim');		
		
        $data['titulo'] = 'Cadastrar';
        $data['form_open_path'] = 'catprod/cadastrar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
	
        #Ver uma solução melhor para este campo

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
            //if (1 == 1) {
            $this->load->view('catprod/form_catprod', $data);
        } else {
			
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Catprod ####
			#$data['catprod']['Desconto'] = 2;
			$data['catprod']['Catprod'] = trim(mb_strtoupper($data['catprod']['Catprod'], 'UTF-8'));
			$data['catprod']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];            
            $data['catprod']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['catprod']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
            $data['catprod']['idTab_Catprod'] = $this->Catprod_model->set_catprod($data['catprod']);
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

            if ($data['idTab_Catprod'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('catprod/form_catprod', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Catprod'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Catprod', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                #redirect(base_url() . 'catprod/listar/' . $data['msg']);
				//redirect(base_url() . 'relatorio/catprod/' . $data['msg']);
				#redirect(base_url() . 'agenda' . $data['msg']);
                redirect(base_url() . 'catprod/alterar/' . $data['catprod']['idTab_Catprod'] . $data['msg']);
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
		
        $data['catprod'] = quotes_to_entities($this->input->post(array(
            #### Tab_Catprod ####
            'idTab_Catprod',			
            'Catprod',
        ), TRUE));

		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('idTab_Atributo' . $i)) {
				$data['atributo'][$j]['idTab_Atributo_Select'] = $this->input->post('idTab_Atributo_Select' . $i);
				$data['atributo'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;
				
		
        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Catprod ####
            $_SESSION['Catprod'] = $data['catprod'] = $this->Catprod_model->get_catprod($id);

            #### Tab_Atributo ####
            $data['atributo'] = $this->Catprod_model->get_atributo($id);
            if (count($data['atributo']) > 0) {
                $data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
                $data['count']['PTCount'] = count($data['atributo']);
				/*
                if (isset($data['atributo'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Catprod', 'Categoria', 'required|trim');
		
		$data['select']['idTab_Atributo'] = $this->Basico_model->select_atributo_cat();

        $data['titulo'] = 'Editar';
        $data['form_open_path'] = 'catprod/alterar';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        //if (isset($data['atributo']) && ($data['atributo'][0]['DataAtributo'] || $data['atributo'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

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
            $this->load->view('catprod/form_catprod', $data);
        } else {
						
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Catprod ####
			$data['catprod']['Catprod'] = trim(mb_strtoupper($data['catprod']['Catprod'], 'UTF-8'));
			$data['catprod']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['catprod']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['catprod']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['update']['catprod']['anterior'] = $this->Catprod_model->get_catprod($data['catprod']['idTab_Catprod']);
            $data['update']['catprod']['campos'] = array_keys($data['catprod']);
            $data['update']['catprod']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['catprod']['anterior'],
                $data['catprod'],
                $data['update']['catprod']['campos'],
                $data['catprod']['idTab_Catprod'], TRUE);
            $data['update']['catprod']['bd'] = $this->Catprod_model->update_catprod($data['catprod'], $data['catprod']['idTab_Catprod']);
			
            #### Tab_Atributo ####
            $data['update']['atributo']['anterior'] = $this->Catprod_model->get_atributo($data['catprod']['idTab_Catprod']);
            if (isset($data['atributo']) || (!isset($data['atributo']) && isset($data['update']['atributo']['anterior']) ) ) {

                if (isset($data['atributo']))
                    $data['atributo'] = array_values($data['atributo']);
                else
                    $data['atributo'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['atributo'] = $this->basico->tratamento_array_multidimensional($data['atributo'], $data['update']['atributo']['anterior'], 'idTab_Atributo_Select');

                $max = count($data['update']['atributo']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['atributo']['inserir'][$j]['idTab_Atributo'] = $data['update']['atributo']['inserir'][$j]['idTab_Atributo'];
					$data['update']['atributo']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['atributo']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['atributo']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['atributo']['inserir'][$j]['idTab_Catprod'] = $data['catprod']['idTab_Catprod'];
                }

                $max = count($data['update']['atributo']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['atributo']['alterar'][$j]['idTab_Atributo'] = $data['update']['atributo']['alterar'][$j]['idTab_Atributo'];
				}

                if (count($data['update']['atributo']['inserir']))
                    $data['update']['atributo']['bd']['inserir'] = $this->Catprod_model->set_atributo($data['update']['atributo']['inserir']);

                if (count($data['update']['atributo']['alterar']))
                    $data['update']['atributo']['bd']['alterar'] =  $this->Catprod_model->update_atributo($data['update']['atributo']['alterar']);

                if (count($data['update']['atributo']['excluir']))
                    $data['update']['atributo']['bd']['excluir'] = $this->Catprod_model->delete_atributo($data['update']['atributo']['excluir']);

            }

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Catprod'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['catprod']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('catprod/form_catprod', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Catprod'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Catprod', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

				unset($_SESSION['Catprod']);
                #redirect(base_url() . 'catprod/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/catprod/' . $data['msg']);
				//redirect(base_url() . 'catprod/alterar2/' . $data['catprod']['idTab_Catprod'] . $data['msg']);
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
		
        $data['catprod'] = quotes_to_entities($this->input->post(array(
            #### Tab_Catprod ####
            'idTab_Catprod',			
            'Catprod',
        ), TRUE));

		(!$this->input->post('PTCount')) ? $data['count']['PTCount'] = 0 : $data['count']['PTCount'] = $this->input->post('PTCount');
		(!$this->input->post('POCount')) ? $data['count']['POCount'] = 0 : $data['count']['POCount'] = $this->input->post('POCount');
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['PTCount']; $i++) {

            if ($this->input->post('Atributo' . $i)) {
				$data['atributo'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
                $data['atributo'][$j]['Atributo'] = $this->input->post('Atributo' . $i);
                $j++;
            }
						
        }
        $data['count']['PTCount'] = $j - 1;
		
        $j = 1;
        for ($i = 1; $i <= $data['count']['POCount']; $i++) {

            if ($this->input->post('Opcao' . $i) || $this->input->post('idTab_Atributo' . $i)) {
				$data['opcao'][$j]['idTab_Opcao'] = $this->input->post('idTab_Opcao' . $i);
                $data['opcao'][$j]['idTab_Atributo'] = $this->input->post('idTab_Atributo' . $i);
				$data['opcao'][$j]['idTab_Catprod'] = $this->input->post('idTab_Catprod' . $i);
				$data['opcao'][$j]['Opcao'] = $this->input->post('Opcao' . $i);
                $j++;
            }
						
        }
        $data['count']['POCount'] = $j - 1;		
				
		
        //Fim do trecho de código que dá pra melhorar

        if ($id) {
            #### Tab_Catprod ####
            $_SESSION['Catprod'] = $data['catprod'] = $this->Catprod_model->get_catprod($id);

            #### Tab_Atributo ####
            $data['atributo'] = $this->Catprod_model->get_atributo($id);
            if (count($data['atributo']) > 0) {
                $data['atributo'] = array_combine(range(1, count($data['atributo'])), array_values($data['atributo']));
                $data['count']['PTCount'] = count($data['atributo']);
				/*
                if (isset($data['atributo'])) {

                    for($j=1; $j <= $data['count']['PTCount']; $j++)
						
                }
				*/				
            }
			
            #### Tab_Opcao ####
            $data['opcao'] = $this->Catprod_model->get_opcao($id);
            if (count($data['opcao']) > 0) {
                $data['opcao'] = array_combine(range(1, count($data['opcao'])), array_values($data['opcao']));
                $data['count']['POCount'] = count($data['opcao']);
				/*
                if (isset($data['opcao'])) {

                    for($j=1; $j <= $data['count']['POCount']; $j++)
						
                }
				*/				
            }			

        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Catprod', 'Categoria', 'required|trim');
		
		$data['select']['idTab_Atributo'] = $this->Basico_model->select_atributo();
        
		$data['titulo'] = 'Editar';
        $data['form_open_path'] = 'catprod/alterar2';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 3;

        //if (isset($data['atributo']) && ($data['atributo'][0]['DataAtributo'] || $data['atributo'][0]['Desconto']))
        if ($data['count']['PTCount'] > 0)
            $data['tratamentosin'] = 'in';
        else
            $data['tratamentosin'] = '';


        #Ver uma solução melhor para este campo

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
            $this->load->view('catprod/form_catprod', $data);
        } else {
						
            ////////////////////////////////Preparar Dados para Inserção Ex. Datas "mysql" //////////////////////////////////////////////
            #### Tab_Catprod ####
			$data['catprod']['Catprod'] = trim(mb_strtoupper($data['catprod']['Catprod'], 'UTF-8'));
			$data['catprod']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];             
            $data['catprod']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['catprod']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['update']['catprod']['anterior'] = $this->Catprod_model->get_catprod($data['catprod']['idTab_Catprod']);
            $data['update']['catprod']['campos'] = array_keys($data['catprod']);
            $data['update']['catprod']['auditoriaitem'] = $this->basico->set_log(
                $data['update']['catprod']['anterior'],
                $data['catprod'],
                $data['update']['catprod']['campos'],
                $data['catprod']['idTab_Catprod'], TRUE);
            $data['update']['catprod']['bd'] = $this->Catprod_model->update_catprod($data['catprod'], $data['catprod']['idTab_Catprod']);
			
            #### Tab_Atributo ####
            $data['update']['atributo']['anterior'] = $this->Catprod_model->get_atributo($data['catprod']['idTab_Catprod']);
            if (isset($data['atributo']) || (!isset($data['atributo']) && isset($data['update']['atributo']['anterior']) ) ) {

                if (isset($data['atributo']))
                    $data['atributo'] = array_values($data['atributo']);
                else
                    $data['atributo'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['atributo'] = $this->basico->tratamento_array_multidimensional($data['atributo'], $data['update']['atributo']['anterior'], 'idTab_Atributo');

                $max = count($data['update']['atributo']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['atributo']['inserir'][$j]['Atributo'] = trim(mb_strtoupper($data['update']['atributo']['inserir'][$j]['Atributo'], 'UTF-8'));
					$data['update']['atributo']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['atributo']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['atributo']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['atributo']['inserir'][$j]['idTab_Catprod'] = $data['catprod']['idTab_Catprod'];
                }

                $max = count($data['update']['atributo']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['atributo']['alterar'][$j]['Atributo'] = trim(mb_strtoupper($data['update']['atributo']['alterar'][$j]['Atributo'], 'UTF-8'));
					$data['update']['atributo']['alterar'][$j]['idTab_Catprod'] = $data['catprod']['idTab_Catprod'];
				}

                if (count($data['update']['atributo']['inserir']))
                    $data['update']['atributo']['bd']['inserir'] = $this->Catprod_model->set_atributo($data['update']['atributo']['inserir']);

                if (count($data['update']['atributo']['alterar']))
                    $data['update']['atributo']['bd']['alterar'] =  $this->Catprod_model->update_atributo($data['update']['atributo']['alterar']);

                if (count($data['update']['atributo']['excluir']))
                    $data['update']['atributo']['bd']['excluir'] = $this->Catprod_model->delete_atributo($data['update']['atributo']['excluir']);

            }
			
            #### Tab_Opcao ####
            $data['update']['opcao']['anterior'] = $this->Catprod_model->get_opcao($data['catprod']['idTab_Catprod']);
            if (isset($data['opcao']) || (!isset($data['opcao']) && isset($data['update']['opcao']['anterior']) ) ) {

                if (isset($data['opcao']))
                    $data['opcao'] = array_values($data['opcao']);
                else
                    $data['opcao'] = array();

                //faz o tratamento da variável multidimensional, que ira separar o que deve ser inserido, alterado e excluído
                $data['update']['opcao'] = $this->basico->tratamento_array_multidimensional($data['opcao'], $data['update']['opcao']['anterior'], 'idTab_Opcao');

                $max = count($data['update']['opcao']['inserir']);
                for($j=0;$j<$max;$j++) {
					$data['update']['opcao']['inserir'][$j]['Opcao'] = trim(mb_strtoupper($data['update']['opcao']['inserir'][$j]['Opcao'], 'UTF-8'));
					$data['update']['opcao']['inserir'][$j]['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
                    $data['update']['opcao']['inserir'][$j]['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
					$data['update']['opcao']['inserir'][$j]['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
                    $data['update']['opcao']['inserir'][$j]['idTab_Catprod'] = $data['catprod']['idTab_Catprod'];
					$data['update']['opcao']['inserir'][$j]['idTab_Atributo'] = $data['update']['opcao']['inserir'][$j]['idTab_Atributo'];
                }

                $max = count($data['update']['opcao']['alterar']);
                for($j=0;$j<$max;$j++) {
					$data['update']['opcao']['alterar'][$j]['Opcao'] = trim(mb_strtoupper($data['update']['opcao']['alterar'][$j]['Opcao'], 'UTF-8'));
					$data['update']['opcao']['alterar'][$j]['idTab_Atributo'] = $data['update']['opcao']['alterar'][$j]['idTab_Atributo'];
					$data['update']['opcao']['alterar'][$j]['idTab_Catprod'] = $data['catprod']['idTab_Catprod'];
				}

                if (count($data['update']['opcao']['inserir']))
                    $data['update']['opcao']['bd']['inserir'] = $this->Catprod_model->set_opcao($data['update']['opcao']['inserir']);

                if (count($data['update']['opcao']['alterar']))
                    $data['update']['opcao']['bd']['alterar'] =  $this->Catprod_model->update_opcao($data['update']['opcao']['alterar']);

                if (count($data['update']['opcao']['excluir']))
                    $data['update']['opcao']['bd']['excluir'] = $this->Catprod_model->delete_opcao($data['update']['opcao']['excluir']);

            }			

/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
            //*******CORRIGIR -  ALTERAR PARA ENTRAR COM TODAS AS MUDANÇAS NA TABELA DE LOG*****
//////////////////////////////////////////////////Dados Basicos/////////////////////////////////////////////////////////////////////////
*/

            //if ($data['idTab_Catprod'] === FALSE) {
            //if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
            if ($data['auditoriaitem'] && !$data['update']['catprod']['bd']) {
                $data['msg'] = '?m=2';
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('catprod/form_catprod', $data);
            } else {

                //$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Catprod'], FALSE);
                //$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Catprod', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';
				
				
                unset($_SESSION['Catprod']);
				redirect(base_url() . 'relatorio/catprod/' . $data['msg']);
				//redirect(base_url() . 'catprod/alterar2/' . $data['catprod']['idTab_Catprod'] . $data['msg']);
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
			'idTab_Catprod',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Catprod',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Catprod'] = $data['query'] = $this->Catprod_model->get_catprod($id, TRUE);
        }
		
        if ($id)
            $data['file']['idTab_Catprod'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiacatprod($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'catprod/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('catprod/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('catprod/form_perfil', $data);
            }
            else {
			
				$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/original/';		
				$foto = $data['file']['Arquivo'];
				$diretorio = $dir.$foto;					
				$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/miniatura/';

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
				$data['idSis_Arquivo'] = $this->Catprod_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('catprod/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Catprod_model->get_catprod($data['query']['idTab_Catprod']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Catprod'], TRUE);

					if ($data['auditoriaitem'] && $this->Catprod_model->update_catprod($data['query'], $data['query']['idTab_Catprod']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'catprod/form_perfil/' . $data['query']['idTab_Catprod'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/original/' . $_SESSION['Catprod']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/original/' . $_SESSION['Catprod']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/original/fotocatprod.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/original/' . $_SESSION['Catprod']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/miniatura/' . $_SESSION['Catprod']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/miniatura/' . $_SESSION['Catprod']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/miniatura/fotocatprod.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/catprod/miniatura/' . $_SESSION['Catprod']['Arquivo'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Catprod', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/catprod/' . $data['msg']);
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
        
                $this->Catprod_model->delete_catprod($id);

                $data['msg'] = '?m=1';

				unset($_SESSION['Catprod']);
                #redirect(base_url() . 'catprod/listar/' . $data['msg']);
				redirect(base_url() . 'relatorio/catprod/' . $data['msg']);
				#redirect(base_url() . 'catprod/cadastrar' . $data['msg']);
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


        //$_SESSION['Catprod'] = $this->Catprod_model->get_cliente($id, TRUE);
        //$_SESSION['Catprod']['idApp_Cliente'] = $id;
        $data['aprovado'] = $this->Catprod_model->list_catprod($id, 'S', TRUE);
        $data['naoaprovado'] = $this->Catprod_model->list_catprod($id, 'N', TRUE);

        //$data['aprovado'] = array();
        //$data['naoaprovado'] = array();
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */

        $data['list'] = $this->load->view('catprod/list_catprod', $data, TRUE);
       # $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('catprod/tela_catprod', $data);

        $this->load->view('basico/footer');
    }

    public function listarBKP($id = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';


        //$_SESSION['Catprod'] = $this->Catprod_model->get_cliente($id, TRUE);
        #$_SESSION['Catprod']['idApp_Cliente'] = $id;
        $data['query'] = $this->Catprod_model->list_catprod(TRUE, TRUE);
        /*
          echo "<pre>";
          print_r($data['query']);
          echo "</pre>";
          exit();
         */
        if (!$data['query'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('catprod/list_catprod', $data, TRUE);

        #$data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $this->load->view('catprod/tela_catprod', $data);

        $this->load->view('basico/footer');
    }

}
