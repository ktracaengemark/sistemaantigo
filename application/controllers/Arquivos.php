<?php

#controlador de Login

defined('BASEPATH') OR exit('No direct script access allowed');

class Arquivos extends CI_Controller {

    public function __construct() {
        parent::__construct();

        #load libraries
        $this->load->helper(array('form', 'url', 'date', 'string'));
      
        $this->load->library(array('basico', 'form_validation'));
        $this->load->model(array('Basico_model', 'Arquivos_model', 'Relatorio_model'));
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

        $this->load->view('arquivos/tela_index', $data);

        #load footer view
        $this->load->view('basico/footer');
    }

    public function cadastrar($orcatrata = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';

        $data['query'] = quotes_to_entities($this->input->post(array(
			'idApp_Arquivos',
            'Arquivos',
			'Texto_Arquivos',
			'Ativo_Arquivos',
			'idSis_Usuario',
			'idSis_Empresa',
			'idApp_OrcaTrata',
                ), TRUE));
		
        $data['file'] = $this->input->post(array(
			'idApp_Arquivos',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($orcatrata) {
            $_SESSION['Orcatrata'] = $data['orcatrata'] = $this->Arquivos_model->get_orcatrata($orcatrata);
		}
		
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$data['select']['Ativo_Arquivos'] = $this->Basico_model->select_status_sn();
		
        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->nomeiaarquivos($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'arquivos/cadastrar';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

 		(!$data['query']['Ativo_Arquivos']) ? $data['query']['Ativo_Arquivos'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo_Arquivos' => $this->basico->radio_checked($data['query']['Ativo_Arquivos'], 'Ativo_Arquivos', 'NS'),
        );
        ($data['query']['Ativo_Arquivos'] == 'S') ?
            $data['div']['Ativo_Arquivos'] = '' : $data['div']['Ativo_Arquivos'] = 'style="display: none;"';		
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('arquivos/form_cad_arquivos', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('arquivos/form_cad_arquivos', $data);
            }
            else {
			
				$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';		
				$foto = $data['file']['Arquivo'];
				$diretorio = $dir.$foto;					
				$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

				switch($_FILES['Arquivo']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
				
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefromjpeg($diretorio);

						$thumb = imagecreatetruecolor(1902, 448);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1902, 448, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;					

					case 'image/png':
					case 'image/x-png';
						
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefrompng($diretorio);

						$thumb = imagecreatetruecolor(1902, 448);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1902, 448, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;
					
				endswitch;			
				
				$data['query']['Arquivos'] = $data['file']['Arquivo'];
				$data['query']['Texto_Arquivos'] = $data['query']['Texto_Arquivos'];
				$data['query']['Ativo_Arquivos'] = $data['query']['Ativo_Arquivos'];
				$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
				$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
				$data['query']['idApp_OrcaTrata'] = $_SESSION['Orcatrata']['idApp_OrcaTrata'];

				$data['campos'] = array_keys($data['query']);
				$data['anterior'] = array();

				$data['idApp_Arquivos'] = $this->Arquivos_model->set_arquivos($data['query']);

				if ($data['idApp_Arquivos'] === FALSE) {
					$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
					$this->basico->erro($msg);
					$this->load->view('arquivos/form_cad_arquivos', $data);
				}				

				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['idApp_Arquivos'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Arquivos', 'CREATE', $data['auditoriaitem']);
					
					$data['file']['idApp_Arquivos'] = $data['idApp_Arquivos'];					
					$data['file']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];
					$data['camposfile'] = array_keys($data['file']);
					$data['idSis_Arquivo'] = $this->Arquivos_model->set_arquivo($data['file']);

					if ($data['idSis_Arquivo'] === FALSE) {
						$msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
						$this->basico->erro($msg);
						$this->load->view('arquivos/form_cad_arquivos', $data);
					} 
					else {

						$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
						$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);						

						$data['msg'] = '?m=1';

						#redirect(base_url() . 'relatorio/arquivos' . $data['msg']);
						#redirect(base_url() . 'orcatrata/listar/' . $_SESSION['Orcatrata']['idApp_Cliente'] . $data['msg']);
						#redirect(base_url() . 'relatorio/parcelas/' . $data['msg']);
						redirect(base_url() . 'OrcatrataPrint/imprimir/' . $_SESSION['Orcatrata']['idApp_OrcaTrata'] . $data['msg']);
						exit();
					}				
				}
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

        $data['query'] = quotes_to_entities($this->input->post(array(
            //'idSis_Usuario',
			'idApp_Arquivos',
            'Texto_Arquivos',
			'Ativo_Arquivos',
			//'idSis_Empresa',
                ), TRUE));


        if ($id){
			$_SESSION['Query'] = $data['query'] = $this->Arquivos_model->get_arquivos($id);
		}

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$this->form_validation->set_rules('Texto_Arquivos', 'Texto do Arquivo', 'trim');
		
		$data['select']['Ativo_Arquivos'] = $this->Basico_model->select_status_sn();

        $data['titulo'] = 'Editar Slide';
        $data['form_open_path'] = 'arquivos/alterar';
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

 		(!$data['query']['Ativo_Arquivos']) ? $data['query']['Ativo_Arquivos'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo_Arquivos' => $this->basico->radio_checked($data['query']['Ativo_Arquivos'], 'Ativo_Arquivos', 'NS'),
        );
        ($data['query']['Ativo_Arquivos'] == 'S') ?
            $data['div']['Ativo_Arquivos'] = '' : $data['div']['Ativo_Arquivos'] = 'style="display: none;"';
			
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('arquivos/form_texto_arquivos', $data);
        } else {
			$data['query']['Texto_Arquivos'] = $data['query']['Texto_Arquivos'];
            $data['query']['Ativo_Arquivos'] = $data['query']['Ativo_Arquivos'];
			//$data['query']['idSis_Usuario'] = $_SESSION['log']['idSis_Usuario'];
			//$data['query']['idSis_Empresa'] = $_SESSION['log']['idSis_Empresa'];

            $data['anterior'] = $this->Arquivos_model->get_arquivos($data['query']['idApp_Arquivos']);
            $data['campos'] = array_keys($data['query']);

            $data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Arquivos'], TRUE);

            if ($data['auditoriaitem'] && $this->Arquivos_model->update_arquivos($data['query'], $data['query']['idApp_Arquivos']) === FALSE) {
                $data['msg'] = '?m=2';
                redirect(base_url() . 'arquivos/form_texto_arquivos' . $data['msg']);
                exit();
            } else {

                if ($data['auditoriaitem'] === FALSE) {
                    $data['msg'] = '';
                } else {
                    $data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Arquivos', 'UPDATE', $data['auditoriaitem']);
                    $data['msg'] = '?m=1';
                }

                //redirect(base_url() . 'relatorio/arquivos/' . $data['msg']);
				redirect(base_url() . 'OrcatrataPrint/imprimir/' . $_SESSION['Query']['idApp_OrcaTrata'] . $data['msg']);
                exit();
            }
        }

        $this->load->view('basico/footer');
    }
		
    public function alterar_arquivos($id = FALSE) {

        if ($this->input->get('m') == 1)
            $data['msg'] = $this->basico->msg('<strong>Informações salvas com sucesso</strong>', 'sucesso', TRUE, TRUE, TRUE);
        elseif ($this->input->get('m') == 2)
            $data['msg'] = $this->basico->msg('<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>', 'erro', TRUE, TRUE, TRUE);
        else
            $data['msg'] = '';
		/*
        $data['query'] = $this->input->post(array(
			'idApp_Arquivos',
			//'Texto_Arquivos',
        ), TRUE);
		*/
        $data['query'] = quotes_to_entities($this->input->post(array(
			'idApp_Arquivos',
            'Texto_Arquivos',
			'Ativo_Arquivos',
		), TRUE));
				
        $data['file'] = $this->input->post(array(
            'idApp_Arquivos',
			'idSis_Empresa',
            'Arquivo',
		), TRUE);

        if ($id) {
            $_SESSION['Arquivos'] = $data['query'] = $this->Arquivos_model->get_arquivos($id, TRUE);
			$data['file']['idApp_Arquivos'] = $id;
		}

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

		$data['select']['Ativo_Arquivos'] = $this->Basico_model->select_status_sn();		
		
        if (isset($_FILES['Arquivo']) && $_FILES['Arquivo']['name']) {
            
			$data['file']['Arquivo'] = $this->basico->renomeiaarquivos($_FILES['Arquivo']['name']);
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'file_allowed_type[jpg, jpeg, gif, png]|file_size_max[1000]');
        }
        else {
            $this->form_validation->set_rules('Arquivo', 'Arquivo', 'required');
        }

        $data['titulo'] = 'Alterar Foto';
        $data['form_open_path'] = 'arquivos/alterar_arquivos';
        $data['readonly'] = 'readonly';
        $data['panel'] = 'primary';
        $data['metodo'] = 2;

 		(!$data['query']['Ativo_Arquivos']) ? $data['query']['Ativo_Arquivos'] = 'S' : FALSE;       
		
		$data['radio'] = array(
            'Ativo_Arquivos' => $this->basico->radio_checked($data['query']['Ativo_Arquivos'], 'Ativo_Arquivos', 'NS'),
        );
        ($data['query']['Ativo_Arquivos'] == 'S') ?
            $data['div']['Ativo_Arquivos'] = '' : $data['div']['Ativo_Arquivos'] = 'style="display: none;"';
		
        #run form validation
        if ($this->form_validation->run() === FALSE) {
            #load login view
            $this->load->view('arquivos/form_arquivos', $data);
        }
        else {

            $config['upload_path'] = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';
            $config['max_size'] = 1000;
            $config['allowed_types'] = ['jpg','jpeg','pjpeg','png','x-png'];
            $config['file_name'] = $data['file']['Arquivo'];

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('Arquivo')) {
                $data['msg'] = $this->basico->msg($this->upload->display_errors(), 'erro', FALSE, FALSE, FALSE);
                $this->load->view('arquivos/form_arquivos', $data);
            }
            else {
			
				$dir = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/';		
				$foto = $data['file']['Arquivo'];
				$diretorio = $dir.$foto;					
				$dir2 = '../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/';

				switch($_FILES['Arquivo']['type']):
					case 'image/jpg';
					case 'image/jpeg';
					case 'image/pjpeg';
				
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefromjpeg($diretorio);

						$thumb = imagecreatetruecolor(1902, 448);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1902, 448, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;					

					case 'image/png':
					case 'image/x-png';
						
						list($largura, $altura, $tipo) = getimagesize($diretorio);
						
						$img = imagecreatefrompng($diretorio);

						$thumb = imagecreatetruecolor(1902, 448);
						
						imagecopyresampled($thumb, $img, 0, 0, 0, 0, 1902, 448, $largura, $altura);
						
						imagejpeg($thumb, $dir2 . $foto);
						imagedestroy($img);
						imagedestroy($thumb);				      
					
					break;
					
				endswitch;			

                $data['camposfile'] = array_keys($data['file']);
				$data['file']['idSis_Empresa'] = $_SESSION['Empresa']['idSis_Empresa'];
				$data['idSis_Arquivo'] = $this->Arquivos_model->set_arquivo($data['file']);

                if ($data['idSis_Arquivo'] === FALSE) {
                    $msg = "<strong>Erro no Banco de dados. Entre em contato com o administrador deste sistema.</strong>";
                    $this->basico->erro($msg);
                    $this->load->view('arquivos/form_arquivos', $data);
                }
				else {

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['file'], $data['camposfile'], $data['idSis_Arquivo'], FALSE);
					$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'idSis_Arquivo', 'CREATE', $data['auditoriaitem']);
					
					$data['query']['Arquivos'] = $data['file']['Arquivo'];
					$data['query']['Texto_Arquivos'] = $data['query']['Texto_Arquivos'];
					$data['query']['Ativo_Arquivos'] = $data['query']['Ativo_Arquivos'];
					$data['anterior'] = $this->Arquivos_model->get_arquivos($data['query']['idApp_Arquivos']);
					$data['campos'] = array_keys($data['query']);

					$data['auditoriaitem'] = $this->basico->set_log($data['anterior'], $data['query'], $data['campos'], $data['query']['idApp_Arquivos'], TRUE);

					if ($data['auditoriaitem'] && $this->Arquivos_model->update_arquivos($data['query'], $data['query']['idApp_Arquivos']) === FALSE) {
						$data['msg'] = '?m=2';
						redirect(base_url() . 'arquivos/form_arquivos/' . $data['query']['idApp_Arquivos'] . $data['msg']);
						exit();
					} else {

						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/arquivos.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '');						
						}
						if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . ''))
							&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '')
							!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/arquivos.jpg'))){
							unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '');						
						}						
						
						if ($data['auditoriaitem'] === FALSE) {
							$data['msg'] = '';
						} else {
							$data['auditoria'] = $this->Basico_model->set_auditoria($data['auditoriaitem'], 'App_Arquivos', 'UPDATE', $data['auditoriaitem']);
							$data['msg'] = '?m=1';
						}

						redirect(base_url() . 'relatorio/site/' . $data['msg']);
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

			if ($id) {
				$_SESSION['Arquivos'] = $this->Arquivos_model->get_arquivos($id, TRUE);
			}		
			$this->Arquivos_model->delete_arquivos($id);

			$data['msg'] = '?m=1';
			
			if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . ''))
				&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '')
				!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/arquivos.jpg'))){
				unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/original/' . $_SESSION['Arquivos']['Arquivos'] . '');						
			}
			if((null!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . ''))
				&& (('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '')
				!==('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/arquivos.jpg'))){
				unlink('../'.$_SESSION['log']['Site'].'/' . $_SESSION['Empresa']['idSis_Empresa'] . '/documentos/miniatura/' . $_SESSION['Arquivos']['Arquivos'] . '');						
			}
			
			redirect(base_url() . 'relatorio/arquivos/' . $data['msg']);
			exit();

        $this->load->view('basico/footer');
    }
	
}
