<?php
class Article_model extends CI_Model {
  
  public function write()
  {
  	$this->load->library('session');
    $data['author_id']=$this->session->userdata('adminid');
    $data['post_title']=$this->input->post('article_title');
    $data['post_content']=$this->input->post('article_content');
    if($this->input->post('category_dropdown'))$data['post_category_id']=$this->input->post('category_dropdown');
    $data['post_time']=date("Y-m-d H:i:s",time());
    $this->db->insert('blog_posts',$data);
    $post_id=$this->db->insert_id();
    if($this->input->post('sethead'))
    {
    	$maxhead=$this->get_max_head()+1;
    	$this->db->update('blog_posts',array('set_head'=>$maxhead),array('id'=>$post_id));
    }
    return $post_id;
  }

  public function edit($post_id)
  {
  	$data['post_title']=$this->input->post('article_title');
  	$data['post_content']=$this->input->post('article_content');
  	if($this->input->post('category_dropdown'))$data['post_category_id']=$this->input->post('category_dropdown');
    if($this->input->post('sethead')&&!$this->is_post_sethead($post_id))
    {
    	$maxhead=$this->get_max_head()+1;
        $data['set_head']=$maxhead;
    }
    else if(!$this->input->post('sethead'))
    {
    	$data['set_head']=0;
    }
    $this->db->update('blog_posts',$data,array('id'=>$post_id));
  }

  public function is_post_sethead($post_id)
  {
  	$this->db->select('set_head');
  	$query=$this->db->get_where('blog_posts',array('id'=>$post_id));
  	$set_head=$query->row();
  	if($set_head->set_head>0)
  		return true;
  	else
  		return false;
  }
  
  public function get_post_detail($post_id)
  {
  	$sql = "SELECT t1. * , t2.blog_category_name, t2.blog_category_description,t3.usr_nickname FROM blog_usr t3,blog_posts t1 LEFT JOIN blog_category t2 ON t1.post_category_id = t2.id WHERE t1.id =? AND t1.author_id=t3.id";
  	$query=$this->db->query($sql, array($post_id));
  	if($query->num_rows())
  	{
  		return $query->row();
  	}
  	else
  	{
  		return false;
  	}

  }

  public function get_max_head()
  {
  	$this->db->select_max('set_head');
  	$query=$this->db->get('blog_posts');
  	return $query->row()->set_head;
  }
  
  public function get_article_total_num()
  {
     return $this->db->count_all('blog_posts');
  }
  
  public function get_article_list($start,$end)
  {
    $limit="LIMIT $start,$end";
    $order=" ORDER BY ID DESC ";
  	$sql="SELECT t1.id, t1.post_title, t1.post_category_id,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1 LEFT JOIN blog_category t2 ON t1.post_category_id = t2.id WHERE t1.author_id = t3.id".$order.$limit;
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
  
  public function get_article_list_detail($start,$end,$id=false)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY set_head DESC,ID DESC ";
  	if($id)
  	{
  		$sql="SELECT t1.id, t1.post_title, t1.post_content,t1.post_category_id,t1.post_views,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1 LEFT JOIN blog_category t2 ON t1.post_category_id = t2.id WHERE t1.author_id = t3.id AND t1.id!=?".$order.$limit;
  		$query=$this->db->query($sql,array($id));
  	}
  	else
  	{
  		$sql="SELECT t1.id, t1.post_title, t1.post_content,t1.post_category_id,t1.post_views,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1 LEFT JOIN blog_category t2 ON t1.post_category_id = t2.id WHERE t1.author_id = t3.id".$order.$limit;
  		$query=$this->db->query($sql);
  	}
  	if($query->num_rows()>0)
  	{
  		$articlelist=$query->result();
  		$this->load->model('Tag_model','',TRUE);
  		foreach ($articlelist as $key=>$value)
  		{
  			$this->db->where('post_id', $value->id);
  			$this->db->from('blog_comment');
  			$comment_num=$this->db->count_all_results();
  			$value->comment_num=$comment_num;
  			$value->tagstr=$this->Tag_model->get_post_tag($value->id,'link');
  		}
  		return $articlelist;
  	}
  	else
  	{
  		return false;
  	}
  }
  
