<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siteconfig extends CI_Controller {
    
	var $c='siteconfig';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Login_model','',TRUE);
		$this->Login_model->check_login_status();
	}
	
	public function index()
	{   
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Siteconfig_model','',TRUE);
		$data['siteconfig']=$this->Siteconfig_model->get_all_config();
		$fp=dir('css/view');
		while (false !== ($entry = $fp->read())) {
			if(is_dir('css/view/'.$entry)&&$entry!='.'&&$entry!='..')
				$theme[]=$entry;
		}
		$data['theme']=$theme;
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/siteconfig');
		$this->load->view('admin/footer');
	}
	
	public function doadd()
	{
		$this->load->model('Siteconfig_model','',TRUE);
		$this->Siteconfig_model->add_all_config();
		redirect(site_url('admin/siteconfig'));
	}

}

?>