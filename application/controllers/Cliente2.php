<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente2 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Cliente_model', 'Contatocliente_model'));
        #$this->load->model(array('Basico_model', 'Cliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        #$this->load->view('basico/nav_principal');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar3() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Empresa',
			'idSis_Usuario',
			'idApp_Cliente',
            'NomeCliente',
            'DataNascimento',
			'DataCadastroCliente',
			'CpfCliente',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataEmissao',			
			'CepCliente',
            'CelularCliente',
            'Telefone2',
            'Telefone3',
			'Ativo',
            'Sexo',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
            'Obs',
			'Email',

            'RegistroFicha',
			'Associado',
			#'Profissional',
			'usuario',
			'senha',
			'CodInterno',
        ), TRUE));

       
		(!$data['query']['DataCadastroCliente']) ? $data['query']['DataCadastroCliente'] = date('d/m/Y', time()) : FALSE;
		
	   $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        #$this->form_validation->set_rules('NomeCliente', 'Nome do Respons�vel', 'required|trim|is_unique_duplo[App_Cliente.NomeCliente.DataNascimento.' . $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql') . ']');
        $this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_duplo[App_Cliente.CpfCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NomeCliente', 'Nome do Respons�vel', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_duplo[App_Cliente.CelularCliente.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		
        $data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_status_sn();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresacli();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
		
        $data['titulo'] = 'Cadastrar Cliente';
        $data['form_open_path'] = 'cliente2/cadastrar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;

        if ($data['query']['Sexo'] || $data['query']['EnderecoCliente'] || $data['query']['BairroCliente'] ||
			$data['query']['MunicipioCliente'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['CepCliente'] || $data['query']['CpfCliente'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoCliente']  || $data['query']['DataEmissao'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['tela'] = $this->load->view('cliente/form_cliente3', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente3', $data);
        } else {

			
            $data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');            
			$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'mysql');
			$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
			$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['EnderecoCliente'] = trim(mb_strtoupper($data['query']['EnderecoCliente'], 'ISO-8859-1'));
			$data['query']['NumeroCliente'] = trim(mb_strtoupper($data['query']['NumeroCliente'], 'ISO-8859-1'));
			$data['query']['ComplementoCliente'] = trim(mb_strtoupper($data['query']['ComplementoCliente'], 'ISO-8859-1'));
			$data['query']['BairroCliente'] = trim(mb_strtoupper($data['query']['BairroCliente'], 'ISO-8859-1'));
			$data['query']['CidadeCliente'] = trim(mb_strtoupper($data['query']['CidadeCliente'], 'ISO-8859-1'));
			$data['query']['EstadoCliente'] = trim(mb_strtoupper($data['query']['EstadoCliente'], 'ISO-8859-1'));
			$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($data['query']['ReferenciaCliente'], 'ISO-8859-1'));
			
			$data['query']['usuario'] = $data['query']['CelularCliente'];
			$data['query']['senha'] = md5($data['query']['CelularCliente']);
			$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
			
			#$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();
			
            $data['idApp_Cliente'] = $this->Cliente_model->set_cliente($data['query']);

            if ($data['idApp_Cliente'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('cliente/form_cliente3', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Cliente'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'relatorio2/clientes3/');
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

        $data['query'] = $this->input->post(array(
            'idSis_Empresa',
			'idApp_Cliente',
            'NomeCliente',
            'DataNascimento',
			#'DataCadastroCliente',
			'CpfCliente',
			'Rg',
			'OrgaoExp',
			'EstadoExp',
			'DataEmissao',
			'CepCliente',
            'CelularCliente',
            'Telefone2',
            'Telefone3',
			'Ativo',
            'Sexo',
            'EnderecoCliente',
			'NumeroCliente',
			'ComplementoCliente',
			'CidadeCliente',
            'BairroCliente',
            'MunicipioCliente',
			'EstadoCliente',
			'ReferenciaCliente',
            'Obs',
            #'idSis_Usuario',
            'Email',
            'RegistroFicha',
			'Associado',
			#'Profissional',
			'usuario',
			'senha',
			'CodInterno',
        ), TRUE);

        if ($id) {
            $data['query'] = $this->Cliente_model->get_cliente($id);
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');
			$data['query']['DataCadastroCliente'] = $this->basico->mascara_data($data['query']['DataCadastroCliente'], 'barras');
			$data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'barras');
        }

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('CpfCliente', 'Cpf', 'trim|valid_cpf|alpha_numeric_spaces|is_unique_by_id_empresa[App_Cliente.CpfCliente.' . $data['query']['idApp_Cliente'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']');
		$this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|trim');
        $this->form_validation->set_rules('DataNascimento', 'Data de Nascimento', 'trim|valid_date');
        $this->form_validation->set_rules('CelularCliente', 'CelularCliente', 'required|trim|is_unique_by_id_empresa[App_Cliente.CelularCliente.' . $data['query']['idApp_Cliente'] . '.idSis_Empresa.' . $data['query']['idSis_Empresa'] . ']|valid_celular');
        $this->form_validation->set_rules('Email', 'E-mail', 'trim|valid_email');
		$this->form_validation->set_rules('idSis_Empresa', 'Empresa', 'required|trim');
		
        $data['select']['MunicipioCliente'] = $this->Basico_model->select_municipio();
        $data['select']['Sexo'] = $this->Basico_model->select_sexo();
		$data['select']['Associado'] = $this->Basico_model->select_status_sn();
		$data['select']['Ativo'] = $this->Basico_model->select_status_sn();
		$data['select']['Profissional'] = $this->Basico_model->select_profissional2();
		$data['select']['idSis_Empresa'] = $this->Basico_model->select_empresacli();
		
		$data['select']['option'] = ($_SESSION['log']['Permissao'] <= 2) ? '<option value="">-- Sel. um Prof. --</option>' : FALSE;
		
        $data['titulo'] = 'Editar Dados';
        $data['form_open_path'] = 'cliente2/alterar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        if ($data['query']['Sexo'] || $data['query']['EnderecoCliente'] || $data['query']['BairroCliente'] ||
			$data['query']['MunicipioCliente'] || $data['query']['Obs'] || $data['query']['Email'] || 
			$data['query']['RegistroFicha'] || $data['query']['CepCliente'] || $data['query']['CpfCliente'] || 
			$data['query']['Rg']  || $data['query']['OrgaoExp'] || $data['query']['EstadoCliente']  || $data['query']['DataEmissao'])
            $data['collapse'] = '';
        else
            $data['collapse'] = 'class="collapse"';

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);

        $data['sidebar'] = 'col-sm-3 col-md-2 sidebar';
        $data['main'] = 'col-sm-7 col-sm-offset-3 col-md-8 col-md-offset-2 main';

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('cliente/form_cliente3', $data);
        } else {

            $data['query']['NomeCliente'] = trim(mb_strtoupper($data['query']['NomeCliente'], 'ISO-8859-1'));
            $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'mysql');
            $data['query']['DataEmissao'] = $this->basico->mascara_data($data['query']['DataEmissao'], 'mysql');
			$data['query']['Obs'] = nl2br($data['query']['Obs']);
			$data['query']['EnderecoCliente'] = trim(mb_strtoupper($data['query']['EnderecoCliente'], 'ISO-8859-1'));
			$data['query']['NumeroCliente'] = trim(mb_strtoupper($data['query']['NumeroCliente'], 'ISO-8859-1'));
			$data['query']['ComplementoCliente'] = trim(mb_strtoupper($data['query']['ComplementoCliente'], 'ISO-8859-1'));
			$data['query']['BairroCliente'] = trim(mb_strtoupper($data['query']['BairroCliente'], 'ISO-8859-1'));
			$data['query']['CidadeCliente'] = trim(mb_strtoupper($data['query']['CidadeCliente'], 'ISO-8859-1'));
			$data['query']['EstadoCliente'] = trim(mb_strtoupper($data['query']['EstadoCliente'], 'ISO-8859-1'));
			$data['query']['ReferenciaCliente'] = trim(mb_strtoupper($data['query']['ReferenciaCliente'], 'ISO-8859-1'));
			
			$data['query']['usuario'] = $data['query']['CelularCliente'];
			$data['query']['senha'] = md5($data['query']['CelularCliente']);
			$data['query']['CodInterno'] = md5(uniqid(time() . rand()));
			
			#$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
			#$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
						
            $data['anterior'] = $this->Cliente_model->get_cliente($data['query']['idApp_Cliente']);
            $data['campos'] = array_keys($data['query']);

			$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Cliente'], TRUE);

            if ($data['auditoriaitem'] && $this->Cliente_model->update_cliente($data['query'], $data['query']['idApp_Cliente']) === FALSE) {
                $data['msg'] = '?m=1';
                redirect(base_url() . 'relatorio2/clientes3');
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Cliente', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'relatorio2/clientes3');
                exit();
            }
        }

        $this->load->view('basico/footer');
    }

    public function excluir3($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->Cliente_model->delete_cliente($id);

        $data['msg'] = '?m=1';

		//redirect(base_url() . 'agenda' . $data['msg']);
		redirect(base_url() . 'relatorio2/clientes3');
		exit();

        $this->load->view('basico/footer');
    }

    public function pesquisar() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Pesquisa', 'Pesquisa', 'required|trim|callback_get_cliente');

        if ($this->input->get('start') && $this->input->get('end')) {
            //$data['start'] = substr($this->input->get('start'),0,-3);
            //$data['end'] = substr($this->input->get('end'),0,-3);
            $_SESSION['agenda']['HoraInicio'] = substr($this->input->get('start'),0,-3);
            $_SESSION['agenda']['HoraFim'] = substr($this->input->get('end'),0,-3);
        }

        $data['titulo'] = "Pesquisar Cliente";

        $data['Pesquisa'] = $this->input->post('Pesquisa');
        //echo date('d/m/Y H:i:s', $data['start'],0,-3));

        #run form validation
        if ($this->form_validation->run() !== FALSE && $this->Cliente_model->lista_cliente($data['Pesquisa'], FALSE) === TRUE) {

            $data['query'] = $this->Cliente_model->lista_cliente($data['Pesquisa'], TRUE);
			
            if ($data['query']->num_rows() == 1) {
                $info = $data['query']->result_array();

                if ($_SESSION['agenda'])
                    redirect('consulta/cadastrar/' . $info[0]['idApp_Cliente'] );
                else
                    redirect('cliente/prontuario/' . $info[0]['idApp_Cliente'] );

                exit();
            } else {
                $data['list'] = $this->load->view('cliente/list_cliente', $data, TRUE);
            }
			
        }

        ($data['Pesquisa']) ? $data['cadastrar'] = TRUE : $data['cadastrar'] = FALSE;

        $this->load->view('cliente/pesq_cliente', $data);

        $this->load->view('basico/footer');
    }

    public function prontuario($id) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informa��es salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $_SESSION['Cliente'] = $data['query'] = $this->Cliente_model->get_cliente($id, TRUE);
        $_SESSION['Cliente']['NomeCliente'] = (strlen($data['query']['NomeCliente']) > 12) ? substr($data['query']['NomeCliente'], 0, 12) : $data['query']['NomeCliente'];
		
		#$data['query'] = $this->Paciente_model->get_paciente($prontuario, TRUE);
        $data['titulo'] = 'Prontu�rio ' . $data['query']['NomeCliente'];
        $data['panel'] = 'primary';
        $data['metodo'] = 4;
		
        $_SESSION['log']['idApp_Cliente'] = $data['resumo']['idApp_Cliente'] = $data['query']['idApp_Cliente'];
        $data['resumo']['NomeCliente'] = $data['query']['NomeCliente'];

        $data['query']['Idade'] = $this->basico->calcula_idade($data['query']['DataNascimento']);
        $data['query']['DataNascimento'] = $this->basico->mascara_data($data['query']['DataNascimento'], 'barras');

        /*
        if ($data['query']['Sexo'] == 1)
            $data['query']['profile'] = 'm';
        elseif ($data['query']['Sexo'] == 2)
            $data['query']['profile'] = 'f';
        else
            $data['query']['profile'] = 'o';
        */
        $data['query']['profile'] = ($data['query']['Sexo']) ? strtolower($data['query']['Sexo']) : 'o';

        $data['query']['Sexo'] = $this->Basico_model->get_sexo($data['query']['Sexo']);
		$data['query']['Ativo'] = $this->Basico_model->get_ativo($data['query']['Ativo']);
		$data['query']['idSis_Empresa'] = $this->Basico_model->get_empresa($data['query']['idSis_Empresa']);
		$data['query']['Profissional'] = $this->Basico_model->get_profissional($data['query']['Profissional']);
		
        $data['query']['Telefone'] = $data['query']['CelularCliente'];
        ($data['query']['Telefone2']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone2'] : FALSE;
        ($data['query']['Telefone3']) ? $data['query']['Telefone'] = $data['query']['Telefone'] . ' - ' . $data['query']['Telefone3'] : FALSE;


        if ($data['query']['MunicipioCliente']) {
            $mun = $this->Basico_model->get_municipio($data['query']['MunicipioCliente']);
            $data['query']['MunicipioCliente'] = $mun['NomeMunicipio'] . '/' . $mun['Uf'];
        } else {
            $data['query']['MunicipioCliente'] = $data['query']['Uf'] = $mun['Uf'] = '';
        }

        $data['contatocliente'] = $this->Contatocliente_model->lista_contatocliente(TRUE);
        /*
          echo "<pre>";
          print_r($data['contatocliente']);
          echo "</pre>";
          exit();
        */
        if (!$data['contatocliente'])
            $data['list'] = FALSE;
        else
            $data['list'] = $this->load->view('contatocliente/list_contatocliente', $data, TRUE);

        $data['nav_secundario'] = $this->load->view('cliente/nav_secundario', $data, TRUE);
        $this->load->view('cliente/tela_cliente', $data);

        $this->load->view('basico/footer');
    }

    function get_cliente($data) {

        if ($this->Cliente_model->lista_cliente($data, FALSE) === FALSE) {
            $this->form_validation->set_message('get_cliente', '<strong>Cliente</strong> n�o encontrado.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
