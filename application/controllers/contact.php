<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Login_model','',TRUE);
		$this->Login_model->get_login_status();
	}
	
	public function index($page=1)
	{
		$this->load->library('session');
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Category_model','',TRUE);
		$this->load->model('Siteconfig_model','',TRUE);
		$this->load->model('Comment_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$this->load->model('Link_model','',TRUE);
		$data['article_head']=$this->Article_model->get_head_post();
		$data['siteconfig']=$this->Siteconfig_model->get_all_config();
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/contact/';
		$config['uri_segment'] = 2;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Comment_model->get_contact_total_num();
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
		$start=$config['per_page']*($page-1);
		$data['pagination']=$this->pagination->create_links();
		$data['comment']=$this->Comment_model->get_contact_list($start,$config['per_page']);
		$this->sidebar($data);
		$this->load->view($data['siteconfig']->site_theme.'header',$data);
		$this->load->view($data['siteconfig']->site_theme.'contact');
		$this->load->view($data['siteconfig']->site_theme.'sidebar');
		$this->load->view($data['siteconfig']->site_theme.'footer');
	}
	
	public function sidebar(&$data)
	{
		$data['categorylist']=$this->Category_model->get_category_list();
		$data['newposts']=$this->Article_model->get_newest_post();
		$data['newcomments']=$this->Comment_model->get_new_comments();
		$data['tagcloud']=$this->Tag_model->get_all_tag();
		$data['linklist']=$this->Link_model->get_link_list(false,false,'1');
	}
}
?>