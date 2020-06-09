<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Prodaux22 extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
        #$this->load->library(array('basico', 'Basico_model', 'form_validation'));
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Prodaux2_model', 'Prodaux3_model', 'Prodaux4_model', 'Contatocliente_model'));
        $this->load->driver('session');

        #load header view
        $this->load->view('basico/header');
        #$this->load->view('basico/nav_principal');

        #$this->load->view('cliente/nav_secundario');
    }

    public function index() {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $this->load->view('cliente/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar3($tabela = NULL) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idTab_Prodaux2',
            'Prodaux2',
			'Abrev2',
			'idSis_Empresa',
			'Prodaux4',
                ), TRUE));

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Prodaux2', 'Nome do Convênio', 'required|trim');
		$this->form_validation->set_rules('Prodaux4', 'Categoria', 'required|trim');

		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();        
		
		$data['titulo'] = 'Cadastrar Tipo';
        $data['form_open_path'] = 'prodaux22/cadastrar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 1;
        $data['button'] =
                '
                <button class="btn btn-sm btn-primary" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-plus"></span> Cadastrar
                </button>
        ';

		$data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Prodaux2_model->lista_prodaux2(TRUE);
        $data['list'] = $this->load->view('prodaux2/list_prodaux23', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('prodaux2/pesq_prodaux23', $data);
        } else {

			$data['query']['Prodaux2'] = trim(mb_strtoupper($data['query']['Prodaux2'], 'ISO-8859-1'));
			$data['query']['Abrev2'] = trim(mb_strtoupper($data['query']['Abrev2'], 'ISO-8859-1'));
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
            $data['query']['idTab_Modulo'] = $_SESSION['log']['idTab_Modulo'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['campos'] = array_keys($data['query']);
            $data['anterior'] = array();

            $data['idTab_Prodaux2'] = $this->Prodaux2_model->set_prodaux2($data['query']);

            if ($data['idTab_Prodaux2'] === FALSE) {
                $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";

                $this->basico->erro($msg);
                $this->load->view('prodaux2/cadastrar3', $data);
            } else {

                $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idTab_Prodaux2'], FALSE);
                $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Prodaux2', 'CREATE', $data['auditoriaitem']);
                $data['msg'] = '?m=1';

                redirect(base_url() . 'prodaux22/cadastrar3' . $data['msg']);
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

        $data['query'] = quotes_to_entities($this->input->post(array(
            'idSis_Usuario',
			'idTab_Prodaux2',
            'Prodaux2',
            'Abrev2',
			'idSis_Empresa',
			'Prodaux4',
                ), TRUE));


        if ($id)
            $data['query'] = $this->Prodaux2_model->get_prodaux2($id);


        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        $this->form_validation->set_rules('Prodaux2', 'Nome do Convênio', 'required|trim');
		$this->form_validation->set_rules('Prodaux4', 'Categoria', 'required|trim');
       # $this->form_validation->set_rules('ValorVenda', 'Valor do Convênio', 'required|trim');

		$data['select']['Prodaux3'] = $this->Prodaux3_model->select_prodaux3();	
		$data['select']['Prodaux4'] = $this->Prodaux4_model->select_prodaux4();	   
	   
        $data['titulo'] = 'Editar Aux2';
        $data['form_open_path'] = 'prodaux22/alterar3';
        $data['readonly'] = '';
        $data['disabled'] = '';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;
        $data['button'] =
                '
                <button class="btn btn-sm btn-warning" name="pesquisar" value="0" type="submit">
                    <span class="glyphicon glyphicon-edit"></span> Salvar Alteração
                </button>
        ';

        $data['sidebar'] = 'col-sm-3 col-md-2';
        $data['main'] = 'col-sm-7 col-md-8';

        $data['q'] = $this->Prodaux2_model->lista_prodaux2(TRUE);
        $data['list'] = $this->load->view('prodaux2/list_prodaux23', $data, TRUE);

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('prodaux2/pesq_prodaux23', $data);
        } else {

            $data['query']['Prodaux2'] = trim(mb_strtoupper($data['query']['Prodaux2'], 'ISO-8859-1'));
			$data['query']['Abrev2'] = trim(mb_strtoupper($data['query']['Abrev2'], 'ISO-8859-1'));
           # $data['query']['ValorVenda'] = str_replace(',','.',str_replace('.','',$data['query']['ValorVenda']));
            $data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['anterior'] = $this->Prodaux2_model->get_prodaux2($data['query']['idTab_Prodaux2']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Prodaux2'], TRUE);

            if ($data['auditoriaitem'] && $this->Prodaux2_model->update_prodaux2($data['query'], $data['query']['idTab_Prodaux2']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'prodaux22/alterar3/' . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Prodaux2', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                redirect(base_url() . 'prodaux22/cadastrar3/' . $data['msg']);
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
			'idTab_Prodaux2',
        ), TRUE);
		
        $data['file'] = $this->input->post(array(
            'idTab_Prodaux2',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Prodaux2'] = $data['query'] = $this->Prodaux2_model->get_prodaux2($id, TRUE);
        }
		
        if ($id)
            $data['file']['idTab_Prodaux2'] = $id;

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaprodaux2($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'prodaux22/alterarlogo';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('prodaux2/form_perfil', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('prodaux2/form_perfil', $data);
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
				$data['idSis_Arquivo'] = $this->Prodaux2_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('prodaux2/form_perfil', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivo'] = $data['file']['Arquivo'];
					$data['anterior'] = $this->Prodaux2_model->get_prodaux2($data['query']['idTab_Prodaux2']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idTab_Prodaux2'], TRUE);

					if ($data['auditoriaitem'] && $this->Prodaux2_model->update2_prodaux2($data['query'], $data['query']['idTab_Prodaux2']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'prodaux2/form_perfil/' . $data['query']['idTab_Prodaux2'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Prodaux2']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Prodaux2']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/fotoproduto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/original/' . $_SESSION['Prodaux2']['Arquivo'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Prodaux2']['Arquivo'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Prodaux2']['Arquivo'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/fotoproduto.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/produtos/miniatura/' . $_SESSION['Prodaux2']['Arquivo'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'Tab_Produto', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'prodaux22/cadastrar3/' . $data['msg']);
						exit();
					}				
				}
            }
        }

        $this->load->view('basico/footer');
    }
	
	public function excluir3($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

                $this->Prodaux2_model->delete_prodaux2($id);

                $data['msg'] = '?m=1';

				redirect(base_url() . 'prodaux22/cadastrar3/' . $data['msg']);
				exit();
            //}
        //}

        $this->load->view('basico/footer');
    }	

}
