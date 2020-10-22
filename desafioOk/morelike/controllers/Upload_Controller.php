<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Upload_Controller extends CI_Controller {
		public function __construct() {
			parent::__construct();
		}
		public function ficheros(){
			$this->load->view('ficheros', array('error' => ' ' ));
		}
		public function do_upload(){
			$idconsulta = $_POST['idarea'];
			$idconsulta = str_replace("uploads/","",$idconsulta);
			if (!file_exists("uploads/".$idconsulta)) {
                mkdir("uploads/".$idconsulta, 0777, true);
            }
			$config = array(
				'upload_path' => "uploads/".$idconsulta,
				'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|rar|zip|txt|xlsx|xls",
				'overwrite' => TRUE,
				'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
				'max_height' => "6000",
				'max_width' => "6000"
			);
			$this->load->library('upload', $config);
			if($this->upload->do_upload()){
				echo json_encode(array("error"=>"","file"=>$this->upload->data('file_name'),"ext"=>$this->upload->data('file_ext')));
			}
			else{
				$error = array('error' => $this->upload->display_errors(),"file"=>"","ext"=>"");
				echo json_encode($error);
			}
		}
		/*function deleteFile(){
			$idconsulta = $_POST['idconsulta'];
			$fichero = $_POST['nombre'];
			unlink("uploads/".$idconsulta."/".$fichero);
		}*/
	}
?>