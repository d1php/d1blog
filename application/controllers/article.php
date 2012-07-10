<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class article extends CI_Controller {
    
	var $c='article';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Login_model','',TRUE);
		$this->Login_model->get_login_status();
	}
	
	public function index($page=1)
	{
		$data['m']=__FUNCTION__;
		$this->load->library('session');
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Category_model','',TRUE);
		$this->load->model('Siteconfig_model','',TRUE);
		$this->load->model('Comment_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$this->load->model('Link_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/article/index';
		$config['uri_segment'] = 3;
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
		$data['articlelist']=$this->Article_model->get_article_list_detail($start,$config['per_page']);
		$data['article_head']=$this->Article_model->get_head_post();
		$data['siteconfig']=$this->Siteconfig_model->get_all_config();
		$this->sidebar($data);		
		$this->load->view($data['siteconfig']->site_theme.'header',$data);
		$this->load->view($data['siteconfig']->site_theme.'index');
		$this->load->view($data['siteconfig']->site_theme.'sidebar');
		$this->load->view($data['siteconfig']->site_theme.'footer');
	}

   public function view($id,$page=1)
   {
   	    $this->load->library('session');
   	    $this->load->model('Article_model','',TRUE);
      	$this->load->model('Category_model','',TRUE);
    	$this->load->model('Siteconfig_model','',TRUE);
    	$this->load->model('Tag_model','',TRUE);
    	$this->load->model('Comment_model','',TRUE);
    	$this->load->model('Link_model','',TRUE);
    	$this->load->model('Login_model','',TRUE);
    	$data['article_head']=$this->Article_model->get_head_post();
    	$data['article_detail']=$this->Article_model->get_post_detail($id);
    	$data['page_title']=$data['article_detail']->post_title;
    	$data['siteconfig']=$this->Siteconfig_model->get_all_config();
    	$tag=$this->Tag_model->get_post_tag($id);
    	$tagstr='';
    	if($tag)
    	foreach ($tag as $value) {
    		$tagstr.='<a href="'.site_url('article/listbytag/'.$value->id).'">'.$value->blog_tag_name.'</a>,';
    	}
    	$data['tagstr']=substr($tagstr,0,-1);
    	$this->load->library('pagination');
    	$config['base_url'] = site_url().'/article/view/'.$id;
    	$config['uri_segment'] = 4;
    	$config['num_links'] = 3;
    	$config['total_rows'] = $this->Comment_model->get_comment_total_num_by_post($id);
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
    	$data['comment']=$this->Comment_model->get_post_comment_list($id,$start,$config['per_page']);
    	$this->sidebar($data);
    	if(!$this->session->userdata('adminid'))$this->Article_model->update_views($id);
		$this->load->view($data['siteconfig']->site_theme.'header',$data);
		$this->load->view($data['siteconfig']->site_theme.'detail');
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
   
   public function listbycategory($id,$page='1')
   {
   	    $this->load->library('session');
   	    $data['current_id']=$id;
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Category_model','',TRUE);
		$this->load->model('Siteconfig_model','',TRUE);
		$this->load->model('Comment_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$this->load->model('Link_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/article/listbycategory/'.$id;
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Article_model->get_total_num_by_category($id);
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
		$data['article_head']=$this->Article_model->get_head_post();
		$data['articlelist']=$this->Article_model->get_article_list_bycategory($start,$config['per_page'],$id);
		$data['page_title']=$this->Article_model->get_article_category_name($id);
		$data['siteconfig']=$this->Siteconfig_model->get_all_config();
		$this->sidebar($data);		
		$this->load->view($data['siteconfig']->site_theme.'header',$data);
		$this->load->view($data['siteconfig']->site_theme.'index');
		$this->load->view($data['siteconfig']->site_theme.'sidebar');
		$this->load->view($data['siteconfig']->site_theme.'footer');
   }
   
   public function listbytag($id,$page='1')
   {
   	$this->load->library('session');
   	$this->load->model('Article_model','',TRUE);
   	$this->load->model('Category_model','',TRUE);
   	$this->load->model('Siteconfig_model','',TRUE);
   	$this->load->model('Comment_model','',TRUE);
   	$this->load->model('Tag_model','',TRUE);
   	$this->load->model('Link_model','',TRUE);
   	$this->load->library('pagination');
   	$config['base_url'] = site_url().'/article/listbytag/'.$id;
   	$config['uri_segment'] = 4;
   	$config['num_links'] = 3;
   	$config['total_rows'] = $this->Article_model->get_total_num_by_tag($id);
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
   	$data['article_head']=$this->Article_model->get_head_post();
   	$data['articlelist']=$this->Article_model->get_article_list_bytag($start,$config['per_page'],$id);
   	$data['siteconfig']=$this->Siteconfig_model->get_all_config();
   	$this->sidebar($data);
	$this->load->view($data['siteconfig']->site_theme.'header',$data);
	$this->load->view($data['siteconfig']->site_theme.'index');
	$this->load->view($data['siteconfig']->site_theme.'sidebar');
	$this->load->view($data['siteconfig']->site_theme.'footer');
   }
   
   public function find()
   {
   	$w=preg_replace('/%/','%25',$this->input->get('w'));
   	if(!trim($w))
   	redirect(site_url());
   	else
   	redirect(site_url('article/search/'.rawurlencode($w)));
   }
   
   public function search($w,$page=1)
   {
   	$this->load->library('session');
   	$this->load->model('Article_model','',TRUE);
   	$this->load->model('Category_model','',TRUE);
   	$this->load->model('Siteconfig_model','',TRUE);
   	$this->load->model('Comment_model','',TRUE);
   	$this->load->model('Tag_model','',TRUE);
   	$this->load->model('Link_model','',TRUE);
   	$this->load->model('Login_model','',TRUE);
   	$this->load->library('pagination');
   	$config['base_url'] = site_url().'/article/search/'.$w;
   	$config['uri_segment'] = 4;
   	$config['num_links'] = 3;
   	$w=preg_replace('/%25/','%',$w);
   	$config['total_rows'] = $this->Article_model->get_total_num_by_search($w);
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
   	$data['article_head']=$this->Article_model->get_head_post();
   	$data['articlelist']=$this->Article_model->get_article_list_by_search($start,$config['per_page'],$w);
   	$data['siteconfig']=$this->Siteconfig_model->get_all_config();
   	$this->sidebar($data);
	$this->load->view($data['siteconfig']->site_theme.'header',$data);
	$this->load->view($data['siteconfig']->site_theme.'index');
	$this->load->view($data['siteconfig']->site_theme.'sidebar');
	$this->load->view($data['siteconfig']->site_theme.'footer');
   }

}

?>