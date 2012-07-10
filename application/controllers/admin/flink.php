<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class flink extends CI_Controller {
    var $c='flink';
    
    public function __construct()
    {
    	parent::__construct();
    	$this->load->library('session');
    	$this->load->model('Login_model','',TRUE);
    	$this->Login_model->check_login_status();
    }
    
	public function addlink()
	{   
		$this->load->library('session');
		$data['c']=__CLASS__;
		$data['m']=__FUNCTION__;
		$this->load->view('admin/header');
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/page_header');
		$this->load->view('admin/addlink');
		$this->load->view('admin/footer');
	}
	
	public function doadd()
	{
	   $this->load->library('session');
	   $data['c']=__CLASS__;
	   $data['m']=__FUNCTION__;
       $this->load->model('Link_model','',TRUE);
       $link_id=$this->Link_model->add();
       redirect(site_url('admin/flink/linklist/'));
	}
	
	public function linklist($page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Link_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/flink/linklist/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Link_model->get_link_total_num();
		$config['anchor_class']=' class=number ';
		$config['first_link'] = '&laquo;首页';
		$config['prev_link'] = '&laquo;上一页';
		$config['next_link'] = '下一页 &raquo;';
		$config['last_link'] = '尾页 &raquo;';
		$config['cur_tag_open'] = '<a href="#" class="number current">';
		$config['cur_tag_close'] = '</a>';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$start=$config['per_page']*($page-1);
		$data['linklist']=$this->Link_model->get_link_list($start,$config['per_page'],1);
		if($data['linklist'])
			foreach ($data['linklist'] as $key=>$value)
			  foreach ($value as $key2=>$value2)
			    $value->$key2=html_escape($value2);
		$this->load->view('admin/header');
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/page_header');
		$this->load->view('admin/linklist');
		$this->load->view('admin/footer');
	}
    
	public function showlink()
	{
		$this->load->model('Link_model','',TRUE);
		$result=$this->Link_model->update_linkstatus($this->input->post('id'));
		if($result)
		{
			echo json_encode(array('success'=>1));
		}
	}
	
	public function send_notify_email()
	{
		$this->load->library('email');
		$this->load->helper('email');
		$this->load->model('Webmaster_model','',TRUE);
		$webmaster=$this->Webmaster_model->get_admin_detail();
		if($webmaster->usr_email&&valid_email($this->input->post('email')))
		{
			$this->load->library('email');
			if($webmaster->is_smtp)
			{
				$config['protocol'] = 'smtp';
				$config['smtp_host']=$webmaster->usr_email_smtp;
				$config['smtp_user']=$webmaster->usr_email_account;
				$config['smtp_pass']=$webmaster->usr_email_pwd;
				$config['smtp_port']=$webmaster->usr_email_port?$webmaster->usr_email_port:'25';
			}
			else
			{
				$config['protocol'] = 'mail';
			}
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->from($webmaster->usr_email_account, $webmaster->usr_nickname);
			$this->email->to($webmaster->usr_email);
			if($this->input->post('message')=='fail')
			{
				$this->email->subject('很遗憾，您的友情链接申请未通过！');
				$this->email->message("很遗憾，您的友情链接申请未通过！\r\n".site_url());
			}
			else
			{
				$this->email->subject('您的友情链接申请已经通过！');
				$this->email->message("您的友情链接申请已经通过，合作愉快！\r\n".site_url());
			}
			if($this->email->send())
			{
				echo json_encode(array('success'=>1));
			}
		}
	}
	
	public function requestlink($page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Link_model','',TRUE);
		$data['linklist']=$this->Link_model->get_link_list(false,false,0);
		if($data['linklist'])
			foreach ($data['linklist'] as $key=>$value)
			foreach ($value as $key2=>$value2)
			$value->$key2=html_escape($value2);
		$this->load->view('admin/header');
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/page_header');
		$this->load->view('admin/requestlinklist');
		$this->load->view('admin/footer');
	}
	
	public function editlink()
	{
		$this->load->model('Link_model','',TRUE);
		$this->Link_model->edit();
	}
	
	public function editalllink()
	{
		$this->load->model('Link_model','',TRUE);
		$this->Link_model->editall();
	}
	
	public function deletelink()
	{
		$this->load->model('Link_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Link_model->delete();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/flink/linklist/',4,$total_num);
		$page_num=ceil($total_num/10);
		if($page+1<=$page_num||$page==$page_num)
		{
			$json['page']=$page;
		}
		else if($page>$page_num&&$page>1)
		{
			$json['page']=$page-1;
		}
		else if($page_num==1)
		{
			$json['page']=1;
		}
		echo json_encode($json);
	}
	
	public function deleterequestalllink()
	{
		$this->load->model('Link_model','',TRUE);
		$deletedata=json_decode($this->input->post('deletedata'));
		foreach ($deletedata as $key=>$value)
		{
			if($this->Link_model->deleterequestlink($value->id))
				$json[$key]['id']=$value->id;
		}
		$json['len']=count($deletedata);
		echo json_encode($json);
	}
	
	public function deleterequestlink()
	{
		$this->load->model('Link_model','',TRUE);
		if($this->Link_model->deleterequestlink($this->input->post('id')))
		$json['id']=$this->input->post('id');
		echo json_encode($json);
	}
	
	public function deletealllink()
	{
		$this->load->model('Link_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Link_model->deleteall($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/flink/linklist/',4,$json['page_num']);
		$json['len']=$len;
	    $page_num=ceil($json['page_num']/10);
		if($page+1<=$page_num||$page==$page_num)
		{
			$json['page']=$page;
		}
		else if($page>$page_num&&$page>1)
		{
			$json['page']=$page-1;
		}
		else if($page_num==1)
		{
			$json['page']=1;
		}
		echo json_encode($json);
	}
	
	function get_new_pagination($base_url,$uri_segment,$total_rows)
	{
		$this->load->library('pagination');
		$config['base_url'] = $base_url;
		$config['uri_segment'] = $uri_segment;
		$config['num_links'] = 3;
		$config['total_rows'] = $total_rows;
		$config['anchor_class']=' class=number ';
		$config['first_link'] = '&laquo;首页';
		$config['prev_link'] = '&laquo;上一页';
		$config['next_link'] = '下一页 &raquo;';
		$config['last_link'] = '尾页 &raquo;';
		$config['cur_tag_open'] = '<a href="#" class="number current">';
		$config['cur_tag_close'] = '</a>';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}

?>