<?php
class Login_model extends CI_Model {
	
	public function check_login_status()
	{
		$this->load->model('user','',TRUE);
		if(!$this->session->userdata('adminid'))
		{
			if(!$this->input->cookie('adminid'))
			{
				redirect('admin/login/unlogin');
			}
			else if($this->input->cookie('adminid')&&$this->user->is_user_exist($this->input->cookie('adminid')))
			{
				$adminarray=array('adminid'=>$this->input->cookie('adminid'),'adminnickname'=>$this->input->cookie('adminnickname'));
				$this->session->set_userdata($adminarray);
				return true;
			}
			else
			{
				redirect('admin/login/statuserror');
			}
		}
		else if($this->session->userdata('adminid')&&$this->user->is_user_exist($this->session->userdata('adminid')))
		{
            return true;
		}
		else
		{
			redirect('admin/login/statuserror');
		}
	}
	
	public function get_login_status()
	{
		$this->load->model('user','',TRUE);
		if(!$this->session->userdata('adminid'))
		{
            if($this->input->cookie('adminid')&&$this->user->is_user_exist($this->input->cookie('adminid')))
			{
				$adminarray=array('adminid'=>$this->input->cookie('adminid'),'adminnickname'=>$this->input->cookie('adminnickname'));
				$this->session->set_userdata($adminarray);
			}
			else if($this->input->cookie('adminid')&&!$this->user->is_user_exist($this->input->cookie('adminid')))
			{
				redirect('admin/login/statuserror');
			}
		}
		else if($this->session->userdata('adminid')&&$this->user->is_user_exist($this->session->userdata('adminid')))
		{
            return true;
		}
		else
		{
			redirect('admin/login/statuserror');
		}
	}
}
?>