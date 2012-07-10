<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cpanel extends CI_Controller {

	var $c='cpanel';

	public function index($page=1)
	{   
        $this->load->library('session');
        $this->load->model('Login_model','',TRUE);
        $this->Login_model->check_login_status();
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Article_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/article/articlelist/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Article_model->get_article_total_num();
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
		$data['articlelist']=$this->Article_model->get_article_list($start,$config['per_page']);
		if($data['articlelist'])
			foreach ($data['articlelist'] as $key=>$value)
			  foreach ($value as $key2=>$value2)
			    $value->$key2=html_escape($value2);
		$this->load->view('admin/header');
		$this->load->view('admin/sidebar',$data);
		$this->load->view('admin/page_header');
		$this->load->view('admin/content');
		$this->load->view('admin/footer');
	}
	
	public function logout()
	{
		$adminid = array(
				'name'   => 'adminid',
				'value'  => '',
				'expire' => time()-3600
		);
		$adminnickname = array(
				'name'   => 'adminnickname',
				'value'  => '',
				'expire' => time()-3600
		);
		$this->input->set_cookie($adminid);
		$this->input->set_cookie($adminnickname);
		
		$this->load->library('session');
		$adminarray=array('adminid'=>'','adminnickname'=>'');
		$this->session->unset_userdata($adminarray);
		$this->session->sess_destroy();
		redirect(site_url('admin/login'));
	}
}

?>