<?php
class Category_model extends CI_Model {
	
  var $blog_category_name='';
  var $blog_category_description='';
  
  public function add()
  {
    $this->blog_category_name=trim($this->input->post('categoryname'));
    $this->blog_category_description=trim($this->input->post('category_description'));
    if(!$this->is_category_exist($this->blog_category_name))
    {
    	$this->db->insert('blog_category',$this);
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
  
  public function is_category_exist($categoryname)
  {
  	$this->db->select('id');
  	$query = $this->db->get_where('blog_category',array('blog_category_name'=>$categoryname),1,0);
    if($query->num_rows())
    	return true;
    else
    	return false;
  }
  
  public function get_category_list($start=false,$end=false)
  {
  	if(!$start&&$end)
  	{
  	   $this->db->limit($end);
  	}
  	elseif($start&&$end){
  	   $this->db->limit($end,$start);
  	   $this->db->order_by('id asc');
  	}elseif(!$start&&!$end){
  	   $this->db->order_by('id asc');
  	}
  	$query=$this->db->get('blog_category');
  	if($query->num_rows())
  	{
  		$categorylist=$query->result();
  		foreach ($categorylist as $key=>$value)
  		{
  			$sql="SELECT COUNT( t2.id ) as total_num FROM blog_category t1,  `blog_posts` t2 WHERE t2.post_category_id = t1.id AND t1.id =?";
  			$query_post_num=$this->db->query($sql,array($value->id));
  			$value->article_num=$query_post_num->row()->total_num;
  		}
  		return $categorylist;
  	}
   else
    {
   	    return false; 	
    }

  }
  
  public function edit()
  {
  	$data['name']=$this->blog_category_name=trim($this->input->post('newcategoryname'));
  	$data['description']=$this->blog_category_description=trim($this->input->post('newcategorydescription'));
    $this->db->update('blog_category',$this,array('id'=>$this->input->post('id')));
    if($this->db->affected_rows()!='-1'){
    $data['name']=html_escape($this->blog_category_name);
    $data['description']=html_escape($this->blog_category_description);
    echo json_encode($data);	
    }else{
    return false;	
    }
  }
  
  public function editall()
  {
  	$editdata=json_decode($this->input->post('editdata'));
  	foreach($editdata as $key=>$value){
  	$data['blog_category_name']=$value->name;
  	$data['blog_category_description']=$value->description;	
  	$this->db->update('blog_category',$data,array('id'=>$value->id));
  	if($this->db->affected_rows()!='-1'){
  		$jsondata[$key]['id']=$value->id;
  		$jsondata[$key]['name']=html_escape($value->name);
  		$jsondata[$key]['description']=html_escape($value->description);
  	}else{
  		return false;
  	}
  	}
  	$jsondata['len']=count($editdata);
  	echo json_encode($jsondata);
  }
  
  public function delete()
  {

  	$this->db->delete('blog_category',array('id'=>$this->input->post('id')));
  	if($this->db->affected_rows()>0){
  	$data['post_category_id']=0;
  	$this->db->update('blog_posts',$data,array('post_category_id'=>$this->input->post('id')));
  		return $this->get_category_total_num();
  	}else{
  		return false;
  	}
  }
  
  public function deleteall($deletedata)
  {
  	foreach($deletedata as $key=>$value){
  		$this->db->delete('blog_category',array('id'=>$value->id));
  		if($this->db->affected_rows()>0){
  			$data['post_category_id']=0;
  			$this->db->update('blog_posts',$data,array('post_category_id'=>$value->id));
  			$jsondata[$key]['id']=$value->id;
  		}else{
  			return false;
  		}	
  	}
  	$jsondata['len']=count($deletedata);
  	$jsondata['page_num']=$this->get_category_total_num();
    return $jsondata;
  }
  
  public function get_category_total_num(){
  	return $this->db->count_all('blog_category');
  }
}
?>