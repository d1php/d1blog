<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

	public function index()
	{	
		if($this->input->cookie('adminid'))
		{
			$this->load->library('session');
			$adminarray=array('adminid'=>$this->input->cookie('adminid'),'adminnickname'=>$this->input->cookie('adminnickname'));
			$this->session->set_userdata($adminarray);
			redirect(base_url().'admin/cpanel');
		}
		else 
		{
		$this->load->helper(array('form'));
		$this->load->view('admin/header');
		$this->load->view('admin/login');
		}
	}
	
	public function dologin()
	{
		$this->load->model('user','',TRUE);
		if($this->user->check_login())
		{
			$usr_detail=$this->user->check_login();
			if($usr_detail->rememberme)
			{
				$adminid = array(
						'name'   => 'adminid',
						'value'  => $usr_detail->id,
						'expire' => '604800'
				);
				$adminnickname = array(
						'name'   => 'adminnickname',
						'value'  => $usr_detail->usr_nickname,
						'expire' => '604800'
				);
				$this->input->set_cookie($adminid);
				$this->input->set_cookie($adminnickname);
			}
			$this->load->library('session');
			$adminarray=array('adminid'=>$usr_detail->id,'adminnickname'=>$usr_detail->usr_nickname);
			$this->session->set_userdata($adminarray);
		}
		else
		{
			echo '用户名或者密码不正确';
		}
	}
	
	public function statuserror()
	{
		$this->load->view('admin/statuserror');
	}
	
	public function unlogin()
	{
		$this->load->view('admin/unlogin');
	}
}

?>