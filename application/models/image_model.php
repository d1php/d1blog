<?php
class Image_model extends CI_Model {
	
	public function add_image($url)
	{
		$data['img_category_id']=$this->input->post('img_category_id');
		$data['img_url']=$url;
		$this->db->insert('blog_image',$data);
		return $this->db->insert_id();
	}
	
	public function get_uploaded_img($img_id)
	{
		$this->db->where_in('id',$img_id);
		$query=$this->db->get('blog_image');
		$this->db->last_query();
		if($query->num_rows()>0)
			return $query->result();
		else
			return false;
	}
	
	public function add_img_description($img_id_arr)
	{
		foreach ($img_id_arr as $value)
		{
			$data['img_description']=trim($this->input->post('img_description_'.$value));
			$this->db->update('blog_image',$data,array('id'=>$value));
		}
	}
	
	public function get_image_total_num()
	{
		$this->db->from('blog_image');
		return $this->db->count_all_results();
	}
	
	public function get_image_list($start,$end)
	{
		$limit="LIMIT $start,$end";
		$order=" ORDER BY ID DESC ";
		$sql="SELECT t1.*, t2.image_category_name FROM blog_image t1 , blog_image_category t2 WHERE t1.img_category_id = t2.id ".$order.$limit;
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	public function get_image_list_bycategory($id,$start,$end)
	{
		$limit="LIMIT $start,$end";
		$order=" ORDER BY ID DESC ";
		$sql="SELECT t1.*, t2.image_category_name FROM blog_image t1 , blog_image_category t2 WHERE t1.img_category_id = t2.id AND t2.id=?".$order.$limit;
		$query=$this->db->query($sql,array($id));
		if($query->num_rows()>0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	
	public function delete()
	{
		if($this->get_img_data_num($this->input->post('imgpath'))=='1')unlink($this->input->post('imgpath'));
		$this->db->delete('blog_image',array('id'=>$this->input->post('id')));
		return $this->get_image_total_num();
	}
	
	public function delete_bycategory()
	{
		if($this->get_img_data_num($this->input->post('imgpath'))=='1')unlink($this->input->post('imgpath'));
		$this->db->delete('blog_image',array('id'=>$this->input->post('id')));
		return $this->get_image_total_num_bycategory($this->get_img_category_id($this->input->post('id')));
	}
	
	public function get_img_category_id($id)
	{
		$this->db->select('img_category_id');
		$query=$this->db->get_where('blog_image',array('id'=>$id));
		if($query->num_rows()>0)
		{
			$idobj=$query->row();
			return $idobj->img_category_id;
		}
		else
		{
			return false;
		}
	}
	
	public function deleteall($img_id)
	{		
		foreach ($img_id as $key=>$value)
		{
			$imgrealpath=strstr($value->imgpath,'images');
			if($this->get_img_data_num($imgrealpath)=='1')unlink($imgrealpath);
			$this->db->delete('blog_image',array('id'=>$value->id));
			$json[$key]['id']=$value->id;
		}
		$json['page_num']=$this->get_image_total_num();
		return $json;
	}

	public function deleteall_bycategory($img_id)
	{
		$json['category_id']=$this->get_img_category_id($img_id[0]->id);
		foreach ($img_id as $key=>$value)
		{
			$imgrealpath=strstr($value->imgpath,'images');
			if($this->get_img_data_num($imgrealpath)=='1')unlink($imgrealpath);
			$this->db->delete('blog_image',array('id'=>$value->id));
			$json[$key]['id']=$value->id;
		}
		$json['page_num']=$this->get_image_total_num_bycategory($json['category_id']);
		return $json;
	}
	
	function get_img_data_num($imgpath)
	{
		$this->db->where('img_url',$imgpath);
		$this->db->from('blog_image');
		return $this->db->count_all_results();
	}
	
	function get_image_total_num_bycategory($id)
	{
		$this->db->where('img_category_id',$id);
		$this->db->from('blog_image');
		return $this->db->count_all_results();
	}
	
	public function edit($img_id)
	{
		$data['img_category_id']=$this->input->post('img_category');
		$data['img_description']=trim($this->input->post('img_description_'.$img_id));
		$this->db->update('blog_image',$data,array('id'=>$img_id));
	}
	
	public function get_category_list($start=false,$end=false)
	{
		if(!$start&&$end)
		{
			$this->db->limit($end);
			$this->db->order_by('id asc');
		}
		elseif($start&&$end){
			$this->db->limit($end,$start);
			$this->db->order_by('id asc');
		}elseif(!$start&&!$end){
			$this->db->order_by('id asc');
		}
		$query=$this->db->get('blog_image_category');
		if($query->num_rows())
		{
			$categorylist=$query->result();
			foreach ($categorylist as $key=>$value)
			{
				$sql="SELECT COUNT( t2.id ) as total_num FROM blog_image_category t1,  `blog_image` t2 WHERE t2.img_category_id = t1.id AND t1.id =?";
				$query_post_num=$this->db->query($sql,array($value->id));
				$value->img_num=$query_post_num->row()->total_num;
			}
			return $categorylist;
		}
		else
		{
			return false;
		}
	
	}
	
	public function get_category_total_num(){
		return $this->db->count_all('blog_image_category');
	}
	
	public function add()
	{
		$this->image_category_name=trim($this->input->post('categoryname'));
		if(!$this->is_category_exist($this->image_category_name))
		{
			$this->db->insert('blog_image_category',$this);
			if($this->db->insert_id())
				echo 'success';
			else
				echo '未知错误';
		}
		else
		{
			echo 'repeat';
		}
	}
	
	public function editcategory()
	{
		$data['image_category_name']=trim($this->input->post('newcategoryname'));
		$this->db->update('blog_image_category',$data,array('id'=>$this->input->post('id')));
		if($this->db->affected_rows()!='-1'){
			$json['name']='<a href="'.site_url('admin/image/listbycategory/'.$this->input->post('id')).'" id="n'.$this->input->post('id').'">'.html_escape($data['image_category_name']).'</a>';
			echo json_encode($json);
		}else{
			return false;
		}
	}
	
	public function editallcategory()
	{
		$editdata=json_decode($this->input->post('editdata'));
		foreach($editdata as $key=>$value){
			$data['image_category_name']=$value->name;
			$this->db->update('blog_image_category',$data,array('id'=>$value->id));
			if($this->db->affected_rows()!='-1'){
				$jsondata[$key]['id']=$value->id;
				$jsondata[$key]['name']='<a href="'.site_url('admin/image/listbycategory/'.$value->id).'" id="n'.$value->id.'">'.html_escape($data['image_category_name']).'</a>';
			}else{
				return false;
			}
		}
		$jsondata['len']=count($editdata);
		echo json_encode($jsondata);
	}
	
	public function deletecategory()
	{
		$this->db->delete('blog_image_category',array('id'=>$this->input->post('id')));
		if($this->db->affected_rows()>0){
			return $this->get_category_total_num();
		}else{
			return false;
		}
	}
	
	public function deleteallcategory($deletedata)
	{
		$jsondata=array();
		$jsondata['error']=0;
		foreach($deletedata as $key=>$value){
			if($this->is_category_have_image($value->id))
			{
				$jsondata['error']+=1;
			}
			else
			{
				$this->db->delete('blog_image_category',array('id'=>$value->id));
				if($this->db->affected_rows()>0){
					$jsondata[$key]['id']=$value->id;
				}else{
					return false;
				}	
			}
		}
		$jsondata['page_num']=$this->get_category_total_num();
		return $jsondata;
	}
	
	public function is_category_have_image($id)
	{
		$this->db->from('blog_image');
		$this->db->where(array('img_category_id'=>$id));
		$num=$this->db->count_all_results();
		if($num>0)
			return true;
		else
			return false;
	}
	
	public function is_category_exist($categoryname)
	{
		$this->db->select('id');
		$query = $this->db->get_where('blog_image_category',array('image_category_name'=>$categoryname),1,0);
		if($query->num_rows())
			return true;
		else
			return false;
	}
}