  public function get_total_num_by_category($id)
  {
  	$this->db->where('post_category_id',$id);
  	$this->db->from('blog_posts');
  	return $this->db->count_all_results();
  }
  
  public function get_article_list_bycategory($start,$end,$categoryid)
  {
    $limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="SELECT t1.id, t1.post_title, t1.post_content, t1.post_views,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1,blog_category t2 WHERE t1.author_id = t3.id AND t1.post_category_id = t2.id AND t2.id =?".$order.$limit;
  	$query=$this->db->query($sql,array($categoryid));
  	if($query->num_rows()>0)
  	{
  		$articlelist=$query->result();
  		$this->load->model('Tag_model','',TRUE);
  		foreach ($articlelist as $key=>$value)
  		{
  			$this->db->where('post_id', $value->id);
  			$this->db->from('blog_comment');
  			$comment_num=$this->db->count_all_results();
  			$value->comment_num=$comment_num;
  			$value->tagstr=$this->Tag_model->get_post_tag($value->id,'link');
  		}
  		return $articlelist;
  	}
  	else
  	{
  		return false;
  	}
  }
  
  public function get_article_list_bytag($start,$end,$tagid)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="SELECT t1.id, t1.post_title, t1.post_content, t1.post_views,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_tag_relationship t4, blog_posts t1 LEFT JOIN blog_category t2 ON t2.id = t1.post_category_id WHERE t1.author_id = t3.id AND t4.post_id = t1.id AND t4.tag_id =?".$order.$limit;
  	$query=$this->db->query($sql,array($tagid));
  	if($query->num_rows()>0)
  	{
  		$articlelist=$query->result();
  		$this->load->model('Tag_model','',TRUE);
  		foreach ($articlelist as $key=>$value)
  		{
  			$this->db->where('post_id', $value->id);
  			$this->db->from('blog_comment');
  			$comment_num=$this->db->count_all_results();
  			$value->comment_num=$comment_num;
  			$value->tagstr=$this->Tag_model->get_post_tag($value->id,'link');
  		}
  		return $articlelist;
  	}
  	else
  	{
  		return false;
  	}
  }
  
  public function get_list_by_category($start,$end,$id)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="SELECT t1.id, t1.post_title, t1.post_category_id,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1,blog_category t2 WHERE t1.author_id = t3.id AND t1.post_category_id = t2.id AND t2.id=?".$order.$limit;
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
  
  public function get_total_num_by_tag($id)
  {
  	$this->db->where('tag_id',$id);
  	$this->db->from('blog_tag_relationship');
  	return $this->db->count_all_results();
  }
  
  public function get_list_by_tag($start,$end,$id)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="SELECT t1.id, t1.post_title, t1.post_category_id,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_tag_relationship t4, blog_posts t1 LEFT JOIN blog_category t2 ON t2.id = t1.post_category_id WHERE t1.author_id = t3.id AND t4.post_id = t1.id AND t4.tag_id =?".$order.$limit;
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
  	$this->db->delete('blog_posts',array('id'=>$this->input->post('id')));
    if($this->db->affected_rows()>0){
  	$this->load->model('Tag_model','',true);
  	$this->Tag_model->delete_tag_by_post_id($this->input->post('id'));
  	return $this->get_article_total_num();
  	}else{
  		return false;
  	}
  }
  
  public function deletesearch($w)
  {
  	$this->db->delete('blog_posts',array('id'=>$this->input->post('id')));
  	if($this->db->affected_rows()>0){
  		$this->load->model('Tag_model','',true);
  		$this->Tag_model->delete_tag_by_post_id($this->input->post('id'));
  		return $this->get_total_num_by_search($w);
  	}else{
  		return false;
  	}
  }
  
  public function delete_bycategory()
  {
  	$this->db->delete('blog_posts',array('id'=>$this->input->post('id')));
  	if($this->db->affected_rows()>0){
  		$this->load->model('Tag_model','',true);
  		$this->Tag_model->delete_tag_by_post_id($this->input->post('id'));
  		return $this->get_total_num_by_category($this->get_article_category_id($this->input->post('id')));
  	}else{
  		return false;
  	}
  }
  
  public function delete_bytag()
  {
  	$this->db->delete('blog_posts',array('id'=>$this->input->post('id')));
  	if($this->db->affected_rows()>0){
  		$this->load->model('Tag_model','',true);
  		$this->Tag_model->delete_tag_by_post_id($this->input->post('id'));
  		return $this->get_total_num_by_tag($this->input->post('tag_id'));
  	}else{
  		return false;
  	}
  }
  
  public function deleteall($deletedata)
  {
  	foreach($deletedata as $key=>$value){
  		$this->db->delete('blog_posts',array('id'=>$value->id));
  		if($this->db->affected_rows()>0){
  			$jsondata[$key]['id']=$value->id;
  			$this->load->model('Tag_model','',true);
  			$this->Tag_model->delete_tag_by_post_id($value->id);
  		}else{
  			return false;
  		}
  	}
  	$jsondata['len']=count($deletedata);
  	$jsondata['page_num']=$this->get_article_total_num();
  	return $jsondata;
  }
  
  public function deleteallsearch($deletedata,$w)
  {
  	foreach($deletedata as $key=>$value){
  		$this->db->delete('blog_posts',array('id'=>$value->id));
  		if($this->db->affected_rows()>0){
  			$jsondata[$key]['id']=$value->id;
  			$this->load->model('Tag_model','',true);
  			$this->Tag_model->delete_tag_by_post_id($value->id);
  		}else{
  			return false;
  		}
  	}
  	$jsondata['len']=count($deletedata);
  	$jsondata['page_num']=$this->get_total_num_by_search($w);
  	return $jsondata;
  }
  
  public function deleteall_bycategory($deletedata)
  {	
  	foreach($deletedata as $key=>$value){
  		$this->db->delete('blog_posts',array('id'=>$value->id));
  		if($this->db->affected_rows()>0){
  			$jsondata[$key]['id']=$value->id;
  			$this->load->model('Tag_model','',true);
  			$this->Tag_model->delete_tag_by_post_id($value->id);
  		}else{
  			return false;
  		}
  	}
  	$jsondata['len']=count($deletedata);
  	$jsondata['page_num']=$this->get_total_num_by_category($this->get_article_category_id($deletedata[0]->id));
  	return $jsondata;
  }
  
  public function deleteall_bytag($deletedata)
  {
  	foreach($deletedata as $key=>$value){
  		$this->db->delete('blog_posts',array('id'=>$value->id));
  		if($this->db->affected_rows()>0){
  			$jsondata[$key]['id']=$value->id;
  			$this->load->model('Tag_model','',true);
  			$this->Tag_model->delete_tag_by_post_id($value->id);
  		}else{
  			return false;
  		}
  	}
  	$jsondata['len']=count($deletedata);
  	$jsondata['page_num']=$this->get_total_num_by_tag($this->input->post('tag_id'));
  	return $jsondata;
  }
  
  public function get_head_post()
  {
  	$this->db->order_by('set_head desc');
  	$this->db->limit('1');
  	$this->db->where(array('set_head >'=>0));
  	$query=$this->db->get('blog_posts');
  	if($query->num_rows()>0)
  	{
  		return $query->row();
  	}
  	else
  	{
  		$query=$this->db->get('blog_posts');
  		if($query->num_rows()>0)
  			return $query->row();
  		else
  			return '赶紧写篇置顶文章吧~';
  	}  		
  }
  
  public function get_newest_post()
  {
  	$this->db->order_by('id desc');
  	$this->db->limit('6');
  	$query=$this->db->get('blog_posts');
  	if($query->num_rows()>0)
  	{
  		return $query->result();
  	}
  	else
  	{
  		return false;
  	}
  }

  public function get_post_comment($post_id)
  {
  	$query=$this->db->get_where('blog_comment',array('post_id'=>$post_id));
    if($query->num_rows()>0)
    	return $query->result();
    else
    	return false;
  }
  
  public function get_post_title($post_id)
  {
  	$this->db->select('post_title');
  	$query=$this->db->get_where('blog_posts',array('id'=>$post_id));
  	$article=$query->row();
  	return $article->post_title;
  }
  
  public function get_total_num_by_search($w)
  {
  	$w=urldecode($w);
  	$warr=explode(' ',trim($w));
  	$num=count($warr);
  	if($num==1)
  	{
  		$this->db->like('post_title',$w);
  		$this->db->or_like('post_content', $w);
        $this->db->from('blog_posts');
  	    return $this->db->count_all_results();
  	}
  	elseif($num>1)
  	{
  		$like='';
  		foreach ($warr as $value)
  		{
  			$like.=' post_title like "%'.$this->db->escape_like_str(trim($value)).'%" or post_content like "%'.$this->db->escape_like_str(trim($value)).'%" or';
  		}
  		$like=substr($like,0,-2);
  		$sql='select count(id) as numrows from blog_posts where '.$like;
  		$query=$this->db->query($sql);
  		return $query->row()->numrows;
  	}
  }
  
  public function get_article_list_by_search($start,$end,$w)
  {
  	$w=rawurldecode($w);
  	$warr=explode(' ',trim($w));
  	$num=count($warr);
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	if($num==1)
  	{
  	    $sql="SELECT t1.id, t1.post_title, t1.post_content,t1.post_category_id,t1.post_views,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1 LEFT JOIN blog_category t2 ON t1.post_category_id = t2.id WHERE t1.author_id = t3.id AND t1.post_title like '%".$this->db->escape_like_str($w)."%' or post_content like '%".$this->db->escape_like_str($w)."%'".$order.$limit;
  	    $query=$this->db->query($sql);
  		if($query->num_rows()>0)
  		{
  			$articlelist=$query->result();
  			$this->load->model('Tag_model','',TRUE);
  			foreach ($articlelist as $key=>$value)
  			{
  				$this->db->where('post_id', $value->id);
  				$this->db->from('blog_comment');
  				$comment_num=$this->db->count_all_results();
  				$value->comment_num=$comment_num;
  				$value->tagstr=$this->Tag_model->get_post_tag($value->id,true);
  			}
  			return $articlelist;
  		}
  		else
  		{
  			return false;
  		}
  	}
  	elseif($num>1)
  	{
  		$like='';
  		foreach ($warr as $value)
  		{
  			$like.=' t1.post_title like "%'.$this->db->escape_like_str($value).'%" or t1.post_content like "%'.$this->db->escape_like_str($value).'%" or';
  		}
  		$like=substr($like,0,-2);
  		$sql="SELECT t1.id, t1.post_title, t1.post_content,t1.post_category_id,t1.post_views,t3.usr_nickname, t2.blog_category_name, t1.post_time, t1.post_editime FROM blog_usr t3, blog_posts t1 LEFT JOIN blog_category t2 ON t1.post_category_id = t2.id WHERE t1.author_id = t3.id AND".$like.$order.$limit;
  		$query=$this->db->query($sql);
  		if($query->num_rows()>0)
  		{
  			$articlelist=$query->result();
  			$this->load->model('Tag_model','',TRUE);
  			foreach ($articlelist as $key=>$value)
  			{
  				$this->db->where('post_id', $value->id);
  				$this->db->from('blog_comment');
  				$comment_num=$this->db->count_all_results();
  				$value->comment_num=$comment_num;
  				$value->tagstr=$this->Tag_model->get_post_tag($value->id,true);
  			}
  			return $articlelist;
  		}
  		else
  		{
  			return false;
  		}
  	}
  }
  
  public function get_article_category_id($id)
  {
  	$this->db->select('post_category_id');
  	$query=$this->db->get_where('blog_posts',array('id'=>$id));
  	if($query->num_rows()>0)
  	{
  		$idobj=$query->row();
  		return $idobj->post_category_id;
  	}
  	else
  	{
  		return false;
  	}
  }  
  
  public function get_article_category_name($id)
  {
  	$this->db->select('blog_category_name');
  	$query=$this->db->get_where('blog_category',array('id'=>$id));
  	if($query->num_rows()>0)
  	{
  		$idobj=$query->row();
  		return $idobj->blog_category_name;
  	}
  	else
  	{
  		return false;
  	}
  }
  
  public function update_views($id)
  {
  	$sql="UPDATE `blog_posts` SET `post_views` = `post_views`+'1' WHERE `blog_posts`.`id` =?;";
  	$this->db->query($sql,array($id));
  }
  
  public function get_escape_str($w)
  {
  	return $this->db->escape_like_str($w);
  }
}
?>