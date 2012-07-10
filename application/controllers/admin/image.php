<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class image extends CI_Controller {
	var $c='image';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Login_model','',TRUE);
		$this->Login_model->check_login_status();
	}
	
	function upload()
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Image_model','',TRUE);
		$data['category']=$this->Image_model->get_category_list();
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/uploadimg');
		$this->load->view('admin/footer');
	}

	function doupload()
	{

		$targetFolder = 'images'; // Relative to the root


		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			if(filesize($tempFile)>1024*200)
			{
				echo '图片不能超过200KB！';
				exit();
			}
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
			$fileParts = explode('.', $_FILES['Filedata']['name']);
			$targetFile = rtrim($targetFolder,'/') . '/'.md5($fileParts[0]).'.'.$fileParts[1];
			if (in_array($fileParts[1],$fileTypes)) {
				move_uploaded_file($tempFile,$targetFile);
				$img_url=$targetFile;
				$this->load->model('Image_model','',TRUE);
				echo $this->Image_model->add_image($img_url);
			} else {
				echo '无效的文件类型！';
			}
		}
	}
	
	function addimginfo($img_id)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$img_id_arr=json_decode(urldecode('['.$img_id.']'));
		$this->load->model('Image_model','',TRUE);
		$data['img_detail']=$this->Image_model->get_uploaded_img($img_id_arr);
		$data['img_id']=$img_id;
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/addimgdescription');
		$this->load->view('admin/footer');
	}
	
	function imgcategory($page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Image_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/img/category/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Image_model->get_category_total_num();
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
		$data['category']=$this->Image_model->get_category_list($start,$config['per_page']);
		if($data['category'])
		   foreach ($data['category'] as $key=>$value)
			 foreach ($value as $key2=>$value2)
			   $value->$key2=html_escape($value2);
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/imgcategory');
		$this->load->view('admin/footer');
	}
	
	public function addcategory()
	{
		$this->load->model('Image_model','',TRUE);
		$this->Image_model->add();
	}
	
	public function editcategory()
	{
		$this->load->model('Image_model','',TRUE);
		$this->Image_model->editcategory();
	}
	
	public function editallcategory()
	{
		$this->load->model('Image_model','',TRUE);
		$this->Image_model->editallcategory();
	}
	
	public function deletecategory()
	{
		$this->load->model('Image_model','',TRUE);
		if($this->Image_model->is_category_have_image($this->input->post('id')))
		{
			echo json_encode(array('error'=>'1'));
		}
		else
		{
			$page=$this->input->post('page');
			$total_num=$this->Image_model->deletecategory();
			$json['newpagination']=$this->get_new_pagination(site_url().'/admin/image/imgcategory/',4,$total_num);
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
	}
	
	public function deleteallcategory()
	{
		    $this->load->model('Image_model','',TRUE);
			$page=$this->input->post('page');
			$deletedata=json_decode($this->input->post('deletedata'));
			$len=count($deletedata);
			$json=$this->Image_model->deleteallcategory($deletedata);
			$json['newpagination']=$this->get_new_pagination(site_url().'/admin/image/imgcategory/',4,$json['page_num']);
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
	
	function save($img_id)
	{
		$img_id_arr=json_decode(urldecode('['.$img_id.']'));
		$this->load->model('Image_model','',TRUE);
		$this->load->model('Category_model','',TRUE);
		$this->Image_model->add_img_description($img_id_arr);
		redirect(site_url('admin/image/imglist'));
	}
	
	function imglist($page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Image_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/image/imglist/';
		$config['uri_segment'] = 4;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Image_model->get_image_total_num();
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
		$data['imagelist']=$this->Image_model->get_image_list($start,$config['per_page']);
		$data['page']=$page;
		$data['page_num']=ceil($config['total_rows']/$config['per_page']);
		if(!$data['imagelist']&&$page>1)
		{
			$page--;
			redirect(site_url('admin/image/imglist/'.$page));
			exit();
		}
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/imagelist');
		$this->load->view('admin/footer');
	}
	
	function listbycategory($id,$page=1)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']='imglist';
		$this->load->model('Image_model','',TRUE);
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/admin/image/listbycategory/'.$id;
		$config['uri_segment'] = 5;
		$config['num_links'] = 3;
		$config['total_rows'] = $this->Image_model->get_image_total_num_bycategory($id);
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
		$data['imagelist']=$this->Image_model->get_image_list_bycategory($id,$start,$config['per_page']);
		$data['page']=$page;
		$data['page_num']=ceil($config['total_rows']/$config['per_page']);
		if(!$data['imagelist']&&$page>1)
		{
			$page--;
			redirect(site_url('admin/image/listbycategory/'.$id.'/'.$page));
			exit();
		}
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/imglistbycategory');
		$this->load->view('admin/footer');
	}
	
	function delete_img()
	{
		$this->load->model('Image_model','',TRUE);
		$page=$this->input->post('page');
		$total_num=$this->Image_model->delete();
		$page_num=ceil($total_num/10);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/image/imglist/',4,$total_num);
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
	
	function delete_img_bycategory()
	{
		$this->load->model('Image_model','',TRUE);
		$page=$this->input->post('page');
		$json['category_id']=$this->Image_model->get_img_category_id($this->input->post('id'));
		$total_num=$this->Image_model->delete_bycategory();
		$page_num=ceil($total_num/10);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/image/listbycategory/'.$this->input->post('id'),4,$total_num);
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
	
	function deleteallimage()
	{
		$this->load->model('Image_model','',TRUE);
		$page=$this->input->post('page');
		$img_id=json_decode($this->input->post('deletedata'));
		$len=count($img_id);
		$json=$this->Image_model->deleteall($img_id);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/image/imglist/',4,$json['page_num']);
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
	
	function deleteallimage_bycategory()
	{
		$this->load->model('Image_model','',TRUE);
		$page=$this->input->post('page');
		$img_id=json_decode($this->input->post('deletedata'));
		$len=count($img_id);
		$json=$this->Image_model->deleteall_bycategory($img_id);
		$json['newpagination']=$this->get_new_pagination(site_url().'/admin/image/imglist/',4,$json['page_num']);
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
	
	function edit($img_id)
	{
		$this->load->library('session');
		$data['c']=$this->c;
		$data['m']=__FUNCTION__;
		$this->load->model('Image_model','',TRUE);
		$data['category']=$this->Image_model->get_category_list();
		$data['img_detail']=$this->Image_model->get_uploaded_img(array($img_id));
		$data['img_id']=$img_id;
		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/page_header');
		$this->load->view('admin/editimg');
		$this->load->view('admin/footer');
	}
	
	function doedit($img_id)
	{
		$this->load->model('Image_model','',TRUE);
        $this->Image_model->edit($img_id);
        redirect(site_url('admin/image/edit/'.$img_id));
	}
}

?>