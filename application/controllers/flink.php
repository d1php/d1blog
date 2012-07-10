<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flink extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Login_model','',TRUE);
		$this->Login_model->get_login_status();
	}
	
	public function index($apply=false)
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
		if($apply)$data['apply']=true;
		$this->sidebar($data);
		$this->load->view($data['siteconfig']->site_theme.'header',$data);
		$this->load->view($data['siteconfig']->site_theme.'flink');
		$this->load->view($data['siteconfig']->site_theme.'sidebar');
		$this->load->view($data['siteconfig']->site_theme.'footer');
	}
	
	public function doadd()
	{
		$this->load->model('Link_model','',TRUE);
		$link_id=$this->Link_model->add();
		redirect(site_url('flink/index/applied#apply'));
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