<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultaPrint extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Orcatrata_model', 'Orcatrataprint_model', 'Consultaprint_model', 'Relatorio_model', 'Usuario_model' , 'Cliente_model'));
        $this->load->driver('session');

        #load header view
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

        $this->load->view('consulta/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function imprimirlista($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';		
		
		//$data['Imprimir']['DataInicio'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataInicio'], 'barras');
		//$data['Imprimir']['DataFim'] = $this->basico->mascara_data($_SESSION['FiltroAlteraParcela']['DataFim'], 'barras');
		
        if ($id) {
            #### App_OrcaTrata ####
            $data['consulta'] = $this->Consultaprint_model->get_consulta($id);
            if (count($data['consulta']) > 0) {
                $data['consulta'] = array_combine(range(1, count($data['consulta'])), array_values($data['consulta']));
                $data['count']['POCount'] = count($data['consulta']);           

				if (isset($data['consulta'])) {

                    for($j=1;$j<=$data['count']['POCount'];$j++) {
						
						$data['consulta'][$j]['idApp_Consulta'] = $data['consulta'][$j]['idApp_Consulta'];
						$data['consulta'][$j]['DataInicio'] = $this->basico->mascara_data($data['consulta'][$j]['DataInicio'], 'barras');

					}
				}	
			}
			/*
			  echo '<br>';
			  echo "<pre>";
			  print_r($data['consulta']);
			  echo "</pre>";
			  exit ();
			  */
        }

        $data['titulo'] = 'Lista de Agendamentos';
        $data['form_open_path'] = 'ConsultaPrint/imprimirlista';
        $data['panel'] = 'info';
        $data['metodo'] = 1;
		$data['imprimir'] = 'OrcatrataPrint/imprimir/';
		$data['imprimirlista'] = 'OrcatrataPrint/imprimirlistarec/';
		$data['imprimirrecibo'] = 'OrcatrataPrint/imprimirreciborec/';
		
        /*
          echo '<br>';
          echo "<pre>";
          print_r($data);
          echo "</pre>";
          #exit ();
         */

        $this->load->view('consulta/print_list_agendamentos', $data);

        $this->load->view('basico/footer');

    }
	
}
