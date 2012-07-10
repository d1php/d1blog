<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class article extends CI_Controller {
    
	var $c='article';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Login_model','',TRUE);
		$this->Login_model->check_login_status();
	}
	
	public function find()
	{
		$w=preg_replace('/%/','%25',$this->input->get('w'));
		if(!trim($w))
			redirect(site_url('admin/article/articlelist'));
		else
			redirect(site_url('admin/article/search/'.rawurlencode($w)));
	}
	
	public function search($w,$page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Category_model','',TRUE);
		$this->load->model('Siteconfig_model','',TRUE);
		$this->load->model('Comment_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url('admin/article/search/'.$w);
		$config['uri_segment'] = 5;
		$config['num_links'] = 3;
		$w=preg_replace('/%25/','%',$w);
		$config['total_rows'] = $this->Article_model->get_total_num_by_search($w);
		$config['anchor_class']=' class=number ';
		$config['first_link'] = '&laquo;首页';
		$config['prev_link'] = '&laquo;上一页';
		$config['next_link'] = '下一页 &raquo;';
		$config['last_link'] = '尾页 &raquo;';
		$config['cur_tag_open'] = '<a href="#" class="number current" id="cpn">';
		$config['cur_tag_close'] = '</a>';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$start=$config['per_page']*($page-1);
		$data['articlelist']=$this->Article_model->get_article_list_by_search($start,$config['per_page'],$w);
		$data['w']=$w;
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/articlesearchlist');
		$this->load->view('admin/footer');
	}
	
	public function write()
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Category_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$data['category']=$this->Category_model->get_category_list();
		$data['tag']=$this->Tag_model->get_tag_list();
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/write');
		$this->load->view('admin/footer');
	}
	
	public function dowrite()
	{
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$post_id=$this->Article_model->write();
		$this->Tag_model->add($post_id);
		redirect(site_url('admin/article/edit/'.$post_id));
	}
	
	public function edit($post_id)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']='';
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$this->load->model('Category_model','',TRUE);
		if(!$this->Article_model->get_post_detail($post_id))
		{
			show_404(site_url('admin/article/edit/10'));
		}
		else
		{
			$data['category']=$this->Category_model->get_category_list();
			$data['tag']=$this->Tag_model->get_tag_list();
			$data['post_detail']=$this->Article_model->get_post_detail($post_id);
			$data['post_tag']=$this->Tag_model->get_post_tag($post_id,'string');
			$this->load->view('admin/header',$data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/page_header');
			$this->load->view('admin/edit');
			$this->load->view('admin/footer');	
		}

	}
	
	public function doedit($post_id)
	{
		$this->load->model('Article_model','',TRUE);
		$this->load->model('Tag_model','',TRUE);
		$this->Article_model->edit($post_id);
        $this->Tag_model->edit($post_id);
		redirect(site_url('admin/article/edit/'.$post_id));
	}
	
	public function articlelist($page=1)
	{
		$this->load->library('session');
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
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/content');
		$this->load->view('admin/footer');
	}
	
	public function comment($page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Comment_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/article/comment/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Comment_model->get_comment_total_num();
		$config['anchor_class']=' class=number ';
		$config['first_link'] = '&laquo;首页';
		$config['prev_link'] = '&laquo;上一页';
		$config['next_link'] = '下一页 &raquo;';
		$config['last_link'] = '尾页 &raquo;';
		$config['cur_tag_open'] = '<a href="#" class="number current">';
		$config['cur_tag_close'] = '</a>';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 1;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$start=$config['per_page']*($page-1);
		$data['comment']=$this->Comment_model->get_all_post_comment_list($start,$config['per_page']);
		if($data['comment'])
			foreach ($data['comment'] as $key=>$value)
			  foreach ($value as $key2=>$value2)
			    $value->$key2=html_escape($value2);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/comment');
		$this->load->view('admin/footer');
	}
	
	public function editcomment($id)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Comment_model','',TRUE);
		$data['comment']=$this->Comment_model->get_post_comment_by_id($id);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/editcomment');
		$this->load->view('admin/footer');
	}
	
	public function doeditcomment($id)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Comment_model','',TRUE);
		$this->Comment_model->edit($id);
		redirect(site_url('admin/article/editcomment/'.$id));
	}
	
	public function category($page='1')
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Category_model','',TRUE);
		
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/article/category/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Category_model->get_category_total_num();
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
		$data['category']=$this->Category_model->get_category_list($start,$config['per_page']);
		if($data['category'])
		   foreach ($data['category'] as $key=>$value)
			 foreach ($value as $key2=>$value2)
			   $value->$key2=html_escape($value2);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/category');
		$this->load->view('admin/footer');
	}
	
	public function listbycategory($id,$page='1')
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Article_model','',TRUE);
	
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/article/listbycategory/'.$id;
		$config['uri_segment'] = 5;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Article_model->get_total_num_by_category($id);
		$config['anchor_class']=' class=number ';
		$config['first_link'] = '&laquo;首页';
		$config['prev_link'] = '&laquo;上一页';
		$config['next_link'] = '下一页 &raquo;';
		$config['last_link'] = '尾页 &raquo;';
		$config['cur_tag_open'] = '<a href="#" class="number current" id="cpn">';
		$config['cur_tag_close'] = '</a>';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$start=$config['per_page']*($page-1);
		$data['articlelist']=$this->Article_model->get_list_by_category($start,$config['per_page'],$id);
		if($data['articlelist'])
			foreach ($data['articlelist'] as $key=>$value)
			  foreach ($value as $key2=>$value2)
			    $value->$key2=html_escape($value2);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/articlelistbycategory');
		$this->load->view('admin/footer');
	}
	
	public function tag($page='1')
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Tag_model','',TRUE);
	
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/article/tag/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Tag_model->get_tag_total_num();
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
		$data['tag']=$this->Tag_model->get_tag_list($start,$config['per_page']);
		if($data['tag'])
			foreach ($data['tag'] as $key=>$value)
			foreach ($value as $key2=>$value2)
			$value->$key2=html_escape($value2);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/tag');
		$this->load->view('admin/footer');
	}
	
	public function listbytag($id,$page='1')
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Article_model','',TRUE);
	
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/article/listbytag/'.$id;
		$config['uri_segment'] = 5;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Article_model->get_total_num_by_tag($id);
		$config['anchor_class']=' class=number ';
		$config['first_link'] = '&laquo;首页';
		$config['prev_link'] = '&laquo;上一页';
		$config['next_link'] = '下一页 &raquo;';
		$config['last_link'] = '尾页 &raquo;';
		$config['cur_tag_open'] = '<a href="#" class="number current" id="cpn">';
		$config['cur_tag_close'] = '</a>';
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 10;
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
		$start=$config['per_page']*($page-1);
		$data['articlelist']=$this->Article_model->get_list_by_tag($start,$config['per_page'],$id);
		$data['tag_id']=$id;
		if($data['articlelist'])
			foreach ($data['articlelist'] as $key=>$value)
			foreach ($value as $key2=>$value2)
			$value->$key2=html_escape($value2);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/articlelistbytag');
		$this->load->view('admin/footer');
	}
	
	public function addcategory()
	{
		$this->load->model('Category_model','',TRUE);
		$this->Category_model->add();
	}
	
	public function editcategory()
	{
		$this->load->model('Category_model','',TRUE);
		$this->Category_model->edit();
	}
	
	public function editallcategory()
	{
		$this->load->model('Category_model','',TRUE);
		$this->Category_model->editall();
	}
	
	public function deletecategory()
	{
		$this->load->model('Category_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Category_model->delete();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/category/',4,$total_num);
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
	
	public function deleteallcategory()
	{
		$this->load->model('Category_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Category_model->deleteall($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/category/',4,$this->Category_model->get_category_total_num());
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
	
	public function deletearticle()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Article_model->delete();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/articlelist/',4,$total_num);
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
	
	public function deletearticlesearch()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$w=$this->input->post('w');
		$total_num=$this->Article_model->deletesearch($w);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/search/'.$w,5,$total_num);
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
		$json['w']=rawurlencode(preg_replace('/%/','%25',$w));
		echo json_encode($json);
	}
	
	public function deletearticle_bycategory()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$json['category_id']=$this->Article_model->get_article_category_id($this->input->post('id'));
		$total_num=$this->Article_model->delete_bycategory();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/listbycategory/'.$json['category_id'],5,$total_num);
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
	
	public function deletearticle_bytag()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Article_model->delete_bytag();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/listbytag/'.$this->input->post('tag_id'),5,$total_num);
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
	
	public function deleteallarticle()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Article_model->deleteall($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/articlelist/',4,$this->Article_model->get_article_total_num());
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
	
	public function deleteallarticlesearch()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Article_model->deleteallsearch($deletedata,$this->input->post('w'));
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/search/'.$this->input->post('w'),5,$json['page_num']);
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
		$json['w']=rawurlencode(preg_replace('/%/','%25',$this->input->post('w')));
		echo json_encode($json);
	}
	
	public function deleteallarticle_bycategory()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$category_id=$this->Article_model->get_article_category_id($deletedata[0]->id);
		$len=count($deletedata);
		$json=$this->Article_model->deleteall_bycategory($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/listbycategory/'.$category_id,5,$json['page_num']);
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
		$json['category_id']=$category_id;
		echo json_encode($json);
	}
	
	public function deleteallarticle_bytag()
	{
		$this->load->model('Article_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Article_model->deleteall_bytag($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/listbytag/'.$this->input->post('tag_id'),5,$json['page_num']);
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
	
	public function deleteallcomment()
	{
		$this->load->model('Comment_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Comment_model->deleteall($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/comment/',4,$json['page_num']);
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
	
	public function deletecomment()
	{
		$this->load->model('Comment_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Comment_model->delete();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/comment/',4,$total_num);
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
	
	public function edittag()
	{
		$this->load->model('Tag_model','',TRUE);
		$this->Tag_model->ajaxedit();
	}
	
	public function editalltag()
	{
		$this->load->model('Tag_model','',TRUE);
		$this->Tag_model->ajaxeditall();
	}
	
	public function deletetag()
	{
		$this->load->model('Tag_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Tag_model->delete();
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/tag/',4,$total_num);
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
	
	public function deletealltag()
	{
		$this->load->model('Tag_model','',TRUE);
		$page=$this->input->post('page');
		$deletedata=json_decode($this->input->post('deletedata'));
		$len=count($deletedata);
		$json=$this->Tag_model->deleteall($deletedata);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/article/tag/',4,$json['page_num']);
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