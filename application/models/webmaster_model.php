<?php
class Webmaster_model extends CI_Model {
	
  public function get_admin_detail()
  {
    $query=$this->db->get('blog_usr');
    if($query->num_rows()>0)
    {
    	return $query->row();
    }
  }
  
  public function add_all_detail()
  {
    $data['usr_account']=$this->input->post('usr_account');
    $data['usr_nickname']=$this->input->post('usr_nickname');
    if(trim($this->input->post('usr_pwd')))$data['usr_pwd']=md5($this->input->post('usr_pwd'));   
    $data['usr_email']=$this->input->post('usr_email');
    $data['usr_email_account']=$this->input->post('usr_email_account');
    $data['is_smtp']=$this->input->post('is_smtp');
    $data['usr_email_smtp']=$this->input->post('usr_email_smtp');
    $data['usr_email_port']=intval($this->input->post('usr_email_port'));
    $data['usr_email_pwd']=$this->input->post('usr_email_pwd');
    if($old_detail=$this->is_admin_exist())
    {
    	if(isset($data['usr_pwd']))
    	{
    	  if($old_detail->usr_account!=$data['usr_account']||$old_detail->usr_nickname!=$data['usr_nickname']||$old_detail->usr_pwd!=$data['usr_pwd'])
    		$relogin=true;
    	}elseif($old_detail->usr_account!=$data['usr_account']||$old_detail->usr_nickname!=$data['usr_nickname'])
    	{
    		$relogin=true;
    	}
    	$this->load->library('session');
    	$this->db->update('blog_usr',$data,array('id'=>$this->session->userdata('adminid')));
    }
    else
    {
    	$this->db->insert('blog_usr',$data);
    }
    return $relogin;
  }
  
  public function is_admin_exist()
  {
  	$query=$this->db->get('blog_usr');
    if($query->num_rows()>0)
    	return $query->row();
    else
    	return false;
  }

  
}
?>