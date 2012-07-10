<?php
class Comment_model extends CI_Model {

  public function get_post_comment_list($post_id,$start,$end)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="select * from blog_comment where post_id=?".$order.$limit;
  	$query=$this->db->query($sql,array($post_id));
    if($query->num_rows()>0)
    	return $query->result();
    else
    	return false;
  }
  
  public function get_contact_list($start,$end)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="select * from blog_comment where post_id=0".$order.$limit;
  	$query=$this->db->query($sql);
  	if($query->num_rows()>0)
  		return $query->result();
  	else
  		return false;
  }
  
  public function get_all_post_comment_list($start,$end)
  {
  	$limit="LIMIT $start,$end";
  	$order=" ORDER BY ID DESC ";
  	$sql="select t1.*,t2.post_title,t1.post_id from blog_comment t1 left join blog_posts t2 on t1.post_id=t2.id".$order.$limit;
  	$query=$this->db->query($sql);
  	if($query->num_rows()>0)
  		return $query->result();
  	else
  		return false;
  }
  
  public function add($post_id=false)
  {

  	$data['post_author']=$this->input->post('usrname')?$this->input->post('usrname'):"匿名游客";
  	if($post_id)
  	$data['post_id']=$post_id;
  	if(trim($this->input->post('email')))
  		$data['comment_email']=$this->input->post('email');
  	if(trim($this->input->post('website')))
  		$data['comment_url']=$this->input->post('website');
  	if(substr($data['comment_url'],0,7)!='http://')$data['comment_url']='http://'.$data['comment_url'];
  		$data['comment_content']=$this->input->post('message');
  	if($maxfllor=$this->get_max_floor($post_id))
  	    $data['comment_floor']=$maxfllor+1;
  	$this->db->insert('blog_comment',$data);
  	if($comment_id=$this->db->insert_id())
  	{
       return $comment_id;
  	}
  	else
  	{
  		exit('评论失败，请重试');
  	}
  }
  
  public function get_max_floor($post_id=false)
  {
  	$this->db->select_max('comment_floor');
  	if(!$post_id)$post_id=0;
  	$query=$this->db->get_where('blog_comment',array('post_id'=>$post_id));
  	if($query->num_rows()>0)
  	{
  		$maxfloor=$query->row();
  		return $maxfloor->comment_floor;
  	}
  	else
  	{
  		return false;
  	}
  }
  
  public function get_comment_time($comment_id)
  {
  	$this->db->select('comment_time');
  	$query=$this->db->get_where('blog_comment',array('id'=>$comment_id));
  	$comment_time=$query->row();
  	return $comment_time->comment_time;
  }
  
  public function get_comment_total_num_by_post($post_id)
  {
  	$this->db->where('post_id',$post_id);
  	$this->db->from('blog_comment');
  	return $this->db->count_all_results();
  }
  
  public function get_contact_total_num()
  {
  	$this->db->where('post_id',0);
  	$this->db->from('blog_comment');
  	return $this->db->count_all_results();
  }
  
  public function get_comment_total_num()
  {
  	$this->db->from('blog_comment');
  	return $this->db->count_all_results();
  }
  
  public function deleteall($idarr)
  {
  	foreach ($idarr as $value)
  	{
  		$this->db->delete('blog_comment',array('id'=>$value->id));
  		$data[]['id']=$value->id;
  	}
  	$data['page_num']=$this->get_comment_total_num();
  	return $data;
  }
  
  public function delete()
  {
  	$this->db->delete('blog_comment',array('id'=>$this->input->post('id')));
  	return $this->get_comment_total_num();
  }
  
  public function edit($id)
  {
  	$data['post_author']=$this->input->post('usrname')?$this->input->post('usrname'):'匿名游客';
  	$data['comment_email']=$this->input->post('email');
  	$data['comment_url']=$this->input->post('website');
  	$data['comment_content']=$this->input->post('message');
  	$this->db->update('blog_comment',$data,array('id'=>$id));
  }
  
  public function get_post_comment_by_id($id)
  {
  	$query=$this->db->get_where('blog_comment',array('id'=>$id));
  	if($query->num_rows()>0)
  		return $query->row();
  	else
  		return false;
  }
  
  public function get_new_comments()
  {
  	$this->db->order_by('id desc');
  	$query=$this->db->get('blog_comment');
  	if($query->num_rows()>0)
  		return $query->result();
  	else 	
  		return false;	
  }
}
?>