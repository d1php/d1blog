<?php
class Link_model extends CI_Model {
  
  public function add()
  {
    $data['link_name']=$this->input->post('link_name');
    $data['link_url']=$this->input->post('link_url');
    $data['link_description']=$this->input->post('link_description');
    $data['link_email']=$this->input->post('link_email');
    if($this->input->post('link_status'))$data['link_status']=$this->input->post('link_status');
    $this->db->insert('blog_link',$data);echo $this->db->last_query();
    $link_id=$this->db->insert_id();
    return $link_id;
  }
  
  public function get_link_total_num()
  {
  	return $this->db->count_all('blog_link');
  }
  
  public function get_request_link_total_num()
  {
  	$this->db->where('link_status','1');
  	$this->db->from('blog_link');
  	return $this->db->count_all_results();
  }
  
  public function get_link_list($start=false,$end=false,$status=false)
  {
  	if(!$start&&$end)
  	{
  	   $this->db->limit($end);
  	   $this->db->order_by('id asc');
  	}
  	elseif($start&&$end)
  	{
  	   $this->db->limit($end,$start);
  	   $this->db->order_by('id asc');
  	}
  	elseif(!$start&&!$end)
  	{
  	   $this->db->order_by('id asc');
  	}
  	if($status!==false)
  	{
  		$this->db->where(array('link_status'=>$status));
  	}
  	$query=$this->db->get('blog_link');
  	if($query->num_rows())
  	{
  		$linkist=$query->result();
  		return $linkist;
  	}
   else
    {
   	    return false; 	
    }

  }
  
  public function edit()
  {
  	$data['link_name']=$this->input->post('newlinkname');
  	$data['link_url']=$this->input->post('newlinkurl');
  	$data['link_description']=$this->input->post('newlinkdescription');
  	$data['link_email']=$this->input->post('newlinkemail');
  	$data['link_status']=$this->input->post('newlinkstatus');
  	$this->db->update('blog_link',$data,array('id'=>$this->input->post('id')));
  	if($this->db->affected_rows()!='-1')
  	{
  		$data['link_name']=html_escape($data['link_name']);
  		$data['link_url']=html_escape($data['link_url']);
  		$data['link_description']=html_escape($data['link_description']);
  		$data['link_email']=html_escape($data['link_email']);
  		echo json_encode($data);
  	}
  		
  }
  
  public function editall()
  {
  	$editdata=json_decode($this->input->post('editdata'));
  	foreach ($editdata as $key=>$value)
  	{
  	$data['link_name']=$value->newlinkname;
  	$data['link_url']=$value->newlinkurl;
  	$data['link_description']=$value->newlinkdescription;
  	$data['link_email']=$value->newlinkemail;
  	$data['link_status']=$value->newlinkstatus;
  	$this->db->update('blog_link',$data,array('id'=>$value->id));
  	if($this->db->affected_rows()!='-1')
  	{
  	$jsondata[$key]['id']=$value->id;
  	$jsondata[$key]['link_name']=html_escape($value->newlinkname);
  	$jsondata[$key]['link_url']=html_escape($value->newlinkurl);
  	$jsondata[$key]['link_description']=html_escape($value->newlinkdescription);
  	$jsondata[$key]['link_email']=html_escape($value->newlinkemail);
  	$jsondata[$key]['link_status']=$value->newlinkstatus;
  	}
  	}
  	$jsondata['len']=count($editdata);
  	echo json_encode($jsondata);
  }
  
  public function delete()
  {
  	$this->db->delete('blog_link',array('id'=>$this->input->post('id')));
  	if($this->db->affected_rows()>0)
  	{
  		return $this->get_link_total_num();
  	}
  }
  
  public function deleterequestlink($id)
  {
  	$this->db->delete('blog_link',array('id'=>$id));
  	if($this->db->affected_rows()>0)
  	{
  		return true;
  	}
  }
  
  public function deleteall()
  {
  	$idarr=json_decode($this->input->post('deletedata'));
  	foreach ($idarr as $key=>$value)
  	{
  		$this->db->delete('blog_link',array('id'=>$value->id));
  		if($this->db->affected_rows()>0){
  			$jsondata[$key]['id']=$value->id;
  		}else{
  			return false;
  		}
  	}
  	$jsondata['page_num']=$this->get_link_total_num();
  	return $jsondata;
  }
  
  public function update_linkstatus($id)
  {
  	$query=$this->db->update('blog_link',array('link_status'=>1),array('id'=>$id));
  	if($this->db->affected_rows()>0)
  		return true;
  	else
  		return false;
  }
}
?>