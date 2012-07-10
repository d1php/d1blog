<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webmaster extends CI_Controller {
    
	var $c='webmaster';
	
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
		$this->load->model('Webmaster_model','',TRUE);
		$data['webmaster']=$this->Webmaster_model->get_admin_detail();
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/webmaster');
		$this->load->view('admin/footer');
	}
	
	public function doadd()
	{
		$this->load->model('Webmaster_model','',TRUE);
		$relogin=$this->Webmaster_model->add_all_detail();
		if(!$relogin)
		{
		    redirect(site_url('admin/webmaster'));
		}
        else
        {
        	echo "<script>alert('您修改了管理员帐号或密码，请重新登录！');location.href=\"".site_url('admin/cpanel/logout')."\";</script>";
        }			
	}

}

?>